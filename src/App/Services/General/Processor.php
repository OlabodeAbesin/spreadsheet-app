<?php
declare(strict_types=1);
namespace Console\App\Services\General;

use Console\App\Services\Google\PrepareSpreadSheetData;
use Console\App\Services\Google\ServiceAccountAuthorization;
use Console\App\Services\Google\CreateSpreadSheet;
use Console\App\Services\Google\SetSpreadSheetPermission;
use Console\App\Services\Google\WriteDataToSpreadSheet;
use JetBrains\PhpStorm\Pure;
use Sabre\Xml\ParseException;

class Processor
{
    protected $prepareSpreadSheetDataObj;
    protected string|array|object $xmlArray;
    protected string $fileName;
    private FileReader $readFeedObj;

    #[Pure] public function __construct($fileName)
    {
        $this->fileName = $fileName;
        $this->readFeedObj = new FileReader($fileName);
    }

    /**
     * @throws ParseException
     */
    public function execute(): string {
        $this->readFeed();
        $spreadSheetId = $this->CreateSpreadSheet();
        $this->writeDataToSpreadSheet($spreadSheetId, $this->getData());
        return "https://docs.google.com/spreadsheets/d/".$spreadSheetId;
    }

    /**
     * @throws ParseException
     */
    public function readFeed()
    {
        $this->xmlArray = $this->readFeedObj->ReadFeedFile();
    }

    protected function CreateSpreadSheet(): string {
        if ($this->checkIfAccountAuthorizedToCreateSpreadSheet()) {

            //Set Google Client With Credentials
            $serviceAccountAuthorizationObj = new ServiceAccountAuthorization();
            $client = $serviceAccountAuthorizationObj->returnAuthorizedClient();

            //Create Spreadsheet
            $name = "Productsup_".date("Ymdhis");
            $createSpreadSheetObj = new CreateSpreadSheet($serviceAccountAuthorizationObj, $name, $client);
            $spreadSheetId = $createSpreadSheetObj->create()->getId();

            //Set Write Permission
            $permissionObj = new SetSpreadSheetPermission($client);
            $permissionObj->setWritePermission($spreadSheetId);

            return $spreadSheetId;
        } else {
            return "Problem With Authorization";
        }
    }

    protected function writeDataToSpreadSheet($spreadSheetId, $result)
    {
        $serviceAccountAuthorizationObj = new ServiceAccountAuthorization();
        $client = $serviceAccountAuthorizationObj->returnAuthorizedClient();

        $writDataToSpreadSheetObj = new WriteDataToSpreadSheet($client);
        $writDataToSpreadSheetObj->writeData($spreadSheetId, $result);
    }

    /**
     * @throws ParseException
     */
    public function getXmlArray(): object|array|string {
        $this->xmlArray = $this->readFeedObj->ReadFeedFile();
        return $this->xmlArray;
    }

    /**
     * @throws ParseException
     */
    public function getData(): array {
        $this->prepareSpreadSheetDataObj = new PrepareSpreadSheetData($this->getXmlArray());
        return $this->prepareSpreadSheetDataObj->prepareSpreadSheetDataFromArray();
    }


    protected function checkIfAccountAuthorizedToCreateSpreadSheet(): int {
        $serviceAccountAuthorizationObj = new ServiceAccountAuthorization();
        $authorized = $serviceAccountAuthorizationObj->authorization();
        return ($authorized ?: 0);
    }
}

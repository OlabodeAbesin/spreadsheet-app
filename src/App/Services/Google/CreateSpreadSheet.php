<?php
declare(strict_types=1);
namespace Console\App\Services\Google;

use Console\App\Services\Google\AccountAuthorizationInterface;
use Console\App\Services\Google\ServiceAccountAuthorization;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;

class CreateSpreadSheet
{
    private $authorziation;
    private $spreadSheetName;
    private $client;

    public function __construct(AccountAuthorizationInterface $authorization, $spreadSheetName, $client)
    {
        $this->authorization = $authorization;
        $this->spreadSheetName = $spreadSheetName;
        $this->client = $client;
    }

    public function create()
    {
        $service = new Drive($this->client);
        $file = new DriveFile();
        $file->setParents(array($file->getDriveId()));
        $file->setMimeType('application/vnd.google-apps.spreadsheet');
        $file->setName($this->spreadSheetName);
        $results = $service->files->create($file);
        unset($service);
        unset($file);
        return $results;
    }
}

<?php
declare(strict_types=1);
namespace Console\App\Services\General;

use Sabre\Xml\ParseException;
use Sabre\Xml\Reader;
use Sabre\Xml\Service;
use function Sabre\Xml\Deserializer\keyValue;

class FileReader
{
    private $xml_file;

    public function __construct($filePath)
    {
        $this->xml_file = $filePath;
    }

    /**
     * @throws ParseException
     */
    public function ReadFeedFile(): object|array|string {
        $xmlString = file_get_contents($this->xml_file);
        $xmlReader = new Reader();
        $xmlReaderService = new Service();
        $xmlReaderService->elementMap = [
            'item' => function (Reader $reader) {
                return keyValue($reader, '');
            }
        ];

        $xmlStringArray = $xmlReaderService->parse($xmlString);
        unset($xmlReader);
        unset($xmlReaderService);
        return $xmlStringArray;
    }
}

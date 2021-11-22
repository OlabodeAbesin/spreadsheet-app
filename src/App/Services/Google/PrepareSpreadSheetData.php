<?php
declare(strict_types=1);
namespace Console\App\Services\Google;

class PrepareSpreadSheetData
{
    private $xmlDataInArray;
    private array $spreadSheetHeader = array();
    private array $spreadSheetContent = array();

    public function __construct($xmlDataInArray)
    {
        $this->xmlDataInArray = $xmlDataInArray;
    }

    public function prepareSpreadSheetDataFromArray(): array {
        foreach ($this->xmlDataInArray as $key => $item) {
            if ($key == 0) {
                array_push($this->spreadSheetHeader, array_keys($item['value']));
            }

            $itemData = array_values($item['value']);
            foreach ($itemData as $key => $value) {
                $itemData[$key] = strval($value);
            }

            array_push($this->spreadSheetContent, $itemData);
            unset($itemData);
        }
        unset($this->xmlDataInArray);
        return array_merge($this->spreadSheetHeader, $this->spreadSheetContent);
    }
}

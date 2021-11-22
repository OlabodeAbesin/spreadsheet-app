<?php
declare(strict_types=1);
namespace Console\App\Services\Google;

use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;

class WriteDataToSpreadSheet
{
    private Sheets $sheets;
    private $client;

    public function __construct($client)
    {
        $this->sheets = new Sheets($client);
        $this->client = $client;
    }

    public function writeData($spreadSheetId, $data): int {
        $range = "sheet1!A1:R".count($data);
        $body = new ValueRange(['values' => $data]);
        $params = ['valueInputOption' => "RAW"];
        $result = $this->sheets->spreadsheets_values->update($spreadSheetId, $range, $body, $params);
        return 1;
    }
}

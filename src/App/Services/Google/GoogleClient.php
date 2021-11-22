<?php

declare(strict_types=1);
namespace Console\App\Services\Google;
use Google_Service_Drive;

class GoogleClient {
    private Google_Client $googleClient;
    private Google_Service_Drive $drive;
    private Google_Service_Drive_Permission $drivePermission;
    private Google_Service_Sheets $service;

     public function __construct()
    {
        $this->googleClient = $this->createGoogleClient();
        $this->service = new Google_Service_Sheets($this->client);
        $this->drivePermission = $this->createDrivePermission();
        $this->drive = new Google_Service_Drive($this->client);
    }

    private function createGoogleClient(): Google_Client
    {
        $client = new Google_Client();
        $client->setApplicationName('Dummy Name');
        $client->setScopes([Google_Service_Sheets::SPREADSHEETS, Google_Service_Drive::DRIVE]);
        $client->setAccessType('offline');
        $client->setAuthConfig(Config::SPREADSHEET_KEY_FILE);

        return $client;
    }

    private function createDrivePermission(): Google_Service_Drive_Permission
    {
        $drivePermisson = new Google_Service_Drive_Permission();
        $drivePermisson->setType('user');
        $drivePermisson->setEmailAddress(Config::EMAIL_WITH_ACCESS_TO_SPREADSHEET);
        $drivePermisson->setRole('writer');

        return $drivePermisson;
    }

    public function createSpreadsheet(string $title): Spreadsheet
    {
        $spreadsheet = new Google_Service_Sheets_Spreadsheet([
            'properties' => [
                'title' => $title,
            ],
        ]);

        $spreadsheet = $this->service->spreadsheets->create($spreadsheet);
        $this->drive->permissions->create($spreadsheet->getSpreadsheetId(), $this->drivePermission);

        return $spreadsheet;
    }

    public function insertDataIntoSpreadsheet(string $spreadsheetId, Google_Service_Sheets_ValueRange $data): void
    {
        $params = [
            'valueInputOption' => 'USER_ENTERED',
        ];

        $this->service->spreadsheets_values->append(
            $spreadsheetId,
            'A1',
            $data,
            $params
        );
    }

}
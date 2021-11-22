<?php
declare(strict_types=1);
namespace Console\App\Services\General;

class Config
{
    private static Config $instance;
    private static string|false $appRoot;
    private static string $appLogPath;
    private static string $defaultDataFile;
    private static string $dataFeedFolder;
    private static string $googleApiCredentialsFile;

    private function __construct()
    {
        self::$appRoot = realpath(__DIR__ . '/../../../..');
        self::$appLogPath = self::$appRoot.'storage/logs/application.log';
        self::$dataFeedFolder = self::$appRoot.'/storage/feed/';
        self::$defaultDataFile = 'coffee_feed.xml';
        self::$googleApiCredentialsFile = self::$appRoot.'/configs/google_api_service_account/credentials.json';
    }

    public static function getInstance(): Config {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getappLogPath(): string {
        return self::$appLogPath;
    }
    public function getdefaultDataFile(): string {
        return self::$defaultDataFile;
    }

    public function getgoogleApiCredentialsFile(): string {
        return self::$googleApiCredentialsFile;
    }

    public function getdataFeedFolder(): string {
        return self::$dataFeedFolder;
    }
}

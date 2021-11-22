<?php
declare(strict_types=1);
namespace Console\App\Services\General;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class AppLogger
{
    private static AppLogger $instance;
    private static Logger $logger;

    private function __construct()
    {
        self::$logger = new Logger('SpreadsheetApp');
    }

    public static function getInstance(): AppLogger {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getLogger(): Logger {
        return self::$logger->pushHandler(new StreamHandler(Config::getInstance()->getappLogPath(), Logger::DEBUG));
    }
}

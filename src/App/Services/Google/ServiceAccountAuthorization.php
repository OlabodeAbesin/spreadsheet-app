<?php
declare(strict_types=1);
namespace Console\App\Services\Google;

use Console\App\Services\General\Config;
use Google\Client;

class ServiceAccountAuthorization implements AccountAuthorizationInterface
{
    private $client;

    public function authorization(): int {
        $this->client = new Client();
        $this->client->setApplicationName("Productsup XML Data");
        $this->client->setScopes(['https://www.googleapis.com/auth/spreadsheets','https://www.googleapis.com/auth/drive']);
        $this->client->setAuthConfig(Config::getInstance()->getgoogleApiCredentialsFile());
        return 1;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function returnAuthorizedClient()
    {
        $this->authorization();
        return $this->client;
    }
}

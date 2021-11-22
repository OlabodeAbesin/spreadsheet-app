<?php
declare(strict_types=1);
namespace Console\App\Services\Google;

use Google\Service\Drive\Permission;
use Google\Service\Drive;

class SetSpreadSheetPermission
{
    private Permission $permission;
    private Drive $service;
    private $client;

    public function __construct($client)
    {
        $this->permission = new Permission();
        $this->service = new Drive($client);
        $this->client = $client;
    }

    public function setWritePermission($spreadSheetId): int {
        $this->permission->setRole('writer');
        $this->permission->setType('anyone');
        $this->service->permissions->create($spreadSheetId, $this->permission);
        return 1;
    }
}

<?php
declare(strict_types=1);

namespace Console\App\Validation;
use Console\App\Services\General\Config;

class InputChecks {

    public function validate(string $givenFileName): ?string{

        $file = $this->getFile($givenFileName);
        return ($this->checkFileExists($file) != null) ? $file : null;
    }
    protected function getFile($givenFileName): ?string
    {
        return (filter_var($givenFileName, FILTER_VALIDATE_URL) ? $givenFileName : Config::getInstance()->getdataFeedFolder().($givenFileName ? $givenFileName :  Config::getInstance()->getdefaultDataFile()));
    }

    protected function checkFileExists( $givenFileName): ?bool {
        $file_headers = @get_headers($givenFileName);
        $exists = !((!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found'));
        return  (file_exists($givenFileName) || $exists) ?: null;
    }
}
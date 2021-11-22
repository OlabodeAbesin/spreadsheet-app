<?php
namespace App\Tests\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Console\App\Commands\ProcessSheetCommand;
use Symfony\Component\Console\Tester\CommandTester;

class ProcessSheetCommandTest extends TestCase{

     public function testFileIsSuccessfullyProcessed(){//test default file
        $application = new Application();
        $application->add(new ProcessSheetCommand());

        $command = $application->find('process-sheet');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array('command' => $command->getName())
        );
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('File Processed Successfully.', $output);
     }
}
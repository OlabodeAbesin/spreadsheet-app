<?php
declare(strict_types=1);
namespace Console\App\Commands;

use Console\App\General\AppLogger;
use Console\App\Services\General\Processor;
use Console\App\Validation\InputChecks;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;


class ProcessSheetCommand extends Command
{
    protected InputChecks $validateInput;

    public function __construct()
    {
        parent::__construct();
        $this->validateInput = New InputChecks();
    }

    protected function configure()
    {
        $this
            ->setName('process-sheet')
            ->setDescription('Process xml from local or remote')
            ->setHelp('Process the xml file. Pass the --filename parameter to specify a remote/local file path.')
            ->addOption(
                'filename',
                'f',
                InputOption::VALUE_OPTIONAL,
                'Pass the file name',
                ''
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        try {
                $filename = $this->validateInput->validate($input->getOption('filename'));
                if($filename == null){
                    throw new Exception("File Not Found");
                }
                $output->writeln('Process is starting, file to be processed is @'.$filename);
                $output->writeln('<comment>Processing ..</comment>');
                $output->writeln('<comment>Processing ....</comment>');
                $this->processorObj = new Processor($filename);
                $googleSheetUrl = $this->processorObj->execute();
                $output->writeln('<info>File Processed Successfully.</info>');
                $output->writeln('Google Sheet URL is: '.$googleSheetUrl);
                $output->writeln('<info>Success!.</info>');
                return Command::SUCCESS;
        } catch (Exception $e) {
            $output->writeln('Error Occurred, File Not Found');
            AppLogger::getInstance()->getLogger()->warning($e->getMessage()."===".$e->getLine());
            return Command::FAILURE;
        }

    }
}

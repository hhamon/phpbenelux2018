<?php

namespace App\Command;

use App\LockerManagement\LockerManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LockerDepositPackageCommand extends Command
{
    protected static $defaultName = 'locker:deposit-package';

    private $lockerManager;

    public function __construct(LockerManager $lockerManager)
    {
        parent::__construct(static::$defaultName);

        $this->lockerManager = $lockerManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Store a package in a locker')
            ->addArgument('locker', InputArgument::REQUIRED, 'Locker ID')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->lockerManager->depositPackage($id = $input->getArgument('locker'));

        $io = new SymfonyStyle($input, $output);
        $io->success(sprintf('Package was delivered in locker "%s".', $id));
    }
}

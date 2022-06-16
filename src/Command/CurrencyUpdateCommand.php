<?php

declare(strict_types=1);

namespace App\Command;

use App\Services\RatesTriangulator;
use App\Services\RatesUpdater;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'currency:update',
    description: 'Update exchange rates',
)]
class CurrencyUpdateCommand extends Command
{
    public function __construct(private readonly RatesUpdater $ratesUpdater, private readonly RatesTriangulator $ratesTriangulator)
    {
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            ($this->ratesUpdater)();
            $io->text('Rates loaded');

            ($this->ratesTriangulator)();
            $io->text('Rates triangulated');
        } catch (RuntimeException $exception) {
            $io->error('Something went wrong');
            $io->text($exception->getMessage());
            $io->text("{$exception->getFile()}:{$exception->getLine()}");

            return Command::FAILURE;
        }

        $io->success('Currency rates successfully updated');

        return Command::SUCCESS;
    }
}

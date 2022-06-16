<?php

declare(strict_types=1);

namespace App\Command;

use App\Dto\Exchange;
use App\Services\RatesExchanger;
use OutOfBoundsException;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function count;

#[AsCommand(
    name: 'currency:exchange',
    description: 'Currency exchange',
    aliases: ['exchange:currency']
)]
class CurrencyExchangeCommand extends Command
{
    public function __construct(private readonly ValidatorInterface $validator, private readonly RatesExchanger $ratesConverter)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('amount', InputArgument::REQUIRED, 'Amount to exchange')
            ->addArgument('from', InputArgument::REQUIRED, 'From currency')
            ->addArgument('to', InputArgument::REQUIRED, 'To currency');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $amount = $input->getArgument('amount');
        $from = $input->getArgument('from');
        $to = $input->getArgument('to');

        $io = new SymfonyStyle($input, $output);

        try {
            $exchange = new Exchange($amount, $from, $to);

            $this->validate($exchange);

            $result = ($this->ratesConverter)($exchange);
        } catch (RuntimeException $exception) {
            $io->error('Something went wrong');
            $io->text($exception->getMessage());
            $io->text("{$exception->getFile()}:{$exception->getLine()}");

            return Command::FAILURE;
        }

        $io->success("{$amount} {$from} is {$result} $to");

        return Command::SUCCESS;
    }


    private function validate(Exchange $exchange): void
    {
        $errors = $this->validator->validate($exchange);
        if (count($errors) > 0) {
            throw new OutOfBoundsException((string)$errors);
        }
    }
}

<?php
declare(strict_types=1);

namespace App\Tests\Command;

use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use Symfony\Component\Console\Exception\CommandNotFoundException;

class CurrencyExchangeCommandTest extends CommandTestCase
{
    protected static string $commandName = 'currency:exchange';


    /**
     * @throws CommandNotFoundException
     */
    protected function setUp(): void
    {
        parent::setUp();

        self::execute('currency:update');
    }


    /**
     * @throws ExpectationFailedException
     * @throws CommandNotFoundException
     * @throws InvalidArgumentException
     * @dataProvider dataProvider
     */
    public function testCurrencyExchangeCommand(float $amount, string $from, string $to, float $expected): void
    {
        $input = [
            'amount' => (string)$amount,
            'from' => $from,
            'to' => $to
        ];

        $expected = number_format($expected, 8);
        $expected = "$amount $from is $expected $to";

        $output = self::execute(self::$commandName, $input);

        self::assertStringContainsString($expected, $output);
    }


    public function dataProvider(): array
    {
        return [
            [1, 'EUR', 'USD', 2],
            [1, 'USD', 'BTC', 0.002],
            [1, 'USD', 'EUR', 0.5],
            [1, 'BTC', 'USD', 500],
            [1, 'EUR', 'BTC', 0.004],
            [1, 'BTC', 'EUR', 250],
        ];
    }
}

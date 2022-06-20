<?php
declare(strict_types=1);

namespace App\Tests\Command;

use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;

class CurrencyUpdateCommandTest extends CommandTestCase
{
    protected static string $commandName = 'currency:update';


    /**
     * @throws CommandNotFoundException
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     * @throws ServiceCircularReferenceException
     */
    public function testCurrencyUpdateCommand(): void
    {
        $output = self::execute(self::$commandName);

        self::assertStringContainsString('Rates loaded', $output);
        self::assertStringContainsString('Rates triangulated', $output);
        self::assertStringContainsString('Currency rates successfully updated', $output);
    }
}

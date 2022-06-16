<?php
declare(strict_types=1);

namespace App\Tests\Command;

use LogicException;
use PHPUnit\Framework\ExpectationFailedException;
use RuntimeException;
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
     * @throws RuntimeException
     * @throws LogicException
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

<?php
declare(strict_types=1);

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\Console\Tester\CommandTester;

abstract class CommandTestCase extends KernelTestCase
{
    private static Application $application;


    protected function setUp(): void
    {
        parent::setUp();

        self::$application = new Application(self::bootKernel());
    }


    /**
     * @param string[] $input
     * @throws CommandNotFoundException
     */
    protected static function execute(string $commandName, array $input = []): string
    {
        $command = self::$application->find($commandName);

        $commandTester = new CommandTester($command);
        $commandTester->execute($input);

        $commandTester->assertCommandIsSuccessful();

        return $commandTester->getDisplay();
    }
}

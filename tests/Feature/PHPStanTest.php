<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PHPStanTest extends TestCase
{
    public function testPhpstanAnalysisPasses(): void
    {
        $process = new Process(['vendor/bin/phpstan', 'analyse', '--level=8']);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $this->assertTrue(true); 
    }
}

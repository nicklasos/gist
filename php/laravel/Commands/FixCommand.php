<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixCommand extends Command
{
    protected $signature = 'fix {what}';

    protected $description = 'Fix something';

    public function handle()
    {
        if (!method_exists($this, 'fix' . $this->argument('what'))) {
            $this->error('Method ' . $this->argument('what') . ' does not exists');
            return;
        }

        $this->{'fix' . $this->argument('what')}();
    }

    public function fixTest()
    {
        $this->line('Test fix command');
    }
}

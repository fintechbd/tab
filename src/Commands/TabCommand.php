<?php

namespace Fintech\Tab\Commands;

use Illuminate\Console\Command;

class TabCommand extends Command
{
    public $signature = 'tab';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}

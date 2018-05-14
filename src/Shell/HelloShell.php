<?php

namespace App\Shell;

use Cake\Console\Shell;

class HelloShell extends Shell
{
    public function main()
    {
        $this->out('Hello Word.');
    }

    public function heyThere(string $name = 'Anonymous')
    {
        $this->out('Hey '. $name);
    }
}
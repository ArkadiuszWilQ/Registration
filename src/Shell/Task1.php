<?php

namespace App\Shell;

use Cake\Console\Shell;

class Task1 extends Shell
{

    public function main()
    {
        $date = new \DateTime();
        $this->createFile('task1.txt', $date->format('Y-m-d H:i:s'));
    }
}
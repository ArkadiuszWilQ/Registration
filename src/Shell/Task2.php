<?php

namespace App\Shell;

use Cake\Console\Shell;

class Task2 extends Shell
{

    public function main()
    {
        $date = $this->out('Select any method'); //Czy jakkolwiek to po angielskiemu napisać
    }

    public function date()
    {
        $date = new \DateTime();
        $this->createFile('task2data.txt', $date->format('Y-m-d'));

    }

    public function time()
    {
        $time = new \DateTime();
        $this->createFile('task2godzina.txt', $time->format('H:i:s'));
    }
}
<?php

namespace App\Shell;

use Cake\Console\Shell;

class Task3 extends Shell
{

    public function main(string $parameters)
    {
        $date = new \DateTime();

        if($parameters == 'date') {
            $this->createFile('task3data.txt', $date->format('Y-m-d'));
        } elseif($parameters == 'time') {
            $this->createFile('task3godzina.txt', $date->format('H:i:s'));
        }
    }
}
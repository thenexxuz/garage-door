<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestSensor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'garage:sensor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Garage Door Sensor';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        do {
            unset($result);
            exec("sudo raspi-gpio get 27 | awk '{print $3}'", $result);
	        echo $result[0] . PHP_EOL;
	    } while($result[0] === 'level=1');
    }
}


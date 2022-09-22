<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PiPHP\GPIO\GPIO;
use PiPHP\GPIO\Pin\InputPinInterface;

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
        // Create a GPIO object
        $gpio = new GPIO();

        // Retrieve pin 18 and configure it as an input pin
        $pin = $gpio->getInputPin(18);

        // Configure interrupts for both rising and falling edges
        $pin->setEdge(InputPinInterface::EDGE_BOTH);

        // Create an interrupt watcher
        $interruptWatcher = $gpio->createWatcher();

        // Register a callback to be triggered on pin interrupts
        $interruptWatcher->register($pin, function (InputPinInterface $pin, $value) {
            echo 'Pin ' . $pin->getNumber() . ' changed to: ' . $value . PHP_EOL;

            // Returning false will make the watcher return false immediately
            return true;
        });

        // Watch for interrupts, timeout after 5000ms (5 seconds)
        while ($interruptWatcher->watch(5000));
    }
}

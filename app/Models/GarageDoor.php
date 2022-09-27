<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GarageDoor extends Model
{
    use HasFactory;

    public function trigger()
    {
        // This feels like such a hack way of
        // setting the output of the pin low
        // then high then low again
        exec("sudo raspi-gpio set 22 a5");
        sleep(0.1);
        exec("sudo raspi-gpio set 22 op pn dl");
        sleep(0.25);
        exec("sudo raspi-gpio set 22 a5");
        sleep(0.1);
        exec("sudo raspi-gpio set 22 op pn dh");
        sleep(0.25);
        exec("sudo raspi-gpio set 22 a5");
        sleep(0.1);
        exec("sudo raspi-gpio set 22 op pn dl");
    }

    public function setState()
    {
        exec("sudo raspi-gpio get 27 | awk '{print $3}'", $output);
        $this->state = ($output[0] === 'level=1') ? 'closed' : 'open';
        $this->save();
        return $this->state;
    }
}

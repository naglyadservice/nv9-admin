<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class DeviceSerialNumberForm extends Form
{
    #[Validate('required')]
    public string $serial_number = '';
}

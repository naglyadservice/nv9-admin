<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class DeviceSerialNumberForm extends Form
{
    #[Validate]
    public string $serial_number = '';

    public function rules(): array
    {
        return [
            'serial_number' => 'required|string',
        ];
    }
}

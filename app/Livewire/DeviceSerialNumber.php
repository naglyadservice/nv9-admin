<?php

namespace App\Livewire;

use App\Livewire\Forms\DeviceSerialNumberForm;
use App\Models\Device;
use Livewire\Component;

class DeviceSerialNumber extends Component
{
    public Device $device;

    public DeviceSerialNumberForm $form;

    public function mount(Device $device): void
    {
        $this->device = $device;
    }

    public function store(): void
    {
        $this->validate();
        $this->device->serialNumbers()->firstOrCreate($this->form->pull());
    }

    public function delete($serialNumberId): void
    {
        $this->device->serialNumbers()->where('id', $serialNumberId)->delete();
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $serialNumbers = $this->device->serialNumbers()->get();

        return view('livewire.device-serial-number', compact('serialNumbers'));
    }
}

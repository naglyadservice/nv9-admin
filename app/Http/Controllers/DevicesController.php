<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceRequest;
use App\Models\Device;
use App\Models\FiskalizationKey;
use App\Models\PaymentGateway;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DevicesController extends Controller
{
    public function index(Request $request)
    {
        $owners = User::all();

        if($request->has('owner'))
        {
            $owner = $request->owner;
            if($owner == "0")
            {
                return redirect()->to('/devices');
            }
            $devices = Device::where('user_id', (int)$request->owner)->paginate(75);
        } else {
            $devices = Device::paginate(75);
        }

        return view('dashboard.devices.index', compact('devices', 'owners'));
    }

    public function delete(Request $request, Device $device) : JsonResponse
    {
        $device->delete();
        return response()->json(['success' => true]);
    }

    public function add(Request $request)
    {
        $partners = User::all();
        return view('dashboard.devices.add', compact('partners'));
    }

    public function add_save(DeviceRequest $request)
    {
        $device = new Device();
        $device->fill($request->all());
        $device->device_hash = $device->my_hash();
        $device->save();
        return redirect()->route('devices')->with(['success' => __('Пристрій успішно додано')]);
    }

    public function edit(Request $request, Device $device)
    {
        $userID = Auth::user()->id;
        $myKeys = FiskalizationKey::where('user_id', $userID)->get();
        $partners = User::all();
        $myPayments = PaymentGateway::where('user_id', $userID)->get();
        return view('dashboard.devices.edit', compact('device','partners', 'myKeys', 'myPayments'));
    }

    public function edit_save(Request $request, Device $device)
    {
        if($request->has('enabled'))
        {
            $device->enabled = true;
        } else {
            $device->enabled = false;
        }
        $device->fill($request->all());
        $device->device_hash = $device->my_hash();
        $device->update();
        return redirect()->route('devices')->with(['success' => __('Пристрій успішно змінено')]);
    }

    public function edit_fiscalization(Request $request, Device $device)
    {
        $device->not_fiscal_cash = false;
        if($request->has('not_fiscal_cash'))
        {
            $device->not_fiscal_cash = true;
        }

        if($request->has('enabled_fiscalization'))
        {
            $device->enabled_fiscalization = true;
        } else {
            $device->enabled_fiscalization = false;
        }

        $device->fiscalization_key_id = $request->fiscalization_key_id;

        if($device->fiscalization_key_id == 0)
        {
            $device->fiscalization_key_id = null;
        }


        $device->update();

        $device->updateFiskalizationToken();

        return back()->with(['success' => __('Налаштування фіскалізації успішно збережено')]);
    }

    public function edit_payment(Request $request, Device $device)
    {
        if($request->has('enable_payment'))
        {
            $device->enable_payment = true;
        } else {
            $device->enable_payment = false;
        }

        $device->payment_system_id = $request->payment_system_id;

        if($device->payment_system_id == 0)
        {
            $device->payment_system_id = null;
        }

        $device->update();

        return back()->with(['success' => __('Налаштування оплати успішно збережено')]);
    }
}

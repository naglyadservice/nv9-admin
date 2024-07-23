<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\FiskalizationKey;
use App\Models\PaymentGateway;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PartnersController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $partners = User::whereNot('id', $user->id)->paginate(10);
        return view('dashboard.partners.index', compact('partners'));
    }

    public function delete(Request $request, User $partner): JsonResponse
    {
        $partner->delete();
        return response()->json(['success' => true]);
    }

    public function add(Request $request)
    {
        $partners = User::all();
        return view('dashboard.partners.add', compact('partners'));
    }

    public function add_save(Request $request)
    {
        $partner = new User();
        $partner->fill($request->all());
        $partner->password = Hash::make(Str::random(10));
        $partner->save();
        return redirect()->route('partners')->with(['success' => 'Партнер успешно добавлен']);
    }

    public function edit(Request $request, User $partner)
    {
        $partners = User::all();
        $userID = Auth::user()->id;
        $myKeys = FiskalizationKey::where('user_id', $userID)->get();
        $myPayments = PaymentGateway::where('user_id', $userID)->get();
        return view('dashboard.partners.edit', compact('partner', 'partners', 'myKeys', 'myPayments'));
    }

    public function edit_save(Request $request, User $partner)
    {
        $partner->fill($request->all());
        $partner->update();
        return redirect()->route('partners')->with(['success' => 'Партнер успешно изменен']);
    }


    public function edit_fiscalization(Request $request, User $user)
    {

        if ($request->has('enabled_fiscalization')) {
            $user->enabled_fiscalization = true;
        } else {
            $user->enabled_fiscalization = false;
        }

        $user->fiscalization_key_id = $request->fiscalization_key_id;

        if ($user->fiscalization_key_id == 0) {
            $user->fiscalization_key_id = null;
        }


        $user->update();

        $devices = Device::where(['user_id' => $user->id])->get();
        if (!empty($devices)) {
            foreach ($devices as $device) {
                if ($request->has('enabled_fiscalization')) {
                    $device->enabled_fiscalization = true;
                } else {
                    $device->enabled_fiscalization = false;
                }

                $device->fiscalization_key_id = $request->fiscalization_key_id;

                if ($device->fiscalization_key_id == 0) {
                    $device->fiscalization_key_id = null;
                }


                $device->update();

                $device->updateFiskalizationToken();
            }
        }

        return back()->with(['success' => 'Настройки фискализации успешно сохранены для всех устройств']);
    }


    public function edit_payment(Request $request, User $user)
    {

        if ($request->has('enable_payment')) {
            $user->enable_payment = true;
        } else {
            $user->enable_payment = false;
        }

        $user->payment_system_id = $request->payment_system_id;

        if ($user->payment_system_id == 0) {
            $user->payment_system_id = null;
        }

        $user->update();

        $devices = Device::where(['user_id' => $user->id])->get();
        if (!empty($devices)) {
            foreach ($devices as $device) {
                if ($request->has('enable_payment')) {
                    $device->enable_payment = true;
                } else {
                    $device->enable_payment = false;
                }

                $device->payment_system_id = $request->payment_system_id;

                if ($device->payment_system_id == 0) {
                    $device->payment_system_id = null;
                }

                $device->update();
            }
        }
        return back()->with(['success' => 'Настройки оплаты успешно сохранены']);
    }


}

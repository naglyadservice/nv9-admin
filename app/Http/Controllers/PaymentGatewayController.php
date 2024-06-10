<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentGatewayController extends Controller
{
    public function index(Request $request)
    {
        $userID = Auth::user()->id;
        $mySystems = PaymentGateway::where('user_id', $userID)->paginate(10);
        return view('dashboard.payment_gateways.index', compact('mySystems'));
    }

    public function add(Request $request)
    {
        $userID = Auth::user()->id;

        $system = $request->system;

        $data = [
            "public_key" => $request->public_key,
            "private_key" => $request->private_key
        ];

        $data = serialize($data);

        $paySystem = new PaymentGateway();
        $paySystem->user_id = $userID;
        $paySystem->name = $request->name;
        $paySystem->system = $system;
        $paySystem->data = $data;
        $paySystem->save();

        return redirect()->back()->with(['success' => 'Успешно добавлено']);
    }

    public function delete(Request $request, PaymentGateway $system)
    {
        $devicesInUse = Device::where('payment_system_id', $system->id)->count();
        if ($devicesInUse > 0)
        {
            return response()->json(['success' => false, 'err' => 'Невозможно удалить данную платежную систему, т.к она где-то используется.']);
        } else {
            $system->delete();
            return response()->json(['success' => true]);
        }
    }
}

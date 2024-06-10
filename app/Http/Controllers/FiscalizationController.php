<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FiskalizationKey;

class FiscalizationController extends Controller
{
    public function index(Request $request)
    {
        $userID = Auth::user()->id;
        $keys = FiskalizationKey::where('user_id', $userID)->paginate(10);
        return view('dashboard.fiscalization.index', compact('keys'));
    }

    public function add(Request $request)
    {
        return view('dashboard.fiscalization.add');
    }

    public function save(Request $request)
    {
        $userID = Auth::user()->id;
        $newKey = new FiskalizationKey();
        $newKey->user_id = $userID;
        $newKey->fill($request->all());
        $newKey->save();
        return redirect()->route('fiscalization')->with(['success' => 'Ключ успешно создан.']);
    }

    public function delete(Request $request, FiskalizationKey $key)
    {
        $devicesInUse = Device::where('fiscalization_key_id', $key->id)->count();
        if ($devicesInUse > 0)
        {
            return response()->json(['success' => false, 'err' => 'Невозможно удалить данный ключ, т.к он где-то используется.']);
        } else {
            $key->delete();
            return response()->json(['success' => true]);
        }

    }

    public function edit(Request $request, FiskalizationKey $key)
    {
        return view('dashboard.fiscalization.edit', compact('key'));
    }

    public function edit_save(Request $request, FiskalizationKey $key)
    {
        $key->fill($request->all());
        $key->update();
        return redirect()->route('fiscalization')->with(['success' => 'Ключ успешно изменён.']);
    }
}

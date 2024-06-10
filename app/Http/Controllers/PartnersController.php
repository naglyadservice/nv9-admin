<?php

namespace App\Http\Controllers;

use App\Models\Device;
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

    public function delete(Request $request, User $partner) : JsonResponse
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
        return view('dashboard.partners.edit', compact('partner','partners'));
    }

    public function edit_save(Request $request, User $partner)
    {
        $partner->fill($request->all());
        $partner->update();
        return redirect()->route('partners')->with(['success' => 'Партнер успешно изменен']);
    }
}

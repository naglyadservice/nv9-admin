<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Fiscalization;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index(Request $request)
    {

        // Получаем GET параметры
        $queryParams = request()->query();
        $fiscalizations = Fiscalization::orderBy('id','desc')
            ->when($request->has('factory_number'), function($query) use ($request){
                $query->where('factory_number', 'like', '%' . $request->input('factory_number') . '%');
            })
            ->paginate(20)
            ->appends($queryParams);

        $factoryNumbers = $fiscalizations->pluck('factory_number')->unique();
        $devices = Device::whereIn('factory_number', $factoryNumbers)
            ->orWhereHas('serialNumbers', function($q) use ($factoryNumbers) {
                $q->whereIn('serial_number', $factoryNumbers);
            })
            ->with(['serialNumbers', 'user'])
            ->get();

        $fiscalizations->map(function($fiscalization) use ($devices){
            $device = $devices->filter(function($device) use ($fiscalization){
                return $device->factory_number === $fiscalization->factory_number || $device->serialNumbers->pluck('serial_number')->contains($fiscalization->factory_number);
            })->first();
            $fiscalization->device = $device;
        });

        return view('dashboard.reports.index',[
            'fiscalizations'=>$fiscalizations
        ]);
    }
}

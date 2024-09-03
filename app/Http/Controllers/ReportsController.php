<?php

namespace App\Http\Controllers;

use App\Models\Fiscalization;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index(Request $request)
    {

        // Получаем GET параметры
        $queryParams = request()->query();
        $fiscalizations = Fiscalization::orderBy('id','desc')->with(['device','device.user']);

        if($request->has('factory_number'))
        {
            $fiscalizations = $fiscalizations->where('factory_number', 'like', '%' . $request->input('factory_number') . '%');
        }

        $fiscalizations = $fiscalizations->paginate(20)
        ->appends($queryParams);

        return view('dashboard.reports.index',[
            'fiscalizations'=>$fiscalizations
        ]);
    }
}

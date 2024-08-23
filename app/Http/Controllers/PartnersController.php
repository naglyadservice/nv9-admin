<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\FiskalizationKey;
use App\Models\PaymentGateway;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $devices = Device::where(['user_id' => $partner->id])->get();

        $email = $partner->email;
        $hashedEmail = md5($email);

        return view('dashboard.partners.edit', compact('partner', 'partners', 'myKeys', 'myPayments','devices','hashedEmail'));
    }

    public function edit_save(Request $request, User $partner)
    {
        $partner->fill($request->all());
        $partner->update();
        return redirect()->route('partners')->with(['success' => 'Партнер успешно изменен']);
    }

    public function getSalesReport(Request $request)
    {
        // Получение дат из запроса
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $partnerId = $request->input('user_id');

        $devices = Device::where('user_id', $partnerId)->pluck('factory_number'); // Получаем только factory_number

        if ($devices->isEmpty()) {
            // Если у партнера нет устройств, возвращаем пустой отчет
            return redirect()->back()->withErrors(['message' => 'У партнера нет устройств.']);
        }

        // Запрос с агрегацией
        // Запрос с агрегацией по устройствам партнера
        $salesReport = DB::table('fiskalization_table')
            ->select(
                'factory_number',
                DB::raw('SUM(CASE WHEN cash = 1 AND fiskalized = 1 THEN sales_cashe ELSE 0 END) AS cash_total'),
                DB::raw('SUM(CASE WHEN cash = 0 AND fiskalized = 1 THEN sales_cashe ELSE 0 END) AS non_cash_total'),
                DB::raw('SUM(CASE WHEN fiskalized = 1 THEN sales_cashe ELSE 0 END) AS total_sales')
            )
            ->whereIn('factory_number', $devices) // Фильтруем по factory_number устройств партнера
            ->whereBetween('date', [$startDate, $endDate])
            ->groupBy('factory_number')
            ->orderBy('factory_number')
            ->get();

        // Расчёт сумм
        $totalCash = $salesReport->sum('cash_total');
        $totalNonCash = $salesReport->sum('non_cash_total');
        $totalSales = $salesReport->sum('total_sales');

        // Сохранение отчета, фильтров и сумм в сессию
        $request->session()->flash('salesReport', $salesReport);
        $request->session()->flash('filters', ['start_date' => $startDate, 'end_date' => $endDate]);
        $request->session()->flash('totals', [
            'totalCash' => $totalCash,
            'totalNonCash' => $totalNonCash,
            'totalSales' => $totalSales
        ]);

        // Возвращение на ту же страницу
        return redirect()->back();
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


    public function edit_enabled(Request $request, User $user)
    {

        if ($request->has('enabled')) {
            $user->enabled = true;
        } else {
            $user->enabled = false;
        }

        $user->update();

        $devices = Device::where(['user_id' => $user->id])->get();
        if (!empty($devices)) {
            foreach ($devices as $device) {
                if ($request->has('enabled')) {
                    $device->enabled = true;
                } else {
                    $device->enabled = false;
                }

                $device->update();
            }
        }
        return back()->with(['success' => 'Успешно сохранено']);
    }

    public function edit_design(Request $request, User $user)
    {

        $user->design = $request->design;

        $user->update();

        $devices = Device::where(['user_id' => $user->id])->get();
        if (!empty($devices)) {
            foreach ($devices as $device) {

                $device->design = $request->design;

                $device->update();
            }
        }
        return back()->with(['success' => 'Настройки оплаты успешно сохранены']);
    }

    public function edit_divide_by(Request $request, User $user)
    {

        $user->divide_by = $request->divide_by;

        $user->update();

        $devices = Device::where(['user_id' => $user->id])->get();
        if (!empty($devices)) {
            foreach ($devices as $device) {

                $device->divide_by = $request->divide_by;

                $device->update();
            }
        }
        return back()->with(['success' => 'Настройки оплаты успешно сохранены']);
    }
}

@extends('dashboard.layout.layout')
@section('title', 'Редактирование устройства')

@section('bread')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{__('Редагування партнера')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('Система')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Партнери')}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab">
                            <button class="nav-link active" type="button">{{__('Статистика')}}</button>
                            <button class="nav-link" type="button">{{__('Пристрої')}}</button>
                            <button class="nav-link" type="button">{{__('Налаштування')}}</button>
                            <button class="nav-link" type="button">{{__('Тексти')}}</button>
                        </div>
                    </nav>
                        <div class="tab-content" id="nav-tabContent">

                            <div class="tab-pane fade show active" id="tab-statistics">
                                <div class="row">

                                    <?php if(!$devices->isEmpty()){ ?>

                                    <div class="col-md-12">
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                                <h3 class="card-title">{{__('Пристрої')}}</h3>
                                            </div>

                                            <div class="card-body" style="overflow-x: scroll;">

                                                <table class="table table-striped">
                                                    <tr>
                                                        <td><span>{{__('Номер')}}</span></td>
                                                        <td><span>{{__('Опис')}}</span></td>

                                                        <td>
                                                            {{__('Помилка')}}
                                                        </td>
                                                        <td>  {{__('Остання транзакція')}} </td>
                                                    </tr>

                                                    <?php foreach($devices as $device){
                                                        $fError = $device->getLastFiskalizationError($device->factory_number);
                                                        ?>
                                                    <tr>
                                                        <td><a target="_blank" href="{{route('check_hash', $device->device_hash)}}">{{$device->factory_number}}</a> </td>

                                                        <td>{{$device->place_name}}</td>

                                                        <td error-row>
                                                            {{$fError->error??__('Помилок нема')}}
                                                        </td>

                                                        <td error-date>
                                                            {{$fError->date??''}}
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </table>
                                            </div>

                                        </div>

                                    </div>

                                    <?php } ?>

                                    <!-- Форма фильтрации -->
                                        <form method="GET" action="{{ route('sales.report') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label for="start_date">{{__('Начальна дата')}}</label>
                                                <input type="date" id="start_date" name="start_date" value="{{ session('filters.start_date', now()->subMonth()->format('Y-m-d')) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="end_date">{{__('Кінцева дата')}}</label>
                                                <input type="date" id="end_date" name="end_date" value="{{ session('filters.end_date', now()->format('Y-m-d')) }}" required>
                                            </div>
                                            <input type="hidden" name="user_id" value="{{$partner->id}}">
                                            <button type="submit" class="btn btn-primary">{{__('Отримати звіт')}}</button>
                                        </form>

                                        @if (!empty(session('salesReport')))
                                        @if (!(session('salesReport')->isEmpty()))


                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>{{__('Серійний номер')}}</th>
                                                    <th>{{__('Сума готівки')}}</th>
                                                    <th>{{__('Сума безготівки')}}</th>
                                                    <th>{{__('Загальна сума')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach (session('salesReport') as $report)
                                                    <tr>
                                                        <td>{{ $report->factory_number }}</td>
                                                        <td>{{ round($report->cash_total/100,2) }}</td>
                                                        <td>{{ round($report->non_cash_total/100,2) }}</td>
                                                        <td>{{ round($report->total_sales/100,2) }}</td>
                                                    </tr>
                                                @endforeach
                                                <!-- Строка с суммами -->
                                                <tr>
                                                    <td><strong>Итого</strong></td>
                                                    <td><strong>{{ round(session('totals.totalCash')/100,2) }}</strong></td>
                                                    <td><strong>{{ round(session('totals.totalNonCash')/100,2) }}</strong></td>
                                                    <td><strong>{{ round(session('totals.totalSales')/100,2) }}</strong></td>
                                                </tr>
                                                </tbody>

                                            </table>

                                        @else
                                                {{__('Нічого не знайдено за вказаний період')}}

                                        @endif
                                        @endif
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab-devices">
                                <div class="row">
                                    <?php if(!$devices->isEmpty()){ ?>

                                    <div class="col-md-12">
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                                <h3 class="card-title">{{__('Пристрої')}}</h3>
                                            </div>

                                                <div class="card-body" style="overflow-x: scroll;">

                                                    <table class="table table-striped">
                                                        <tr>
                                                            <td><span>{{__('Номер')}}</span></td>
                                                            <td><span>{{__('Опис')}}</span></td>
                                                            <td><span>URL</span></td>
                                                            <td>
                                                                <span desktop-only>{{__('Налаштування')}}</span>
                                                                <span mobile-only>Set</span>
                                                            </td>
                                                            <td>
                                                                <span desktop-only>{{__('Фіскалізація')}}</span>
                                                                <span mobile-only>{{__('Фіск')}}</span>
                                                            </td>
                                                            <td><span>Оплата</span></td>
                                                        </tr>
                                                    <?php foreach($devices as $device){ ?>
                                                <tr>
                                                    <td><a target="_blank" href="{{route('devices.edit',$device->id)}}">{{$device->factory_number}}</a> </td>

                                                    <td>{{$device->place_name}}</td>

                                                    <td>
                                                        @if($device->device_hash)
                                                        <a href="{{route('check_hash', $device->device_hash)}}" target="_blank">
                                                            <span desktop-only>{{route('check_hash', $device->device_hash)}}</span>
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <a target="_blank" href="{{route('devices.edit',$device->id)}}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </td>
                                                <td>
                                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                        <input disabled @if($device->enabled_fiscalization) checked @endif  type="checkbox" class="custom-control-input" id="fiscEnableField{{$device->id}}">
                                                        <label class="custom-control-label" for="fiscEnableField{{$device->id}}"></label>
                                                    </div>

                                                </td>
                                                    <td>
                                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                            <input disabled @if($device->enable_payment) checked @endif  type="checkbox" class="custom-control-input" id="enable_paymentEnableField{{$device->id}}">
                                                            <label class="custom-control-label" for="enable_paymentEnableField{{$device->id}}"></label>
                                                        </div>

                                                    </td>
                                                </tr>
                                                    <?php } ?>
                                                    </table>
                                                </div>

                                        </div>

                                    </div>

                                    <?php } ?>

                                    <div class="col-md-12">
                                        <div class="card card-secondary">
                                            <a target="_blank" class="btn btn-success" href="{{route('user_page',['userHash'=>$hashedEmail])}}">Ссылка на страницу партнёра</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab-settings">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                                <h3 class="card-title">{{__('Фіскалізація')}}</h3>
                                            </div>

                                            <form method="POST" action="{{route('partners.edit_fiscalization', $partner->id)}}">
                                                <div class="card-body">
                                                    @csrf
                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                            <input @if($partner->enabled_fiscalization) checked @endif name="enabled_fiscalization" type="checkbox" class="custom-control-input" id="fiscEnableField">
                                                            <label class="custom-control-label" for="fiscEnableField">{{__('Включити фіскалізацію')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="user_field_id">{{__('Ключ фіскалізації')}}</label>
                                                        <select name="fiscalization_key_id" class="form-control" id="user_field_id">
                                                            <option value="0">{{__('Ні')}}</option>
                                                            @foreach($myKeys as $key)
                                                                <option @if($partner->fiscalization_key_id == $key->id) selected @endif value="{{$key->id}}">{{$key->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <button type="submit" class="btn btn-primary">{{__('Зберегти')}}</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                                <h3 class="card-title">{{__('Онлайн оплата')}}</h3>
                                            </div>

                                            <form method="POST" action="{{route('partners.edit_payment', $partner->id)}}">
                                                <div class="card-body">
                                                    @csrf
                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                            <input @if($partner->enable_payment) checked @endif name="enable_payment" type="checkbox" class="custom-control-input" id="paymentEnableField">
                                                            <label class="custom-control-label" for="paymentEnableField">{{__('Включити оплату онлайн')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="payment_system_field_id">{{__('Система онлайн оплати')}}</label>
                                                        <select name="payment_system_id" class="form-control" id="payment_system_field_id">
                                                            <option value="0">{{__('Ні')}}</option>
                                                            @foreach($myPayments as $key)
                                                                <option @if($partner->payment_system_id == $key->id) selected @endif value="{{$key->id}}">{{$key->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <button type="submit" class="btn btn-primary">{{__('Зберегти')}}</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                                <h3 class="card-title">{{__('Доступність пристроїв')}}</h3>
                                            </div>

                                            <form method="POST" action="{{route('partners.edit_enabled', $partner->id)}}">
                                                <div class="card-body">
                                                    @csrf
                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                            <input @if($partner->enabled) checked @endif name="enabled" type="checkbox" class="custom-control-input" id="enableField">
                                                            <label class="custom-control-label" for="enableField">{{__('Доступні')}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <button type="submit" class="btn btn-primary">{{__('Зберегти')}}</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                                <h3 class="card-title">{{__('Дизайн')}}</h3>
                                            </div>

                                            <form method="POST" action="{{route('partners.edit_design', $partner->id)}}">
                                                <div class="card-body">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="design">{{__('Дизайни')}}</label>
                                                        <select name="design" class="form-control" id="design">
                                                            @foreach(\App\Models\Device::getDesigns() as $key => $name)
                                                                <option @if($partner->design == $key) selected @endif value="{{$key}}">{{$name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <button type="submit" class="btn btn-primary">{{__('Зберегти')}}</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                                <h3 class="card-title">{{__('Кратність')}}</h3>
                                            </div>

                                            <form method="POST" action="{{route('partners.edit_divide_by', $partner->id)}}">
                                                <div class="card-body">
                                                    @csrf
                                                    <div class="form-group">
                                                        <input type="text"  class="form-control" name="divide_by" value="{{$partner->divide_by}}">
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <button type="submit" class="btn btn-primary">{{__('Зберегти')}}</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab-texts">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">{{__('Заповніть дані')}}</h3>
                                    </div>

                                    <form method="POST">
                                        <div class="card-body">
                                            @csrf
                                            <x-my-field value="{{$partner->name}}" name="name" title="{{__('Им`я (назва)')}}" type="text"></x-my-field>
                                            <x-my-field value="{{$partner->email}}" name="email" title="{{__('Пошта')}}" type="email"></x-my-field>
                                            <x-my-field value="{{$partner->title}}" name="title" title="{{__('Заголовок')}}" type="text"></x-my-field>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <x-my-field value="{{$partner->address}}" name="address" title="{{__('Адреса')}}" type="text"></x-my-field>
                                            </div>
                                            {{-- <div class="col-md-6">
                                                <x-my-field value="{{$partner->water}}" name="water" title="Вода" type="text"></x-my-field>
                                            </div>--}}
                                            <div class="col-md-12">

                                            <div class="form-group">
                                                <label for="extra_text">{{__('Доп текст')}}</label>
                                                <br>
                                                <textarea name="extra_text" id="extra_text">{{ $partner->extra_text }}</textarea>
                                            </div>
                                            </div>
                                        </div>

                                            <div class="form-group">
                                                <label for="privacy_policy">{{__('Політика конфіденційності')}}</label>
                                                <br>
                                                <textarea name="privacy_policy" id="privacy_policy">{{ $partner->privacy_policy }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="oferta">{{__('Договір оферти')}}</label>
                                                <br>
                                            <textarea name="oferta" id="oferta">{{ $partner->oferta }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="email_field_id3">{{__('Про нас')}}</label>
                                                <br>
                                                <textarea name="about_us" id="about_us">{{ $partner->about_us }}</textarea>
                                            </div>

                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">{{__('Зберегти')}}</button>
                                        </div>
                                    </form>

                                </div>
                            </div>

                    </div>
                </div>
            </div>

            <script>
                try {
                    const tabButtons = document.querySelectorAll("#nav-tab button");
                    const tabContent = document.querySelectorAll("#nav-tabContent .tab-pane");

                    tabButtons.forEach((_, index) => {
                        tabButtons[index].onclick = () => {
                            tabButtons.forEach(item => item.classList.remove("active"));
                            tabContent.forEach(item => item.classList.remove("show", "active"));

                            tabButtons[index].classList.add("active");
                            tabContent[index].classList.add("show", "active");
                        }
                    })

                    const errorRow = document.querySelectorAll('[error-row]');

                    errorRow.forEach(item => {
                        const text = item.textContent;
                        if (text) item.textContent = text.trim().slice(0, 50)
                    });

                    const errorDateField = document.querySelectorAll('[error-date]');
                    const dateNow = new Date()

                    errorDateField.forEach(item => {
                        const text = item.textContent;
                        const date = new Date(text);

                        if (date) {
                            const diff = dateNow - date;

                            if (diff <= 6) {
                                return item;
                            } else if (diff <= 12) {
                                return item.style.color = "yellow";
                            } else if (diff <= 24) {
                                return item.style.color = "orange";
                            } else {
                                return item.style.color = "red";
                            }
                        }
                    })
                } catch (error) {
                    console.warn(error)
                }
            </script>

            <style>
                @media (min-width: 700px) {
                    #tab-devices table td:nth-child(3) i {
                        display: none;
                    }

                    *[mobile-only] {
                        display: none;
                    }
                }

                @media (max-width: 700px) {
                    *[desktop-only] {
                        display: none;
                    }

                    #tab-devices .card-body,
                    #tab-statistics .card-body{
                        padding: 0;
                    }

                    #tab-devices td,
                    #tab-statistics td {
                        padding: 0.75rem 0.5rem;
                    }

                    #tab-devices table td,
                    #tab-statistics table td {
                        text-align: center;
                    }

                    #tab-devices table td:nth-child(3) {
                        max-width: 150px;
                    }

                    #tab-devices table td:nth-child(3) a {
                        display: block;
                        width: 100%;
                        overflow: hidden;
                        text-wrap: nowrap;
                    }
                }

                @media (max-width: 500px) {
                    #tab-devices table td:nth-child(3) {
                        max-width: 100px;
                    }

                    #tab-devices td {
                        padding: 0.75rem 0.25rem;
                    }
                }
            </style>

        </div>
    </section>

@section('scrips')
    @parent
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('privacy_policy');
        CKEDITOR.replace('oferta');
        CKEDITOR.replace('about_us');
        CKEDITOR.replace('extra_text');
    </script>
@endsection

@endsection

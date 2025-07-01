@extends('dashboard.layout.layout')
@section('title', 'Редактирование устройства')

@section('bread')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{__('Редагування пристрою')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('Система')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Пристрої')}}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">

            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
                <script>
                    setTimeout(function(){
                        $("div.alert.alert-success").slideUp(1000);
                    }, 3000);
                </script>
            @endif

            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{__('Основні дані')}}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="">
                            <div class="card-body">
                                @csrf
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input @if($device->enabled) checked @endif name="enabled" type="checkbox" class="custom-control-input" id="enableField">
                                        <label class="custom-control-label" for="enableField">{{__('Доступний')}}</label>
                                    </div>
                                </div>
                                <x-my-field value="{{$device->factory_number}}" name="factory_number" title="{{__('Серійний номер')}}" type="text"></x-my-field>
                                 <x-my-field value="{{$device->address}}" name="address" title="{{__('Адреса')}}" type="text"></x-my-field>
                                <x-my-field value="{{$device->place_name}}" name="place_name" title="{{__('Назва місця')}}" placeholder="{{__('Наприклад Піст №4')}}" type="text"></x-my-field>

                                <x-my-field value="{{$device->divide_by}}" name="divide_by" title="{{__('Кратність')}}" type="text"></x-my-field>


                                <div class="form-group">
                                    <label for="user_field_id">{{__('Дизайн')}}</label>
                                    <select name="design" class="form-control" id="design">
                                        @foreach(\App\Models\Device::getDesigns() as $key => $name)
                                            <option @if($device->design == $key) selected @endif value="{{$key}}">{{$name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="user_field_id">{{__('Приналежність')}}</label>
                                    <select name="user_id" class="form-control" id="user_field_id">
                                        @foreach($partners as $partner)
                                            <option @if($partner->id == $device->user_id) selected @endif value="{{$partner->id}}">{{$partner->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <x-my-field value="{{$device->service}}" name="service" title="{{__('Послуга')}}" type="text"></x-my-field>


                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{__('Зберегти')}}</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                    <!-- /.card -->
                </div>
                <!-- right column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">{{__('Фіскалізація')}}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="{{route('devices.edit_fiscalization', $device->id)}}">
                            <div class="card-body">
                                @csrf
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input @if($device->enabled_fiscalization) checked @endif name="enabled_fiscalization" type="checkbox" class="custom-control-input" id="fiscEnableField">
                                        <label class="custom-control-label" for="fiscEnableField">{{__('Включити фіскалізацію')}}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input @if($device->not_fiscal_cash) checked @endif name="not_fiscal_cash" type="checkbox" class="custom-control-input" id="not_fiscal_cash">
                                        <label class="custom-control-label" for="not_fiscal_cash">{{__('Не фіскалізувати готівку')}}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="user_field_id">{{__('Ключ фіскалізації')}}</label>
                                    <select name="fiscalization_key_id" class="form-control" id="user_field_id">
                                        <option value="0">{{__('Ні')}}</option>
                                        @foreach($myKeys as $key)
                                            <option @if($device->fiscalization_key_id == $key->id) selected @endif value="{{$key->id}}">{{$key->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{__('Зберегти')}}</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">{{__('Онлайн оплата')}}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="{{route('devices.edit_payment', $device->id)}}">
                            <div class="card-body">
                                @csrf
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input @if($device->enable_payment) checked @endif name="enable_payment" type="checkbox" class="custom-control-input" id="paymentEnableField">
                                        <label class="custom-control-label" for="paymentEnableField">{{__('Включити оплату онлайн')}}</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="payment_system_field_id">{{__('Система онлайн оплати')}}</label>
                                    <select name="payment_system_id" class="form-control" id="payment_system_field_id">
                                        <option value="0">Нет</option>
                                        @foreach($myPayments as $key)
                                            <option @if($device->payment_system_id == $key->id) selected @endif value="{{$key->id}}">{{$key->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{__('Зберегти')}}</button>
                            </div>
                        </form>
                    </div>

                    <!-- /.card -->
                </div>
                <!--/.col (right) -->
            </div>

            <div class="row">
                <div class="col">
                    <livewire:device-serial-number :device="$device"/>
                </div>
            </div>
        </div>
    </section>
@endsection

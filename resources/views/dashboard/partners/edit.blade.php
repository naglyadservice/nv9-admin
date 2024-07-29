@extends('dashboard.layout.layout')
@section('title', 'Редактирование устройства')

@section('bread')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Редактирование устройства</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Система</a></li>
                        <li class="breadcrumb-item active">Устройства</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">


            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Заполните данные</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST">
                            <div class="card-body">
                                @csrf
                                <x-my-field value="{{$partner->name}}" name="name" title="Имя (название)" type="text"></x-my-field>
                                <x-my-field value="{{$partner->email}}" name="email" title="Почта" type="email"></x-my-field>
                                <x-my-field value="{{$partner->title}}" name="title" title="Заголовок" type="text"></x-my-field>

                               <div class="row">
                                   <div class="col-md-12">
                                       <x-my-field value="{{$partner->address}}" name="address" title="Адрес" type="text"></x-my-field>
                                   </div>
                                  {{-- <div class="col-md-6">
                                       <x-my-field value="{{$partner->water}}" name="water" title="Вода" type="text"></x-my-field>
                                   </div>--}}
                                   <div class="col-md-6">
                                       <x-my-field value="{{$partner->water_value}}" name="water_value" title="Цена воды" type="text"></x-my-field>
                                   </div>

                                  {{-- <div class="col-md-6">
                                       <x-my-field value="{{$partner->foam}}" name="foam" title="Пена" type="text"></x-my-field>
                                   </div>--}}
                                   <div class="col-md-6">
                                       <x-my-field value="{{$partner->foam_value}}" name="foam_value" title="Цена пены" type="text"></x-my-field>
                                   </div>

                                 {{--  <div class="col-md-6">
                                       <x-my-field value="{{$partner->osmosis}}" name="osmosis" title="Осмос" type="text"></x-my-field>
                                   </div>--}}
                                   <div class="col-md-6">
                                       <x-my-field value="{{$partner->osmosis_value}}" name="osmosis_value" title="Цена осмоса" type="text"></x-my-field>
                                   </div>

                                  {{-- <div class="col-md-6">
                                       <x-my-field value="{{$partner->air}}" name="air" title="Воздух" type="text"></x-my-field>
                                   </div>--}}
                                   <div class="col-md-6">
                                       <x-my-field value="{{$partner->air_value}}" name="air_value" title="Цена воздуха" type="text"></x-my-field>
                                   </div>

                                 {{--  <div class="col-md-6">
                                       <x-my-field value="{{$partner->dust_cleaner}}" name="dust_cleaner" title="Пылеочиститель" type="text"></x-my-field>
                                   </div>--}}
                                   <div class="col-md-6">
                                       <x-my-field value="{{$partner->dust_cleaner_value}}" name="dust_cleaner_value" title="Цена пылеочистителя" type="text"></x-my-field>
                                   </div>

                                   {{--<div class="col-md-6">
                                       <x-my-field value="{{$partner->cleaner}}" name="cleaner" title="Очиститель" type="text"></x-my-field>
                                   </div>--}}
                                   <div class="col-md-6">
                                       <x-my-field value="{{$partner->cleaner_value}}" name="cleaner_value" title="Цена очистителя" type="text"></x-my-field>
                                   </div>
                               </div>

                                <div class="form-group">
                                    <label for="email_field_id">Политика кофиденциальности</label>
                                    <br>
                                    <textarea name="privacy_policy" id="privacy_policy">{{ $partner->privacy_policy }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="email_field_id2">Договор оферты</label>
                                    <br>
                                 <textarea name="oferta" id="oferta">{{ $partner->oferta }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="email_field_id3">Про нас</label>
                                    <br>
                                    <textarea name="about_us" id="about_us">{{ $partner->about_us }}</textarea>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                    <!-- /.card -->
                </div>
                <!--/.col (right) -->


                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Фискализация</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="{{route('partners.edit_fiscalization', $partner->id)}}">
                            <div class="card-body">
                                @csrf
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input @if($partner->enabled_fiscalization) checked @endif name="enabled_fiscalization" type="checkbox" class="custom-control-input" id="fiscEnableField">
                                        <label class="custom-control-label" for="fiscEnableField">Включить фискализацию</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="user_field_id">Ключ фискализации</label>
                                    <select name="fiscalization_key_id" class="form-control" id="user_field_id">
                                        <option value="0">Нет</option>
                                        @foreach($myKeys as $key)
                                            <option @if($partner->fiscalization_key_id == $key->id) selected @endif value="{{$key->id}}">{{$key->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Онлайн оплата</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="{{route('partners.edit_payment', $partner->id)}}">
                            <div class="card-body">
                                @csrf
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input @if($partner->enable_payment) checked @endif name="enable_payment" type="checkbox" class="custom-control-input" id="paymentEnableField">
                                        <label class="custom-control-label" for="paymentEnableField">Включить онлайн оплату</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="payment_system_field_id">Система онлайн оплаты</label>
                                    <select name="payment_system_id" class="form-control" id="payment_system_field_id">
                                        <option value="0">Нет</option>
                                        @foreach($myPayments as $key)
                                            <option @if($partner->payment_system_id == $key->id) selected @endif value="{{$key->id}}">{{$key->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </form>
                    </div>

                    <!-- /.card -->
                </div>


                <div class="col-md-4">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Доступность устройств</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="{{route('partners.edit_enabled', $partner->id)}}">
                            <div class="card-body">
                                @csrf
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input @if($partner->enabled) checked @endif name="enabled" type="checkbox" class="custom-control-input" id="enableField">
                                        <label class="custom-control-label" for="enableField">Доступны</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-md-4">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Дизайн</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="{{route('partners.edit_design', $partner->id)}}">
                            <div class="card-body">
                                @csrf
                                <div class="form-group">
                                    <label for="design">Дизайны</label>
                                    <select name="design" class="form-control" id="design">
                                        @foreach(\App\Models\Device::getDesigns() as $key => $name)
                                            <option @if($partner->design == $key) selected @endif value="{{$key}}">{{$name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-md-4">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Кратность</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="{{route('partners.edit_divide_by', $partner->id)}}">
                            <div class="card-body">
                                @csrf
                                <div class="form-group">
                                    <input type="text"  class="form-control" name="divide_by" value="{{$partner->divide_by}}">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-md-6">
                    <div class="card card-secondary">
                        <a target="_blank" class="btn btn-success" href="{{route('user_page',['userHash'=>$hashedEmail])}}">Ссылка на страницу партнёра</a>
                    </div>
                </div>
                <?php if(!$devices->isEmpty()){ ?>
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Устройства</h3>
                        </div>

                            <div class="card-body">

                                <table class="table table-striped">
                                    <tr>
                                        <td>Номер</td>
                                        <td>Опис</td>
                                        <td>URL</td>
                                        <td>Settings</td>
                                        <td>Доступность</td>
                                    </tr>
                                <?php foreach($devices as $device){ ?>
                            <tr>
                                <td><a target="_blank" href="{{route('devices.edit',$device->id)}}">{{$device->factory_number}}</a> </td>

                                <td>{{$device->place_name}}</td>
                                <td>@if($device->device_hash) <a href="{{route('check_hash', $device->device_hash)}}" target="_blank">{{route('check_hash', $device->device_hash)}}</a> @endif</td>
                                <td><a target="_blank" href="{{route('devices.edit',$device->id)}}">{{$device->factory_number}} <i class="fas fa-edit"></i></a></td>
                            <td>
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input disabled @if($device->enabled_fiscalization) checked @endif  type="checkbox" class="custom-control-input" id="fiscEnableField{{$device->id}}">
                                    <label class="custom-control-label" for="fiscEnableField{{$device->id}}">Включить фискализацию</label>
                                </div>

                            </td>
                            </tr>
                                <?php } ?>
                                </table>
                            </div>

                    </div>

                </div>
                <?php } ?>

            </div>

        </div>
    </section>

@section('scrips')
    @parent
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('privacy_policy');
        CKEDITOR.replace('oferta');
        CKEDITOR.replace('about_us');
    </script>
@endsection

@endsection

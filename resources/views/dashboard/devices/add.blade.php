@extends('dashboard.layout.layout')
@section('title', 'Добавление устройства')

@section('bread')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{__('Додавання пристрою')}}</h1>
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


            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{__('Заповніть дані')}}</h3>
                        </div>
                        <!-- /.card-header -->

                        <!-- form start -->
                        <form method="POST">
                            <div class="card-body">
                                @csrf
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input name="enabled" type="checkbox" class="custom-control-input" id="enableField">
                                        <label class="custom-control-label" for="enableField">{{__('Доступний')}}</label>
                                    </div>
                                </div>
                                <x-my-field name="factory_number" title="{{__('Серійний номер')}}" type="text"></x-my-field>
                                <x-my-field name="address" title="{{__('Адреса')}}" type="text"></x-my-field>
                                <x-my-field name="place_name" title="{{__('Назва місця')}}" placeholder="{{__('Наприклад Піст №4')}}" type="text"></x-my-field>

                                <x-my-field  name="divide_by" title="{{__('Кратність')}}" type="text"></x-my-field>


                                <div class="form-group">
                                    <label for="user_field_id">{{__('Дизайн')}}</label>
                                    <select name="design" class="form-control" id="design">
                                        @foreach(\App\Models\Device::getDesigns() as $key => $name)
                                            <option value="{{$key}}">{{$name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="user_field_id">{{__('Приналежність')}}</label>
                                    <select name="user_id" class="form-control" id="user_field_id">
                                        @foreach($partners as $partner)
                                            <option value="{{$partner->id}}">{{$partner->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-my-field name="service" title="{{__('Послуга')}}" type="text"></x-my-field>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{__('Додати')}}</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                    <!-- /.card -->
                </div>
                <!--/.col (right) -->
            </div>



        </div>
    </section>
@endsection

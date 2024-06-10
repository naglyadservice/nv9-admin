@extends('dashboard.layout.layout')
@section('title', 'Добавление устройства')

@section('bread')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Добавление устройства</h1>
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
                <div class="col-md-6">
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
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input name="enabled" type="checkbox" class="custom-control-input" id="enableField">
                                        <label class="custom-control-label" for="enableField">Доступен</label>
                                    </div>
                                </div>
                                <x-my-field name="factory_number" title="Серийный номер" type="text"></x-my-field>
                                <x-my-field name="address" title="Адрес" type="text"></x-my-field>
                                <x-my-field name="place_name" title="Название места" placeholder="Например Пост №4" type="text"></x-my-field>
                                <div class="form-group">
                                    <label for="user_field_id">Принадлежность</label>
                                    <select name="user_id" class="form-control" id="user_field_id">
                                        @foreach($partners as $partner)
                                            <option value="{{$partner->id}}">{{$partner->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-my-field name="service" title="Послуга" type="text"></x-my-field>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Добавить устройство</button>
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

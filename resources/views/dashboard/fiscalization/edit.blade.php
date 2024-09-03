@extends('dashboard.layout.layout')
@section('title', 'Редактирование ключа фискализации')

@section('bread')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{__('Редагування ключа фіскалізації')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">{{__('Система')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{route('fiscalization')}}">{{__('Ключі фіскалізації')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Редагування ключа фіскалізації')}}</li>
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

                                <x-my-field name="name" value="{!! $key->name !!}" title="{{__('Назва')}}" placeholder="{{__('ФОП Роги та копита')}}" type="text"></x-my-field>
                                <x-my-field name="cashier_login" value="{{$key->cashier_login}}" title="{{__('Логін касира')}}" type="text"></x-my-field>
                                <x-my-field name="cashier_password" value="{{$key->cashier_password}}" title="{{__('Пароль касира')}}" type="text"></x-my-field>
                                <x-my-field name="cashier_license_key" value="{{$key->cashier_license_key}}" title="{{__('Ключ ліцензії каси')}}" type="text"></x-my-field>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{__('Зберегти')}}</button>
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

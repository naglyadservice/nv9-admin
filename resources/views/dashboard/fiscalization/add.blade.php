@extends('dashboard.layout.layout')
@section('title', 'Добавление ключа фискализации')

@section('bread')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Добавление ключа фискализации</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Система</a></li>
                        <li class="breadcrumb-item"><a href="{{route('fiscalization')}}">Ключи фискализации</a></li>
                        <li class="breadcrumb-item active">Добавление ключа фискализации</li>
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

                                <x-my-field name="name" title="Название" placeholder="ФОП Рога и копыта" type="text"></x-my-field>
                                <x-my-field name="cashier_login" title="Логин касира" type="text"></x-my-field>
                                <x-my-field name="cashier_password" title="Пароль касира" type="text"></x-my-field>
                                <x-my-field name="cashier_license_key" title="Ключ лицензии кассы" type="text"></x-my-field>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Добавить ключ</button>
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

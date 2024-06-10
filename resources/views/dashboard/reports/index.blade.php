@extends('dashboard.layout.layout')
@section('title', 'Партнеры')

@section('bread')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Управление партнерами</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Система</a></li>
                        <li class="breadcrumb-item active">Партнеры</li>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Партнеры</h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;justify-content: flex-end;">
                                    <div class="input-group-append">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Автомат</th>
                                    <th>Владелец</th>
                                    <th>Сумма фискализации (грн)</th>
                                    <th>Дата/время</th>
                                    <th>Управление отчётом</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <td colspan="6" style="text-align: center;">Нет данных для отчёта</td>
                                </tbody>
                            </table>
                            <div class="pagi">

                            </div>

                        </div>

                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>
    </section>
@endsection

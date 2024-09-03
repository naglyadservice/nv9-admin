@extends('dashboard.layout.layout')
@section('title', 'Партнеры')

@section('bread')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{__('Управління Звітами')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('Система')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Звіти')}}</li>
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
                            <h3 class="card-title">{{__('Звіти')}}</h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;justify-content: flex-end;">
                                    <div class="input-group-append">
                                        <div class="row">
                                        <div class="col-lg-6" style="text-align: right;">{{__('Серійний номер')}}:</div>
                                        <div class="col-lg-6">
                                            <form method="GET">
                                                <input class="" value="{{ request('factory_number')??''}}" type="text" name="factory_number">
                                            </form>
                                        </div>
                                        </div>
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
                                    <th>{{__('Автомат')}}</th>
                                    <th>{{__('Власник')}}</th>
                                    <th>{{__('Сума фіскалізації (грн)')}}</th>
                                    <th>{{__('Дата/час')}}</th>
                                    <th>{{__('Sales Code')}}</th>
                                   {{-- <th>{{__('Check Code')}}</th>--}}
                                    <th>{{__('Тип оплати (Готівка / Картка)')}}</th>
                                    <th>{{__('Фіскалізовано')}}</th>
                                    <th>{{__('Помилка')}}</th>

                                    <th>{{__('Управління звітом')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(!$fiscalizations->isEmpty()){ ?>
                                <?php foreach($fiscalizations as $fiscalization){ ?>
                                <tr>
                                    <td>{{$fiscalization->id}}</td>
                                    <td>
                                        @if($fiscalization->device->device_hash)
                                            <a desktop-only href="{{route('check_hash', $fiscalization->device->device_hash)}}" target="_blank">{{$fiscalization->factory_number}}</a>
                                            <a mobile-only href="{{route('check_hash', $fiscalization->device->device_hash)}}" target="_blank"><i class="fas fa-link"></i></a>
                                        @endif
                                    </td>
                                    <td>

                                        <a href="{{route('partners.edit',['partner'=>$fiscalization->device->user->id])}}">{{$fiscalization->device->user->name??''}}</a>

                                    </td>
                                    <td>{{round($fiscalization->sales_cashe/100,2)}} (грн)</td>
                                    <td>{{$fiscalization->date}}</td>
                                    <td>{{$fiscalization->sales_code}}</td>
                                  {{--  <td>
                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">

                                        <input disabled @if(empty($fiscalization->check_code)) checked @endif  type="checkbox" class="custom-control-input" id="fiscEnableField{{$fiscalization->id}}">
                                        <label class="custom-control-label" for="fiscEnableField{{$fiscalization->id}}"></label>
                                        </div>

                                    </td>--}}
                                    <td>
                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">

                                            <input disabled @if(empty($fiscalization->cash)) checked @endif  type="checkbox" class="custom-control-input" id="fiscEnableField{{$fiscalization->id}}">
                                            <label class="custom-control-label" for="fiscEnableField{{$fiscalization->id}}"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if(!empty($fiscalization->check_code) && empty($fiscalization->error)){ ?>
                                        V
                                        <?php } else { ?>
                                        X
                                        <?php } ?>
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit($fiscalization->error, 50) }}</td>

                                    <td></td>
                                </tr>
                                <?php } ?>
                                <?php } else{ ?>
                                    <td colspan="6" style="text-align: center;">{{__('Немає даних для звіту')}}</td>
                               <?php } ?>
                                </tbody>
                            </table>
                            <div class="pagi">
                                {{$fiscalizations->links()}}
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

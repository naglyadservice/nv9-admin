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
                                <div class="row">
                                    <div class="col-lg-6" style="text-align: right;">{{__('Серійний номер')}}:</div>
                                    <div class="col-lg-6">
                                        <form method="GET" style="text-align: right;">
                                            <input style="width: 100%; max-width: 100px; text-align: left;" value="{{ request('factory_number')??''}}" type="text" name="factory_number">
                                        </form>
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
                                        <th>{{__('Сума')}}</th>
                                        <th>{{__('Дата')}}</th>
                                        <th>{{__('Code')}}</th>
                                    {{-- <th>{{__('Check Code')}}</th>--}}
                                        <th>{{__('Тип')}}</th>
                                        <th desktop-only>{{__('Фіскалізовано')}}</th>
                                        <th mobile-only>{{__('Фіск')}}</th>
                                        <th>{{__('Помилка')}}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php if(!$fiscalizations->isEmpty()){ ?>
                                <?php foreach($fiscalizations as $fiscalization){ ?>
                                <tr>
                                    <td>{{$fiscalization->id}}</td>

                                    <td>
                                        @if(!empty($fiscalization->device))
                                        @if($fiscalization->device->device_hash)
                                            <a desktop-only href="{{route('check_hash', $fiscalization->device->device_hash)}}" target="_blank">{{$fiscalization->factory_number}}</a>
                                            <a mobile-only href="{{route('check_hash', $fiscalization->device->device_hash)}}" target="_blank"><i class="fas fa-link"></i></a>
                                        @endif
                                        @endif
                                    </td>

                                    <td>
                                        <?php if(!empty($fiscalization->device->user)){ ?>
                                        <a href="{{route('partners.edit',['partner'=>$fiscalization->device->user->id])}}">{{$fiscalization->device->user->name??''}}</a>
                                        <?php } ?>
                                    </td>

                                    <td>{{round($fiscalization->sales_cashe/100,2)}} (грн)</td>

                                    <td>{{$fiscalization->date}}</td>

                                    <td>{{$fiscalization->sales_code}}</td>

                                    {{--    
                                    <td>
                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input disabled @if(empty($fiscalization->check_code)) checked @endif  type="checkbox" class="custom-control-input" id="fiscEnableField{{$fiscalization->id}}">
                                            <label class="custom-control-label" for="fiscEnableField{{$fiscalization->id}}"></label>
                                        </div>
                                    </td>   
                                    --}}

                                    <td>
                                        @if(empty($fiscalization->cash)) 
                                            <i class="far fa-credit-card" id="fiscEnableField{{$fiscalization->id}}"></i>        
                                        @else
                                            <i class="fas fa-coins" id="fiscEnableField{{$fiscalization->id}}"></i>
                                        @endif
                                    </td>

                                    <td>
                                        <?php if(!empty($fiscalization->check_code) && empty($fiscalization->error)){ ?>
                                            <a href="https://check.checkbox.ua/{{$fiscalization->check_code}}">
                                                <i class="fas fa-check-circle"></i>
                                            </a>
                                        <?php } else { ?>
                                            <i class="fas fa-times"></i>
                                        <?php } ?>
                                    </td>

                                    <td error-row>{{ \Illuminate\Support\Str::limit($fiscalization->error, 50) }}</td>
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

        <script>
            try {
                const errorRow = document.querySelectorAll('[error-row]');

                errorRow.forEach(item => {
                    const text = item.textContent;
                    if (text) item.textContent = text.trim().slice(0, 50)
                });
            } catch (error) {
                console.warn(error)
            }
        </script>

        <style>
            @media (min-width: 700px) {
                *[mobile-only] {
                    display: none;
                }
            }

            @media (max-width: 700px) {
                *[desktop-only] {
                    display: none;
                }

                th, td {
                    text-wrap: wrap;
                    text-align: center;
                    padding: 0.75rem 0.5rem !important;
                }
            }
        </style>
    </section>


@endsection

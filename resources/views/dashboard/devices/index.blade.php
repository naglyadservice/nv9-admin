@extends('dashboard.layout.layout')
@section('title', 'Devices')

@section('bread')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('Пристрої')}}</h1>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Пристрої')}}</h3>

                        <div class="card-tools">

                            <div class="input-group input-group-sm" style="width: 340px;justify-content: flex-end;align-items: center;">

                            <div class="col-lg-4" style="text-align: right;">{{__('Власник')}}:</div>
                            <div class="col-lg-6">
                                <form method="GET">
                                    <select id="ownerFilter" name="owner" class="form-control">
                                        <option value="0">All</option>
                                        @foreach($owners as $owner)
                                            <option @if($owner->id == request()->owner) selected @endif value="{{$owner->id}}">{{$owner->name}}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>

                            <div class="input-group-append">
                                    <a href="{{route('devices.add')}}">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </a>
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
                                <th>SN</th>
                                <th>{{__('Власник')}}</th>
                              {{--  <th>ADRESS</th>--}}
                                <th>URL</th>
                                <th>{{__('Фіскалізація')}}</th>
                                <th>{{__('Управління')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($devices as $device)
                                    <tr>
                                        <td>{{$device->id}}</td>
                                        <td>{{$device->factory_number}}</td>
                                        <td>{{$device->user->name}}</td>
                                       {{-- <td>{{$device->address}}</td>--}}
                                        <td>
                                            @if($device->device_hash)
                                            <a desktop-only href="{{route('check_hash', $device->device_hash)}}" target="_blank">{{route('check_hash', $device->device_hash)}}</a>
                                            <a mobile-only href="{{route('check_hash', $device->device_hash)}}" target="_blank"><i class="fas fa-link"></i></a>
                                            @endif
                                        </td>
                                        <td>{{$device->fiszalization_status}}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-secondary editDevice" data-id="{{$device->id}}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger deleteDevice" data-id="{{$device->id}}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

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

                        <div class="pagi">
                            {{$devices->links()}}
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

@section('scrips')
    <script>
        $(document).ready(function(){

            $('.editDevice').click(function(){
                let deviceID = $(this).data('id');
                window.location.href = `/devices/${deviceID}/edit`;
            });

            $('.deleteDevice').click(function(){

                var deleteDeviceID = $(this).data('id');

                $.confirm({
                    title: 'Необхідне підтвердження',
                    content: 'Ви впевнені, що хочете видалити пристрій?',
                    autoClose: 'no|9000',
                    buttons: {
                        yes: {
                            text: 'Видалити',
                            btnClass: 'btn-red',
                            action: function () {
                                $.post(`/devices/${deleteDeviceID}/delete`, function(resp){
                                    $.alert({
                                        title: 'Видалення',
                                        content: 'Пристрій успішно видалено',
                                        onClose: function () {
                                            window.location.reload();
                                        },
                                    });

                                });
                            }
                        },
                        no: {
                            text: 'Відміна',
                            btnClass: 'btn-secondary',
                        }
                    }
                });

            });

        });

        $("#ownerFilter").change(function()
        {
            $(this).parent().submit();
        });
    </script>
@endsection

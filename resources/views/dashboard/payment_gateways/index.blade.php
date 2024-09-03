@extends('dashboard.layout.layout')
@section('title', 'Управление платежными системами')

@section('bread')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{__('Управління платіжними системами')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{__('Система')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Управління платіжними системами')}}</li>
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
                            <h3 class="card-title">{{__('Платіжні системи')}}</h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;justify-content: flex-end;">
                                    <div class="input-group-append">
                                        <a href="#" data-toggle="modal" data-target="#addPaymentModal">
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
                                    <th>{{__('Назва')}}</th>
                                    <th>{{__('Платіжна система')}}</th>
                                    <th>{{__('Додано')}}</th>
                                    <th>{{__('Управління')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($mySystems as $system)
                                        <tr>
                                        <td>{{$system->name}}</td>
                                        <td>{{\App\Models\PaymentGateway::systems()[$system->system]}}</td>
                                        <td>{{\Carbon\Carbon::parse($system->created_at)->format('d.m.Y - H:i')}}</td>
                                        <td>
                                            <div class="btn-group" role="group">
{{--                                                <button type="button" class="btn btn-secondary editKey" data-id="{{$system->id}}">--}}
{{--                                                    <i class="fas fa-edit"></i>--}}
{{--                                                </button>--}}
                                                <button type="button" class="btn btn-danger deleteSystem" data-id="{{$system->id}}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                        </tr>
                                    @endforeach
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

    <!-- Modal -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('Виберіть платіжну систему')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{__('Платіжна система')}}</label>
                            <select name="system" class="form-control">
                                @foreach(\App\Models\PaymentGateway::systems() as $key => $system)
                                    <option value="{{$key}}">{{$system}}</option>
                                @endforeach
                            </select>
                        </div>

                        <x-my-field type="text" name="name" title="{{__('Назва')}}" placeholder="{{__('ФОП Роги та копита')}}"></x-my-field>
                        <x-my-field type="text" name="public_key" title="Public key" placeholder="{{__('Публічний ключ')}}"></x-my-field>
                        <x-my-field type="text" name="private_key" title="Private key" placeholder="{{__('Приватний ключ')}}"></x-my-field>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Відміна')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Додати')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('scrips')
    <script>
        $(document).ready(function(){

            $('.editSystem').click(function(){
                let editID = $(this).data('id');
                window.location.href = `/payment-gateways/${editID}/edit`;
            });

            $('.deleteSystem').click(function(){

                var deleteID = $(this).data('id');

                $.confirm({
                    title: 'Необхідне підтвердження',
                    content: 'Ви впевнені, що хочете видалити платіжну систему?',
                    autoClose: 'no|9000',
                    buttons: {
                        yes: {
                            text: 'Видалити',
                            btnClass: 'btn-red',
                            action: function () {
                                $.post(`/payment-gateways/${deleteID}/delete`, function(resp){
                                    if(resp.success)
                                    {
                                        $.alert({
                                            title: 'Видалення',
                                            content: 'Платіжну систему успішно видалено',
                                            onClose: function () {
                                                window.location.reload();
                                            },
                                        });
                                    } else {
                                        $.confirm({
                                            title: 'Видалення',
                                            content: resp.err,
                                            type: 'red',
                                            typeAnimated: true,
                                            buttons: {
                                                OK: function () {
                                                }
                                            }
                                        });
                                    }
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
    </script>
@endsection

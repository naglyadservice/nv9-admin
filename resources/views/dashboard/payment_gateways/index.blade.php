@extends('dashboard.layout.layout')
@section('title', 'Управление платежными системами')

@section('bread')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Управление платежными системами</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Система</a></li>
                        <li class="breadcrumb-item active">Управление платежными системами</li>
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
                            <h3 class="card-title">Платежные системы</h3>

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
                                    <th>Название</th>
                                    <th>Платежная система</th>
                                    <th>Добавлено</th>
                                    <th>Управление</th>
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
                    <h5 class="modal-title" id="exampleModalLabel">Выберите платежную систему</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Платежная система</label>
                            <select name="system" class="form-control">
                                @foreach(\App\Models\PaymentGateway::systems() as $key => $system)
                                    <option value="{{$key}}">{{$system}}</option>
                                @endforeach
                            </select>
                        </div>

                        <x-my-field type="text" name="name" title="Название" placeholder="ФОП Рога и копыта"></x-my-field>
                        <x-my-field type="text" name="public_key" title="Public key" placeholder="Публичный ключ"></x-my-field>
                        <x-my-field type="text" name="private_key" title="Private key" placeholder="Приватный ключ"></x-my-field>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Добавить</button>
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
                    title: 'Необходимо подтверждение',
                    content: 'Вы уверены что хотите удалить платежную систему?',
                    autoClose: 'no|9000',
                    buttons: {
                        yes: {
                            text: 'Удалить',
                            btnClass: 'btn-red',
                            action: function () {
                                $.post(`/payment-gateways/${deleteID}/delete`, function(resp){
                                    if(resp.success)
                                    {
                                        $.alert({
                                            title: 'Удаление',
                                            content: 'Платежная система успешно удалена',
                                            onClose: function () {
                                                window.location.reload();
                                            },
                                        });
                                    } else {
                                        $.confirm({
                                            title: 'Удаление',
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
                            text: 'Отмена',
                            btnClass: 'btn-secondary',
                        }
                    }
                });

            });

        });
    </script>
@endsection

@extends('dashboard.layout.layout')
@section('title', 'Ключи фискализации')

@section('bread')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ключи фискализации</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Система</a></li>
                        <li class="breadcrumb-item active">Ключи фискализации</li>
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
                            <h3 class="card-title">Ключи фискализации</h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;justify-content: flex-end;">
                                    <div class="input-group-append">
                                        <a href="{{route('fiscalization.add')}}">
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
                                    <th>Название ключа</th>
                                    <th>Дата создания</th>
                                    <th>Управление</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($keys as $key)
                                    <tr>
                                        <td>{{$key->name}}</td>
                                        <td>{{ \Carbon\Carbon::parse($key->created_at)->format('d.m.Y - H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-secondary editKey" data-id="{{$key->id}}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger deleteKey" data-id="{{$key->id}}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagi">
                                {{$keys->links()}}
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

            $('.editKey').click(function(){
                let deviceID = $(this).data('id');
                window.location.href = `/fiscalization/${deviceID}/edit`;
            });

            $('.deleteKey').click(function(){

                var deleteDeviceID = $(this).data('id');

                $.confirm({
                    title: 'Необходимо подтверждение',
                    content: 'Вы уверены что хотите удалить ключ?',
                    autoClose: 'no|9000',
                    buttons: {
                        yes: {
                            text: 'Удалить',
                            btnClass: 'btn-red',
                            action: function () {
                                $.post(`/fiscalization/${deleteDeviceID}/delete`, function(resp){
                                    if(resp.success)
                                    {
                                        $.alert({
                                            title: 'Удаление',
                                            content: 'Ключ успешно удалён',
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

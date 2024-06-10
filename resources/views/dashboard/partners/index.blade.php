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
                                    <a href="{{route('partners.add')}}">
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
                                <th>Имя (название)</th>
                                <th>Почта</th>
                                <th>Кол-во устройств</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($partners as $partner)
                                    <tr>
                                        <td>{{$partner->id}}</td>
                                        <td>{{$partner->name}}</td>
                                        <td><a href="mailto:{{$partner->email}}">{{$partner->email}}</a></td>
                                        <td>{{$partner->devices->count()}}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-secondary editDevice" data-id="{{$partner->id}}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger deleteDevice" data-id="{{$partner->id}}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagi">
                            {{$partners->links()}}
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
                let partnerID = $(this).data('id');
                window.location.href = `/partners/${partnerID}/edit`;
            });

            $('.deleteDevice').click(function(){

                var deletePartnerID = $(this).data('id');

                $.confirm({
                    title: 'Необходимо подтверждение',
                    content: 'Вы уверены что хотите далить партнера?',
                    autoClose: 'no|9000',
                    buttons: {
                        yes: {
                            text: 'Удалить',
                            btnClass: 'btn-red',
                            action: function () {
                                $.post(`/partners/${deletePartnerID}/delete`, function(resp){
                                    $.alert({
                                        title: 'Удаление',
                                        content: 'Партнер успешно удалён',
                                        onClose: function () {
                                            window.location.reload();
                                        },
                                    });

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

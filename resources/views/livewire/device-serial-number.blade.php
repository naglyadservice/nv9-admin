<div>
    <div class="row">
        <div class="col col-md-6">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">{{__('Додаткові серійні номери')}}</h3>
                </div>
                <div class="card-body">
                    <form wire:submit="store">
                        <div class="form-group">
                            <label for="serial_number">{{__('Серійний номер')}}</label>
                            <input wire:model="form.serial_number" type="text" class="form-control" id="serialNumber" placeholder="{{__('Введіть серійний номер')}}">
                            @error('form.serial_number') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{__('Зберегти')}}
                            <div wire:loading wire:target="store">
                                <div class="spinner-border spinner-border-sm" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </button>
                    </form>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>{{__('Серійний номер')}}</th>
                                <th>{{__('Дії')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($device->serialNumbers as $serialNumber)
                                <tr>
                                    <td>{{$serialNumber->serial_number}}</td>
                                    <td>
                                        <button wire:click="delete({{$serialNumber->id}})" class="btn btn-danger" wire:confirm="{{__('Ви впевнені?')}}">
                                            {{__('Видалити')}}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

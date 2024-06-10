@props([
    'name', 'type', 'title', 'value' => null, 'placeholder' => null
    ])

<div class="form-group">
    <label for="{{$name}}_field_id">{{$title}}</label>
    <input name="{{$name}}" type="{{$type}}" @if($value) value="{{$value}}" @endif class="form-control @error($name) is-invalid @enderror" id="{{$name}}_field_id" placeholder="{{$placeholder}}">
    @error($name)
    <small style="color: red;">{{ $message }}</small>
    @enderror
</div>

<div class="form-group row">
    <label for="{{ $id }}" class="col-sm-2 col-form-label">{{ $label }}</label>
    <div class="col-sm-10">
    <input type="{{ $type }}" class="form-control {{$name}}" id="{{ $id }}" value="{{ $value }}" name="{{ $name }}" placeholder="{{ $label }}" @error($name) is-invalid @enderror>
    </div>
</div>

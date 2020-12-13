<div class="form-group row">
    <label for="{{ $id }}" class="col-sm-2 col-form-label font-weight-bolder">{{ $label }}</label>
    <div class="col-sm-10">
    <input type="{{ $type }}" class="form-control money @error($name) is-invalid @enderror" required id="{{ $id }}" value="{{ $value }}" name="{{ $name }}" placeholder="{{ $label }}">
    @error($name)
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    </div>
</div>

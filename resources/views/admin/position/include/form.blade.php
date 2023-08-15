<div class="row">
    <div class="mb-3 col-md-12">
        <label for="name" class="form-label">Nama Jabatan <span class="text-danger"> &#42;</span></label>
        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
            value="{{ isset($position) ? $position->name : old('name') }}" />
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

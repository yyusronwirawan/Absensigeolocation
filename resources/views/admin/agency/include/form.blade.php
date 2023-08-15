<div class="row">
    <div class="mb-3 col-md-12">
        <label for="name" class="form-label">Nama Instansi <span class="text-danger"> &#42;</span></label>
        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
            value="{{ isset($agency) ? $agency->name : old('name') }}" />
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3 col-md-6">
        <label for="latitude" class="form-label">Latitude <span class="text-danger"> &#42;</span></label>
        <input class="form-control @error('latitude') is-invalid @enderror" type="text" name="latitude"
            value="{{ isset($agency) ? $agency->latitude : old('latitude') }}" />
        @error('latitude')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3 col-md-6">
        <label for="longitude" class="form-label">Longitude<span class="text-danger"> &#42;</span></label>
        <input class="form-control @error('longitude') is-invalid @enderror" type="text" name="longitude"
            value="{{ isset($agency) ? $agency->longitude : old('longitude') }}" />
        @error('longitude')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

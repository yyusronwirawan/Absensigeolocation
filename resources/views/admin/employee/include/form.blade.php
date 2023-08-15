<div class="row">
    <div class="mb-3 col-md-6">
        <label for="nip" class="form-label">NIP <span class="text-danger"> &#42;</span></label>
        <input class="form-control @error('nip') is-invalid @enderror" type="text" name="nip"
            value="{{ isset($employee) ? $employee->nip : old('nip') }}" />
        @error('nip')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3 col-md-6">
        <label for="name" class="form-label">Nama (tanpa gelar) <span class="text-danger"> &#42;</span></label>
        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
            value="{{ isset($employee) ? $employee->name : old('name') }}" />
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3 col-md-6">
        <label for="position" class="form-label">Jabatan <span class="text-danger"> &#42;</span></label>
        <select id="selectPosition" class="form-select" name="position_id" id="position">
            <option disabled selected>-- Pilih Jabatan --</option>
            @foreach ($positions as $position)
                <option value="{{ $position->id }}"
                    {{ isset($employee) && $employee->position_id == $position->id ? 'selected' : (old('position_id') == $position->id ? 'selected' : '') }}>
                    {{ $position->name }}</option>
            @endforeach
        </select>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3 col-md-6">
        <label for="agency" class="form-label">Instansi <span class="text-danger"> &#42;</span></label>
        <select id="selectAgency" class="form-select" name="agency_id" id="agency">
            <option disabled selected>-- Pilih Instansi --</option>
            @foreach ($agencies as $agency)
                <option value="{{ $agency->id }}"
                    {{ isset($employee) && $employee->agency_id == $agency->id ? 'selected' : (old('agency_id') == $agency->id ? 'selected' : '') }}>
                    {{ $agency->name }}</option>
            @endforeach
        </select>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3 col-md-6">
        <label for="email" class="form-label">Email <span class="text-danger"> &#42;</span></label>
        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email"
            autocomplete="off" value="{{ isset($employee) ? $employee->email : old('email') }}" />
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3 col-md-6">
        <label for="password" class="form-label">Password <span class="text-danger"> &#42;</span></label>
        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password"
            autocomplete="off" />
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="status">Status <span class="text-danger"> &#42;</span></label>
            <select class="form-select" name="status" id="status">
                <option selected disabled>{{ __('-- Pilih status --') }}</option>
                <option value="0"
                    {{ isset($employee) && $employee->user->status == 0 ? 'selected' : (old('status') == 0 ? 'selected' : '') }}>
                    Tidak Aktif</option>
                <option value="1"
                    {{ isset($employee) && $employee->user->status == 1 ? 'selected' : (old('status') == 1 ? 'selected' : '') }}>
                    Aktif</option>
            </select>
            @error('status')
                <div class="invalid-feedback">
                    <i class="bx bx-radio-circle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    @empty($employee)
        <div class="col-md-6">
            <div class="form-group">
                <label for="role">Role <span class="text-danger"> &#42;</span></label>
                <select class="form-select" name="role" id="role">
                    <option selected disabled>-- Select role --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role')
                    <div class="invalid-feedback">
                        <i class="bx bx-radio-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    @endempty

    @isset($employee)
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="role">{{ __('Role') }}</label>
                    <select class="form-select" name="role" id="role">
                        <option selected disabled>{{ __('-- Pilih role --') }}</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}"
                                {{ $employee->user->getRoleNames()->toArray() !== [] && $employee->user->getRoleNames()[0] == $role->name ? 'selected' : '-' }}>
                                {{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    @endisset
</div>

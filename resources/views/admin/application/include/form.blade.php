<div class="row">
    <div class="mb-3 col-md-6">
        <div class="form-group">
            <label for="type">Jenis Pengajuan <span class="text-danger"> &#42;</span></label>
            <select class="form-select" name="type" id="type">
                <option selected disabled>{{ __('-- Pilih pengajuan --') }}</option>
                <option value="1"
                    {{ isset($application) && $application->status == 1 ? 'selected' : (old('status') == 1 ? 'selected' : '') }}>
                    Izin</option>
                <option value="2"
                    {{ isset($application) && $application->status == 2 ? 'selected' : (old('status') == 2 ? 'selected' : '') }}>
                    Cuti</option>
                <option value="3"
                    {{ isset($application) && $application->status == 3 ? 'selected' : (old('status') == 3 ? 'selected' : '') }}>
                    Sakit</option>
            </select>
            @error('type')
                <div class="invalid-feedback">
                    <i class="bx bx-radio-circle"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="mb-3 col-md-6">
        <label for="file" class="form-label">Surat Pengajuan <span class="text-danger"> &#42;</span></label>
        <input class="form-control @error('file') is-invalid @enderror" type="file" name="file" />
        @error('file')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3 col-md-6">
        <label for="start_date" class="form-label">Tanggal Mulai Pengajuan <span class="text-danger">
                &#42;</span></label>
        <input class="form-control @error('start_date') is-invalid @enderror" type="date" name="start_date"
            value="{{ isset($application) ? $application->start_date : old('start_date') }}" />
        @error('start_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3 col-md-6">
        <label for="end_date" class="form-label">Tanggal Selesai Pengajuan <span class="text-danger">
                &#42;</span></label>
        <input class="form-control @error('end_date') is-invalid @enderror" type="date" name="end_date"
            value="{{ isset($application) ? $application->end_date : old('end_date') }}" />
        @error('end_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3 col-md-12">
        <label for="explanation" class="form-label">Keterangan Pengajuan <span class="text-danger"> &#42;</span></label>
        <textarea class="form-control @error('explanation') is-invalid @enderror" name="explanation" cols="20"
            rows="5">
            {{ isset($application) ? $application->explanation : old('explanation') }}
        </textarea>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>

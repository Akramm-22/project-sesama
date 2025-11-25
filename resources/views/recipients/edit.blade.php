@extends('layouts.app')

@section('title', 'Edit Penerima')

@section('content')
<style>
    .status-chip {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 999px;
        border: 1px solid transparent;
    }

    .status-chip.success {
        background: #dcfce7;
        color: #166534;
        border-color: #bbf7d0;
    }

    .status-chip.pending {
        background: #fef3c7;
        color: #92400e;
        border-color: #fde68a;
    }
</style>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">Edit Data Penerima</h5>
            </div>
            <div class="card-body">
                @php
                    $regionLabel = $recipient->region
                        ? ($regionOptions[$recipient->region] ?? $recipient->region)
                        : 'Belum ditentukan';
                @endphp
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
                    <div>
                        <small class="text-muted text-uppercase">QR Code</small>
                        <div class="fs-5 fw-bold mb-1">{{ $recipient->qr_code }}</div>
                        <span class="badge bg-primary-subtle text-primary">
                            <i class="fas fa-map-marker-alt"></i> {{ $regionLabel }}
                        </span>
                    </div>
                    <div class="text-md-end">
                        <small class="text-muted text-uppercase d-block mb-1">Status Penyaluran</small>
                        <div class="d-flex flex-wrap gap-1">
                            <span class="status-chip {{ $recipient->registrasi ? 'success' : 'pending' }}">Registrasi</span>
                            <span class="status-chip {{ $recipient->has_circumcision ? 'success' : 'pending' }}">Khitan</span>
                            <span class="status-chip {{ $recipient->has_received_gift ? 'success' : 'pending' }}">Uang & Bingkisan</span>
                            <span class="status-chip {{ $recipient->has_photo_booth ? 'success' : 'pending' }}">Foto Booth</span>
                        </div>
                    </div>
                </div>
                <form action="{{ route('recipients.update', $recipient) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="child_name" class="form-label">Nama Anak <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('child_name') is-invalid @enderror"
                                   id="child_name" name="child_name" value="{{ old('child_name', $recipient->child_name) }}" required>
                            @error('child_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="whatsapp_number" class="form-label">Nomor WhatsApp</label>
                            <input type="text" class="form-control @error('whatsapp_number') is-invalid @enderror"
                                   id="whatsapp_number" name="whatsapp_number"
                                   value="{{ old('whatsapp_number', $recipient->whatsapp_number) }}"
                                   placeholder="08xxxxxxxxxx">
                            @error('whatsapp_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="Ayah_name" class="form-label">Nama Ayah <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('Ayah_name') is-invalid @enderror"
                                   id="Ayah_name" name="Ayah_name" value="{{ old('Ayah_name', $recipient->Ayah_name) }}" required>
                            @error('Ayah_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="Ibu_name" class="form-label">Nama Ibu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('Ibu_name') is-invalid @enderror"
                                   id="Ibu_name" name="Ibu_name" value="{{ old('Ibu_name', $recipient->Ibu_name) }}" required>
                            @error('Ibu_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="birth_place" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('birth_place') is-invalid @enderror"
                                   id="birth_place" name="birth_place" value="{{ old('birth_place', $recipient->birth_place) }}" required>
                            @error('birth_place')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="birth_date" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                   id="birth_date" name="birth_date" value="{{ old('birth_date', $recipient->birth_date->format('Y-m-d')) }}" required>
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="age" class="form-label">Umur <span class="text-danger">*</span></label>
                            <input type="number" min="1" max="25" class="form-control @error('age') is-invalid @enderror"
                                   id="age" name="age"
                                   value="{{ old('age', $recipient->age ?? optional($recipient->birth_date)->age) }}" required>
                            @error('age')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 mb-3">
                            <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address" name="address" rows="4" required>{{ old('address', $recipient->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="region" class="form-label">Wilayah</label>
                                <select class="form-select @error('region') is-invalid @enderror" id="region" name="region">
                                    <option value="">Pilih Wilayah</option>
                                    @foreach($regionOptions as $key => $label)
                                        <option value="{{ $key }}" {{ old('region', $recipient->region) === $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('region')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="reference_source" class="form-label">Referensi</label>
                                <input type="text" class="form-control @error('reference_source') is-invalid @enderror"
                                       id="reference_source" name="reference_source"
                                       value="{{ old('reference_source', $recipient->reference_source) }}"
                                       placeholder="Contoh: Kepala Sekolah / RT / Relawan">
                                @error('reference_source')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="id_card_photo" class="form-label d-flex justify-content-between">
                                    <span>Foto ID Card</span>
                                    @if($recipient->id_card_photo_path)
                                        <span class="text-muted small">Terunggah</span>
                                    @endif
                                </label>
                                @if($recipient->id_card_photo_path)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $recipient->id_card_photo_path) }}"
                                             alt="Foto ID"
                                             class="img-fluid rounded border">
                                        <a href="{{ asset('storage/' . $recipient->id_card_photo_path) }}"
                                           target="_blank" class="small d-block mt-1">Lihat versi penuh</a>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('id_card_photo') is-invalid @enderror"
                                       id="id_card_photo" name="id_card_photo" accept="image/*">
                                <small class="text-muted">Unggah ulang untuk mengganti foto (PNG/JPG maks. 2MB)</small>
                                @error('id_card_photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="class" class="form-label">Kelas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('class') is-invalid @enderror"
                                   id="class" name="class" value="{{ old('class', $recipient->class) }}" placeholder="Contoh: 5A" required>
                            @error('class')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="shoe_size" class="form-label">Nomor Sepatu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('shoe_size') is-invalid @enderror"
                                   id="shoe_size" name="shoe_size" value="{{ old('shoe_size', $recipient->shoe_size) }}" placeholder="Contoh: 38" required>
                            @error('shoe_size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="shirt_size" class="form-label">Nomor Baju <span class="text-danger">*</span></label>
                            <select class="form-select @error('shirt_size') is-invalid @enderror"
                                    id="shirt_size" name="shirt_size" required>
                                <option value="">Pilih Ukuran</option>
                                <option value="XS" {{ old('shirt_size', $recipient->shirt_size) == 'XS' ? 'selected' : '' }}>XS</option>
                                <option value="S" {{ old('shirt_size', $recipient->shirt_size) == 'S' ? 'selected' : '' }}>S</option>
                                <option value="M" {{ old('shirt_size', $recipient->shirt_size) == 'M' ? 'selected' : '' }}>M</option>
                                <option value="L" {{ old('shirt_size', $recipient->shirt_size) == 'L' ? 'selected' : '' }}>L</option>
                                <option value="XL" {{ old('shirt_size', $recipient->shirt_size) == 'XL' ? 'selected' : '' }}>XL</option>
                                <option value="XXL" {{ old('shirt_size', $recipient->shirt_size) == 'XXL' ? 'selected' : '' }}>XXL</option>
                            </select>
                            @error('shirt_size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('recipients.index', $recipient) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Data
                        </button>
                    </div>

                <div class="border-top pt-4 mt-4">
                    <h6 class="fw-bold mb-3">Status Penyaluran</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="status-chip {{ $recipient->registrasi ? 'success' : 'pending' }}">Registrasi</span>
                        <span class="status-chip {{ $recipient->has_circumcision ? 'success' : 'pending' }}">Khitan</span>
                        <span class="status-chip {{ $recipient->has_received_gift ? 'success' : 'pending' }}">Uang & Bingkisan</span>
                        <span class="status-chip {{ $recipient->has_photo_booth ? 'success' : 'pending' }}">Foto Booth</span>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const birthDateField = document.getElementById('birth_date');
    const ageField = document.getElementById('age');

    function calculateAge(dateString) {
        if (!dateString) return '';
        const today = new Date();
        const birthDate = new Date(dateString);
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age > 0 ? age : '';
    }

    function updateAgeValue() {
        ageField.value = calculateAge(birthDateField.value);
    }

    birthDateField?.addEventListener('change', updateAgeValue);

    if (birthDateField?.value && !ageField.value) {
        updateAgeValue();
    }
</script>
@endpush

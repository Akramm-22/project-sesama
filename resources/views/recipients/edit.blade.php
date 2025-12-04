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

            {{-- Header --}}
            <div class="card-header">
                <h5 class="mb-0">Edit Data Penerima</h5>
            </div>

            <div class="card-body">

                {{-- Region Label --}}
                @php
                    $regionLabel = $recipient->region
                        ? ($regionOptions[$recipient->region] ?? $recipient->region)
                        : 'Belum ditentukan';
                @endphp

                {{-- QR Code & Region --}}
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
                    <div>
                        <small class="text-muted text-uppercase">QR Code</small>
                        <div class="fs-5 fw-bold mb-1">{{ $recipient->qr_code }}</div>

                        <span class="badge bg-primary-subtle text-primary">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $regionLabel }}
                        </span>
                    </div>
                </div>

                {{-- Form --}}
                <form action="{{ route('recipients.update', $recipient) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Data Anak --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="child_name" class="form-label">
                                Nama Anak <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   id="child_name"
                                   name="child_name"
                                   class="form-control @error('child_name') is-invalid @enderror"
                                   value="{{ old('child_name', $recipient->child_name) }}"
                                   required>
                            @error('child_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="whatsapp_number" class="form-label">Nomor WhatsApp</label>
                            <input type="text"
                                   id="whatsapp_number"
                                   name="whatsapp_number"
                                   class="form-control @error('whatsapp_number') is-invalid @enderror"
                                   value="{{ old('whatsapp_number', $recipient->whatsapp_number) }}"
                                   placeholder="08xxxxxxxxxx">
                            @error('whatsapp_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Data Orang Tua --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="Ayah_name" class="form-label">
                                Nama Ayah <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   id="Ayah_name"
                                   name="Ayah_name"
                                   class="form-control @error('Ayah_name') is-invalid @enderror"
                                   value="{{ old('Ayah_name', $recipient->Ayah_name) }}"
                                   required>
                            @error('Ayah_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="Ibu_name" class="form-label">
                                Nama Ibu <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   id="Ibu_name"
                                   name="Ibu_name"
                                   class="form-control @error('Ibu_name') is-invalid @enderror"
                                   value="{{ old('Ibu_name', $recipient->Ibu_name) }}"
                                   required>
                            @error('Ibu_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div class="col-md-6 mb-3">
                        <label for="birth_date" class="form-label">
                            Tanggal Lahir <span class="text-danger">*</span>
                        </label>
                        <input type="date"
                               id="birth_date"
                               name="birth_date"
                               class="form-control @error('birth_date') is-invalid @enderror"
                               value="{{ old('birth_date', $recipient->birth_date->format('Y-m-d')) }}"
                               required>
                        @error('birth_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Alamat & Wilayah --}}
                    <div class="row">
                        <div class="col-lg-8 mb-3">
                            <label for="address" class="form-label">
                                Alamat <span class="text-danger">*</span>
                            </label>
                            <textarea id="address"
                                      name="address"
                                      rows="4"
                                      class="form-control @error('address') is-invalid @enderror"
                                      required>{{ old('address', $recipient->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-lg-4">
                            {{-- Wilayah --}}
                            <div class="mb-3">
                                <label for="region" class="form-label">Wilayah</label>
                                <select id="region"
                                        name="region"
                                        class="form-select @error('region') is-invalid @enderror">
                                    <option value="">Pilih Wilayah</option>

                                    @foreach ($regionOptions as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ old('region', $recipient->region) === $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('region')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Referensi --}}
                            <div class="mb-3">
                                <label for="reference_source" class="form-label">Referensi</label>
                                <input type="text"
                                       id="reference_source"
                                       name="reference_source"
                                       class="form-control @error('reference_source') is-invalid @enderror"
                                       value="{{ old('reference_source', $recipient->reference_source) }}"
                                       placeholder="Contoh: Kepala Sekolah / RT / Relawan">
                                @error('reference_source')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('recipients.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Data
                        </button>
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
        const month = today.getMonth() - birthDate.getMonth();

        if (month < 0 || (month === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        return age > 0 ? age : '';
    }

    function updateAgeValue() {
        if (ageField) {
            ageField.value = calculateAge(birthDateField.value);
        }
    }

    birthDateField?.addEventListener('change', updateAgeValue);

    if (birthDateField?.value && ageField && !ageField.value) {
        updateAgeValue();
    }
</script>
@endpush

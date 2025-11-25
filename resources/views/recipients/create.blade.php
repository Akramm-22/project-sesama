@extends('layouts.app')

@section('title', 'Tambah Penerima')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">Tambah Data Penerima Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('recipients.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="child_name" class="form-label">Nama Anak <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('child_name') is-invalid @enderror"
                                   id="child_name" name="child_name" value="{{ old('child_name') }}" required>
                            @error('child_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="whatsapp_number" class="form-label">Nomor WhatsApp</label>
                            <input type="text" class="form-control @error('whatsapp_number') is-invalid @enderror"
                                   id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number') }}"
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
                                   id="Ayah_name" name="Ayah_name" value="{{ old('Ayah_name') }}" required>
                            @error('Ayah_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="Ibu_name" class="form-label">Nama Ibu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('Ibu_name') is-invalid @enderror"
                                   id="Ibu_name" name="Ibu_name" value="{{ old('Ibu_name') }}" required>
                            @error('Ibu_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="birth_place" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('birth_place') is-invalid @enderror"
                                   id="birth_place" name="birth_place" value="{{ old('birth_place') }}" required>
                            @error('birth_place')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="birth_date" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                   id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="age" class="form-label">Umur <span class="text-danger">*</span></label>
                            <input type="number" min="1" max="25" class="form-control @error('age') is-invalid @enderror"
                                   id="age" name="age" value="{{ old('age') }}" required>
                            @error('age')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 mb-3">
                            <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address" name="address" rows="4" required>{{ old('address') }}</textarea>
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
                                        <option value="{{ $key }}" {{ old('region') === $key ? 'selected' : '' }}>
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
                                       id="reference_source" name="reference_source" value="{{ old('reference_source') }}"
                                       placeholder="Contoh: Sekolah / RT / Relawan">
                                @error('reference_source')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="id_card_photo" class="form-label">Foto ID Card</label>
                                <input type="file" class="form-control @error('id_card_photo') is-invalid @enderror"
                                       id="id_card_photo" name="id_card_photo" accept="image/*">
                                <small class="text-muted">Format JPG/PNG maks. 2MB</small>
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
                                   id="class" name="class" value="{{ old('class') }}" placeholder="Contoh: 5A" required>
                            @error('class')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="shoe_size" class="form-label">Nomor Sepatu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('shoe_size') is-invalid @enderror"
                                   id="shoe_size" name="shoe_size" value="{{ old('shoe_size') }}" placeholder="Contoh: 38" required>
                            @error('shoe_size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="shirt_size" class="form-label">Nomor Baju <span class="text-danger">*</span></label>
                            <select class="form-select @error('shirt_size') is-invalid @enderror"
                                    id="shirt_size" name="shirt_size" required>
                                <option value="">Pilih Ukuran</option>
                                <option value="XS" {{ old('shirt_size') == 'XS' ? 'selected' : '' }}>XS</option>
                                <option value="S" {{ old('shirt_size') == 'S' ? 'selected' : '' }}>S</option>
                                <option value="M" {{ old('shirt_size') == 'M' ? 'selected' : '' }}>M</option>
                                <option value="L" {{ old('shirt_size') == 'L' ? 'selected' : '' }}>L</option>
                                <option value="XL" {{ old('shirt_size') == 'XL' ? 'selected' : '' }}>XL</option>
                                <option value="XXL" {{ old('shirt_size') == 'XXL' ? 'selected' : '' }}>XXL</option>
                            </select>
                            @error('shirt_size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('recipients.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Data
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
    const birthDateCreate = document.getElementById('birth_date');
    const ageCreate = document.getElementById('age');

    function calcAge(dateString) {
        if (!dateString) return '';
        const today = new Date();
        const birth = new Date(dateString);
        let age = today.getFullYear() - birth.getFullYear();
        const diffMonth = today.getMonth() - birth.getMonth();
        if (diffMonth < 0 || (diffMonth === 0 && today.getDate() < birth.getDate())) {
            age--;
        }
        return age > 0 ? age : '';
    }

    function syncAge() {
        ageCreate.value = calcAge(birthDateCreate.value);
    }

    birthDateCreate?.addEventListener('change', syncAge);

    if (birthDateCreate?.value && !ageCreate.value) {
        syncAge();
    }
</script>
@endpush

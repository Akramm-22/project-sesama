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

                    {{-- NAMA & WA --}}
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

                    {{-- ORANG TUA --}}
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

                    {{-- TANGGAL LAHIR --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="birth_date" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                   id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- ALAMAT, WILAYAH, REFERENSI, FOTO --}}
                    <div class="row">
                        {{-- Alamat --}}
                        <div class="col-lg-8 mb-3">
                            <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address" name="address" rows="4" required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kolom Kanan --}}
                        <div class="col-lg-4">

                            {{-- Wilayah --}}
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

                            {{-- Referensi --}}
                            <div class="mb-3">
                                <label for="reference_source" class="form-label">Referensi</label>
                                <input type="text" class="form-control @error('reference_source') is-invalid @enderror"
                                       id="reference_source" name="reference_source" value="{{ old('reference_source') }}"
                                       placeholder="Contoh: Sekolah / RT / Relawan">
                                @error('reference_source')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                        </div> {{-- col-lg-4 --}}
                    </div> {{-- row --}}

                    {{-- BUTTON --}}
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
    // Ambil elemen input tanggal lahir
    const birthDateCreate = document.getElementById('birth_date');

    // Fungsi untuk menghitung umur dari tanggal lahir
    function calcAge(dateString) {
        if (!dateString) return '';
        const today = new Date();
        const birth = new Date(dateString);

        let age = today.getFullYear() - birth.getFullYear();
        const diffMonth = today.getMonth() - birth.getMonth();

        // Koreksi umur jika bulan & tanggal belum lewat
        if (diffMonth < 0 || (diffMonth === 0 && today.getDate() < birth.getDate())) {
            age--;
        }

        return age > 0 ? age : '';
    }

    // Jika input tanggal lahir berubah → hitung umur
    birthDateCreate?.addEventListener('change', () => {
        const age = calcAge(birthDateCreate.value);
        console.log("Umur otomatis:", age, "tahun");

        // Jika kamu ingin menampilkan umur di halaman (opsional)
        const ageLabel = document.getElementById('ageLabel');
        if (ageLabel) {
            ageLabel.innerText = age ? age + " Tahun" : "-";
        }
    });
</script>

@endpush

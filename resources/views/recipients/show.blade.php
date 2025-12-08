@extends('layouts.app')

@section('title', 'Detail Penerima')

@section('content')
<div class="row">

    <!-- ======================== -->
    <!-- CARD DETAIL PENERIMA (KIRI) -->
    <!-- ======================== -->
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Penerima</h5>
            </div>

            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>QR Code:</strong></td>
                        <td><span class="badge bg-primary">{{ $recipient->qr_code }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Nama Anak:</strong></td>
                        <td>{{ $recipient->child_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama Ayah:</strong></td>
                        <td>{{ $recipient->Ayah_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama Ibu:</strong></td>
                        <td>{{ $recipient->Ibu_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nomor Whatsapp:</strong></td>
                        <td>{{ $recipient->whatsapp_number ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tempat, Tanggal Lahir:</strong></td>
                        <td>{{ $recipient->birth_place }} {{ $recipient->birth_date->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat:</strong></td>
                        <td>{{ $recipient->address }}</td>
                    </tr>
                    <tr>
                        <td><strong>Wilayah:</strong></td>
                        <td>{{ $regionLabel ?? 'Belum ditentukan' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Referensi:</strong></td>
                        <td>{{ $recipient->reference_source ?? '-' }}</td>
                    </tr>
                </table>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('recipients.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>

                    <div>
                        <a href="{{ route('recipients.edit', $recipient) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>

                        <a href="{{ route('recipients.qr-code', $recipient) }}"
                           class="btn btn-info"
                           target="_blank">
                            <i class="fas fa-qrcode me-2"></i>Lihat QR
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ======================== -->
        <!-- STATUS + CATATAN -->
        <!-- ======================== -->
        <div class="card shadow mt-4">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Informasi Penyaluran</h5>

                <a href="{{ route('recipients.export-distribution', $recipient) }}"
                   class="btn btn-danger btn-sm"
                   target="_blank">
                    <i class="fas fa-file-pdf me-2"></i>Export PDF
                </a>
            </div>

            <div class="card-body">
                {{-- STATUS PENYALURAN --}}
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    Status Penyaluran
                </h6>

                @php
                    $statuses = [
                        ['label' => 'Registrasi',       'state' => $recipient->registrasi],
                        ['label' => 'Khitan',           'state' => $recipient->has_circumcision],
                        ['label' => 'Uang & Bingkisan', 'state' => $recipient->has_received_gift],
                        ['label' => 'Foto Booth',       'state' => $recipient->has_photo_booth],
                    ];
                @endphp

                <div class="d-flex flex-wrap gap-2 mb-4">
                    @foreach($statuses as $status)
                        <span class="badge rounded-pill {{ $status['state'] ? 'bg-success' : 'bg-secondary' }}">
                            <i class="fas {{ $status['state'] ? 'fa-check-circle me-1' : 'fa-minus-circle me-1' }}"></i>
                            {{ $status['label'] }}
                        </span>
                    @endforeach
                </div>

                {{-- CATATAN --}}
                <h6 class="fw-bold mb-2">
                    <i class="fas fa-sticky-note me-2 text-warning"></i>
                    Catatan Penyaluran
                </h6>

                <div class="p-3 bg-light rounded border">
                    {!! nl2br(e($recipient->notes ?? 'Tidak ada catatan')) !!}
                </div>
            </div>
        </div>
    </div>

    <!-- ======================== -->
    <!-- CARD QR CODE (KANAN) -->
    <!-- ======================== -->
    <div class="col-md-4">
        <div class="card shadow mb-4 text-center">
            <div class="card-header">
                <h5 class="mb-0">QR Code</h5>
            </div>

            <div class="card-body">
                <img src="{{ route('recipients.qr-code', $recipient) }}"
                     alt="QR Code"
                     class="img-fluid mb-3"
                     style="max-width: 220px;">

                <h6 class="fw-bold">{{ $recipient->qr_code }}</h6>

                <a href="{{ route('recipients.qr-print', $recipient) }}"
                   class="btn btn-primary btn-sm mt-2">
                    <i class="fas fa-download me-1"></i>Download QR
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

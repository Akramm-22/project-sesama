@extends('layouts.user')

@section('title', 'Data Penerima')

@section('content')

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>QR Code</th>
                        <th>Nama Anak</th>
                        <th>Nama Ayah</th>
                        <th>Umur</th>
                        <th>Alamat</th>
                        <th>Referensi</th>
                        <th>Foto ID</th>
                        <th>Status</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($recipients as $recipient)
                        <tr>
                            <td>
                                <span class="badge bg-primary">{{ $recipient->qr_code }}</span>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $recipient->child_name }}</div>
                                @php
                                    $regionLabel = $recipient->region
                                        ? ($regionOptions[$recipient->region] ?? $recipient->region)
                                        : null;
                                @endphp
                                @if($regionLabel)
                                    <small class="text-muted">{{ $regionLabel }}</small>
                                @endif
                            </td>
                            <td>{{ $recipient->Ayah_name }}</td>
                            @php
                                $displayAge = $recipient->age ?? optional($recipient->birth_date)->age;
                            @endphp
                            <td>{{ $displayAge ? $displayAge . ' th' : '-' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($recipient->address, 50) }}</td>
                            <td>{{ $recipient->reference_source ?? '-' }}</td>
                            <td>
                                @if($recipient->id_card_photo_path)
                                    <a href="{{ asset('storage/' . $recipient->id_card_photo_path) }}"
                                       target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-id-card"></i>
                                    </a>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    @if($recipient->is_distributed)
                                        <span class="badge bg-success">Sudah Menerima</span>
                                    @elseif($recipient->registrasi)
                                        <span class="badge bg-warning text-dark">Sudah Registrasi</span>
                                    @else
                                        <span class="badge bg-danger">Belum Registrasi</span>
                                    @endif
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data penerima</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $recipients->links() }}
        </div>
    </div>
</div>
@endsection

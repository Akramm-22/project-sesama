@extends('layouts.app')

@section('title', 'Data Penerima')

@section('content')
<style>

/* =============================
   HEADER
============================= */
.page-header {
    background: linear-gradient(135deg,#1e40af,#3b82f6);
    border-radius:16px;
    padding:28px;
    margin-bottom:24px;
    color:#fff;
    box-shadow:0 10px 24px rgba(30,64,175,.25);
}

/* =============================
   SEARCH + FILTER
============================= */
.search-container {
    background:#fff;
    border-radius:16px;
    padding:20px;
    border:1px solid #e5e7eb;
    box-shadow:0 6px 18px rgba(0,0,0,.08);
}

.search-wrapper {
    position:relative;
    max-width:360px;
}

.search-wrapper input{
    width:100%;
    border-radius:10px;
    border:1px solid #d1d5db;
    padding:8px 40px 8px 14px;
}

.search-wrapper button{
    position:absolute;
    right:6px;
    top:50%;
    transform:translateY(-50%);
    width:34px;
    height:34px;
    border:none;
    background:#2563eb;
    border-radius:8px;
    color:#fff;
}

/* =============================
   ACTION BUTTON
============================= */
.action-buttons{
    display:flex;
    gap:10px;
    justify-content:flex-end;
    flex-wrap:wrap;
}

.btn-custom{
    border-radius:10px;
    padding:9px 18px;
    font-weight:600;
}

/* =============================
   TABLE CARD
============================= */
.data-table{
    background:#fff;
    padding:22px;
    border-radius:16px;
    border:1px solid #e5e7eb;
    box-shadow:0 6px 18px rgba(0,0,0,.08);
}

/* scroll wrapper */
.table-responsive{
    overflow-x:auto;
}

/* table base */
.table{
    min-width:1000px;
}

.table th{
    background:#f1f5f9;
    color:#334155;
    font-weight:600;
    font-size:14px;

    /* ✅ MATIKAN CAPSLOCK */
    text-transform:none !important;
    letter-spacing:normal !important;
}

.table td{
    vertical-align:middle;
}

.table tbody tr:hover{
    background:#f8fafc;
}

/* QR COLUMN FINAL FIX */
.table th:first-child{
    background:#f1f5f9 !important;  /* header ikut abu */
}

.table td:first-child{
    background:#fff !important;     /* isi tetap putih */
}

.table th:first-child,
.table td:first-child{
    position:static !important;
    min-width:140px;
}


.table td:first-child .badge{
    border-radius:6px;
    padding:6px 12px;
    font-size:13px;
    white-space:nowrap;
}

/* =============================
   REGION BADGE
============================= */
.region-badge{
    display:inline-flex;
    align-items:center;
    gap:4px;
    background:#e0f2fe;
    color:#0369a1;
    padding:2px 10px;
    border-radius:999px;
    font-size:11px;
    margin-top:4px;
}

/* =============================
   STATUS BADGE
============================= */
.status-badge{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:6px 14px;
    font-size:12px;
    font-weight:600;
    border-radius:999px;
}

.status-completed{ background:#dcfce7; color:#166534;}
.status-registered{ background:#fef3c7; color:#92400e;}
.status-pending{ background:#fee2e2; color:#991b1b;}

/* =============================
   BUTTON AKSI
============================= */
.btn-group .btn,
.btn-sm{
    border-radius:6px !important;
    padding:5px 10px;
}

/* =============================
   PAGINATION
============================= */
.pagination{
    justify-content:center;
}

.pagination .page-link{
    border-radius:8px;
}

/* =============================
   RESPONSIVE
============================= */
@media (max-width:768px){

    .action-buttons{
        justify-content:center;
        flex-direction:column;
    }

    .action-buttons .btn{
        width:100%;
    }

}
</style>

<!-- =============================
 HEADER
============================= -->
<div class="page-header">
    <h2>Data Penerima</h2>
    <p>Kelola data penerima bantuan khitanan </p>
</div>


<!-- =============================
 SEARCH + FILTER
============================= -->
<div class="search-container mb-3">
    <div class="row gy-3">

        <div class="col-md-6">
            <form action="{{ route('recipients.index') }}"
                  method="GET"
                  class="d-flex gap-2">

                <div class="search-wrapper">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari penerima...">

                    <button type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

                <select name="region"
                        class="form-select"
                        style="max-width:220px"
                        onchange="this.form.submit()">

                    <option value="">Semua Wilayah</option>

                    @foreach($regionOptions as $key => $label)
                        <option value="{{ $key }}"
                            {{ ($regionFilter ?? '') === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach

                </select>

            </form>
        </div>


        <div class="col-md-6">
            <div class="action-buttons">

                <a href="{{ route('recipients.import') }}"
                   class="btn btn-success btn-custom">
                    <i class="fas fa-plus me-1"></i> Import Excel
                </a>

                <a href="{{ route('recipients.qr-print') }}"
                   class="btn btn-info text-white btn-custom">
                    <i class="fas fa-download me-1"></i> Download QR
                </a>

                <a href="{{ route('recipients.create') }}"
                   class="btn btn-primary btn-custom">
                    <i class="fas fa-pen-nib me-1"></i> Tambah Manual
                </a>

            </div>
        </div>

    </div>
</div>


<!-- =============================
 TABLE
============================= -->
<div class="data-table">

<div class="table-responsive">

<table class="table table-hover">

<thead>
<tr>
    <th>QR</th>
    <th>Nama Anak</th>
    <th>Nama Ayah</th>
    <th>Tgl Lahir</th>
    <th>Alamat</th>
    <th>Referensi</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>
</thead>


<tbody>

@forelse($recipients as $recipient)
<tr>

    <td>
        <span class="badge bg-primary">
            {{ $recipient->qr_code }}
        </span>
    </td>

    <td>
        <div class="fw-semibold">
            {{ $recipient->child_name }}
        </div>

        @php
        $regionLabel = $recipient->region
            ? ($regionOptions[$recipient->region] ?? $recipient->region)
            : null;
        @endphp

        @if($regionLabel)
        <span class="region-badge">
            <i class="fas fa-map-marker-alt"></i>
            {{ $regionLabel }}
        </span>
        @endif

    </td>

    <td>{{ $recipient->Ayah_name }}</td>

    <td>
        {{ $recipient->birth_date
            ? \Carbon\Carbon::parse($recipient->birth_date)->format('d M Y')
            : '-' }}
    </td>

    <td>
        {{ \Illuminate\Support\Str::limit($recipient->address,60) }}
    </td>

    <td>
        @if($recipient->reference_source)
            <span class="badge bg-secondary-subtle text-secondary">
                {{ $recipient->reference_source }}
            </span>
        @else
            <span class="text-muted">-</span>
        @endif
    </td>

    <td>
        @if($recipient->is_distributed && $recipient->registrasi)
            <span class="status-badge status-completed">
                <i class="fas fa-check-circle"></i>
                Penyaluran Selesai
            </span>

        @elseif($recipient->registrasi)
            <span class="status-badge status-registered">
                <i class="fas fa-check"></i>
                Sudah Registrasi
            </span>
        @else
            <span class="status-badge status-pending">
                <i class="fas fa-times"></i>
                Belum Registrasi
            </span>
        @endif
    </td>


    <td>
        <div class="btn-group">

            <a href="{{ route('recipients.show',$recipient) }}"
               class="btn btn-sm btn-outline-info">
                <i class="fas fa-eye"></i>
            </a>

            <a href="{{ route('recipients.edit',$recipient) }}"
               class="btn btn-sm btn-outline-warning">
                <i class="fas fa-edit"></i>
            </a>

            <form action="{{ route('recipients.destroy',$recipient) }}"
                  method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                @csrf
                @method('DELETE')

                <button class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-trash"></i>
                </button>

            </form>

        </div>
    </td>

</tr>

@empty

<tr>
    <td colspan="8"
        class="text-center text-muted py-4">
        <i class="fas fa-inbox fa-2x mb-2"></i><br>
        Belum ada data penerima
    </td>
</tr>

@endforelse

</tbody>
</table>

</div>

<div class="mt-3">
    {{ $recipients->onEachSide(1)->links('pagination::bootstrap-5') }}
</div>

</div>

@endsection

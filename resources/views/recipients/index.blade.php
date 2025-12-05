@extends('layouts.app')

@section('title', 'Data Penerima')

@section('content')
<style>

/* =============================
   HEADER BANNER
============================= */
.page-header {
    background: linear-gradient(135deg,#1e40af,#3b82f6);
    border-radius:16px;
    padding:28px;
    margin-bottom:24px;
    color:#fff;
    box-shadow:0 10px 24px rgba(30,64,175,.25);
}

.page-header h2 {
    font-weight:700;
}

.page-header p {
    opacity:.9;
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
    width:100%;
    max-width:380px;
}

.search-wrapper input {
    width:100%;
    height:42px;
    border-radius:10px;
    padding:8px 40px 8px 14px;
    border:1px solid #d1d5db;
    font-size:14px;
    transition:.2s ease;
}

.search-wrapper input:focus {
    outline:none;
    border-color:#3b82f6;
    box-shadow:0 0 0 3px rgba(59,130,246,.2);
}

.search-wrapper button {
    position:absolute;
    top:50%;
    right:8px;
    transform:translateY(-50%);
    background:#2563eb;
    border:none;
    color:white;
    width:32px;
    height:32px;
    border-radius:8px;
    display:flex;
    align-items:center;
    justify-content:center;
}

.filter-select{
    min-width:200px;
    border-radius:10px;
}

/* =============================
   ACTION BUTTONS
============================= */
.action-buttons{
    display:flex;
    gap:12px;
    flex-wrap:wrap;
    justify-content:flex-end;
}

.btn-custom{
    border-radius:10px;
    padding:10px 20px;
    font-weight:600;
    transition:.25s ease;
}

.btn-custom:hover{
    transform:translateY(-2px);
    box-shadow:0 6px 16px rgba(0,0,0,.15);
}

/* =============================
   TABLE CARD
============================= */
.data-table{
    background:#fff;
    padding:24px;
    border-radius:16px;
    margin-top:18px;
    border:1px solid #e5e7eb;
    box-shadow:0 6px 20px rgba(0,0,0,.08);
}

.table th{
    background:#f1f5f9;
    color:#334155;
    font-size:14px;
    font-weight:600;
}

.table td{
    vertical-align:middle;
}

.table tbody tr{
    transition:.15s ease;
}

.table tbody tr:hover{
    background:#f8fafc;
}

/* Lock first column (mobile UX) */
.table th:first-child,
.table td:first-child{
    position:sticky;
    left:0;
    z-index:2;
    background:#fff;
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
    border-radius:999px;
    padding:2px 10px;
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
    border-radius:999px;
    font-size:12px;
    font-weight:600;
    box-shadow:0 2px 5px rgba(0,0,0,.08);
    transition:.18s ease;
}

.status-badge:hover{
    transform:translateY(-1px);
}

.status-completed{
    background:#dcfce7;
    color:#166534;
}

.status-registered{
    background:#fef3c7;
    color:#92400e;
}

.status-pending{
    background:#fee2e2;
    color:#991b1b;
}

/* =============================
   PAGINATION
============================= */
.pagination{
    justify-content:center;
    gap:6px;
}

.pagination .page-link{
    border-radius:8px;
    font-size:13px;
    padding:4px 10px!important;
}

.pagination .page-item.active .page-link{
    background:#2563eb!important;
    border-color:#2563eb!important;
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

    .filter-select{
        width:100%;
    }

    .data-table{
        padding:18px;
    }

    .table{
        font-size:13px;
    }

    .table th,
    .table td{
        padding:10px;
    }
}

</style>

<!-- =============================
   HEADER
============================= -->
<div class="page-header">
    <h2 class="mb-1">Data Penerima</h2>
    <p class="mb-0">Kelola data penerima bantuan pendidikan</p>
</div>


<!-- =============================
   SEARCH + FILTER
============================= -->
<div class="search-container">
    <div class="row gy-3">

        <div class="col-lg-6 col-md-12">
            <form action="{{ route('recipients.index') }}"
                  method="GET"
                  class="d-flex align-items-center flex-wrap gap-2">

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
                        class="form-select filter-select"
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


        <div class="col-lg-6 col-md-12">
            <div class="action-buttons">
                <a href="{{ route('recipients.import') }}"
                   class="btn btn-success btn-custom">
                    <i class="fas fa-plus me-2"></i>Import Excel
                </a>
                
    <a href="{{ route('recipients.printAll') }}"
                   class="btn btn-info text-white btn-custom">
                    <i class="fas fa-download me-2"></i>Download QR
                </a>


                <a href="{{ route('recipients.create') }}"
                   class="btn btn-primary btn-custom">
                    <i class="fas fa-pen-nib me-2"></i>Tambah Data Manual
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

<table class="table">
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

<td>{{ \Illuminate\Support\Str::limit($recipient->address,60) }}</td>

<td>
@if($recipient->reference_source)
    <span class="badge bg-secondary-subtle text-secondary">
        {{ $recipient->reference_source }}
    </span>
@else
    <span class="text-muted small">-</span>
@endif
</td>


<td>

@if($recipient->is_distributed && $recipient->registrasi)
    <span class="status-badge status-completed">
        <i class="fas fa-check-circle"></i>
        Penyaluran selesai
    </span>

@elseif($recipient->registrasi)
    <span class="status-badge status-registered">
        <i class="fas fa-check"></i>
        Sudah registrasi
    </span>

@else
    <span class="status-badge status-pending">
        <i class="fas fa-times"></i>
        Belum registrasi
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
<td colspan="8" class="text-center text-muted py-4">
<i class="fas fa-inbox fa-2x mb-2"></i><br>
Belum ada data penerima
</td>
</tr>

@endforelse

</tbody>
</table>

</div>

<div class="pagination-container mt-3">
    {{ $recipients->onEachSide(1)->links('pagination::bootstrap-5') }}
</div>

</div>
@endsection

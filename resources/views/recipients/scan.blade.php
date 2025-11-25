@extends('layouts.app')

@section('title', 'Penyaluran')

@section('content')
<style>
    /* --- Card Shadow Premium --- */
.scan-container,
.result-container {
    border-radius: 16px;
    background: #fff;
    padding: 30px;

    box-shadow:
        0 6px 12px rgba(0,0,0,0.08),
        0 12px 24px rgba(0,0,0,0.12),
        0 18px 32px rgba(0,0,0,0.06) !important;
}

    .page-header {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        color: white;
    }

    .scan-container {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 5px 5px rgba(0, 0, 0, 0.05);
    }

    .scan-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #3b82f6, #1e40af);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        padding: 12px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }

    .btn-custom {
        border-radius: 10px;
        padding: 12px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .result-container {
        background: #f8fafc;
        border-radius: 12px;
        padding: 25px;
        border: 1px solid #e5e7eb;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }
</style>

<div class="page-header">
    <h2 class="mb-2">Penyaluran Bantuan</h2>
    <p class="mb-0">Scan QR penerima untuk memproses penyaluran</p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="scan-container">

            <div class="text-center mb-4">
                <div class="scan-icon">
                    <i class="fas fa-qrcode fa-2x text-white"></i>
                </div>
                <h4 class="mb-2">Scan QR Code</h4>
                <p class="text-muted">Masukkan atau scan QR penerima bantuan</p>
            </div>

            <!-- FORM SCAN -->
            <form id="verifyForm">
                @csrf

                <label class="form-label">Kode QR</label>
                <input type="text" id="qr_code" name="qr_code"
                       class="form-control mb-3"
                       placeholder="Scan atau ketik kode QR di sini..."
                       required>

                <div class="text-center">
                    <button class="btn btn-primary btn-custom">
                        <i class="fas fa-search me-2"></i> Verifikasi QR
                    </button>
                </div>
            </form>

            <!-- RESULT -->
            <div id="result" class="mt-4" style="display:none;">
                <div class="result-container">

                    <h5 class="fw-bold mb-3 text-center">
                        <i class="fas fa-user-check me-2 text-success"></i>
                        Data Penerima
                    </h5>

                    <input type="hidden" id="recipient_id">

                    <div class="mb-3">
                        <label class="form-label">Nama Anak</label>
                        <input class="form-control" id="child_name" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Ayah</label>
                        <input class="form-control" id="Ayah_name" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Ibu</label>
                        <input class="form-control" id="Ibu_name" readonly>
                    </div>

                    <hr class="my-4">

                    <h5 class="fw-bold mb-3 text-center">
                        <i class="fas fa-hand-holding-heart me-2 text-primary"></i>
                        Form Penyaluran
                    </h5>

                    <form id="distributeForm" data-action-template="{{ route('recipients.distribute', ['recipient' => '__RECIPIENT_ID__']) }}">
                        @csrf
                        <input type="hidden" name="recipient_id" id="recipient_id_2">

                        <div class="mb-3">
                            <label class="form-label">Tanggal Penyaluran</label>
                            <input type="date" name="delivery_date" id="delivery_date_field"
                                   class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Checklist Status Penerima</label>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="status_registrasi" name="registrasi">
                                        <label class="form-check-label" for="status_registrasi">Sudah Registrasi</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="status_khitan" name="has_circumcision">
                                        <label class="form-check-label" for="status_khitan">Sudah Khitan</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="status_gift" name="has_received_gift">
                                        <label class="form-check-label" for="status_gift">Sudah Terima Uang & Bingkisan</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="status_photo" name="has_photo_booth">
                                        <label class="form-check-label" for="status_photo">Sudah Foto Booth</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-success btn-custom">
                                <i class="fas fa-check me-2"></i> Simpan Penyaluran
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
const deliveryDateInput = document.getElementById('delivery_date_field');
const today = new Date().toISOString().split('T')[0];
if (deliveryDateInput && !deliveryDateInput.value) {
    deliveryDateInput.value = today;
}

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const statusControls = {
    registrasi: document.getElementById('status_registrasi'),
    khitan: document.getElementById('status_khitan'),
    gift: document.getElementById('status_gift'),
    photo: document.getElementById('status_photo'),
};

function promptStatusChecklist(currentStates) {
    Swal.fire({
        title: 'Checklist Penyaluran',
        html: `
            <div class="text-start">
                <div class="form-check mb-2">
                    <input type="checkbox" class="form-check-input" id="popup_registrasi" ${currentStates.registrasi ? 'checked' : ''}>
                    <label class="form-check-label" for="popup_registrasi">Registrasi</label>
                </div>
                <div class="form-check mb-2">
                    <input type="checkbox" class="form-check-input" id="popup_khitan" ${currentStates.khitan ? 'checked' : ''}>
                    <label class="form-check-label" for="popup_khitan">Khitan</label>
                </div>
                <div class="form-check mb-2">
                    <input type="checkbox" class="form-check-input" id="popup_gift" ${currentStates.gift ? 'checked' : ''}>
                    <label class="form-check-label" for="popup_gift">Uang Binaan & Bingkisan</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="popup_photo" ${currentStates.photo ? 'checked' : ''}>
                    <label class="form-check-label" for="popup_photo">Foto Booth</label>
                </div>
            </div>
        `,
        confirmButtonText: 'Simpan Checklist',
        confirmButtonColor: '#2563eb',
        focusConfirm: false,
        preConfirm: () => ({
            registrasi: document.getElementById('popup_registrasi').checked,
            khitan: document.getElementById('popup_khitan').checked,
            gift: document.getElementById('popup_gift').checked,
            photo: document.getElementById('popup_photo').checked,
        })
    }).then(result => {
        if (result.isConfirmed && result.value) {
            statusControls.registrasi.checked = result.value.registrasi;
            statusControls.khitan.checked = result.value.khitan;
            statusControls.gift.checked = result.value.gift;
            statusControls.photo.checked = result.value.photo;
        }
    });
}

// ===================================
// VERIFIKASI QR
// ===================================
document.getElementById('verifyForm').addEventListener('submit', function(e){
    e.preventDefault();

    const formData = new FormData(this);
    fetch("{{ route('recipients.verify-qr') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {

        if (!data.success) {
            showPopup("error", data.error || "QR tidak valid!");
            return;
        }

        showPopup("success", "QR Berhasil Diverifikasi!");
        document.getElementById('result').style.display = 'block';

        const r = data.recipient;
        document.getElementById('recipient_id').value = r.id;
        document.getElementById('recipient_id_2').value = r.id;
        const form = document.getElementById('distributeForm');
        const template = form.dataset.actionTemplate;
        if (template) {
            form.action = template.replace('__RECIPIENT_ID__', r.id);
        }

        document.getElementById('child_name').value = r.child_name;
        document.getElementById('Ayah_name').value = r.Ayah_name;
        document.getElementById('Ibu_name').value = r.Ibu_name;

        if (statusControls.registrasi) statusControls.registrasi.checked = Boolean(r.registrasi);
        if (statusControls.khitan) statusControls.khitan.checked = Boolean(r.has_circumcision);
        if (statusControls.gift) statusControls.gift.checked = Boolean(r.has_received_gift);
        if (statusControls.photo) statusControls.photo.checked = Boolean(r.has_photo_booth);

        promptStatusChecklist({
            registrasi: Boolean(r.registrasi),
            khitan: Boolean(r.has_circumcision),
            gift: Boolean(r.has_received_gift),
            photo: Boolean(r.has_photo_booth),
        });
    })
    .catch(() => showPopup("error", "Gagal menghubungi server"));
});

// ===================================
// SIMPAN PENYALURAN
// ===================================
document.getElementById('distributeForm').addEventListener('submit', function(e){
    e.preventDefault();

    const id = document.getElementById('recipient_id').value;

    const targetUrl = this.action || `/recipients/${id}/distribute`;
    const formData = new FormData(this);

    fetch(targetUrl, {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(res => {
        if (!res.ok) {
            throw new Error('HTTP ' + res.status);
        }
        return res.json();
    })
    .then(data => {
        if (data.success) {
            showPopup("success", "Penyaluran Berhasil!");
            setTimeout(() => location.reload(), 1500);
        } else {
            showPopup("warning", data.error ?? "Terjadi kesalahan");
        }
    })
    .catch(() => showPopup("error", "Gagal mengirim data"));
});
</script>

@endsection

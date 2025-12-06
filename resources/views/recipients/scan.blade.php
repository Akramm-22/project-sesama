@extends('layouts.app')

@section('title', 'Penyaluran')

@section('content')
    <style>
        /* --- Card Shadow Premium --- */
        .page-header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            border-radius: 16px;
            padding: 28px;
            margin-bottom: 35px;
            color: white;
            box-shadow:
                0 10px 20px rgba(0, 0, 0, 0.12),
                0 15px 30px rgba(0, 0, 0, 0.10);
        }

        .scan-container,
        .result-container {
            background: #ffffff;
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 25px;
            box-shadow:
                0 6px 12px rgba(0, 0, 0, 0.10),
                0 12px 24px rgba(0, 0, 0, 0.06),
                0 18px 36px rgba(0, 0, 0, 0.04) !important;
        }

        .scan-icon {
            width: 85px;
            height: 85px;
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow:
                0 6px 12px rgba(0, 0, 0, 0.15),
                0 12px 20px rgba(0, 0, 0, 0.10);
        }

        .btn-custom {
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: 600;
        }

        .hidden {
            display: none !important;
        }

        #camera-area {
            position: relative;
            max-width: 320px;
            margin: 10px auto;
        }

        #reader {
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
        }

        /* FRAME QR */
        .scan-frame {
            position: absolute;
            width: 200px;
            height: 200px;
            pointer-events: none;
        }

        /* CORNER STYLE */
        .scan-frame span {
            position: absolute;
            width: 35px;
            height: 35px;
            border: 4px solid #2563eb;
        }

        /* Corners */
        .scan-frame span:nth-child(1) {
            top: 0;
            left: 0;
            border-right: none;
            border-bottom: none;
        }

        .scan-frame span:nth-child(2) {
            top: 0;
            right: 0;
            border-left: none;
            border-bottom: none;
        }

        .scan-frame span:nth-child(3) {
            bottom: 0;
            left: 0;
            border-right: none;
            border-top: none;
        }

        .scan-frame span:nth-child(4) {
            bottom: 0;
            right: 0;
            border-left: none;
            border-top: none;
        }

        @media (max-width:576px) {

            #btnCamera {
                display: block;
                width: 100%;
                margin-bottom: 10px !important;
            }

            #btnManual {
                display: block;
                width: 100%;
                margin-top: 4px !important;
            }

        }
        /* === BUTTON KAMERA DEFAULT BIRU PUTIH === */
.btn-camera-primary {
    background: #2563eb !important;
    color: #fff !important;
    border: none !important;
    padding: 12px 28px;
    border-radius: 10px;
    font-weight: 600;

    box-shadow:
        0 6px 14px rgba(37,99,235,0.45),
        0 10px 22px rgba(37,99,235,0.25);

    transition: all .2s ease;
}

/* icon putih */
.btn-camera-primary i {
    color: #fff !important;
}

/* hover tetap biru (sedikit naik tone aja) */
.btn-camera-primary:hover,
.btn-camera-primary:focus,
.btn-camera-primary:active {
    background: #1d4ed8 !important;
    color: #fff !important;

    box-shadow:
        0 8px 18px rgba(37,99,235,0.55),
        0 12px 28px rgba(37,99,235,0.35);

    transform: translateY(-1px);
}

    </style>

    <div class="page-header">
        <h2 class="mb-3">Penyaluran Bantuan</h2>
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
                    <p class="text-muted">Pilih mode: pakai kamera atau masukkan manual</p>
                </div>

                <!-- PILIH MODE -->
                <div class="text-center mt-3 mb-2">
                   <button type="button" class="btn btn-camera-primary btn-custom" id="btnCamera">

                        <i class="fas fa-camera me-2"></i> Scan via Kamera
                    </button>

                    <button type="button" class="btn btn-secondary btn-custom" id="btnManual">
                        <i class="fas fa-keyboard me-2"></i>Input Manual
                    </button>
                </div>

                <!-- AREA KAMERA -->
                <div id="camera-area" style="display:none;max-width:380px;margin:0 auto;">
                    <div id="reader"></div>
                    <div class="scan-frame">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>

                    <p class="text-center small text-muted mt-2">
                        Arahkan kamera ke QR Code
                    </p>
                    <div class="text-center mt-2">
                        <button type="button" class="btn btn-outline-danger btn-custom d-none" id="btnStopCamera">
                            <i class="fas fa-stop me-2"></i> Stop Kamera
                        </button>
                    </div>
                </div>

                <!-- FORM VERIFIKASI QR -->
                <form id="verifyForm" class="mt-3">
                    @csrf
                    <div class="mb-4" id="manual-input-wrapper">
                        <label for="qr_code" class="form-label">Kode QR</label>
                        <input type="text" name="qr_code" id="qr_code" class="form-control"
                            placeholder="Scan atau ketik kode QR di sini..." autofocus required>
                        <small class="form-text text-muted mt-2 d-block">
                            <i class="fas fa-info-circle me-1"></i>
                            Gunakan scanner atau ketik manual kode QR
                        </small>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-custom">
                            <i class="fas fa-search me-2"></i>Verifikasi QR Code
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

                        <form id="distributeForm"
                            data-action-template="{{ route('recipients.distribute', ['recipient' => '__RECIPIENT_ID__']) }}">
                            @csrf
                            <input type="hidden" name="recipient_id" id="recipient_id_2">

                            <div class="mb-3">
                                <label class="form-label">Tanggal Penyaluran</label>
                                <input type="date" name="delivery_date" id="delivery_date_field" class="form-control"
                                    value="{{ now()->format('Y-m-d') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Checklist Status Penerima</label>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="status_registrasi"
                                                name="registrasi">
                                            <label class="form-check-label" for="status_registrasi">Sudah Registrasi</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="status_khitan"
                                                name="has_circumcision">
                                            <label class="form-check-label" for="status_khitan">Sudah Khitan</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="status_gift"
                                                name="has_received_gift">
                                            <label class="form-check-label" for="status_gift">Sudah Terima Uang &
                                                Bingkisan</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="status_photo"
                                                name="has_photo_booth">
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

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

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
        document.getElementById('verifyForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            fetch("https://sesama-baru.smktibazma.com/recipients/verify-qr", {
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
        document.getElementById('distributeForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const targetUrl = this.action;
            const formData = new FormData(this);

            fetch(targetUrl, {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(r => r.json())
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

    <script>
        const scanSound = new Audio("/sounds/beep.mp3");
        scanSound.volume = 0.7;

        // ======================================================
        // ELEMENT
        // ======================================================
        const readerId = "reader";
        const cameraArea = document.getElementById("camera-area");
        const btnCamera = document.getElementById("btnCamera");
        const btnStop = document.getElementById("btnStopCamera");
        const manualWrapper = document.getElementById("manual-input-wrapper");
        const btnManual = document.getElementById("btnManual");

        let scanner = null;
        let trackingInterval = null;

        // ======================================================
        // START SCANNER
        // ======================================================
        btnCamera.addEventListener("click", () => {
            cameraArea.style.display = "block";
            btnStop.classList.remove("d-none");

            // sembunyikan input manual
            if (manualWrapper) {
                manualWrapper.classList.add("hidden");
            }

            if (scanner) return;

            scanner = new Html5Qrcode(readerId);

            scanner.start({
                        facingMode: "environment"
                    }, {
                        fps: 12,
                        qrbox: {
                            width: 200,
                            height: 200
                        }
                    },

                    // QR SUCCESS CALLBACK
                    qrMessage => {

                        // 🔊 beep
                        scanSound.currentTime = 0;
                        scanSound.play().catch(() => {});

                        // isi input QR
                        document.getElementById("qr_code").value = qrMessage;

                        // stop kamera
                        stopScanner();

                        // submit form -> inilah yg munculin popup + fetch verify
                        document.getElementById("verifyForm")
                            .dispatchEvent(new Event("submit"));

                    }

                )
                .then(() => {
                    startFrameTracker();
                })
                .catch(err => {
                    console.error("Scanner error:", err);
                    showPopup("error", "Gagal mengakses kamera");
                });
        });

        // tombol Input Manual → paksa kembali ke mode manual
        btnManual.addEventListener("click", () => {
            stopScanner();
            cameraArea.style.display = "none";
            btnStop.classList.add("d-none");

            if (manualWrapper) {
                manualWrapper.classList.remove("hidden");
            }
        });

        // ======================================================
        // STOP SCANNER
        // ======================================================
        btnStop.addEventListener("click", stopScanner);

        function stopScanner() {
            if (!scanner) {
                // pastikan form manual muncul lagi walau scanner sudah null
                if (manualWrapper) manualWrapper.classList.remove("hidden");
                cameraArea.style.display = "none";
                btnStop.classList.add("d-none");
                return;
            }

            scanner.stop().then(() => {
                scanner.clear();
                scanner = null;

                cameraArea.style.display = "none";
                btnStop.classList.add("d-none");

                if (manualWrapper) {
                    manualWrapper.classList.remove("hidden");
                }

                if (trackingInterval) {
                    clearInterval(trackingInterval);
                    trackingInterval = null;
                }
            });
        }

        // ======================================================
        // FRAME TRACKING
        // ======================================================
        function startFrameTracker() {
            trackingInterval = setInterval(() => {
                const frame = document.querySelector(".scan-frame");
                const video = document.querySelector("#reader video");

                if (!frame || !video) return;

                const videoRect = video.getBoundingClientRect();
                const parentRect = cameraArea.getBoundingClientRect();
                const frameSize = 200;

                frame.style.top =
                    (videoRect.top - parentRect.top +
                        (videoRect.height - frameSize) / 2) + 'px';

                frame.style.left =
                    (videoRect.left - parentRect.left +
                        (videoRect.width - frameSize) / 2) + 'px';

            }, 150);
        }
    </script>
@endsection

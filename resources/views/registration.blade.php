@extends('layouts.app')


@section('title', 'Registrasi')


@section('content')
    <!-- Pastikan layout kamu sudah memuat Bootstrap / FontAwesome jika belum, tambahkan di layout utama -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <style>
        /* --- (CSS kamu, 1x saja) --- */
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


        .form-control {
            border-radius: 10px;
            padding: 12px 14px;
            border: 1px solid #e5e7eb;
            font-size: 0.95rem;
            transition: .25s ease;
        }


        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }


        .btn-custom {
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: 600;
            transition: 0.25s ease;
        }


        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
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


        .scan-icon i {
            font-size: 2rem;
            color: white;
        }


        .result-container {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
        }


        @media (max-width: 576px) {
            .page-header {
                padding: 20px;
                text-align: center;
            }

            .scan-container,
            .result-container {
                padding: 22px;
            }

            .btn-custom {
                width: 100%;
                font-size: 1rem;
            }

            .scan-icon {
                width: 70px;
                height: 70px;
            }

@media (max-width:576px){

    #btnCamera{
        margin-bottom:12px !important;
    }

    #btnManual{
        margin-top:4px !important;
    }

}

        }


        /* small helper */
        .hidden {
            display: none !important;
        }
    </style>


    <div class="page-header">
        <h2 class="mb-3">Registrasi Bantuan</h2>
        <p class="mb-0">Scan QR Code untuk verifikasi dan proses registrasi</p>
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
                <div class="text-center mb-4">
                    <button type="button" class="btn btn-primary btn-custom me-2" id="btnCamera">
                        <i class="fas fa-camera me-2"></i>Scan via Kamera
                    </button>


                    <button type="button" class="btn btn-secondary btn-custom" id="btnManual">
                        <i class="fas fa-keyboard me-2"></i>Input Manual
                    </button>
                </div>


                <!-- AREA KAMERA -->
                <div id="camera-area" class="mb-3 hidden">
                    <div id="reader" style="width: 100%; max-width: 420px; margin: 0 auto;"></div>
                    <p class="text-center text-muted small mt-2">Arahkan kamera ke QR Code</p>
                    <div class="text-center mt-2">
                        <button type="button" id="btnStopCamera" class="btn btn-sm btn-outline-danger">Stop Kamera</button>
                    </div>
                </div>


                <!-- FORM VERIFIKASI MANUAL -->
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


                <!-- Hasil scan / form edit -->
                <div id="result" class="mt-4 hidden">
                    <div class="result-container">
                        <h5 class="fw-bold mb-4 text-center">
                            <i class="fas fa-user-check me-2 text-success"></i>
                            Data Penerima
                        </h5>


                        <form id="editForm">
                            @csrf
                            <input type="hidden" name="qr_code" id="edit_qr_code">


                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Anak</label>
                                    <input type="text" name="child_name" id="child_name" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Ayah</label>
                                    <input type="text" name="Ayah_name" id="Ayah_name" class="form-control">
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Ibu</label>
                                    <input type="text" name="Ibu_name" id="Ibu_name" class="form-control">
                                </div>
                                 <div class="col-md-6 mb-3">
                                    <label class="form-label">Nomor whatsapp</label>
                                    <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-control">
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="birth_date" id="birth_date" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Region</label>
                                    <input type="text" name="region" id="region" class="form-control">
                                </div>

                            </div>


                            <div class="mb-4">
                                <label class="form-label">Alamat</label>
                                <textarea name="address" id="address" class="form-control" rows="3"></textarea>
                            </div>


                            <div class="text-center">
                                <button type="submit" class="btn btn-success btn-custom">
                                    <i class="fas fa-check me-2"></i>Simpan & Registrasikan
                                </button>
                            </div>


                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>


    <!-- Small table style if needed -->
    <style>
        .table th {
            white-space: nowrap;
            padding: 4px 8px;
            font-size: 0.9rem;
        }

        .table td {
            padding: 4px 8px;
            font-size: 0.9rem;
        }
    </style>


    <!-- LIB: html5-qrcode -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>


    <script>
        // helper: show popup (simple)



        function showPopup(type, message) {

            alert((type || '').toUpperCase() + ": " + (message || ''));
        }


        // csrf token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


        // DOM refs
        const scanSound = new Audio("/sounds/beep.mp3");
        scanSound.volume = 0.7;

        const btnCamera = document.getElementById('btnCamera');
        const btnManual = document.getElementById('btnManual');
        const cameraArea = document.getElementById('camera-area');
        const manualWrapper = document.getElementById('manual-input-wrapper');
        const readerId = 'reader';
        const btnStopCamera = document.getElementById('btnStopCamera');
        const birthDateInput = document.getElementById('birth_date');


        let scannerInstance = null;


        // show/hide functions
        function showCamera() {
            cameraArea.classList.remove('hidden');
            manualWrapper.classList.add('hidden');
        }


        function hideCamera() {
            cameraArea.classList.add('hidden');
            manualWrapper.classList.remove('hidden');
        }


        btnCamera.addEventListener('click', () => {
            showCamera();
            startCameraScanner();
        });


        btnManual.addEventListener('click', () => {
            hideCamera();
            stopScannerIfAny();
        });


        // Stop camera button
        btnStopCamera.addEventListener('click', () => {
            stopScannerIfAny();
            hideCamera();
        });


        // START/STOP scanner
        function startCameraScanner() {
            if (scannerInstance) return;


            scannerInstance = new Html5Qrcode(readerId);


            scannerInstance.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: 250,
                    supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
                },
                qrMessage => {
                    // ketika terbaca: isi input hidden dan panggil verify otomatis
                    scanSound.currentTime = 0;
                    scanSound.play().catch(()=>{});


                    document.getElementById('qr_code').value = qrMessage;
                    stopScannerIfAny();
                    // otomatis verifikasi (sama dengan submit verifyForm)
                    verifyQr(qrMessage);
                },
                errorMessage => {
                    // console.debug('scan error', errorMessage);
                }
            ).catch(err => {
                console.error('startCameraScanner error', err);
                showPopup('error', 'Gagal mengakses kamera. Pastikan izinkan akses kamera pada browser.');
            });
        }


        function stopScannerIfAny() {
            if (!scannerInstance) return;
            scannerInstance.stop().then(() => {
                scannerInstance.clear();
                scannerInstance = null;
            }).catch(e => {
                scannerInstance = null;
            });
        }


        // VERIFY via fetch (dipanggil dari camera auto atau form manual submit)
        function verifyQr(qrCode) {
            const fd = new FormData();
            fd.append('qr_code', qrCode);


            fetch('https://sesama-baru.smktibazma.com/registration/verify', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: fd
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        // tampilkan form edit dan isi
                        document.getElementById('result').classList.remove('hidden');
                        document.getElementById('edit_qr_code').value = data.recipient.qr_code || qrCode;
                        document.getElementById('child_name').value = data.recipient.child_name || '';
                        document.getElementById('Ayah_name').value = data.recipient.Ayah_name || '';
                        document.getElementById('Ibu_name').value = data.recipient.Ibu_name || '';
                        document.getElementById('birth_date').value = data.recipient.birth_date || '';
                        document.getElementById('whatsapp_number').value = data.recipient.whatsapp_number || '';
                        document.getElementById('region').value = data.recipient.region || '';
                        document.getElementById('address').value = data.recipient.address || '';


                        showPopup('success', 'QR Valid! Edit data jika perlu lalu Simpan.');
                    } else {
                        showPopup('error', data.error || 'QR tidak ditemukan pada database.');
                    }
                })
                .catch(() => {
                    showPopup('error', 'Gagal koneksi ke server!');
                });
        }


        // FORM MANUAL SUBMIT
        document.getElementById('verifyForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const code = document.getElementById('qr_code').value.trim();
            if (!code) {
                showPopup('warning', 'Masukkan kode QR terlebih dahulu.');
                return;
            }
            verifyQr(code);
        });


        // EDIT FORM SUBMIT (simpan & update status -> registered)
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();


            const form = e.target;
            const fd = new FormData(form);
            // pastikan qr_code ada
            if (!fd.get('qr_code')) {
                showPopup('warning', 'Tidak ada QR code untuk disimpan.');
                return;
            }


            fetch('https://sesama-baru.smktibazma.com/registration/confirm', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: fd
                })
                .then(r => r.json())
                .then(resp => {
                    if (resp.success) {
                        showPopup('success', resp.message || 'Registrasi berhasil.');
                        setTimeout(() => location.reload(), 1200);
                    } else {
                        showPopup('error', resp.error || 'Gagal memperbarui data.');
                    }
                })
                .catch(() => {
                    showPopup('error', 'Gagal koneksi ke server!');
                });
        });

        function syncAgeWithBirthDate() {
            const dateVal = birthDateInput.value;
            if (!dateVal) return;
            const today = new Date();
            const birth = new Date(dateVal);
            let age = today.getFullYear() - birth.getFullYear();
            const m = today.getMonth() - birth.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) {
                age--;
            }
            ageInput.value = age > 0 ? age : '';
        }

        birthDateInput?.addEventListener('change', syncAgeWithBirthDate);
        if (birthDateInput?.value && !ageInput.value) {
            syncAgeWithBirthDate();
        }
    </script>


@endsection

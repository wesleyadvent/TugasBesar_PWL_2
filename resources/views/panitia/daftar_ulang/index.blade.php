@extends('layouts.app2')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid py-2">
        <div class="row justify-content-center">
            <div class="col-md-15">

                <div class="card shadow-sm">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Re - Registration</h6>
                        </div>
                    </div>
                    <br>
                    <div class="card-body">

                        <div id="reader" class="mx-auto" style="width: 100%; max-width: 750px;"></div>

                        <div id="result" class="mt-3 text-center fw-semibold" style="min-height: 40px;"></div>

                        <div id="loading" class="mt-2 text-center d-none">
                            <div class="spinner-border text-primary" role="status" aria-hidden="true"></div>
                            <div>Memproses...</div>
                        </div>

                        <!-- Tombol Scan Lagi, awalnya disembunyikan -->
                        <div class="text-center mt-3">
                            <button id="btn-scan-again" class="btn btn-primary d-none">Scan Lagi</button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ✅ Import library html5-qrcode --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const resultElem = document.getElementById("result");
            const loadingElem = document.getElementById("loading");
            const btnScanAgain = document.getElementById("btn-scan-again");

            let html5QrcodeScanner;

            function showResult(message, success = true) {
                resultElem.innerHTML = message;
                resultElem.style.color = success ? "green" : "red";
            }

            function startScanner() {
                btnScanAgain.classList.add('d-none');
                loadingElem.classList.add('d-none');
                showResult('');
                html5QrcodeScanner = new Html5QrcodeScanner("reader", {
                    fps: 10,
                    qrbox: 250
                });
                html5QrcodeScanner.render(onScanSuccess);
            }

            function onScanSuccess(decodedText, decodedResult) {
                html5QrcodeScanner.clear();
                loadingElem.classList.remove('d-none');
                showResult('');

                let data;
                try {
                    data = JSON.parse(decodedText);
                } catch (e) {
                    loadingElem.classList.add('d-none');
                    showResult("<strong>QR Code tidak valid</strong>", false);
                    btnScanAgain.classList.remove('d-none'); // Tampilkan tombol scan lagi
                    return;
                }

                fetch("http://localhost:3000/api/kehadiran", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        pendaftaran_event_id: data.pendaftaran_event_id,
                        user_id: data.user_id,
                        event_id: data.event_id
                    })
                })
                .then(res => res.json())
                .then(responseData => {
                    loadingElem.classList.add('d-none');
                    if (responseData.message) {
                        showResult("<strong>" + responseData.message + "</strong>", true);
                    } else {
                        showResult("<strong>Response tidak sesuai</strong>", false);
                    }
                    btnScanAgain.classList.remove('d-none'); // Tampilkan tombol scan lagi setelah selesai
                })
                .catch(err => {
                    loadingElem.classList.add('d-none');
                    showResult("<strong>Gagal: " + err.message + "</strong>", false);
                    btnScanAgain.classList.remove('d-none'); // Tampilkan tombol scan lagi jika error
                });
            }

            // Event klik tombol scan lagi
            btnScanAgain.addEventListener('click', function() {
                startScanner();
            });

            // Mulai scanner pertama kali saat halaman dimuat
            startScanner();
        });
    </script>
@endsection

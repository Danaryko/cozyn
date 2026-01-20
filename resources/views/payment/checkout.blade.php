<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Kost - Cozyn</title>
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full text-center">
        <h2 class="text-2xl font-bold mb-4 text-orange-500">Konfirmasi Pembayaran</h2>
        <p class="mb-6 text-gray-600">Total yang harus dibayar:</p>
        <div class="text-3xl font-bold mb-8">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</div>

        <button id="pay-button" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-full w-full transition duration-300">
            Bayar Sekarang
        </button>
    </div>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            // Trigger Snap Popup
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    // Redirect jika sukses
                    window.location.href = "{{ route('payment.success', $transaction->id) }}";
                },
                onPending: function (result) {
                    alert("Menunggu pembayaran Anda!");
                },
                onError: function (result) {
                    alert("Pembayaran gagal!");
                },
                onClose: function () {
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        });
    </script>
</body>
</html>
<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Panggil config sesuai nama key di file midtrans.php kamu
        Config::$serverKey = config('midtrans.serverKey');      
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');
    }

    public function pay(Transaction $transaction)
    {
        // Pastikan transaksi milik user yang login
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        // Buat params untuk Snap Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => 'TRX-' . $transaction->id . '-' . time(), // Order ID unik
                'gross_amount' => $transaction->total_amount,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];

        // Dapatkan Snap Token
        $snapToken = Snap::getSnapToken($params);

        // Tampilkan halaman pembayaran
        return view('payment.checkout', compact('snapToken', 'transaction'));
    }

    public function success(Transaction $transaction)
    {
        return redirect()->route('my-orders')->with('success', 'Pembayaran Berhasil! Kost kamu sudah siap.');
    }

    // --- TAMBAHKAN CODE INI ---
    public function notification(Request $request)
    {
        // 1. Ambil Server Key dari Config
        $serverKey = config('midtrans.serverKey');

        // 2. Buat Validasi Signature Key (Keamanan)
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        // Jika signature valid (benar dari Midtrans)
        if ($hashed == $request->signature_key) {
            
            // 3. Pecah Order ID untuk dapatkan ID Transaksi asli
            // Format tadi: TRX-1-123456789
            // Kita butuh angka '1' saja
            $orderIdParts = explode('-', $request->order_id);
            $transactionId = $orderIdParts[1]; 

            // 4. Cari Transaksi di Database
            $transaction = Transaction::find($transactionId);

            if ($transaction) {
                // 5. Cek Status dari Midtrans & Update Database
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    // Pembayaran Berhasil
                    $transaction->update(['payment_status' => 'paid']);
                } 
                elseif ($request->transaction_status == 'expire' || $request->transaction_status == 'cancel' || $request->transaction_status == 'deny') {
                    // Pembayaran Gagal
                    $transaction->update(['payment_status' => 'failed']);
                }
            }
        }

        return response('OK'); // Beritahu Midtrans bahwa notifikasi sudah diterima
    }
}
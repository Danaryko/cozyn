<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingShowRequest;
use App\Http\Requests\CustomerInformationStoreRequest;
use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Interfaces\TransactionRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Room;

class BookingController extends Controller
{
    private BoardingHouseRepositoryInterface $boardingHouseRepository;
    private TransactionRepositoryInterface $transactionRepository;

    public function __construct(
        BoardingHouseRepositoryInterface $boardingHouseRepository,
        TransactionRepositoryInterface $transactionRepository
    ) {
        $this->boardingHouseRepository = $boardingHouseRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function booking(Request $request, $slug)
    {
        $this->transactionRepository->saveTransactionDataToSession($request->all());

        return redirect()->route('booking.information', $slug);
    }

    public function information($slug)
    {
        $transaction = $this->transactionRepository->getTransactionDataFromSession();
        $boardingHouse = $this->boardingHouseRepository->getBoardingHouseBySlug($slug);
        $room = $this->boardingHouseRepository->getBoardingHouseRoomById($transaction['room_id']);

        return view('pages.booking.information', compact('transaction', 'boardingHouse', 'room'));
    }

    public function saveInformation(CustomerInformationStoreRequest $request, $slug)
    {
        $data = $request->validated();

        $this->transactionRepository->saveTransactionDataToSession($data);

        return redirect()->route('booking.checkout', $slug);
    }

    public function checkout($slug)
    {
        $transaction = $this->transactionRepository->getTransactionDataFromSession();
        $boardingHouse = $this->boardingHouseRepository->getBoardingHouseBySlug($slug);
        $room = $this->boardingHouseRepository->getBoardingHouseRoomById($transaction['room_id']);

        return view('pages.booking.checkout', compact('transaction', 'boardingHouse', 'room'));
    }

    public function payment(Request $request)
    {
        dd([
            'ISI_SESSION' => session()->all(),
            'ISI_REQUEST' => $request->all(),
        ]);
        // 1. Simpan input ke session (SOP standar)
        $this->transactionRepository->saveTransactionDataToSession($request->all());

        // 2. Ambil data dari session
        $data = $this->transactionRepository->getTransactionDataFromSession();

        // 3. Ambil data Room untuk menghitung harga (Manual)
        $room = Room::find($data['room_id']);

        // 4. 🔥 RACIK DATA SECARA MANUAL (BYPASS REPOSITORY) 🔥
        // Kita isi semua field wajib di sini supaya tidak ada alasan error lagi
        $data['code'] = 'TRX-' . mt_rand(10000, 99999); // Kode Unik
        $data['payment_status'] = 'paid'; // Status Langsung Paid
        $data['transaction_date'] = now(); // Tanggal Transaksi

        // Hitung Total Bayar Manual
        $subtotal = $room->price_per_month * $data['duration'];
        $tax = $subtotal * 0.11;      // PPN 11%
        $insurance = $subtotal * 0.01; // Asuransi 1%
        $total = $subtotal + $tax + $insurance;
        
        // Cek metode pembayaran (Full / DP 30%)
        $data['total_amount'] = ($data['payment_method'] === 'full_payment') ? $total : ($total * 0.3);

        // 5. Simpan ke Database LANGSUNG via Model (Tanpa lewat Repository yang error)
        $transaction = Transaction::create($data);

        // 6. Konfigurasi Midtrans (Tetap sama)
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->code,
                'gross_amount' => (int) $transaction->total_amount,
            ],
            'customer_details' => [
                'first_name' => $transaction->name,
                'email' => $transaction->email,
                'phone' => $transaction->phone_number,
            ],
        ];

        $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;
        return redirect($paymentUrl);
    }

    public function success(Request $request)
    {
        $transaction = $this->transactionRepository->getTransactionByCode($request->order_id);

        if (!$transaction) {
            return redirect()->route('home');
        }

        return view('pages.booking.success', compact('transaction'));
    }

    public function check()
    {
        return view('pages.booking.check-booking');
    }

    public function show(BookingShowRequest $request)
    {
        $transaction = $this->transactionRepository->getTransactionByCodeEmailPhone($request->code, $request->email, $request->phone_number);
        
        if (!$transaction) {
            return redirect()->back()->with('error', 'Transaction not found');
        }
        
        return view('pages.booking.detail', compact('transaction'));
    }
}

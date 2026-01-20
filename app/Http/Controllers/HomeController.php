<?php

namespace App\Http\Controllers;

use App\Models\BoardingHouse;
use App\Models\Category;
use App\Models\City;
use App\Models\Transaction; // Jangan lupa import ini
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $cities = City::all();
        
        $popularBoardingHouses = BoardingHouse::with(['city', 'category'])
            ->inRandomOrder()
            ->take(5)
            ->get();

        $boardingHouses = BoardingHouse::with(['city', 'category'])
            ->latest()
            ->take(5)
            ->get();

        return view('pages.home', compact('categories', 'cities', 'popularBoardingHouses', 'boardingHouses'));
    }

    // --- FITUR PENCARIAN & DETAIL ---

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $boardingHouses = BoardingHouse::where('category_id', $category->id)->get();
        return view('pages.category.show', compact('category', 'boardingHouses'));
    }

    public function city($slug)
    {
        $city = City::where('slug', $slug)->firstOrFail();
        $boardingHouses = BoardingHouse::where('city_id', $city->id)->get();
        return view('pages.city.show', compact('city', 'boardingHouses'));
    }

    public function details($slug)
    {
        $boardingHouse = BoardingHouse::where('slug', $slug)->firstOrFail();
        
        $isWishlist = false;
        if (auth()->check()) {
            $isWishlist = auth()->user()->hasLiked($boardingHouse->id);
        }

        return view('pages.boarding-house.show', compact('boardingHouse', 'isWishlist'));
    }

    // --- FITUR USER DASHBOARD ---

    public function favorites()
    {
        $boardingHouses = auth()->user()->wishlists()->with('city')->get();
        return view('pages.my-favorites', compact('boardingHouses'));
    }

    public function toggleWishlist($id)
    {
        $boardingHouse = BoardingHouse::findOrFail($id);
        
        if (auth()->user()->hasLiked($id)) {
            auth()->user()->wishlists()->detach($id);
        } else {
            auth()->user()->wishlists()->attach($id);
        }

        return redirect()->back();
    }

    // --- ALUR BOOKING (STEP 1 - 3) ---

    // STEP 1: Cek Ketersediaan & Tanggal
    public function check_booking($slug)
    {
        $boardingHouse = BoardingHouse::where('slug', $slug)->firstOrFail();
        return view('pages.booking.check-booking', compact('boardingHouse'));
    }

    public function check_booking_store(Request $request, $slug)
    {
        $request->validate([
            'start_date' => 'required|date',
            'duration'   => 'required|integer|min:1',
        ]);

        session()->put('booking_data', [
            'slug' => $slug,
            'start_date' => $request->start_date,
            'duration' => $request->duration,
        ]);

        return redirect()->route('booking.information', $slug);
    }

    // STEP 2: Informasi Data Diri
    public function booking_information($slug)
    {
        $boardingHouse = BoardingHouse::where('slug', $slug)->firstOrFail();
        
        if (!session()->has('booking_data')) {
            return redirect()->route('booking.check', $slug);
        }

        return view('pages.booking.information', compact('boardingHouse'));
    }

    public function booking_information_store(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        $bookingData = session()->get('booking_data');
        $bookingData['name'] = $request->name;
        $bookingData['email'] = $request->email;
        $bookingData['phone'] = $request->phone;
        
        session()->put('booking_data', $bookingData);

        return redirect()->route('checkout', $slug);
    }

    // STEP 3: Review & Simpan Transaksi
    public function checkout($slug)
    {
        $boardingHouse = BoardingHouse::where('slug', $slug)->firstOrFail();
        $bookingData = session()->get('booking_data');

        if (!$bookingData) {
            return redirect()->route('booking.check', $slug);
        }

        return view('pages.booking.checkout', compact('boardingHouse', 'bookingData'));
    }
    
    public function checkout_store(Request $request, $slug)
    {
        // 1. Ambil Data Booking dari Session (Laci 'booking_data')
        $bookingData = session()->get('booking_data');

        if (!$bookingData) {
            return redirect()->route('booking.check', $slug);
        }

        // 2. Ambil Data Kost
        $boardingHouse = BoardingHouse::where('slug', $slug)->firstOrFail();

        // 3. Otomatis Pilih Kamar yang Tersedia
        $room = $boardingHouse->rooms()->where('is_available', true)->first();

        if (!$room) {
            return redirect()->back()->with('error', 'Maaf, kamar di kost ini sedang penuh.');
        }

        // 4. Hitung Total Harga (Perbaiki 'price' jadi 'price_per_month')
        $duration = (int) $bookingData['duration'];
        $totalAmount = $room->price_per_month * $duration;

        // 5. Simpan Transaksi (LENGKAP DENGAN CODE & MAPPING DATA)
        $transaction = Transaction::create([
            'code'              => 'TRX-' . mt_rand(10000, 99999), // <-- INI YANG DULU HILANG
            'user_id'           => auth()->id(),
            'room_id'           => $room->id,
            'boarding_house_id' => $boardingHouse->id,
            'total_amount'      => $totalAmount,
            'payment_status'    => 'pending', // Status awal Pending
            'payment_method'    => 'full_payment', // Default method
            'start_date'        => $bookingData['start_date'],
            'duration'          => $duration,
            'name'              => $bookingData['name'],
            'email'             => $bookingData['email'],
            'phone_number'      => $bookingData['phone'], // <-- Mapping: phone ke phone_number
        ]);

        // 6. Redirect ke PaymentController untuk proses Midtrans
        return redirect()->route('payment.pay', $transaction->id);
    }

    // Halaman Terima Kasih (Setelah Bayar)
    public function payment_success()
    {
        return view('pages.booking.success');
    }
}
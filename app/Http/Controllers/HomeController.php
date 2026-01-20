<?php

namespace App\Http\Controllers;

use App\Models\BoardingHouse;
use App\Models\Category;
use App\Models\City;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $cities = City::all();
        
        // 1. Data untuk bagian "Popular Kos" (Kita ambil 5 secara acak)
        $popularBoardingHouses = BoardingHouse::with(['city', 'category'])
            ->inRandomOrder()
            ->take(5)
            ->get();

        // 2. Data untuk bagian "All Great Kost" (Kita ambil 5 terbaru)
        $boardingHouses = BoardingHouse::with(['city', 'category'])
            ->latest()
            ->take(5)
            ->get();

        // Kirimkan SEMUA variabel ke view
        return view('pages.home', compact('categories', 'cities', 'popularBoardingHouses', 'boardingHouses'));
    }

    // --- TAMBAHKAN 3 FUNGSI INI ---

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $boardingHouses = BoardingHouse::where('category_id', $category->id)->get();
        // Pastikan file view ini nanti dibuat
        return view('pages.category.show', compact('category', 'boardingHouses'));
    }

    public function city($slug)
    {
        $city = City::where('slug', $slug)->firstOrFail();
        $boardingHouses = BoardingHouse::where('city_id', $city->id)->get();
        // Pastikan file view ini nanti dibuat
        return view('pages.city.show', compact('city', 'boardingHouses'));
    }

    public function details($slug)
    {
        $boardingHouse = BoardingHouse::where('slug', $slug)->firstOrFail();
        
        // Cek status like
        $isWishlist = false;
        if (auth()->check()) {
            $isWishlist = auth()->user()->hasLiked($boardingHouse->id);
        }

        return view('pages.boarding-house.show', compact('boardingHouse', 'isWishlist'));
    }

    public function favorites()
    {
        // Ambil daftar kost yang disukai user
        $boardingHouses = auth()->user()->wishlists()->with('city')->get();
        
        return view('pages.my-favorites', compact('boardingHouses'));
    }

    public function orders()
    {
        // Nanti bisa diganti dengan data transaksi asli
        return view('pages.my-orders');
    }

    public function toggleWishlist($id)
    {
        $boardingHouse = BoardingHouse::findOrFail($id);
        
        // Logika Toggle: Kalau sudah ada -> hapus (detach), kalau belum -> tambah (attach)
        if (auth()->user()->hasLiked($id)) {
            auth()->user()->wishlists()->detach($id);
        } else {
            auth()->user()->wishlists()->attach($id);
        }

        return redirect()->back();
    }

    // ----------------------------------------------------
    // STEP 1: PILIH TANGGAL
    // ----------------------------------------------------
    public function check_booking($slug)
    {
        $boardingHouse = BoardingHouse::where('slug', $slug)->firstOrFail();
        return view('pages.booking.check-booking', compact('boardingHouse'));
    }

    public function check_booking_store(Request $request, $slug)
    {
        // Validasi
        $request->validate([
            'start_date' => 'required|date',
            'duration'   => 'required|integer|min:1',
        ]);

        // Simpan ke session
        session()->put('booking_data', [
            'slug' => $slug,
            'start_date' => $request->start_date,
            'duration' => $request->duration,
        ]);

        // UBAH ARAH: Ke halaman Information dulu (bukan checkout)
        return redirect()->route('booking.information', $slug);
    }

    // ----------------------------------------------------
    // STEP 2: ISI DATA DIRI (booking.information)
    // ----------------------------------------------------
    public function booking_information($slug)
    {
        $boardingHouse = BoardingHouse::where('slug', $slug)->firstOrFail();
        
        // Cek apakah user sudah pilih tanggal?
        if (!session()->has('booking_data')) {
            return redirect()->route('booking.check', $slug);
        }

        return view('pages.booking.information', compact('boardingHouse'));
    }

    public function booking_information_store(Request $request, $slug)
    {
        // Validasi Data Diri
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        // Tambahkan data diri ke session booking yang sudah ada
        $bookingData = session()->get('booking_data');
        $bookingData['name'] = $request->name;
        $bookingData['email'] = $request->email;
        $bookingData['phone'] = $request->phone;
        
        session()->put('booking_data', $bookingData);

        // Lanjut ke Checkout
        return redirect()->route('checkout', $slug);
    }

    // ----------------------------------------------------
    // STEP 3: CHECKOUT (Review & Bayar)
    // ----------------------------------------------------
    public function checkout($slug)
    {
        $boardingHouse = BoardingHouse::where('slug', $slug)->firstOrFail();
        $bookingData = session()->get('booking_data');

        // --- PENGAMAN (VALIDASI DATA) ---
        // Jika data booking hilang, kembalikan ke cek tanggal
        if (!$bookingData) {
            return redirect()->route('booking.check', $slug);
        }

        // Jika data nama/email belum diisi, kembalikan ke input data diri
        if (!isset($bookingData['name']) || !isset($bookingData['email'])) {
            return redirect()->route('booking.information', $slug);
        }
        // -------------------------------

        return view('pages.booking.checkout', compact('boardingHouse', 'bookingData'));
    }
    
    public function checkout_store(Request $request, $slug)
    {
        // Proses simpan transaksi / Midtrans disini
        return redirect()->route('payment.success');
    }

    public function payment_success()
    {
        return view('pages.booking.success');
    }
}
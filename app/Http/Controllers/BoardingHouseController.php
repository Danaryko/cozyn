<?php

namespace App\Http\Controllers;

use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\CityRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\BoardingHouse;
use Illuminate\Support\Facades\Auth; // <-- PENTING: Tambahkan ini agar Auth dikenal

class BoardingHouseController extends Controller
{
    private CityRepositoryInterface $cityRepository;
    private CategoryRepositoryInterface $categoryRepository;
    private BoardingHouseRepositoryInterface $boardingHouseRepository;

    public function __construct(
        CityRepositoryInterface $cityRepository,
        CategoryRepositoryInterface $categoryRepository,
        BoardingHouseRepositoryInterface $boardingHouseRepository
    ) {
        $this->cityRepository = $cityRepository;
        $this->categoryRepository = $categoryRepository;
        $this->boardingHouseRepository = $boardingHouseRepository;
    }

    public function show($slug)
    {
        // KITA PAKAI CARA LANGSUNG AGAR DATA OWNER & FASILITAS TERAMBIL
        $boardingHouse = BoardingHouse::where('slug', $slug)
            ->with(['city', 'category', 'testimonials', 'user']) // Tambahkan 'user' untuk ambil nama owner
            ->firstOrFail();

        return view('pages.boarding-house.show', compact('boardingHouse'));
    }

    public function rooms($slug)
    {
        $boardingHouse = $this->boardingHouseRepository->getBoardingHouseBySlug($slug);

        return view('pages.boarding-house.rooms', compact('boardingHouse'));
    }

    public function find()
    {
        $cities = $this->cityRepository->getAllCities();
        $categories = $this->categoryRepository->getAllCategories();

        return view('pages.boarding-house.find', compact('cities', 'categories'));
    }

    public function findResults(Request $request)
    {
        $categories = $this->categoryRepository->getAllCategories();
        $cities = $this->cityRepository->getAllCities();
        $boardingHouses = $this->boardingHouseRepository->getAllBoardingHouses(
            $request->get('search'),
            $request->get('category'),
            $request->get('city')
        );

        return view('pages.boarding-house.index', compact('boardingHouses'));
    }

    // --- FUNGSI TAMBAHAN UNTUK FAVORIT (WISHLIST) ---
    public function toggleWishlist($slug)
    {
        // 1. Cari dulu kost berdasarkan slug (menggunakan repository yang sudah ada)
        $boardingHouse = $this->boardingHouseRepository->getBoardingHouseBySlug($slug);

        // 2. Cek apakah user sudah pernah like kost ini sebelumnya?
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('boarding_house_id', $boardingHouse->id)
            ->first();

        // 3. Logika Toggle (Kalau sudah ada -> hapus. Kalau belum ada -> buat baru)
        if ($wishlist) {
            $wishlist->delete(); 
            $message = 'Dihapus dari favorit.';
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'boarding_house_id' => $boardingHouse->id
            ]);
            $message = 'Ditambahkan ke favorit!';
        }

        // 4. Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', $message);
    }
}
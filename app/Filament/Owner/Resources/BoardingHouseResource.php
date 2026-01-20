<?php

namespace App\Filament\Owner\Resources;

use App\Filament\Resources\BoardingHouseResource\Pages;
use App\Models\BoardingHouse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

// Import komponen desain tambahan
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Set;

class BoardingHouseResource extends Resource
{
    protected static ?string $model = BoardingHouse::class;

    // Ganti ikon menu di sidebar (pilih icon lain jika mau)
    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    
    // Ganti label di sidebar
    protected static ?string $navigationLabel = 'Kelola Kost';
    
    // Grouping menu (Opsional)
    protected static ?string $navigationGroup = 'Properti Saya';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // BAGIAN 1: Informasi Utama (Kiri)
                Section::make('Informasi Utama')
                    ->description('Masukkan detail dasar kost kamu di sini.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Kost')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Wisma Cozyn Indah')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                        TextInput::make('slug')
                            ->disabled() // Biar gak bisa diubah manual
                            ->dehydrated() // Tetap dikirim ke database
                            ->required()
                            ->helperText('Link unik akan terbuat otomatis dari nama kost.'),

                        // Grid untuk membagi Kota & Kategori bersebelahan
                        Grid::make(2)
                            ->schema([
                                Select::make('city_id')
                                    ->label('Kota')
                                    ->relationship('city', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Select::make('category_id')
                                    ->label('Kategori')
                                    ->relationship('category', 'name')
                                    ->required(),
                            ]),
                            
                        TextInput::make('price')
                            ->label('Harga per Bulan')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),
                    ])->columnSpan(2), // Mengambil 2 kolom lebar

                // BAGIAN 2: Media & Alamat (Kanan)
                Section::make('Media & Lokasi')
                    ->schema([
                        FileUpload::make('thumbnail')
                            ->label('Foto Depan')
                            ->image()
                            ->directory('boarding_houses')
                            ->required()
                            ->columnSpanFull(),

                        Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->rows(3)
                            ->required(),
                            
                        // Menggunakan RichEditor agar deskripsi bisa Bold/Italic
                        RichEditor::make('description')
                            ->label('Deskripsi Fasilitas')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'bulletList',
                            ])
                            ->required(),
                    ])->columnSpan(1), // Mengambil 1 kolom lebar
            ])->columns(3); // Total layout dibagi 3 kolom (2 untuk Info, 1 untuk Media)
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Gambar Bulat
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->circular()
                    ->label('Foto'),

                // Nama Kost (Bold)
                Tables\Columns\TextColumn::make('name')
                    ->weight('bold')
                    ->searchable(),

                // Kota (Pakai Badge biar keren)
                Tables\Columns\TextColumn::make('city.name')
                    ->badge()
                    ->color('info') // Warna biru
                    ->sortable(),
                
                // Kategori
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),

                // Harga (Format Rupiah)
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable()
                    ->color('success'), // Warna hijau
            ])
            ->filters([
                // Filter berdasarkan Kota
                Tables\Filters\SelectFilter::make('city_id')
                    ->label('Filter Kota')
                    ->relationship('city', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        // Tetap batasi agar Owner hanya melihat punya sendiri
        $query = parent::getEloquentQuery();
        if (auth()->user()->role === 'owner') {
            return $query->where('user_id', auth()->id());
        }
        return $query;
    }
    
    // Menambahkan Badge Angka di Menu Sidebar
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('user_id', auth()->id())->count();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBoardingHouses::route('/'),
            'create' => Pages\CreateBoardingHouse::route('/create'),
            'edit' => Pages\EditBoardingHouse::route('/{record}/edit'),
        ];
    }
}
<?php

namespace App\Filament\Resources;

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
use Filament\Forms\Components\Group; // Import Group
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput; // Import TagsInput
use Filament\Forms\Set;

class BoardingHouseResource extends Resource
{
    protected static ?string $model = BoardingHouse::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationLabel = 'Kelola Kost';
    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // --- KOLOM KIRI (Informasi Utama & Fasilitas) ---
                Group::make()
                    ->schema([
                        // BAGIAN 1: Informasi Utama
                        Section::make('Informasi Utama')
                            ->description('Informasi dasar mengenai kost Anda.')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Kost')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Contoh: Wisma Cozyn Indah')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                TextInput::make('slug')
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->helperText('Link unik akan terbuat otomatis.'),

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
                            ]),

                        // BAGIAN 2: Spesifikasi & Fasilitas (BARU DITAMBAHKAN)
                        Section::make('Spesifikasi & Fasilitas')
                            ->description('Detail fasilitas kamar dan peraturan kost.')
                            ->schema([
                                TextInput::make('room_size')
                                    ->label('Ukuran Kamar')
                                    ->placeholder('Contoh: 3x4 Meter')
                                    ->required(),

                                TagsInput::make('room_facilities')
                                    ->label('Fasilitas Kamar')
                                    ->placeholder('Ketik fasilitas lalu tekan Enter (Cth: AC, Kasur, Meja)')
                                    ->separator(',')
                                    ->splitKeys(['Tab', ',']),

                                TagsInput::make('bathroom_facilities')
                                    ->label('Fasilitas Kamar Mandi')
                                    ->placeholder('Ketik fasilitas lalu tekan Enter (Cth: Water Heater, Shower)')
                                    ->separator(',')
                                    ->splitKeys(['Tab', ',']),

                                TagsInput::make('general_facilities')
                                    ->label('Fasilitas Umum')
                                    ->placeholder('Cth: Dapur, WiFi, CCTV, Penjaga, Laundry')
                                    ->separator(',')
                                    ->splitKeys(['Tab', ',']),

                                TagsInput::make('parking_facilities')
                                    ->label('Fasilitas Parkir')
                                    ->placeholder('Cth: Motor, Mobil, Sepeda, Garasi')
                                    ->separator(',')
                                    ->splitKeys(['Tab', ',']),
                                    
                                TagsInput::make('rules')
                                    ->label('Peraturan Kost')
                                    ->placeholder('Ketik peraturan lalu tekan Enter (Cth: Dilarang Merokok)')
                                    ->separator(',')
                                    ->splitKeys(['Tab', ',']),
                            ]),
                    ])
                    ->columnSpan(2), // Grup kiri mengambil 2 kolom lebar

                // --- KOLOM KANAN (Media & Lokasi) ---
                Group::make()
                    ->schema([
                        Section::make('Media & Lokasi')
                            ->schema([
                                FileUpload::make('thumbnail')
                                    ->label('Foto Depan')
                                    ->image()
                                    ->directory('boarding_houses')
                                    ->required(),

                                Textarea::make('address')
                                    ->label('Alamat Lengkap')
                                    ->rows(3)
                                    ->required(),
                                    
                                RichEditor::make('description')
                                    ->label('Deskripsi Lengkap')
                                    ->toolbarButtons(['bold', 'italic', 'bulletList'])
                                    ->required(),
                            ])
                    ])
                    ->columnSpan(1), // Grup kanan mengambil 1 kolom lebar

            ])
            ->columns(3); // Total layout dibagi 3 kolom
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Gambar Bulat
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Foto')
                    ->circular()
                    ->stacked(),

                // 2. Nama & Kota (Digabung biar rapi)
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kost')
                    ->description(fn (BoardingHouse $record): string => $record->city->name ?? '-')
                    ->searchable()
                    ->weight('bold'),

                // 3. Harga dengan format Uang
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable()
                    ->color('primary'), // Warna orange

                // 4. Kategori sebagai Badge
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Kost Putra' => 'info',
                        'Kost Putri' => 'danger',
                        'Kost Campur' => 'success',
                        default => 'gray',
                    }),
                    
                // 5. Tanggal Dibuat
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Terdaftar Sejak')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
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
        $query = parent::getEloquentQuery();
        if (auth()->user()->role === 'owner') {
            return $query->where('user_id', auth()->id());
        }
        return $query;
    }
    
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
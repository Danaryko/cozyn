<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users'; // Icon User Group
    protected static ?string $navigationLabel = 'Data Pengguna';
    protected static ?string $navigationGroup = 'User Management'; // Masuk Grup Baru
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                // Select Role agar Admin bisa ubah role user
                Forms\Components\Select::make('role')
                    ->options([
                        'admin' => 'Super Admin',
                        'owner' => 'Owner (Pemilik Kost)',
                        'user'  => 'User (Pencari Kost)',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('password')
                    ->password()
                    // Hanya required saat create baru, saat edit boleh kosong
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
                    
                Forms\Components\FileUpload::make('avatar')
                    ->avatar()
                    ->directory('avatars'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Avatar Bulat
                Tables\Columns\ImageColumn::make('avatar')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png')), // Opsional

                // 2. Nama & Email
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn (User $record): string => $record->email),

                // 3. Role dengan Badge Warna-Warni
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',   // Merah
                        'owner' => 'warning',  // Kuning/Orange
                        'user'  => 'success',  // Hijau
                        default => 'gray',
                    })
                    ->sortable(),

                // 4. Tanggal Bergabung
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Bergabung Sejak')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                // Filter biar Admin bisa cari "Cuma Owner" atau "Cuma User"
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'owner' => 'Owner',
                        'user' => 'User Biasa',
                    ]),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
<?php

namespace App\Filament\Resources\BoardingHouseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class RoomsRelationManager extends RelationManager
{
    protected static string $relationship = 'rooms';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Kamar'),

                Forms\Components\TextInput::make('room_type')
                    ->required()
                    ->maxLength(255)
                    ->label('Tipe Kamar'),

                // 🔥 INI PENTING: Pakai numeric() biar gak error '3x4' lagi
                Forms\Components\TextInput::make('square_feet')
                    ->numeric()
                    ->required()
                    ->label('Luas Kamar (m²)'),

                Forms\Components\TextInput::make('capacity')
                    ->numeric()
                    ->required()
                    ->label('Kapasitas Orang'),

                Forms\Components\TextInput::make('price_per_month')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->label('Harga per Bulan'),

                Forms\Components\Toggle::make('is_available')
                    ->required()
                    ->label('Tersedia?'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama'),
                Tables\Columns\TextColumn::make('room_type')->label('Tipe'),
                Tables\Columns\TextColumn::make('price_per_month')->money('IDR')->label('Harga'),
                Tables\Columns\IconColumn::make('is_available')->boolean()->label('Ready?'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(), // Tombol "New Room"
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
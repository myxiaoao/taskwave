<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('Client'))
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->prefixIcon('heroicon-o-phone')
                    ->label(__('Phone')),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->prefixIcon('heroicon-o-at-symbol')
                    ->label(__('Email')),

                Forms\Components\TextInput::make('website')
                    ->label(__('Website'))
                    ->prefix('https://')
                    ->maxLength(255),

                Forms\Components\TextInput::make('address')
                    ->label(__('Address'))
                    ->maxLength(255),

                Forms\Components\TextInput::make('city')
                    ->label(__('City'))
                    ->maxLength(255),

                Forms\Components\TextInput::make('zip_code')
                    ->label(__('ZIP'))
                    ->maxLength(255),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('full_address')
                    ->label(__('Address')),

                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email')),

                Tables\Columns\TextColumn::make('phone')
                    ->label(__('Phone')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListClients::route('/'),
            //'create' => Pages\CreateClient::route('/create'),
            //'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}

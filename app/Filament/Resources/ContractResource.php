<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContractResource\Pages;
use App\Filament\Resources\ContractResource\RelationManagers;
use App\Filament\Resources\ContractResource\Widgets\ContractsByType;
use App\Filament\Resources\ContractResource\Widgets\ContractStats;
use App\Models\Contract;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('client_id')
                    ->label(__('Client'))
                    ->required()
                    ->prefixIcon('heroicon-o-user')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('subject')
                    ->label(__('Subject'))
                    ->columnSpanFull()
                    ->required(),

                Forms\Components\TextInput::make('contract_value')
                    ->label(__('Contract Value'))
                    ->numeric()
                    ->suffixIcon('heroicon-o-currency-euro')
                    ->columnSpanFull(),

                Forms\Components\Select::make('type_id')
                    ->label(__('Type'))
                    ->prefixIcon('heroicon-o-folder')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Split::make([
                    Forms\Components\DatePicker::make('start_date')
                        ->required()
                        ->label(__('Start Date'))
                        ->default(now()),

                    Forms\Components\DatePicker::make('end_date')
                        ->label(__('End Date')),
                ])->columnSpanFull(),

                Forms\Components\RichEditor::make('description')
                    ->label(__('Description'))
                    ->columnSpanFull(),
            ]);
    }

    public static function getWidgets(): array
    {
        return [
            ContractStats::class, ContractsByType::class
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListContracts::route('/'),
            //'create' => Pages\CreateContract::route('/create'),
            //'edit' => Pages\EditContract::route('/{record}/edit'),
        ];
    }
}
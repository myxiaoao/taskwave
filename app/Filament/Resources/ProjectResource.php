<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use App\ProjectStatus;
use Filament\Forms;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieTagsColumn;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-command-line';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Naziv')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('client_id')
                    ->label(__('Client'))
                    ->required()
                    ->options(Client::get()->pluck('name', 'id')),

                Forms\Components\Select::make('users')
                    ->required()
                    ->preload()
                    ->relationship('users')
                    ->options(User::get()->pluck('full_name', 'id'))
                    ->multiple()
                    ->label(__('Users')),

                Forms\Components\Split::make([
                    Forms\Components\DatePicker::make('start_at')
                        ->required()
                        ->label(__('Start At')),

                    Forms\Components\DatePicker::make('deadline_at')
                        ->label(__('Deadline At')),

                ]),

                SpatieTagsInput::make('tags')
                    ->label(__('Tags'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('client.name')
                    ->sortable()
                    ->label(__('Client')),

                Tables\Columns\TextColumn::make('users.first_name')
                    ->limitList(2)
                    ->label(__('Users')),

                SpatieTagsColumn::make('tags')
                    ->color('gray')
                    ->label(__('Tags')),

                Tables\Columns\TextColumn::make('deadline_at')
                    ->label(__('Deadline At'))
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status_id')
                    ->formatStateUsing(function ($state) {
                        return ProjectStatus::from($state)->getLabel();
                    })
                    ->badge()
                    ->color('primary')
                    ->label(__('Status')),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListProjects::route('/'),
            //'create' => Pages\CreateProject::route('/create'),
            //'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
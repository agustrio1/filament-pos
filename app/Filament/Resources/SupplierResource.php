<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Filament\Resources\SupplierResource\RelationManagers;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;
    protected static ?string $label = 'Supplier';
    protected static ?string $navigationGroup = 'Inventory Management';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('company_name')->minLength(4)->maxLength(255)->required(),
                Forms\Components\TextInput::make('name_sales')->minLength(4)->maxLength(255)->required(),
                Forms\Components\TextInput::make('contact_name')->minLength(4)->maxLength(255)->required(),
                Forms\Components\TextInput::make('contact_email')->minLength(4)->maxLength(255)->required(),
                Forms\Components\TextInput::make('contact_phone')->minLength(4)->maxLength(255)->required(),
                Forms\Components\TextInput::make('address')->minLength(4)->maxLength(255)->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_name')->label('nama perusahaan')->searchable(),
                Tables\Columns\TextColumn::make('name_sales')->label('nama sales')->searchable(),
                Tables\Columns\TextColumn::make('contact_name')->label('kontak')->searchable(),
                Tables\Columns\TextColumn::make('contact_email')->label('email')->searchable(),
                Tables\Columns\TextColumn::make('contact_phone')->label('telepon')->searchable(),
                Tables\Columns\TextColumn::make('address')->label('alamat')->searchable(),     
            ])
            ->filters([
               //
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
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}

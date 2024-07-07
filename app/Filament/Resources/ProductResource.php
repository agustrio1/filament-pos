<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $label = 'Produk';
    protected static ?string $navigationGroup = 'Inventory Management';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->minLength(4)->maxLength(255)->required(),
                Forms\Components\TextInput::make('slug')->disabled(),
                Forms\Components\TextInput::make('code_qr')->minLength(4)->maxLength(255)->required(),
                Forms\Components\TextInput::make('description')->minLength(4)->maxLength(255)->required(),
                Forms\Components\TextInput::make('price')->minLength(4)->maxLength(255)->required(),
                Forms\Components\TextInput::make('stock')->maxLength(255)->required(),
                Forms\Components\FileUpload::make('image')
                    ->nullable()
                    ->image()
                    ->preserveFilenames()
                    ->imageEditor()
                    ->imagePreviewHeight('250')
                    ->loadingIndicatorPosition('left')
                    ->panelAspectRatio('2:1')
                    ->panelLayout('integrated')
                    ->removeUploadedFileButtonPosition('right')
                    ->uploadButtonPosition('left')
                    ->uploadProgressIndicatorPosition('left'),
                Forms\Components\Select::make('supplier_id')->relationship('supplier', 'company_name')->required(),
                Forms\Components\Select::make('category_id')->relationship('category', 'name')->required(),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')->label('nama')->searchable()->searchable(),
            Tables\Columns\TextColumn::make('slug')->label('slug')->searchable(),
            Tables\Columns\TextColumn::make('code_qr')->label('kode qr')->searchable(),
            Tables\Columns\TextColumn::make('description')->label('deskripsi')->searchable(),
            Tables\Columns\TextColumn::make('price')->label('harga')->searchable(),
            Tables\Columns\TextColumn::make('stock')->label('stok')->searchable(),
            Tables\Columns\ImageColumn::make('image')->square()->label('foto')->searchable(),
            Tables\Columns\TextColumn::make('supplier.company_name')->searchable(),
            Tables\Columns\TextColumn::make('category.name')->searchable()->label('kategori'),
            Tables\Columns\TextColumn::make('created_at')->label('tanggal')->searchable()->sortable()
                ->dateTime(),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] = (string) $data['name'];
        $data['slug'] = Str::slug($data['name']);
        return $this->handleImageUpload($data);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['name'] = (string) $data['name'];
        $data['slug'] = Str::slug($data['name']);
        return $this->handleImageUpload($data);
    }

    private function handleImageUpload(array $data): array
{
    if (isset($data['image']) && is_object($data['image'])) {
        $data['image'] = $data['image']->store('images', 'public');
    }
    return $data;
}

}

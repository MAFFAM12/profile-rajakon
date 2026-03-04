<?php

namespace App\Filament\Resources\Heroes;

use App\Models\Hero;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class HeroResource extends Resource
{
    protected static ?string $model = Hero::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Hero';

    public static function form(Schema $schema): Schema
    {
        return Schemas\HeroForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return Schemas\HeroTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return Schemas\HeroInfoList::configure($schema);
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
            'index' => Pages\ListHeros::route('/'),
            'create' => Pages\CreateHero::route('/create'),
            'view' => Pages\ViewHero::route('/{record}'),
            'edit' => Pages\EditHero::route('/{record}/edit'),
        ];
    }
}

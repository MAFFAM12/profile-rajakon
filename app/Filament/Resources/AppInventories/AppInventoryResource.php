<?php

namespace App\Filament\Resources\AppInventories;

use App\Filament\Exports\AppInventoryExporter;
use App\Models\AppInventory;
use BackedEnum;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Forms;
use Filament\Infolists;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class AppInventoryResource extends Resource
{
    protected static ?string $model = AppInventory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'app_name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('app_name')
                    ->label('Nama Aplikasi')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'normal' => 'Normal',
                        'error' => 'Error',
                        'backup' => 'Back Up'
                    ])
                    ->required()
                    ->native(false)
                    ->live(),

                Forms\Components\TextInput::make('link')
                    ->label('Link')
                    ->prefixIcon(Heroicon::Link)
                    ->required()
                    ->url()
                    ->maxLength(255),

                Forms\Components\TextInput::make('username')
                    ->label('Username / Email')
                    ->prefixIcon(Heroicon::User)
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->prefixIcon(Heroicon::Key)
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('host_instance')
                    ->label('Host Instance')
                    ->prefixIcon(Heroicon::Server)
                    ->maxLength(255),

                Forms\Components\Select::make('primary_id')
                    ->label('Primary App')
                    ->options(self::$model::orderBy('app_name', 'asc')->pluck('app_name', 'id'))
                    ->prefixIcon(Heroicon::GlobeAlt)
                    ->uuid()
                    ->native(false)
                    ->searchable()
                    ->visible(fn(Get $get): bool => $get('status') === 'backup'),

                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Infolists\Components\TextEntry::make('app_name')
                    ->label('Nama Aplikasi'),

                Infolists\Components\TextEntry::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'normal' => 'success',
                        'error' => 'danger',
                        'backup' => 'warning',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'normal' => 'Normal',
                        'error' => 'Error',
                        'backup' => 'Back Up',
                    }),

                Infolists\Components\TextEntry::make('link')
                    ->label('Link')
                    ->url(fn(Model $record): string => $record->link)
                    ->openUrlInNewTab(),

                Infolists\Components\TextEntry::make('username')
                    ->label('Username / Email')
                    ->copyable()
                    ->icon(Heroicon::DocumentDuplicate)
                    ->iconPosition(IconPosition::After)
                    ->tooltip('Copy'),

                Infolists\Components\TextEntry::make('password')
                    ->label('Password')
                    ->copyable()
                    ->icon(Heroicon::DocumentDuplicate)
                    ->iconPosition(IconPosition::After)
                    ->tooltip('Copy'),

                Infolists\Components\TextEntry::make('host_instance')
                    ->label('Host Instance'),

                Infolists\Components\TextEntry::make('primary.app_name')
                    ->label('Primary App')
                    ->visible(fn($record) => $record->status === 'backup'),

                Section::make('Related Backup Apps')
                    ->collapsible()
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('backups')
                            ->label('')
                            ->schema([
                                Infolists\Components\TextEntry::make('app_name')
                                    ->label('App Name'),
                                Infolists\Components\TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn(string $state): string => match ($state) {
                                        'normal' => 'success',
                                        'error' => 'danger',
                                        'backup' => 'warning',
                                    })
                                    ->formatStateUsing(fn(string $state): string => match ($state) {
                                        'normal' => 'Normal',
                                        'error' => 'Error',
                                        'backup' => 'Back Up',
                                    }),
                            ]),
                    ]),

                Infolists\Components\TextEntry::make('description')
                    ->label('Deskripsi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('app_name')
            ->columns([
                Tables\Columns\TextColumn::make('app_name')
                    ->searchable()
                    ->sortable()
                    ->description(fn(Model $record): string => $record->description ?? '-'),

                Tables\Columns\TextColumn::make('status')
                    ->sortable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'normal' => 'success',
                        'error' => 'danger',
                        'backup' => 'warning',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'normal' => 'Normal',
                        'error' => 'Error',
                        'backup' => 'Back Up',
                    }),

                Tables\Columns\TextColumn::make('link')
                    ->url(fn(Model $record): string => $record->link)
                    ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('username')
                    ->copyable()
                    ->icon(Heroicon::DocumentDuplicate)
                    ->iconPosition(IconPosition::After)
                    ->tooltip('Copy'),

                Tables\Columns\TextColumn::make('username')
                    ->copyable()
                    ->icon(Heroicon::DocumentDuplicate)
                    ->iconPosition(IconPosition::After)
                    ->tooltip('Copy'),

                Tables\Columns\TextColumn::make('password')
                    ->copyable()
                    ->copyableState(fn(Model $model): string => $model->password)
                    ->formatStateUsing(fn(): string => '******')
                    ->icon(Heroicon::DocumentDuplicate)
                    ->iconPosition(IconPosition::After)
                    ->tooltip('Copy'),

                Tables\Columns\TextColumn::make('host_instance')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'normal' => 'Normal',
                        'error' => 'Error',
                        'backup' => 'Back Up'
                    ])
                    ->native(false),

                Tables\Filters\SelectFilter::make('primary_id')
                    ->label('Primary App')
                    ->options(
                        AppInventory::where('status', 'normal')
                            ->orderBy('app_name', 'asc')
                            ->pluck('app_name', 'id')
                    )
                    ->native(false)
                    ->searchable(),
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Ekspor data')
                    ->exporter(AppInventoryExporter::class),
            ])
            ->recordActions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAppInventories::route('/'),
        ];
    }
}

<?php

namespace App\Filament\Resources\Blogs;

use App\Models\Blog;
use BackedEnum;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Infolists;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $navigationLabel = 'Blog';

    protected static ?string $modelLabel = 'Blog';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Informasi Blog')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->label('Judul')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, $set, $record) {
                                if (!$record) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('URL artikel. Contoh: tips-hemat-bbm'),

                        Forms\Components\TextInput::make('kategori')
                            ->label('Kategori')
                            ->nullable()
                            ->placeholder('Contoh: Tips, Berita, Tutorial'),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Tanggal Publish')
                            ->nullable(),

                        Forms\Components\Toggle::make('is_published')
                            ->label('Publikasikan')
                            ->default(false),

                        Forms\Components\TextInput::make('urutan')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Textarea::make('excerpt')
                            ->label('Ringkasan')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Ditampilkan di halaman list blog dan preview homepage'),
                    ])
                    ->columns(2),

                Section::make('Thumbnail')
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('Gambar Thumbnail')
                            ->image()
                            ->disk('public')
                            ->directory('blog')
                            ->columnSpanFull()
                            ->helperText('Gambar utama artikel yang ditampilkan di card'),
                    ]),

                Section::make('Konten Artikel')
                    ->schema([
                        Forms\Components\RichEditor::make('konten')
                            ->label('')
                            ->columnSpanFull()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('blog/attachments'),
                    ]),
            ]);
    }
    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Infolists\Components\Section::make('Informasi Artikel')
                    ->schema([
                        Infolists\Components\TextEntry::make('judul')
                            ->label('Judul Artikel')
                            ->columnSpanFull()
                            ->size(\Filament\Support\Enums\FontSize::Large)
                            ->weight(\Filament\Support\Enums\FontWeight::Bold),
                        Infolists\Components\TextEntry::make('slug')
                            ->label('Slug URL')
                            ->copyable()
                            ->copyMessage('Slug berhasil disalin')
                            ->copyMessageDuration(1500),
                        Infolists\Components\TextEntry::make('kategori')
                            ->label('Kategori')
                            ->badge()
                            ->color('primary')
                            ->placeholder('Tidak ada kategori'),
                        Infolists\Components\IconEntry::make('is_published')
                            ->label('Status Publikasi')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-clock')
                            ->trueColor('success')
                            ->falseColor('warning'),
                        Infolists\Components\TextEntry::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-m-calendar-days')
                            ->placeholder('Belum dipublikasikan'),
                        Infolists\Components\TextEntry::make('urutan')
                            ->label('Urutan Tampil')
                            ->icon('heroicon-m-bars-3'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Ringkasan & Konten')
                    ->schema([
                        Infolists\Components\TextEntry::make('excerpt')
                            ->label('Ringkasan Artikel')
                            ->columnSpanFull()
                            ->formatStateUsing(fn (string $state): string => nl2br(e($state)))
                            ->html(),
                        Infolists\Components\TextEntry::make('konten')
                            ->label('Konten Lengkap')
                            ->columnSpanFull()
                            ->formatStateUsing(fn (string $state): string => $state)
                            ->html()
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('Media')
                    ->schema([
                        ImageEntry::make('thumbnail')
                            ->label('Thumbnail Artikel')
                            ->disk('public')
                            ->width(300)
                            ->height(200),
                    ])
                    ->collapsible(),

                Infolists\Components\Section::make('Informasi Sistem')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Tanggal Dibuat')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-m-calendar-days'),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Terakhir Diubah')
                            ->dateTime('d F Y, H:i')
                            ->icon('heroicon-m-clock'),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->rowIndex(),

                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->width(80)
                    ->height(60),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Publish')
                    ->boolean(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Status Publish'),
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
            ])
            ->defaultSort('published_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'view'   => Pages\ViewBlog::route('/{record}'),
            'edit'   => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
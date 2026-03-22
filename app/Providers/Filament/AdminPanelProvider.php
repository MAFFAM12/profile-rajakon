<?php

namespace App\Providers\Filament;

use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Filament\Support\Enums\Width;
use App\Filament\Resources\Heroes\HeroResource;
use App\Filament\Resources\Kontaks\KontakResource;
use App\Filament\Resources\Galleries\GalleryResource;
use App\Filament\Resources\Partners\PartnerResource;
use App\Filament\Resources\Produks\ProdukResource;
use App\Filament\Resources\Blogs\BlogResource;
use App\Filament\Resources\WebsiteSettings\WebsiteSettingResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->maxContentWidth(Width::Full)
            ->sidebarCollapsibleOnDesktop()
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->items([
                    NavigationItem::make('Dashboard')
                        ->icon('heroicon-o-home')
                        ->isActiveWhen(fn(): bool => request()->routeIs('filament.admin.pages.dashboard'))
                        ->url(fn(): string => Dashboard::getUrl()),
                    ...KontakResource::getNavigationItems(),
                ])
                    ->groups([
                        NavigationGroup::make('Manage Content')
                            ->items([
                                ...HeroResource::getNavigationItems(),
                                ...GalleryResource::getNavigationItems(),
                                ...PartnerResource::getNavigationItems(),
                                ...ProdukResource::getNavigationItems(),
                                ...BlogResource::getNavigationItems(),
                            ]),
                        NavigationGroup::make('Pengaturan')
                            ->items([
                                ...WebsiteSettingResource::getNavigationItems(),
                            ]),
                    ]);
            })
            ->databaseNotifications();
    }
}
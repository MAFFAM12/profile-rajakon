<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Models\Permission;

class RegisterResourceRoutesToPermission extends Command
{
    protected $signature = 'permission:register-resource-routes';
    protected $description = 'Mendaftarkan semua route resource ke tabel permission';

    public function handle()
    {
        $routes = Route::getRoutes();
        $count = 0;
        // Kumpulkan semua http_path resource yang masih ada di route
        $existingPaths = collect();
        foreach ($routes as $route) {
            $action = $route->getActionName();
            if (Str::contains($action, 'Resource')) {
                $httpPath = '/' . ltrim($route->uri(), '/');
                $existingPaths->push($httpPath);
                $resource = Str::of($httpPath)
                    ->after('/admin/')
                    ->before('/')
                    ->replace('-', ' ')
                    ->replace('_', ' ')
                    ->title()
                    ->value();

                $permName = $resource;
                $description = "Mengelola data " . Str::lower($resource);

                if (Str::endsWith($route->getName(), '.edit')) {
                    $permName = "Ubah $resource";
                    $description = "Mengubah data " . Str::lower($resource);
                } elseif (Str::endsWith($route->getName(), '.create')) {
                    $permName = "Buat $resource";
                    $description = "Membuat data " . Str::lower($resource) . " baru";
                }

                // Cek apakah permission dengan nama dan http_path sudah ada
                if (!Permission::where('name', $permName)->where('http_path', $httpPath)->exists()) {
                    Permission::create([
                        'name' => $permName,
                        'guard_name' => 'web',
                        'http_path' => $httpPath,
                        'description' => $description,
                    ]);
                    $count++;
                }
            }
        }

        $existingPaths->push('/admin'); // Tambahkan admin path jika belum ada
        // Hapus permission yang http_path-nya tidak ada di $existingPaths
        $deleted = Permission::whereNotIn('http_path', $existingPaths)->delete();
        $this->info("{$count} resource route(s) registered to permissions table. {$deleted} permission(s) deleted.");
    }
}

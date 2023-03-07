<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class ResourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $routes = Route::getRoutes()->getRoutes();
        foreach ($routes as $route) {
            $routeName = $route->getName();
            if (empty($routeName)) {
                continue;
            }

            $checkName = Resource::where('resource', $routeName)->first();
            if ($checkName) {
                continue;
            }

            Resource::create([
                'name' => ucwords(Str::replace('.', ' ', $routeName)),
                'resource' => $routeName,
                'is_menu' => false
            ]);
        }
    }
}

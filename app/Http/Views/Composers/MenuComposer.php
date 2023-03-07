<?php

namespace App\Http\Views\Composers;

use Illuminate\View\View;
use function auth;

class MenuComposer
{
    /**
     * Undocumented function
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view): void
    {
        $user = auth()->user();
        $modulesFiltered = session()->get('modules', null);

        if (empty($modulesFiltered) && !empty($user->role_id)) {
            $roleUser = $user->role;
            $modules = $roleUser->modules()->with('resources')->get();
            foreach ($modules as $key => $module) {
                $modulesFiltered[$key]['name'] = $module->name;
                foreach ($module->resources as $resource) {
                    if ($resource->roles->contains($roleUser)) {
                        $modulesFiltered[$key]['resources'][] = $resource;
                    }
                }
            }

            session()->put('modules', $modulesFiltered);
        }

        $view->with('modules', $modulesFiltered);
    }
}
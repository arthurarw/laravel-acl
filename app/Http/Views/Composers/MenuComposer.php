<?php

namespace App\Http\Views\Composers;

use App\Models\Module;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use function auth;

/**
 *
 */
class MenuComposer
{
    /**
     * @param Module $module
     */
    public function __construct(private Module $module)
    {
    }

    /**
     * Undocumented function
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view): void
    {
        $user = auth()->user();
        $modulesFiltered = session()->get('modules', []);

        if (empty($modulesFiltered) && !empty($user->role_id)) {
            if ($user->isAdmin()) {
                $modulesFiltered = ($this->getModules($this->module))->toArray();
            } else {
                $roleUser = $user->role;
                $modules = $this->getModules($roleUser->modules());
                foreach ($modules as $key => $module) {
                    $modulesFiltered[$key]['name'] = $module->name;
                    foreach ($module->resources as $k => $resource) {
                        if ($resource->roles->contains($roleUser)) {
                            $modulesFiltered[$key]['resources'][$k] = [
                                'name' => $resource->name,
                                'resource' => $resource->resource
                            ];
                        }
                    }
                }
            }

            session()->put('modules', $modulesFiltered);
        }

        $view->with('modules', $modulesFiltered);
    }

    /**
     * @param Module $modules
     * @return Builder[]|Collection
     */
    private function getModules(Module $modules): Collection|array
    {
        return $modules->with(['resources' => function ($query) {
            return $query->where('is_menu', 1);
        }])->get();
    }
}

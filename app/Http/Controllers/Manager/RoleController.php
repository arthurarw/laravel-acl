<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\RoleRequest;
use App\Models\Resource;
use App\Models\Role;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 *
 */
class RoleController extends Controller
{
    /**
     * @param Role $role
     */
    public function __construct(private Role $role)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        $roles = $this->role->paginate(10);

        return view('manager.roles.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Foundation\Application|View
     */
    public function create(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('manager.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return RedirectResponse
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        try {
            $this->role->create($request->validated());

            flash('Papél criado com sucesso!')->success();
            return redirect()->route('roles.index');
        } catch (\Exception $e) {
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar criação...';

            flash($message)->error();
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return RedirectResponse
     */
    public function show(Role $role): RedirectResponse
    {
        return redirect()->route('roles.edit', $role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return Application|Factory|\Illuminate\Foundation\Application|View
     */
    public function edit(Role $role): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('manager.roles.edit', [
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        try {
            $role->update($request->validated());

            flash('Papél atualizado com sucesso!')->success();
            return redirect()->route('roles.index');
        } catch (\Exception $e) {
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar atualização...';

            flash($message)->error();
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return RedirectResponse
     */
    public function destroy(Role $role): RedirectResponse
    {
        try {
            $role->delete();

            flash('Papél removido com sucesso!')->success();
            return redirect()->route('roles.index');
        } catch (\Exception $e) {
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar remoção...';

            flash($message)->error();
            return redirect()->back();
        }
    }

    /**
     * @param Role $role
     *
     * @return Factory|\Illuminate\View\View
     */
    public function syncResources(Role $role): Factory|\Illuminate\View\View
    {
        $resources = Resource::all(['id', 'resource']);

        return view('manager.roles.sync-resources', [
            'role' => $role,
            'resources' => $resources
        ]);
    }

    /**
     * @param Role $role
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateSyncResources(Role $role, Request $request): RedirectResponse
    {
        try {
            $role->resources()->sync($request->resources);

            flash('Recursos adicionados com sucesso!')->success();
            return redirect()->route('roles.resources', $role);
        } catch (\Exception $e) {
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar adição de recursos...';

            flash($message)->error();
            return redirect()->back();
        }
    }
}

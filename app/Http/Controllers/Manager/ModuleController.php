<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\ModuleRequest;
use App\Models\Module;
use App\Models\Resource;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 *
 */
class ModuleController extends Controller
{
    /**
     * @param Module $module
     */
    public function __construct(private Module $module)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $modules = $this->module->with(['roles', 'resources'])->paginate(10);

        return view('manager.modules.index', [
            'modules' => $modules
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Foundation\Application|View
     */
    public function create(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('manager.modules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ModuleRequest $request
     *
     * @return RedirectResponse
     */
    public function store(ModuleRequest $request): RedirectResponse
    {
        try {
            $this->module->create($request->all());

            flash('Módulo criado com sucesso!')->success();
            return redirect()->route('modules.index');
        } catch (Exception $e) {
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar atualização...';

            flash($message)->error();
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Module $module
     * @return RedirectResponse
     */
    public function show(Module $module): RedirectResponse
    {
        return redirect()->route('modules.edit', $module);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Module $module
     * @return Application|Factory|\Illuminate\Foundation\Application|View
     */
    public function edit(Module $module): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('manager.modules.edit', [
            'module' => $module
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ModuleRequest $request
     * @param Module $module
     * @return RedirectResponse
     */
    public function update(ModuleRequest $request, Module $module): RedirectResponse
    {
        try {
            $module->update($request->all());

            flash('Módulo atualizado com sucesso!')->success();
            return redirect()->route('modules.index');
        } catch (Exception $e) {
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar atualização...';

            flash($message)->error();
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Module $module
     * @return RedirectResponse
     */
    public function destroy(Module $module)
    {
        try {
            $module->delete();

            flash('Módulo removido com sucesso!')->success();
            return redirect()->route('modules.index');
        } catch (Exception $e) {
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar remoção...';

            flash($message)->error();
            return redirect()->back();
        }
    }

    /**
     * @param Module $module
     * @param Resource $resource
     * @return Factory|\Illuminate\Foundation\Application|View|Application
     */
    public function syncResources(Module $module, Resource $resource): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $resources = $resource->with(['roles', 'module'])->whereNull('module_id')
            ->where('is_menu', true)
            ->get();

        return view('manager.modules.sync-resources', [
            'module' => $module,
            'resources' => $resources
        ]);
    }

    /**
     * @param Module $module
     * @param Request $request
     * @param Resource $resource
     * @return RedirectResponse
     */
    public function updateSyncResources(Module $module, Request $request, Resource $resource): RedirectResponse
    {
        try {
            foreach ($request->resources as $r) {
                $resourceModel = $resource->find($r);
                $resourceModel->module()->associate($module);
                $resourceModel->save();
            }

            flash('Recursos adicionados para o módulo!')->success();
            return redirect()->back();
        } catch (Exception $e) {
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar adição de recursos para o módulo...';

            flash($message)->error();
            return redirect()->back();
        }
    }
}

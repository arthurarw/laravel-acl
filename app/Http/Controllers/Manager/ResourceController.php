<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\ResourceRequest;
use App\Models\Resource;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

class ResourceController extends Controller
{
    public function __construct(private Resource $resource)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        $resources = $this->resource->paginate(10);

        return view('manager.resources.index', [
            'resources' => $resources
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Foundation\Application|View
     */
    public function create(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $routes = Route::getRoutes()->getRoutesByName();

        return view('manager.resources.create', [
            'routes' => $routes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ResourceRequest $request
     *
     * @return RedirectResponse
     */
    public function store(ResourceRequest $request): RedirectResponse
    {
        try {
            $this->resource->create($request->validated());

            flash('Recurso atualizado com sucesso!')->success();
            return redirect()->route('resources.index');
        } catch (\Exception $e) {
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar atualização...';

            flash($message)->error();
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Resource $resource
     * @return RedirectResponse
     */
    public function show(Resource $resource): RedirectResponse
    {
        return redirect()->route('resources.edit', $resource);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Resource $resource
     * @return Application|Factory|\Illuminate\Foundation\Application|View
     */
    public function edit(Resource $resource): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('manager.resources.edit', [
            'resource' => $resource
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ResourceRequest $request
     * @param Resource $resource
     * @return RedirectResponse
     */
    public function update(ResourceRequest $request, Resource $resource): RedirectResponse
    {
        try {
            $resource->update($request->validated());

            flash('Recurso atualizado com sucesso!')->success();
            return redirect()->route('resources.index');
        } catch (\Exception $e) {
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar atualização...';

            flash($message)->error();
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Resource $resource
     * @return RedirectResponse
     */
    public function destroy(Resource $resource): RedirectResponse
    {
        try {
            $resource->delete();

            flash('Recurso removido com sucesso!')->success();
            return redirect()->route('resources.index');
        } catch (\Exception $e) {
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar remoção...';

            flash($message)->error();
            return redirect()->back();
        }
    }
}

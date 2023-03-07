<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function __construct(private User $user)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        $users = $this->user->with('role')->paginate(10);

        return view('manager.users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Application|Factory|\Illuminate\Foundation\Application|View
     */
    public function edit(User $user): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $roles = Role::all('id', 'name');

        return view('manager.users.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        try {
            $data = $request->validated();

            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }

            $user->update($data);

            if (!empty($data['role'])) {
                $role = Role::find($data['role']);
                $user = $user->role()->associate($role);
            }

            $user->save();

            flash('Usuário atualizado com sucesso!')->success();
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            dd($e);
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar atualização...';

            flash($message)->error();
            return redirect()->back();
        }
    }
}

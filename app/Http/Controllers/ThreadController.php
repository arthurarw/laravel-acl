<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ThreadController extends Controller
{
    public function __construct(private Thread $thread)
    {
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $threads = $this->thread->orderByDesc('created_at')->paginate(5);

        return view('threads.index', [
            'threads' => $threads
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $data['slug'] = Str::slug($data['title']);

            $user = User::find(1);

            $user->threads()->create($data);

            dd('Tópico criado com sucesso.');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $thread)
    {
        $thread = $this->thread->with(['user', 'replies'])->whereSlug($thread)->firstOrFail();

        return view('threads.show', [
            'thread' => $thread
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $thread)
    {
        $thread = $this->thread->whereSlug($thread)->firstOrFail();

        return view('threads.edit', [
            'thread' => $thread
        ]);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param string $thread
     * @return void
     */
    public function update(Request $request, string $thread)
    {
        try {
            $thread = $this->thread->whereSlug($thread)->firstOrFail();

            $thread->update($request->all());

            dd('Tópico atualizado com sucesso.');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $thread)
    {
        try {
            $thread = $this->thread->whereSlug($thread)->firstOrFail();

            $thread->delete();

            dd('Tópico removido com sucesso.');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}

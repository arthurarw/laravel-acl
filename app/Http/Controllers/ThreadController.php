<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Exception;
use Illuminate\Http\Request;

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
        $threads = $this->thread->paginate(5);

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
            $this->thread->create($request->all());

            dd('Tópico criado com sucesso.');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Thread $thread)
    {
        return view('threads.show', [
            'thread' => $thread
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Thread $thread)
    {
        return view('threads.edit', [
            'thread' => $thread
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Thread $thread)
    {
        try {
            $this->thread->update($request->all());

            dd('Tópico atualizado com sucesso.');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Thread $thread)
    {
        try {
            $this->thread->delete();

            dd('Tópico removido com sucesso.');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}

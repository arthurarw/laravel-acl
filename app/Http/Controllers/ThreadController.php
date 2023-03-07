<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThreadStoreUpdateRequest;
use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 *
 */
class ThreadController extends Controller
{
    /**
     * @param Thread $thread
     */
    public function __construct(private Thread $thread)
    {
    }

    /**
     * @param Request $request
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     */
    public function index(Request $request): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $threads = $this->thread->with(['user', 'channel', 'replies'])->orderByDesc('created_at');
        if (!empty($request->channel)) {
            $channel = Channel::whereSlug($request->channel)->first();
            if ($channel) {
                $threads = $threads->where('channel_id', $channel->id);
            }
        }

        return view('threads.index', [
            'threads' => $threads->paginate(10)
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
     * Undocumented function
     *
     * @param ThreadStoreUpdateRequest $request
     * @return RedirectResponse
     */
    public function store(ThreadStoreUpdateRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['title']);

            $user = User::find(1);

            $thread = $user->threads()->create($data);

            flash('Tópico criado com sucesso!')->success();

            return redirect()->route('threads.show', $thread->slug);
        } catch (Exception $e) {
            flash($e->getMessage())->warning();
            return redirect()->back();
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
     * @param string $thread
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     * @throws AuthorizationException
     */
    public function edit(string $thread): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $thread = $this->thread->whereSlug($thread)->firstOrFail();
        $this->authorize('update', $thread);

        return view('threads.edit', [
            'thread' => $thread
        ]);
    }

    /**
     * Undocumented function
     *
     * @param ThreadStoreUpdateRequest $request
     * @param string $thread
     * @return RedirectResponse
     */
    public function update(ThreadStoreUpdateRequest $request, string $thread): RedirectResponse
    {
        try {
            $data = $request->validated();

            $thread = $this->thread->whereSlug($thread)->firstOrFail();
            $this->authorize('update', $thread);

            $thread->update($data);

            flash('Tópico atualizado com sucesso!')->success();

            return redirect()->back();
        } catch (Exception $e) {
            flash($e->getMessage())->warning();
            return redirect()->back();
        }
    }

    /**
     * @param string $thread
     * @return RedirectResponse
     */
    public function destroy(string $thread): RedirectResponse
    {
        try {
            $thread = $this->thread->whereSlug($thread)->firstOrFail();
            $this->authorize('delete', $thread);

            $thread->delete();

            flash('Tópico removido com sucesso!')->success();
            return redirect()->route('threads.index');
        } catch (Exception $e) {
            flash($e->getMessage())->warning();
            return redirect()->back();
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyStoreUpdateRequest;
use App\Models\Thread;
use Exception;

class ReplyController extends Controller
{
    public function store(ReplyStoreUpdateRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = 1;
        
            $thread = Thread::findOrFail($data['thread_id']);
            $thread->replies()->create($data);

            flash('Resposta criada com sucesso!')->success();

            return redirect()->route('threads.show', $thread->slug);
        } catch (Exception $e) {
            flash($e->getMessage())->warning();
            return redirect()->back();
        }
    }
}

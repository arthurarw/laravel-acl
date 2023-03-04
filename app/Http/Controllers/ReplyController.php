<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Exception;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->all();
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

<?php

namespace App\Http\Views\Composers;

use App\Models\Channel;
use Illuminate\View\View;

class ChannelComposer
{
    public function __construct(private Channel $channels)
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
        $view->with('channels', $this->channels->orderBy('name')->get(['name', 'slug', 'id']));
    }
}

<?php

namespace App\View\Components;

use App\Models\MenuLink;
use App\Repositories\MenuLinkRepository;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Menu extends Component
{
    public $links;
    public function __construct()
    {
        $this->links = MenuLink::published()->get()->toTree();
    }

    public function render(): View
    {
        return view('components.menu', ['links' => $this->links]);
    }
}

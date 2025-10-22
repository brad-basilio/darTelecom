<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Service;

class ServiceComposer
{
    public function compose(View $view)
    {
        $serviciosMenu = Service::where('visible', 1)->where('status', 1)->get();
        $view->with('serviciosMenu', $serviciosMenu);
    }
}
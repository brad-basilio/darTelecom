<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Collection;
use App\Models\General;
use App\Models\Message;
use App\Models\PolyticsCondition;
use App\Models\TermsAndCondition;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pagination\Paginator as PaginationPaginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.public.footer', function ($view) {
            // Obtener los datos del footer
            $general = General::first(); // Suponiendo que tienes un modelo Footer y un método footerData() en él
            // Pasar los datos a la vista
            $politicDev = PolyticsCondition::first();
            $termsAndCondicitions = TermsAndCondition::first();
            // $view->with('general', $general)
            //     ->with('politicDev', $politicDev)
            //     ->with('termsAndCondicitions', $termsAndCondicitions);

            $view->with(['general' => $general, 'politicDev' => $politicDev, 'termsAndCondicitions' => $termsAndCondicitions]);
        });



        View::composer('components.public.matrix', function ($view) {

            $general = General::first();
            // Pasar los datos a la vista
            $view->with('general', $general);
        });

        View::composer('components.public.header', function ($view) {
            $general = General::first();
            $serviciosMenu = \App\Models\Service::where('visible', 1)->get();
            $view->with(['general' => $general, 'serviciosMenu' => $serviciosMenu]);
        });

        View::composer('components.app.sidebar', function ($view) {
            // Obtener los datos del footer


            $mensajes = Message::where('is_read', '!=', 1)->where('status', '!=', 0)->count(); // Suponiendo que tienes un modelo Footer y un método footerData() en él
            // Pasar los datos a la vista
            $view->with('mensajes', $mensajes);

            // Pasar los datos a la vista
            /*  $view->with('mensajes', $mensajes)
                 ->with('mensajeslanding', $mensajeslanding)
                 ->with('mensajesproduct', $mensajesproduct);*/
        });


        PaginationPaginator::useTailwind();
    }
}

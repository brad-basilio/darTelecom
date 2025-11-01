@extends('components.public.matrix', ['pagina' => 'index'])
@section('titulo', 'Inicio')
@section('css_importados')

    <style>
        .swiper-pagination_productos>.swiper-pagination-bullet-active {
            background-color: transparent;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            width: 20px;
            height: 20px;
            opacity: 1;
            background-image: url({{ asset('images/svg/image_29.svg') }});
        }

        .swiper-pagination_productos .swiper-pagination-bullet:not(.swiper-pagination-bullet-active) {
            background-color: transparent;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            width: 20px;
            height: 20px;
            opacity: 1;
            background-image: url({{ asset('images/svg/image_30.svg') }});
        }

        .swiper-button-next {
            background-color: #FFD9C7;
            background-repeat: no-repeat;
            background-position: center;
            width: calc(var(--swiper-navigation-size) / 29 * 27) !important;
            height: 50px;
            border-radius: 50%;
            transition: background-color 0.3s ease-in;
            background-image: url({{ asset('images/svg/image_43.svg') }})
        }

        .swiper-button-next:hover {
            background-color: #FF5E14;
            opacity: 1;
        }

        .swiper-button-prev {
            background-color: #FFD9C7;
            background-repeat: no-repeat;
            background-position: center;
            width: calc(var(--swiper-navigation-size) / 29 * 27) !important;
            height: 50px;
            border-radius: 50%;
            transition: background-color 0.3s ease-in;
            background-image: url({{ asset('images/svg/image_44.svg') }})
        }

        .swiper-button-prev:hover {
            background-color: #FF5E14;
            opacity: 1;
        }

        .slider-pagination {

            margin-bottom: 30px;
        }

        /* Estilo de los puntos de paginación */
        .slider-pagination .swiper-pagination-bullet {
            width: 16px;
            /* Ancho personalizado */
            height: 9px;
            /* Alto personalizado */
            border-radius: 6px;
            /* Bordes redondeados */
            background-color: #F07407 !important;
            /* Color base */
            transition: background-color 0.3s, transform 0.3s;
            /* Transiciones suaves */
        }

        /* Estilo de los puntos que no están activos */
        .slider-pagination .swiper-pagination-bullet:not(.swiper-pagination-bullet-active) {
            background-color: white !important;
            /* Color más tenue */
            opacity: 0.8;
            /* Opacidad constante */
        }

        #imagen-zona {
            transition: opacity 0.3s ease-in-out;
        }

        .blocker {
            z-index: 50 !important;
        }

        .comment.hidden {
            opacity: 0;
            pointer-events: none;
        }

        .comment {
            opacity: 1;
            transition: opacity 0.3s ease-in-out;
        }

        /*ESTILOS PARA ESTA SE3CCION DAR TELECOM*/
        #descripcion_extensa>p {
            margin-bottom: 1rem;
        }

        /* En tu archivo CSS */
        aside nav ul li.active {
            background-color: #ed1b2f;
            /* Color de fondo para el elemento activo */
            color: white;
            /* Color de texto para el elemento activo */
        }

        aside nav ul li.active div {
            background-color: #FFFFFF;
            /* Color de fondo para el elemento activo */


        }
    </style>



@stop


@section('content')
    <main class="bg-white">

        <!-- Header Section -->
        <div class="hidden h-[200px] w-full bg-cover bg-colorBackgroundAzulOscuro lg:flex flex-col justify-center"
            style="background-image: linear-gradient(to right, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0)), url('{{ asset($servicioParaHeader?->imagen_principal ?? $servicioPage?->imagen) }}'); background-position: center center; background-size: cover; background-attachment: fixed;">
        </div>

        <section class="relative w-full"> <!-- Subheader -->
            <div class="absolute left-0  top-0 transform rotate-180 ">
                <img src="{{ asset('images/img/background/bg-testimonio.png') }}" alt="" class="w-20 md:w-36 lg:w-48">
            </div>
            <div class="absolute right-0  bottom-0 transform  ">
                <img src="{{ asset('images/img/background/bg-testimonio.png') }}" alt=""
                    class="w-20 md:w-36 lg:w-48">
            </div>
            <section class="w-11/12 text-center px-4 lg:max-w-3xl mx-auto mt-20 lg:mt-0">
                <div class=" bg-opacity-50 flex items-center justify-center">
                    <h1 class="text-colorAzulOscuro pt-8 text-text40 lg:text-text48 font-bold mb-2" data-aos="fade-up"
                        data-aos-offset="150" data-aos-duration="1000" data-aos-delay="200">
                        <x-custom.texto-titulo :text="$servicioParaHeader?->title ?? $servicioPage?->titulo" style="text-colorRojo" />
                    </h1>
                </div>
                <h2 class="text-colorParrafo text-text20 lg:text-text24 font-semibold mb-6" data-aos="fade-up"
                    data-aos-offset="150" data-aos-duration="1000" data-aos-delay="300">
                    {{ $servicioParaHeader?->subtitle ?? $servicioPage?->subtitulo }}
                </h2>
             
            </section>
               
                @if($servicioParaHeader?->descripcion_breve || $servicioParaHeader?->descripcion_extensa)
                <div class="prose prose-base w-11/12 lg:max-w-7xl mx-auto px-4 text-colorParrafo  mb-8" data-aos="fade-up"
                     data-aos-offset="150" data-aos-duration="1000" data-aos-delay="400">
                    @if($servicioParaHeader?->descripcion_breve)
                        <p class="text-text16 mb-4">{{ $servicioParaHeader->descripcion_breve }}</p>
                    @endif
                    @if($servicioParaHeader?->descripcion_extensa)
                        <div class="text-text16">
                            {!! $servicioParaHeader->descripcion_extensa !!}
                        </div>
                    @endif
                </div>
                @endif

            @if($servicios && $servicios->count() > 0)
            <div class="w-11/12 lg:max-w-7xl mx-auto px-4 flex flex-col lg:flex-row gap-8 pt-8">
                <!-- Sidebar -->
                <aside class="lg:w-1/4">
                    <nav class="">
                        <ul class="grid grid-cols-2 lg:grid-cols-1 gap-4 " data-aos="fade-up" data-aos-offset="150"
                            data-aos-duration="1000" data-aos-delay="200">
                            @foreach ($servicios as $index => $servicioItem)
                                <li data-slug="{{ $servicioItem->slug }}"
                                    class="cursor-pointer group rounded-xl flex items-center gap-4 p-4 text-text20 font-semibold bg-colorBackgroundAzulClaro hover:bg-colorBackgroundRed text-colorAzulOscuro hover:text-white transition-all duration-300 {{ isset($servicioSeleccionado) && $servicioSeleccionado == $servicioItem->slug ? 'active' : ($index === 0 && !isset($servicioSeleccionado) ? 'active' : '') }}">
                                    <div class="group-hover:hidden h-7 w-7 bg-black {{ isset($servicioSeleccionado) && $servicioSeleccionado == $servicioItem->slug ? 'hidden' : '' }}"
                                        style="mask-image: url('{{ asset($servicioItem->icono) }}'); mask-size: contain; mask-repeat: no-repeat;">
                                    </div>
                                    <div class="hidden group-hover:inline-block h-7 w-7 bg-white {{ isset($servicioSeleccionado) && $servicioSeleccionado == $servicioItem->slug ? '!inline-block' : '' }}"
                                        style="mask-image: url('{{ asset($servicioItem->icono) }}'); mask-size: contain; mask-repeat: no-repeat;">
                                    </div>
                                    <a href="#" class="servicio-link">{{ $servicioItem->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </aside>

                <!-- Main Content -->
                <main class="lg:w-3/4 max-w-full bg-white mb-16" id="main-content">
                    <!-- El contenido del primer subservicio se mostrará por defecto -->
                    @if($servicio)
                        @include('components.custom.component-servicio', $servicio)
                    @endif
                </main>
            </div>
            @else
            <div class="w-11/12 lg:max-w-3xl mx-auto px-4 text-center py-16">
                <div class="bg-gray-50 rounded-lg p-8" data-aos="fade-up" data-aos-offset="150" data-aos-duration="1000" data-aos-delay="200">
                    <i class="fa-solid fa-info-circle text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Sin subservicios disponibles</h3>
                    <p class="text-gray-600">Este servicio aún no tiene subservicios configurados.</p>
                </div>
            </div>
            @endif

        </section>
    </main>







@section('scripts_importados')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarItems = document.querySelectorAll('aside nav ul li');
            const mainContent = document.getElementById('main-content');

            // Función para cargar el contenido del servicio
            function loadServicioContent(servicioSlug) {
                fetch(`/servicios/show/${servicioSlug}`)
                    .then(response => response.text())
                    .then(data => {
                        mainContent.innerHTML = data;
                    })
                    .catch(error => console.error('Error al cargar el servicio:', error));
            }

            // Manejar el clic en los elementos del sidebar
            sidebarItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remover la clase 'active' de todos los elementos
                    sidebarItems.forEach(i => i.classList.remove('active'));

                    // Agregar la clase 'active' al elemento seleccionado
                    item.classList.add('active');

                    // Obtener el slug del servicio y cargar su contenido
                    const servicioSlug = item.getAttribute('data-slug');
                    loadServicioContent(servicioSlug);
                });
            });

            // Cargar el contenido del servicio seleccionado o el primer servicio por defecto
            if (sidebarItems.length > 0) {
                // Buscar si hay un servicio activo (seleccionado desde la URL)
                const activeItem = document.querySelector('aside nav ul li.active');
                if (activeItem) {
                    const servicioSlug = activeItem.getAttribute('data-slug');
                    loadServicioContent(servicioSlug);
                } else {
                    // Si no hay activo, cargar el primer servicio
                    const firstItem = sidebarItems[0];
                    const servicioSlug = firstItem.getAttribute('data-slug');
                    loadServicioContent(servicioSlug);
                }
            }
        });
    </script>

@stop

@stop

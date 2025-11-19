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
        aside nav ul li.active,
        aside nav .swiper-slide li.active {
            background-color: #ed1b2f !important;
            color: white !important;
            border: none !important;
        }

        aside nav ul li.active div,
        aside nav .swiper-slide li.active div {
            background-color: #FFFFFF !important;
        }

        /* Estilos para el carrusel de servicios en mobile */
        .servicios-swiper {
            padding: 0 !important;
            margin: 0 !important;
            border: 0 !important;
            outline: 0 !important;
            box-shadow: none !important;
        }

        .servicios-swiper .swiper-slide {
            height: auto;
            display: flex;
            justify-content: center;
            border: 0 !important;
            outline: 0 !important;
            box-shadow: none !important;
        }

        .servicios-swiper .swiper-slide li {
            height: 100%;
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 200px;
            margin: 0 auto;
            border: 0 !important;
            outline: 0 !important;
            box-shadow: none !important;
        }

        /* Eliminar cualquier borde/outline del swiper activo */
        .servicios-swiper .swiper-slide-active,
        .servicios-swiper .swiper-slide-active li,
        .servicios-swiper .swiper-slide-next,
        .servicios-swiper .swiper-slide-prev {
            border: 0 !important;
            outline: 0 !important;
            box-shadow: none !important;
        }

        /* CRÍTICO: Eliminar el shadow/border ROJO del slide activo de Swiper */
        .servicios-swiper .swiper-slide-active::before,
        .servicios-swiper .swiper-slide-active::after {
            display: none !important;
            content: none !important;
            border: 0 !important;
            box-shadow: none !important;
        }

        /* Forzar transparencia en cualquier pseudo-elemento del swiper */
        .servicios-swiper .swiper-slide::before,
        .servicios-swiper .swiper-slide::after,
        .servicios-swiper .swiper-wrapper::before,
        .servicios-swiper .swiper-wrapper::after {
            display: none !important;
            content: none !important;
            border: 0 !important;
            box-shadow: none !important;
            background: transparent !important;
        }

        /* Eliminar cualquier efecto visual adicional del slide activo */
        .servicios-swiper .swiper-slide-active {
            transform: none !important;
            filter: none !important;
            opacity: 1 !important;
            background: transparent !important;
        }

        /* Asegurar que el contenedor del swiper no tenga bordes */
        .servicios-swiper .swiper-container,
        .servicios-swiper.swiper {
            border: 0 !important;
            outline: 0 !important;
            box-shadow: none !important;
            background: transparent !important;
        }

        /* Asegurar que no haya bordes en ningún estado del swiper */
        .servicios-swiper .swiper-wrapper,
        .servicios-swiper .swiper-container {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
        }

        .servicios-next,
        .servicios-prev {
            width: 36px !important;
            height: 36px !important;
            margin-top: -18px !important;
            background-color: #ed1b2f !important;
            border-radius: 50% !important;
            color: white !important;
            display: flex !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .servicios-next:after,
        .servicios-prev:after {
            font-size: 16px !important;
            font-weight: bold !important;
        }

        .servicios-next {
            right: 5px !important;
        }

        .servicios-prev {
            left: 5px !important;
        }

        .servicios-next.swiper-button-disabled,
        .servicios-prev.swiper-button-disabled {
            opacity: 0.3 !important;
            visibility: visible !important;
        }

        /* Eliminar cualquier focus outline o borde del swiper */
        .servicios-swiper *:focus,
        .servicios-swiper *:focus-visible,
        .servicios-swiper *:active {
            outline: none !important;
            border: none !important;
            box-shadow: none !important;
        }

        /* Resetear estilos específicos de Swiper que puedan causar bordes */
        .servicios-swiper .swiper-slide::before,
        .servicios-swiper .swiper-slide::after {
            display: none !important;
        }

        /* Eliminar el marco rojo del swiper completo */
        .servicios-swiper,
        .servicios-swiper .swiper-container,
        .servicios-swiper .swiper-wrapper,
        aside nav > div {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            -webkit-box-shadow: none !important;
            -moz-box-shadow: none !important;
        }

        /* AOS puede agregar efectos - eliminarlos del swiper */
        [data-aos].lg\\:hidden {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
        }

        /* Forzar eliminación de TODOS los outlines, borders y shadows en el swiper de servicios */
        aside nav .lg\\:hidden *,
        aside nav .lg\\:hidden,
        aside nav .servicios-swiper *,
        aside nav .servicios-swiper {
            border: 0 !important;
            outline: 0 !important;
            box-shadow: none !important;
            -webkit-box-shadow: none !important;
            -moz-box-shadow: none !important;
        }

        /* Eliminar ring de Tailwind en focus */
        aside nav .servicios-swiper *:focus,
        aside nav .servicios-swiper *:focus-within,
        aside nav .servicios-swiper *:focus-visible {
            --tw-ring-shadow: 0 0 #0000 !important;
            --tw-ring-offset-shadow: 0 0 #0000 !important;
            border: 0 !important;
            outline: 0 !important;
            box-shadow: none !important;
        }

        /* Eliminar cualquier borde del aside completo en mobile */
        aside,
        aside nav,
        aside nav > *,
        aside .lg\\:hidden {
            border: 0 !important;
            outline: 0 !important;
            box-shadow: none !important;
        }

        /* Eliminar COMPLETAMENTE el outline/shadow de focus y active en TODOS los elementos */
        aside *,
        aside *:focus,
        aside *:active,
        aside *:focus-visible,
        aside *:focus-within,
        .servicios-swiper,
        .servicios-swiper *,
        .servicios-swiper *:focus,
        .servicios-swiper *:active,
        .servicios-swiper *:focus-visible,
        .servicios-swiper li,
        .servicios-swiper li:focus,
        .servicios-swiper li:active,
        .servicios-swiper a,
        .servicios-swiper a:focus,
        .servicios-swiper a:active {
            outline: 0 !important;
            outline-width: 0 !important;
            outline-style: none !important;
            outline-color: transparent !important;
            border: 0 !important;
            box-shadow: none !important;
            -webkit-box-shadow: none !important;
            -moz-box-shadow: none !important;
            -webkit-tap-highlight-color: transparent !important;
            --tw-ring-shadow: 0 0 #0000 !important;
            --tw-ring-offset-shadow: 0 0 #0000 !important;
            --tw-shadow: 0 0 #0000 !important;
            --tw-shadow-colored: 0 0 #0000 !important;
        }
    </style>



@stop


@section('content')
    <main class="bg-white">

        <!-- Header Section -->
        <div class="hidden h-[200px] w-full bg-cover bg-colorBackgroundAzulOscuro lg:flex flex-col justify-center"
            style="background-image: linear-gradient(to right, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0)), url('{{ asset($servicioParaHeader?->imagen_principal ?? $servicioPage?->imagen) }}'); background-position: center center; background-size: cover; background-attachment: fixed;">
        </div>

        <section class="relative w-full "> <!-- Subheader -->
            <!--<div class="absolute left-0  top-0 transform rotate-180 ">
                <img src="{{ asset('images/img/background/bg-testimonio.png') }}" alt="" class="w-20 md:w-36 lg:w-40">
            </div>
            <div class="absolute right-0  bottom-0 transform  ">
                <img src="{{ asset('images/img/background/bg-testimonio.png') }}" alt=""
                    class="w-20 md:w-36 lg:w-40">
            </div>-->
            <div class="bg-colorBackgroundAzulClaro pb-6">
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
            </div>

            @if($servicios && $servicios->count() > 0)
            <div class="w-11/12 lg:max-w-7xl mx-auto px-4 flex flex-col lg:flex-row gap-8 pt-8">
                <!-- Sidebar -->
                <aside class="lg:w-1/4">
                    <nav class="">
                        <!-- Desktop: Grid normal -->
                        <ul class="hidden lg:grid grid-cols-1 gap-4" data-aos="fade-up" data-aos-offset="150"
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
                        
                        <!-- Mobile: Swiper Carousel -->
                        <div class="lg:hidden" data-aos="fade-up" data-aos-offset="150" data-aos-duration="1000" data-aos-delay="200" style="border: none !important; outline: none !important; box-shadow: none !important;">
                            <div class="swiper servicios-swiper" style="border: none !important; outline: none !important; box-shadow: none !important;">
                                <div class="swiper-wrapper" style="border: none !important; outline: none !important; box-shadow: none !important;">
                                    @foreach ($servicios as $index => $servicioItem)
                                        <div class="swiper-slide" style="border: none !important; outline: none !important; box-shadow: none !important;">
                                            <li data-slug="{{ $servicioItem->slug }}"
                                                class="cursor-pointer group rounded-xl flex items-center gap-3 p-3 text-text16 font-semibold bg-colorBackgroundAzulClaro hover:bg-colorBackgroundRed text-colorAzulOscuro hover:text-white transition-all duration-300 {{ isset($servicioSeleccionado) && $servicioSeleccionado == $servicioItem->slug ? 'active' : ($index === 0 && !isset($servicioSeleccionado) ? 'active' : '') }}"
                                                style="border: none !important; outline: none !important; box-shadow: none !important;">
                                                <div class="group-hover:hidden min-h-6 min-w-6 bg-black {{ isset($servicioSeleccionado) && $servicioSeleccionado == $servicioItem->slug ? 'hidden' : '' }}"
                                                    style="mask-image: url('{{ asset($servicioItem->icono) }}'); mask-size: contain; mask-repeat: no-repeat;">
                                                </div>
                                                <div class="hidden group-hover:inline-block h-6 w-6 bg-white {{ isset($servicioSeleccionado) && $servicioSeleccionado == $servicioItem->slug ? '!inline-block' : '' }}"
                                                    style="mask-image: url('{{ asset($servicioItem->icono) }}'); mask-size: contain; mask-repeat: no-repeat;">
                                                </div>
                                                <a href="#" class="servicio-link text-sm">{{ $servicioItem->title }}</a>
                                            </li>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Navegación del swiper -->
                                <div class="swiper-button-next servicios-next"></div>
                                <div class="swiper-button-prev servicios-prev"></div>
                            </div>
                        </div>
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
            // Inicializar el carrusel de servicios para mobile
            const serviciosSwiper = new Swiper('.servicios-swiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                centeredSlides: true,
                // Desactivar efectos visuales que puedan causar el borde
                effect: 'slide',
                watchSlidesProgress: false,
                watchSlidesVisibility: false,
                navigation: {
                    nextEl: '.servicios-next',
                    prevEl: '.servicios-prev',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                        centeredSlides: false,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                        centeredSlides: false,
                    }
                },
                // Eventos para forzar eliminación de estilos
                on: {
                    init: function() {
                        removeActiveStyles();
                        // Forzar visibilidad de los botones
                        showNavigationButtons();
                    },
                    slideChange: function() {
                        removeActiveStyles();
                    }
                }
            });

            // Función para forzar la visibilidad de los botones
            function showNavigationButtons() {
                setTimeout(() => {
                    const nextBtn = document.querySelector('.servicios-next');
                    const prevBtn = document.querySelector('.servicios-prev');
                    
                    if (nextBtn) {
                        nextBtn.style.display = 'flex';
                        nextBtn.style.visibility = 'visible';
                        nextBtn.style.opacity = '1';
                    }
                    if (prevBtn) {
                        prevBtn.style.display = 'flex';
                        prevBtn.style.visibility = 'visible';
                        prevBtn.style.opacity = '1';
                    }
                }, 100);
            }

            // Función para eliminar estilos del slide activo
            function removeActiveStyles() {
                setTimeout(() => {
                    const activeSlides = document.querySelectorAll('.servicios-swiper .swiper-slide-active');
                    activeSlides.forEach(slide => {
                        slide.style.border = '0';
                        slide.style.outline = '0';
                        slide.style.boxShadow = 'none';
                    });
                }, 10);
            }

            const sidebarItems = document.querySelectorAll('aside nav ul li, aside nav .swiper-slide li');
            const mainContent = document.getElementById('main-content');

            // Función para cargar el contenido del servicio
            function loadServicioContent(servicioSlug) {
                fetch(`/servicios/show/${servicioSlug}`)
                    .then(response => response.text())
                    .then(data => {
                        mainContent.innerHTML = data;
                        
                        // Disparar evento para que los componentes se reinicialicen
                        setTimeout(() => {
                            window.dispatchEvent(new CustomEvent('contenidoCargado'));
                        }, 100);
                    })
                    .catch(error => console.error('Error al cargar el servicio:', error));
            }

            // Manejar el clic en los elementos del sidebar
            sidebarItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Quitar el foco del elemento inmediatamente para evitar el outline
                    this.blur();
                    if (e.target) e.target.blur();
                    if (document.activeElement) document.activeElement.blur();

                    // Remover la clase 'active' de todos los elementos (desktop y mobile)
                    document.querySelectorAll('aside nav ul li, aside nav .swiper-slide li').forEach(i => i.classList.remove('active'));

                    // Agregar la clase 'active' al elemento seleccionado
                    item.classList.add('active');

                    // También sincronizar el estado activo entre desktop y mobile
                    const servicioSlug = item.getAttribute('data-slug');
                    document.querySelectorAll(`[data-slug="${servicioSlug}"]`).forEach(el => {
                        el.classList.add('active');
                    });

                    // Cargar contenido
                    loadServicioContent(servicioSlug);
                });
                
                // También manejar touchstart para mobile
                item.addEventListener('touchstart', function(e) {
                    setTimeout(() => {
                        this.blur();
                        if (document.activeElement) document.activeElement.blur();
                    }, 10);
                });
            });

            // Cargar el contenido del servicio seleccionado o el primer servicio por defecto
            if (sidebarItems.length > 0) {
                // Buscar si hay un servicio activo (seleccionado desde la URL)
                const activeItem = document.querySelector('aside nav ul li.active, aside nav .swiper-slide li.active');
                if (activeItem) {
                    const servicioSlug = activeItem.getAttribute('data-slug');
                    // Sync active state between desktop and mobile
                    document.querySelectorAll(`[data-slug="${servicioSlug}"]`).forEach(el => {
                        el.classList.add('active');
                    });
                    loadServicioContent(servicioSlug);
                } else {
                    // Si no hay activo, cargar el primer servicio
                    const firstItem = sidebarItems[0];
                    const servicioSlug = firstItem.getAttribute('data-slug');
                    // Sync active state between desktop and mobile
                    document.querySelectorAll(`[data-slug="${servicioSlug}"]`).forEach(el => {
                        el.classList.add('active');
                    });
                    loadServicioContent(servicioSlug);
                }
            }
        });
    </script>

@stop

@stop

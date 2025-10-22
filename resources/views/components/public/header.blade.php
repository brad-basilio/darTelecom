<style>
    #menuToggle,
    #menuClose {
        width: 33px;
        height: 34px;

        align-items: center;
        justify-content: center;
    }

    #menuToggle svg,
    #menuClose svg {
        width: 100%;
        height: 100%;
    }

    #main-header {
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    #menu {
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    #menu {
        top: 5rem;
        /* Asegura que esté debajo del header */
        overflow-y: auto;
        /* Permite scroll si el contenido es muy largo */
    }
</style>

<header class="w-full z-40">

    <!--  top-0-->

    <nav id="main-header"
        class="fixed top-0 left-0 w-screen {{ request()->routeIs('index') ? 'bg-transparent ' : 'bg-colorBackgroundAzulOscuro' }}  text-white z-10 duration-300 ">


        <div class="w-11/12 max-w-[91.666667%] md:max-w-7xl mx-auto  flex justify-between items-center py-4">
            <a href="/" class="text-2xl font-bold w-auto">
                <img src="{{ asset('images/img/logo/DarTelecom.png') }}" alt="Dar Telecom"
                    class="h-14 w-auto object-contain" />
            </a>

            <div class="hidden lg:flex justify-center items-center gap-10 font-semibold text-text18 xl:text-text22">
                <ul class="flex space-x-6">
                    <li>
                        <x-nav-link href="{{ route('index') }}" :active="request()->routeIs('index')">
                            Inicio</x-nav-link>

                    </li>
                    <li>
                        <x-nav-link href="{{ route('nosotros') }}" :active="request()->routeIs('nosotros')">
                            Nosotros</x-nav-link>

                    </li>
                    <li class="relative group">
                        <x-nav-link  :active="request()->routeIs('servicios')" class="flex items-center gap-1">
                            Servicios
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </x-nav-link>
                        <!-- Dropdown Menu -->
                        <div class="absolute top-full left-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                            <div class="py-2">
                                @if($serviciosMenu && $serviciosMenu->count() > 0)
                                    @foreach($serviciosMenu as $servicioItem)
                                        <a href="{{ route('servicios', $servicioItem->slug) }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-colorBackgroundRed transition-colors duration-200">
                                            <div class="flex items-center gap-3">
                                                @if($servicioItem->icono)
                                                    <div class="w-5 h-5 bg-gray-600" style="mask-image: url('{{ asset($servicioItem->icono) }}'); mask-size: contain; mask-repeat: no-repeat;"></div>
                                                @endif
                                                <span class="font-medium">{{ $servicioItem->title }}</span>
                                            </div>
                                            @if($servicioItem->descripcion_breve)
                                                <p class="text-xs text-gray-500 mt-1 ml-8">{{ Str::limit($servicioItem->descripcion_breve, 60) }}</p>
                                            @endif
                                        </a>
                                    @endforeach
                                @else
                                    <div class="px-4 py-3 text-sm text-gray-500">No hay servicios disponibles</div>
                                @endif
                            </div>
                        </div>
                    </li>

                    <li>
                        <x-nav-link href="{{ route('catalogo.all') }}" :active="request()->routeIs('catalogo.all')">
                            Equipos</x-nav-link>

                    </li>
                    <li>
                        <x-nav-link href="{{ route('blog.all') }}" :active="request()->routeIs('blog.all')">
                            Blog</x-nav-link>

                    </li>
                    <li>
                        <x-nav-link href="{{ route('contacto') }}" :active="request()->routeIs('contacto')">
                            Contacto</x-nav-link>

                    </li>

                </ul>

                <x-custom.button-cotizar :general="$general"  text="CONTACTANOS"/>
            </div>
            <div class="lg:hidden flex items-center justify-end">
                <button id="menuToggle" class="text-white fill-white focus:outline-none">
                    <i>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="current" width="33" height="34"
                            viewBox="0 0 448 512">
                            <path
                                d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z" />
                        </svg>

                    </i>
                </button>
                <button id="menuClose" class=" text-white fill-white focus:outline-none hidden">
                    <i>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                            <path
                                d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                        </svg>

                    </i>
                </button>
            </div>
        </div>
    </nav>




    <div class="flex justify-end w-full mx-auto z-[100] relative">
        <div class="fixed bottom-6 sm:bottom-[2rem] lg:bottom-[4rem] z-20 cursor-pointer">
            <a target="_blank" id="whatsapp-toggle"
                href="https://api.whatsapp.com/send?phone={{ $general?->whatsapp }}&text={{ $general?->mensaje_whatsapp }}">
                <img src="{{ asset('images/img/background/WhatsApp.svg') }}" alt="whatsapp"
                    class="mr-3 w-16 h-16 md:w-[85px] md:h-[85px]">

            </a>
        </div>
    </div>

    <!-- Menú desplegable para móviles -->
    <div id="menu"
        class="hidden lg:hidden bg-colorBackgroundAzulOscuro text-textWhite shadow-lg  w-screen max-w-[100vw] h-[calc(100vh-5rem)] fixed z-[999] top-24">

        <nav class="pt-8 flex flex-col justify-center items-center gap-10 text-center w-11/12 md:max-w-6xl mx-auto"
            data-aos="fade-up" data-aos-offset="150">
            <ul class="flex space-y-6 flex-col">
                <li>
                    <x-nav-link href="{{ route('index') }}" :active="request()->routeIs('index')">
                        Inicio</x-nav-link>

                </li>
                <li>
                    <x-nav-link href="{{ route('nosotros') }}" :active="request()->routeIs('nosotros')">
                        Nosotros</x-nav-link>

                </li>
                <li>
                    <div class="flex flex-col justify-center items-center space-y-2">
                        <x-nav-link onclick="toggleMobileServiciosDropdown()"  :active="request()->routeIs('servicios')" class="flex items-center justify-center gap-2">
                            Servicios
                            <button onclick="toggleMobileServiciosDropdown()" class="text-white">
                                <svg id="servicios-arrow" class="w-4 h-4 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </x-nav-link>
                        <div id="mobile-servicios-dropdown" class="hidden bg-colorBackgroundAzulOscuro rounded-lg mt-2 ">
                            @if($serviciosMenu && $serviciosMenu->count() > 0)
                                @foreach($serviciosMenu as $servicioItem)
                                    <a href="{{ route('servicios', $servicioItem->slug) }}" class="block  py-2 text-sm text-white hover:bg-colorBackgroundRed transition-colors duration-200 rounded">
                                        <div class="flex items-center justify-center gap-2">
                                            @if($servicioItem->icono)
                                                <div class="w-4 h-4 bg-white" style="mask-image: url('{{ asset($servicioItem->icono) }}'); mask-size: contain; mask-repeat: no-repeat;"></div>
                                            @endif
                                            <span>{{ $servicioItem->title }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </li>

                <li>
                    <x-nav-link href="{{ route('catalogo.all') }}" :active="request()->routeIs('catalogo.all')">
                        Equipos</x-nav-link>

                </li>
                <li>
                    <x-nav-link href="{{ route('blog.all') }}" :active="request()->routeIs('blog.all')">
                        Blog</x-nav-link>

                </li>
                <li>
                    <x-nav-link href="{{ route('contacto') }}" :active="request()->routeIs('contacto')">
                        Contacto</x-nav-link>

                </li>

            </ul>

            <x-custom.button-cotizar :general="$general" style="bg-colorBackgroundRed " text="CONTACTANOS" />
        </nav>


    </div>


</header>


<script>
    // Función para aplicar estilos de scroll
    function applyScrollStyles() {
        const header = document.getElementById('main-header');
        const isHomePage = "{{ request()->routeIs('index') }}" === "1";
        const menuIsOpen = !menu.classList.contains('hidden');

        // Si el menú está abierto, forzar el fondo oscuro
        if (menuIsOpen) {
            header.classList.add('bg-colorBackgroundAzulOscuro');
            header.classList.remove('bg-transparent');
            return;
        }

        if (!isHomePage) {
            // Páginas que no son el inicio siempre tienen fondo oscuro
            header.classList.add('bg-colorBackgroundAzulOscuro');
            header.classList.remove('bg-transparent');
            return;
        }

        // Solo para página de inicio
        if (window.scrollY > 50) {
            header.classList.add('bg-colorBackgroundAzulOscuro');
            header.classList.remove('bg-transparent');
            header.classList.add('shadow-md');
        } else {
            header.classList.add('bg-transparent');
            header.classList.remove('bg-colorBackgroundAzulOscuro');
            header.classList.remove('shadow-md');
        }
    }

    // Control del menú móvil
    const menuToggle = document.getElementById('menuToggle');
    const menuToggleClose = document.getElementById('menuClose');
    const menu = document.getElementById('menu');

    menuToggle.addEventListener('click', function() {
        menu.classList.remove('hidden');
        menuToggle.classList.add('hidden');
        menuToggleClose.classList.remove('hidden');
        applyScrollStyles(); // Actualizar estilos del header
    });

    menuToggleClose.addEventListener('click', function() {
        menu.classList.add('hidden');
        menuToggle.classList.remove('hidden');
        menuToggleClose.classList.add('hidden');
        applyScrollStyles(); // Actualizar estilos del header
    });

    // Inicialización
    document.addEventListener('DOMContentLoaded', function() {
        applyScrollStyles();
        // Asegurarse de que el botón de cerrar esté oculto al cargar
        menuToggleClose.classList.add('hidden');
    });

    window.addEventListener('scroll', applyScrollStyles);

    // Función para toggle del dropdown de servicios en móvil
    function toggleMobileServiciosDropdown() {
        const dropdown = document.getElementById('mobile-servicios-dropdown');
        const arrow = document.getElementById('servicios-arrow');
        
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
            arrow.classList.add('rotate-180');
        } else {
            dropdown.classList.add('hidden');
            arrow.classList.remove('rotate-180');
        }
    }
</script>

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
            <a href="/" class="text-2xl font-bold">
                <img src="{{ asset('images/img/logo/DarTelecom.png') }}" alt="Dar Telecom"
                    class="h-14 w-full object-contain" />
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
                    <li>
                        <x-nav-link href="{{ route('servicios') }}" :active="request()->routeIs('servicios')">
                            Servicios</x-nav-link>

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

                <x-custom.button-cotizar :general="$general" />
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
                    <x-nav-link href="{{ route('servicios') }}" :active="request()->routeIs('servicios')">
                        Servicios</x-nav-link>

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

            <x-custom.button-cotizar :general="$general" style="bg-white text-[#0E1D42]" />
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
</script>

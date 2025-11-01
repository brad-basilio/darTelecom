@extends('components.public.matrix', ['pagina' => 'contacto'])
@section('titulo', 'Contacto')
@section('css_importados')

@stop


@section('content')
    <main class="bg-white ">


        <section class="w-full relative pt-32">
            <div class="absolute left-0 transform hidden md:block ">
                <!-- <img src="{{ asset('images/img/background/bg-contacto.png') }}" alt="" class="w-20"-->
            </div>
            <div class="w-11/12 lg:max-w-7xl mx-auto  flex flex-col md:flex-row gap-4 " data-aos="fade-up"
                data-aos-offset="150" data-aos-duration="1000" data-aos-delay="200">
                <div class="md:w-1/2  ">
                    <div class="w-full lg:w-10/12 flex flex-col justify-start items-start gap-8">

                        <h2 class="text-colorAzulOscuro text-text44 font-bold">{{ $contactoview->titleSection }}</h2>
                        <p class=" text-colorParrafo text-text16 font-light" data-aos="fade-down">
                            {{ $contactoview->subtitleSection }}</p>

                        <div class="flex flex-col gap-2 items-start justify-start" data-aos="fade-down">
                            <p class="text-colorRojo text-text18 font-semibold">Horario de oficina</p>

                            <p class="text-colorParrafo text-text16 font-light w-full leading-tight">

                                {!! str_replace(',', '<br>', $general->schedule) !!}

                            </p>
                        </div>
                        <div class="flex flex-col gap-2 items-start  justify-start">

                            <p class="text-colorRojo text-text18 font-semibold">Nuestra Dirección</p>
                            <p class="text-textAzul group-hover:text-white text-base font-gotham_book w-full leading-tight">
                                {{ $general->address }} - {{ $general->district }} - {{ $general->city }}

                            </p>
                        </div>

                        <div class="flex flex-col gap-2 items-start  justify-start">
                            <p class="text-colorRojo text-text18 font-semibold">Ponerse en Contacto</p>
                            <p
                                class="text-textAzul group-hover:text-textAzul text-base font-gotham_book w-full leading-tight">

                                @if ($general->cellphone && $general->office_phone)
                                    {{ $general->cellphone ?? 'Ingrese nro. celular' }} /
                                    {{ $general->office_phone ?? 'Ingrese nro. telefónico' }}
                                @elseif($general->cellphone && empty($general->office_phone))
                                    {{ $general->cellphone ?? 'Ingrese nro. celular' }}
                                @elseif($general->office_phone && empty($general->cellphone))
                                    {{ $general->office_phone ?? 'Ingrese nro. telefónico' }}
                                @else
                                    <p>No hay información disponible para este ítem.</p>
                                @endif

                            </p>
                        </div>
                    </div>



                </div>
                <form id="formContactos" class="w-full md:w-1/2" method="POST" action="{{ route('guardarContactos') }}">
                    @csrf
                    <h2 class="text-colorAzulOscuro text-text32 font-bold">{{ $contactoview->titleForm }}</h2>
                    <p class="text-colorParrafo text-text16 font-light my-8">{{ $contactoview->subtitleForm }}</p>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <label class="text-colorAzulOscuro text-text12 w-full leading-tight">Nombres
                            <input id="name" type="text" name="name" required placeholder="Ingrese tu nombre"
                                class="w-full mt-2 text-text16 px-3 py-3 text-colorParrafo bg-transparent border-[#D0D5DD] shadow-sm rounded-xl focus:outline-none focus:ring-none focus:border-none focus:ring-[#D0D5DD]" />
                        </label>

                        <label class="text-colorAzulOscuro text-text12 w-full leading-tight">Apellidos
                            <input id="lastname" type="text" name="lastname" required placeholder="Ingrese tu apellido"
                                class="w-full mt-2 text-text16 px-3 py-3 text-colorParrafo bg-transparent border-[#D0D5DD] shadow-sm rounded-xl focus:outline-none focus:ring-none focus:border-none focus:ring-[#D0D5DD]" />
                        </label>

                        <label class="text-colorAzulOscuro text-text12 w-full leading-tight lg:col-span-2">Email
                            <input id="email" type="email" name="email" required
                                placeholder="Ingrese tu correo electrónico"
                                class="w-full mt-2 text-text16 px-3 py-3 text-colorParrafo bg-transparent border-[#D0D5DD] shadow-sm rounded-xl focus:outline-none focus:ring-none focus:border-none focus:ring-[#D0D5DD]" />
                        </label>

                        <label class="text-colorAzulOscuro text-text12 w-full leading-tight lg:col-span-2">Teléfono
                            <input id="phone" type="text" name="phone" required placeholder="Teléfono"
                                maxlength="9"
                                class="w-full mt-2 text-text16 px-3 py-3 text-colorParrafo bg-transparent border-[#D0D5DD] shadow-sm rounded-xl focus:outline-none focus:ring-none focus:border-none focus:ring-[#D0D5DD]" />
                        </label>

                        <label class="text-colorAzulOscuro text-text12 w-full leading-tight lg:col-span-2">Escribe un
                            mensaje
                            <textarea id="message" name="message" required placeholder="Escríbenos tu pregunta aquí"
                                class="w-full mt-2 text-text16 px-3 py-3 text-colorParrafo bg-transparent border-[#D0D5DD] shadow-sm rounded-xl focus:outline-none focus:ring-none focus:border-none focus:ring-[#D0D5DD] min-h-[200px]"></textarea>
                        </label>
                    </div>

                    <div class="flex justify-start gap-4 items-center pt-4">
                        <div class="flex justify-between py-4">
                            <!-- Label con estilos dinámicos -->
                            <label for="privacy_policy" class="flex items-center cursor-pointer w-full justify-between">
                                <!-- Input Checkbox -->
                                <input type="checkbox" id="privacy_policy" class="hidden peer" />
                                <!-- Visual del Checkbox -->
                                <div
                                    class="text-transparent w-5 h-5 flex items-center justify-center border border-[#333F51] rounded-sm bg-white peer-checked:bg-white peer-checked:border-[#ED1B2F] peer-checked:text-colorRojo">
                                    <i class="fa-solid fa-check fa-xs"></i>
                                </div>
                                <!-- Texto del Label -->
                                <span class="ml-4 text-sm  text-colorParrafo ">
                                    Acepto la política de
                                    privacidad.
                                </span>
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                        class="bg-colorBackgroundRed my-8 flex flex-row items-center text-text18 justify-center gap-2 text-white font-semibold rounded-full px-4 py-2.5">
                        Enviar mensaje
                    </button>
                </form>


            </div>

        </section>
        <!--Seccion FAQs-->
        <section class="w-11/12 lg:max-w-7xl mx-auto flex flex-col lg:flex-row gap-12 mt-12" data-aos="fade-up"
            data-aos-offset="150" data-aos-duration="1000" data-aos-delay="200">
            <div class="w-full lg:w-1/2">
                <h2 class="text-text32 font-bold text-colorAzulOscuro">{{ $contactoview->titleFaqs }}</h2>
                <p class="text-colorParrafo font-light text-text16">{{ $contactoview->subtitleFaqs }}</p>
            </div>
            <div class="w-full lg:w-1/2 mt-8 lg:mt-0">
                @foreach ($faqs as $faq)
                    <div x-data="{ open: false }" class="border-b pb-4">
                        <!-- Pregunta -->
                        <h4 @click="open = !open"
                            class="cursor-pointer flex justify-between items-center text-text16 font-semibold text-colorRojo py-3">
                            {{ $faq->pregunta }}

                            <div class="h-6 w-6 border-2 border-[#ed1b2f] rounded-full flex items-center justify-center">
                                <i x-show="!open" class="fa-solid fa-plus"></i>
                                <i x-show="open" class="fa-solid fa-minus"></i>
                            </div>

                        </h4>
                        <!-- Respuesta -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-screen"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 max-h-screen" x-transition:leave-end="opacity-0 max-h-0"
                            class="text-gray-500 overflow-hidden">
                            <p class="pt-3">
                                {{ $faq->respuesta }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <!--Seccion Contactar-->
        <section class="w-11/12 lg:max-w-7xl mx-auto py-12" data-aos="fade-up" data-aos-offset="150"
            data-aos-duration="1000" data-aos-delay="200">
            <section class="bg-colorBackgroundAzulClaro rounded-xl p-8 w-full relative overflow-hidden z-0 ">
                <div class="absolute -left-16  transform  rotate-[85deg] -z-10">
                    <img src="{{ asset('images/img/background/bg-footer.png') }}" alt="" class="w-full"
                        style=" filter: opacity(10%);">
                </div>
                <div class="mt-6 flex justify-center items-center z-20">
                    <div x-data="carousel()" class="w-full flex justify-center items-center relative overflow-hidden">
                        <!-- Contenedor de las imágenes -->
                        <div class="relative flex w-[300px] h-[100px] justify-center items-center">
                            <template x-for="(image, index) in visibleImages" :key="index">
                                <div class="absolute transition-all duration-1000 flex items-center justify-center "
                                    :class="{
                                        'w-14 h-14 z-10 left-1/2 transform -translate-x-1/2': index === 1,
                                        /* Imagen central */
                                        'w-12 h-12 z-0 opacity-80 left-1/4': index === 0,
                                        /* Izquierda */
                                        'w-12 h-12 z-0 opacity-80 right-1/4': index === 2 /* Derecha */
                                    }">
                                    <img :src="image.image" alt="Imagen"
                                        class="object-cover w-full h-full rounded-full border-2 border-white bg-colorBackgroundAzulOscuro">
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                <script>
                    function carousel() {
                        return {
                            images: [],
                            currentIndex: 0,
                            get visibleImages() {
                                let total = this.images.length;
                                if (total < 3) return this.images; // Si hay menos de 3 imágenes, mostrarlas todas
                                let prev = (this.currentIndex - 1 + total) % total;
                                let next = (this.currentIndex + 1) % total;
                                return [this.images[prev], this.images[this.currentIndex], this.images[next]];
                            },
                            async init() {
                                const response = await fetch('/imagenes');
                                this.images = await response.json();
                                this.startAutoSlide();
                            },
                            startAutoSlide() {
                                setInterval(() => {
                                    this.currentIndex = (this.currentIndex + 1) % this.images.length;
                                }, 3000); // Cambia cada 3 segundos
                            }
                        }
                    }
                </script>

                <div class="text-center max-w-md mx-auto z-20" data-aos="fade-up" data-aos-offset="150"
                    data-aos-duration="1000" data-aos-delay="200">
                    <h2 class="text-text24 font-semibold text-colorAzulOscuro">{{ $contactoview->titleSlider }}</h2>
                    <p class="text-colorParrafo mt-2 text-text16">{{ $contactoview->subtitleSlider }}</p>
                </div>

                <div class="mt-6 text-center z-20" data-aos="fade-up" data-aos-offset="150" data-aos-duration="1000"
                    data-aos-delay="200">

                    <x-custom.button-cotizar :general="$general" text="Ponerse en contacto"
                        style=" bg-colorBackgroundRed text-white px-6 py-3 rounded-full hover:bg-colorBackgroundRed transition duration-300" />
                </div>


            </section>


        </section>
        <!-- Modal -->
        <div id="modalDarTelecom"
            class="fixed inset-0 hidden bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white p-6  w-[600px] h-[650px] relative rounded-xl overflow-hidden">
                <video class="absolute top-0 left-0 w-full h-full object-cover" autoplay loop muted>
                    <source src="{{ asset('images/img/background/backgroundInicio.mp4') }}" type="video/mp4" />
                    Tu navegador no soporta la reproducción de videos.
                </video>
                <div
                    class="absolute inset-0 bg-transparent bg-opacity-50 flex flex-col mt-24 justify-start items-center text-white text-center">
                    <img src="{{ asset('images/img/logo/DarTelecom.png') }}" alt="Dar Telecom"
                        class="h-14 w-auto object-cover mb-6" />
                    <h2 class="text-text28 font-bold">¡Gracias por escribirnos!</h2>
                    <p id="text-nombre" class="mt-2 font-medium">¡Hola [Nombre del Cliente]!</p>
                    <p class="mt-2 font-medium">En breve nos estaremos comunicando contigo.</p>
                    <button onclick="document.getElementById('modalDarTelecom').classList.add('hidden');"
                        class="bg-colorBackgroundRed cursor-pointer mt-4  hover:bg-colorBackgroundRed text-white font-semibold py-3 rounded-full px-5 text-base">
                        Visita nuestra Web
                    </button>
                </div>
                <div class="absolute left-0  bottom-20 transform translate-y-1/2">
                    <img src="{{ asset('images/img/background/bg-cable.png') }}" alt="" class="w-96">
                </div>
            </div>

        </div>
        </div>
    </main>


@section('scripts_importados')
    <script>
        // Obtener información del navegador y del sistema operativo
        const platform = navigator.platform;
        document.getElementById('sistema').value = platform;

        // Obtener la geolocalización del usuario (si se permite)
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById('latitud').value = position.coords.latitude;
                document.getElementById('longitud').value = position.coords.longitude;
            });
        }

        // Obtener la página de referencia
        const referrer = document.referrer;
        document.getElementById('llegade').value = referrer;


        // Obtener la resolución de la pantalla
        const screenWidth = window.screen.width;
        const screenHeight = window.screen.height;
        document.getElementById('anchodispositivo').value = screenWidth;
        document.getElementById('largodispositivo').value = screenHeight;
    </script>

    <script>
        function alerta(message) {
            Swal.fire({
                title: message,
                icon: "error",
            });
        }


        $('#formContactos').submit(function(event) {
            event.preventDefault();

            const formData = $(this).serialize();

            Swal.fire({
                title: 'Procesando información...',
                html: '<div class="spinner"></div>',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });

            $.ajax({
                url: '{{ route('guardarContactos') }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    Swal.close();
                    $('#text-nombre').html('¡Hola ' + response.data.full_name + '!');

                    $('#modalDarTelecom').removeClass('hidden');
                    $('#formContactos')[0].reset();
                },
                error: function(error) {
                    Swal.close();
                    if (error.status === 400) {
                        const errors = error.responseJSON.message;
                        const firstError = Object.values(errors)[0][0];
                        Swal.fire({
                            title: 'Error',
                            text: firstError,
                            icon: 'error',
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Ocurrió un error inesperado. Inténtalo de nuevo.',
                            icon: 'error',
                        });
                    }
                },
            });
        });

        $('#newsletterForm').submit(function(event) {
            event.preventDefault();
            let formDataArray = $(this).serializeArray();

            if (!validarEmail($('#emailSubscriptor').val())) {
                return;
            };

            Swal.fire({

                title: 'Procesando información',
                html: `Enviando... 
                    <p class=" text-text12">Espere un momento</p>
                        <div class="max-w-2xl mx-auto overflow-hidden flex justify-center items-center mt-4 ">
                            <div role="status">
                                <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                </svg>
                                
                            </div>
                        </div>                  
                        `,
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '{{ route('guardarSubscriptor') }}',
                method: 'POST',
                data: {
                    email: $('#emailSubscriptor').val(), // Envía directamente el valor del campo de email
                    _token: $('input[name="_token"]').val() // Incluye el token CSRF
                },
                success: function(response) {
                    Swal.close();
                    Swal.fire({
                        title: response.message,
                        icon: "success",
                    });
                    $('#newsletterForm')[0].reset();
                },
                error: function(error) {
                    Swal.close();
                    console.log(error);
                }
            });
        });
    </script>


@stop

@stop

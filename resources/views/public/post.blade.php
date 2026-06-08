 @extends('components.public.matrix', ['pagina' => 'blog'])
 @section('titulo', $post->titulo)

 @section('css_importados')

 @stop


 @section('content')

     <main class="bg-white">

         <section class="pt-32 w-11/12 lg:max-w-7xl mx-auto">
             <div class="flex flex-col text-center items-center max-w-6xl mx-auto">
                 <div class="flex gap-4">
                     <h3 class="font-bold text-colorRojo text-text12 md:text-text16"> {{ $post->category->nombre }} </h3>
                     <span class="font-bold text-colorRojo text-text12 md:text-text16">|</span>
                     <h3 class="font-bold text-colorRojo text-text16 ">Publicado
                         {{ \Carbon\Carbon::parse($post->fecha_publicacion)->translatedFormat('d F, Y') }}</h3>
                 </div>
                 <h2 class=" text-colorAzulOscuro text-text32 lg:text-text48 font-bold">{{ $post->titulo }}
                 </h2>
             </div>
         </section>


         <section class="w-11/12 lg:max-w-7xl mx-auto pb-12 mt-8" data-aos="fade-up" data-aos-offset="150"
             data-aos-duration="1000" data-aos-delay="200">

             @if ($post->imagen)
                <div class="w-full" data-aos="fade-up" data-aos-offset="150">
                    <img src="{{ asset($post->imagen) }}" alt="{{ $post->titulo }}"
                        class="w-full aspect-[16/10] object-cover rounded-xl" />
                </div>
            @endif

             <div class="prose prose-lg  max-w-7xl mt-8 text-start" data-aos="fade-up" data-aos-offset="150"
                 data-aos-duration="1000" data-aos-delay="200">
                 {!! $post->descripcion !!}
             </div>
             <div class="flex text-colorRojo flex-col gap-2 mt-8" data-aos="fade-up" data-aos-offset="150"
                 data-aos-duration="1000" data-aos-delay="200">
                 <p class="font-bold text-text16"> compartir</p>

                 <!-- Botones para compartir -->
                 <div class="flex gap-4">
                     <!-- Copiar enlace -->
                     <button onclick="copyLink()" class="px-3 py-2 bg-colorBackgroundAzulClaro rounded-full">
                         <i class="fa-solid fa-link"></i>
                     </button>

                     <!-- Compartir en LinkedIn -->
                     <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                         target="_blank" class="px-3 py-2 bg-colorBackgroundAzulClaro rounded-full">
                         <i class="fa-brands fa-linkedin"></i>
                     </a>

                     <!-- Compartir en X (Twitter) -->
                     <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->titulo) }}&url={{ urlencode(url()->current()) }}"
                         target="_blank" class="px-3 py-2 bg-colorBackgroundAzulClaro rounded-full">
                         <i class="fa-brands fa-x-twitter"></i>
                     </a>

                     <!-- Compartir en Facebook -->
                     <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                         target="_blank" class="px-3 py-2 bg-colorBackgroundAzulClaro rounded-full">
                         <i class="fa-brands fa-facebook"></i>
                     </a>
                 </div>
             </div>

         </section>

         @if (count($postsrelacionados) > 0)
             <section class="w-11/12 lg:max-w-7xl mx-auto" data-aos="fade-up" data-aos-offset="150" data-aos-duration="1000"
                 data-aos-delay="200">
                 <div class="flex flex-col gap-5">
                     <div class="flex  gap-3 flex-col w-full justify-start mb-4">
                         <h2 class="font-gotham_bold text-colorAzulOscuro text-4xl lg:text-5xl">Otras publicaciones</span>
                         </h2>
                         <!--p class="text-colorParrafo text-text18">Nam tempor diam quis urna maximus, ac laoreet arcu
                                                                                             convallis. Aenean
                                                                                             dignissim nec sem quis
                                                                                             consequat.</p-->
                     </div>

                     <div class="w-full mb-16" data-aos="fade-up" data-aos-offset="150" data-aos-duration="1000"
                         data-aos-delay="200">
                         <div class="swiper slider_blog h-max">
                             <div class="swiper-wrapper">

                                 @foreach ($postsrelacionados as $post)
                                     <div class="swiper-slide" data-aos="fade-up" data-aos-offset="150"
                                         data-aos-duration="1000" data-aos-delay="200">
                                         <a href="{{ route('detalleBlog', $post->slug) }}">
                                             <div data-aos="fade-down" class="flex flex-col w-full">
                                                 <a href="{{ route('detalleBlog', $post->slug) }}">
                                                     <div class="flex flex-row justify-center">
                                                         <img class="w-full h-[300px] object-cover rounded-xl"
                                                             src="{{ asset($post->imagen) }}"
                                                             onerror="this.onerror=null;this.src='{{ asset('images/img/noimagen.jpg') }}';" />
                                                     </div>
                                                     <div class=" flex flex-col gap-3 mt-4">

                                                         <div class="flex flex-col justify-center items-start">
                                                             <p class="text-text16 font-bold text-colorRojo">
                                                                 {{ $post->category->nombre }}</p>
                                                             <h2
                                                                 class=" text-colorAzulOscuro text-text24 line-clamp-3 font-bold">
                                                                 {{ $post->titulo }}
                                                             </h2>
                                                         </div>
                                                         <div class=" text-colorParrafo text-18 text-justify line-clamp-3">
                                                             {!! $post->extracto ?? $post->descripcion !!}</div>
                                                         <p
                                                             class="flexjustify-start gap-4 text-colorRojo text-text14 font-medium">
                                                             <span>{{ \Carbon\Carbon::parse($post->fecha_publicacion)->translatedFormat('d F, Y') }}</span>
                                                             .

                                                             <span id="last-read-{{ $post->id }}">Cargando...</span>
                                                         </p>
                                                     </div>
                                                 </a>
                                             </div>
                                         </a>
                                     </div>
                                 @endforeach

                             </div>
                         </div>
                     </div>
                 </div>
             </section>
         @endif
     </main>


 @section('scripts_importados')

     <script>
         var swiper = new Swiper(".slider_blog", {
             slidesPerView: 3,
             spaceBetween: 30,
             centeredSlides: false,
             initialSlide: 0,
             grabCursor: true,
             loop: true,
             autoplay: {
                 delay: 2000,
                 disableOnInteraction: true,
             },
             breakpoints: {
                 0: {
                     slidesPerView: 1,

                 },
                 640: {
                     slidesPerView: 2,

                 },
                 750: {
                     slidesPerView: 3,

                 },
                 1250: {
                     slidesPerView: 3,

                 },
             },
             pagination: {
                 el: ".swiper-pagination_productos",
                 clickable: true,
             },
         });
     </script>
     <script>
         // Función para calcular el tiempo relativo
         function getRelativeTime(diffInMinutes) {
             if (diffInMinutes < 1) {
                 return "Leído hace menos de un minuto";
             } else if (diffInMinutes < 60) {
                 return `Leído hace ${diffInMinutes} ${diffInMinutes === 1 ? 'minuto' : 'minutos'}`;
             } else if (diffInMinutes < 1440) {
                 const diffInHours = Math.floor(diffInMinutes / 60);
                 return `Leído hace ${diffInHours} ${diffInHours === 1 ? 'hora' : 'horas'}`;
             } else {
                 const diffInDays = Math.floor(diffInMinutes / 1440);
                 return `Leído hace ${diffInDays} ${diffInDays === 1 ? 'día' : 'días'}`;
             }
         }


         // Función para actualizar el texto del último tiempo leído
         function updateLastReadTime(postId) {
             const spanElement = document.getElementById(`last-read-${postId}`);

             if (!spanElement) return;

             // Obtener la última lectura del localStorage
             const lastRead = localStorage.getItem(`blog_${postId}_last_read`);

             if (lastRead) {
                 const lastReadDate = new Date(lastRead);
                 const now = new Date();
                 const diffInMinutes = Math.floor((now - lastReadDate) / (1000 * 60));

                 // Mostrar el tiempo relativo
                 spanElement.innerText = getRelativeTime(diffInMinutes);
             } else {
                 spanElement.innerText = "No ha sido leído aún.";
             }
         }


         // Función para registrar la lectura en localStorage
         function markAsRead(postId) {
             localStorage.setItem(`blog_${postId}_last_read`, new Date().toISOString());
             updateLastReadTime(postId); // Actualizar el texto después de marcar como leído
         }


         document.addEventListener("DOMContentLoaded", function() {
             const postId = {{ $post->id }};
             localStorage.setItem(`blog_${postId}_last_read`, new Date().toISOString());
             updateLastReadTime({{ $post->id }});

         });

         // Actualizar el tiempo de lectura para los relacionados con el posts abierto al cargar la página
         document.addEventListener("DOMContentLoaded", function() {
             @foreach ($postsrelacionados as $post)
                 updateLastReadTime({{ $post->id }}); // Solo actualizar el texto, no marcar como leído
             @endforeach
         });
     </script>
     <script>
         function copyLink() {
             const link = "{{ url()->current() }}";
             navigator.clipboard.writeText(link).then(() => {

                 Swal.fire({

                     icon: "success",
                     title: "Enlace copiado al portapapeles.",
                     showConfirmButton: false,
                     timer: 1500

                 });
             }).catch(err => {
                 wal.fire({

                     icon: "error",
                     title: "Error al copiar el enlaces.",
                     showConfirmButton: false,
                     timer: 1500

                 });
             });
         }
     </script>

 @stop

@stop

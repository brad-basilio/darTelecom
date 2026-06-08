@extends('components.public.matrix', ['pagina' => 'blog'])
@section('titulo', 'Blog')
@section('css_importados')

@stop


@section('content')
    <main class=" pt-36 bg-white">

        <section class="w-11/12  lg:max-w-7xl mx-auto " data-aos="fade-up" data-aos-offset="150" data-aos-duration="1000"
            data-aos-delay="200">
            <div class="flex flex-col gap-1  text-left" data-aos="fade-down">
                <p class=" text-colorRojo text-text20 font-bold">blog</p>
                <h2 class=" text-colorAzul text-text32  lg:text-text48 font-bold">Descubre lo mejor:<br />
                    Publicaciones sobre el mundo del internet</h2>
                <!--p class="text-colorParrafo text-text18">Praesent non euismod arcu, eu dignissim erat. Aliquam erat
                                                                                                        volutpat..</p-->
            </div>
        </section>

        <section class="w-11/12 lg:max-w-7xl mx-auto  pt-10 flex flex-col lg:flex-row gap-10" data-aos="fade-up"
            data-aos-offset="150" data-aos-duration="1000" data-aos-delay="200">
            <div class="lg:w-1/2 flex flex-col justify-center" data-aos="fade-down">
                @if (is_null($mostRecentPost))
                @else
                    <a href="{{ route('detalleBlog', $mostRecentPost->slug) }}">
                        <div class="flex flex-col w-full bg-white bg-opacity-10 overflow-hidden rounded-xl text-left">
                            <div class="flex flex-row justify-center">
                                <img class="w-full aspect-[16/10] object-cover rounded-xl"
                                    src="{{ asset($mostRecentPost->imagen) }}"
                                    onerror="this.onerror=null;this.src='{{ asset('images/img/noimagen.jpg') }}';" />
                            </div>
                            <div class="py-6 flex flex-col gap-3">
                                <p class="text-text16 font-bold text-colorRojo">{{ $mostRecentPost->category->nombre }}</p>
                                <h2 class=" text-colorAzulOscuro text-text24 line-clamp-3 font-bold">
                                    {{ $mostRecentPost->titulo }}</h2>
                                <div class=" text-colorParrafo text-18 text-justify line-clamp-3">
                                    {!! $mostRecentPost->extracto ?? $mostRecentPost->descripcion !!}</div>
                                <p class="flexjustify-start gap-4 text-colorRojo text-text14 font-medium">
                                    <span>{{ \Carbon\Carbon::parse($mostRecentPost->fecha_publicacion)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</span>
                                    .
                                    <span id="last-read-{{ $mostRecentPost->id }}">Cargando...</span>
                                </p>
                            </div>
                        </div>
                    </a>
                @endif
            </div>
            <div class="lg:w-1/2" data-aos="fade-down" data-aos="fade-up" data-aos-offset="150" data-aos-duration="1000"
                data-aos-delay="200">

                @foreach ($nextTwoRecentPosts as $post)
                    <div class=" w-full mb-4">
                        <a href="{{ route('detalleBlog', $post->slug) }}" class="flex flex-col md:flex-row gap-4">
                            <div class="w-full md:w-2/5">
                                <img class="w-full aspect-[16/10] lg:aspect-square object-cover rounded-xl" src="{{ asset($post->imagen) }}"
                                    onerror="this.onerror=null;this.src='{{ asset('images/img/noimagen.jpg') }}';" />
                            </div>
                            <div class="flex flex-col gap-3 justify-center items-start w-full md:w-3/5 p-3 cursor-pointer">
                                <p class="text-text16 font-bold text-colorRojo">{{ $post->category->nombre }}</p>
                                <div class="flex flex-col justify-center items-start h-20">
                                    <h2 class=" text-colorAzulOscuro text-text24 line-clamp-3 font-bold">
                                        {{ $post->titulo }}
                                    </h2>
                                </div>
                                <div class=" text-colorParrafo text-18 text-justify line-clamp-3">
                                    {!! $post->extracto ?? $post->descripcion !!}</div>
                                <p class="flexjustify-start gap-4 text-colorRojo text-text14 font-medium">
                                    <span>{{ \Carbon\Carbon::parse($post->fecha_publicacion)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</span>
                                    .
                                    <span id="last-read-{{ $post->id }}">Cargando...</span>
                                </p>
                            </div>

                        </a>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="w-11/12 lg:max-w-7xl mx-auto py-20 " data-aos="fade-up" data-aos-offset="150"
            data-aos-duration="1000" data-aos-delay="200">
            <div class="flex flex-col">
                <div class="flex flex-col w-full ">
                    <h2 class=" text-colorAzulOscuro text-text48 font-semibold" data-aos="fade-down">Últimas
                        publicaciones</h2>

                    <p class="text-colorParrafo text-text18 mt-5 mb-10">Lo mas reciente en nuestro blogs, explora nuevos
                        contenidos.</p>
                </div>

                <div class="w-full">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

                        @foreach ($remainingPosts as $post)
                            <div data-aos="fade-down" class="flex flex-col w-full" data-aos="fade-up" data-aos-offset="150"
                                data-aos-duration="1000" data-aos-delay="200">
                                <a href="{{ route('detalleBlog', $post->slug) }}">
                                    <div class="flex flex-row justify-center">
                                        <img class="w-full aspect-[16/10] object-cover rounded-xl"
                                            src="{{ asset($post->imagen) }}"
                                            onerror="this.onerror=null;this.src='{{ asset('images/img/noimagen.jpg') }}';" />
                                    </div>
                                    <div class=" flex flex-col gap-3 mt-4">

                                        <div class="flex flex-col justify-center items-start">
                                            <p class="text-text16 font-bold text-colorRojo">{{ $post->category->nombre }}
                                            </p>
                                            <h2 class=" text-colorAzulOscuro text-text24 line-clamp-3 font-bold">
                                                {{ $post->titulo }}
                                            </h2>
                                        </div>
                                        <div class=" text-colorParrafo text-18 text-justify line-clamp-3">
                                            {!! $post->extracto ?? $post->descripcion !!}</div>
                                        <p class="flexjustify-start gap-4 text-colorRojo text-text14 font-medium">
                                            <span>{{ \Carbon\Carbon::parse($post->fecha_publicacion)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</span>
                                            .
                                            <span id="last-read-{{ $post->id }}">Cargando...</span>
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                    </div>

                </div>

            </div>
        </section>
    </main>


@section('scripts_importados')
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

        // Actualizar el tiempo de lectura para los posts restantes al cargar la página
        document.addEventListener("DOMContentLoaded", function() {
            @foreach ($remainingPosts as $post)
                updateLastReadTime({{ $post->id }}); // Solo actualizar el texto, no marcar como leído
            @endforeach
        });

        // Actualizar el tiempo de lectura para los próximos dos posts recientes al cargar la página
        document.addEventListener("DOMContentLoaded", function() {
            @foreach ($nextTwoRecentPosts as $post)
                updateLastReadTime({{ $post->id }}); // Solo actualizar el texto, no marcar como leído
            @endforeach
        });


        // Actualizar el tiempo de lectura para el post más reciente al cargar la página
        document.addEventListener("DOMContentLoaded", function() {
            updateLastReadTime({{ $mostRecentPost->id }}); // Solo actualizar el texto, no marcar como leído
        });
    </script>


@stop

@stop

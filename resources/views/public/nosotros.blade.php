@extends('components.public.matrix', ['pagina' => 'Nosotros'])
@section('titulo', 'Nosotros')
@section('css_importados')

@stop


@section('content')
    <main class="pt-40 bg-white">
        <!--Seccion breve historia -->
        <section class="w-11/12 lg:max-w-7xl mx-auto " data-aos="fade-up" data-aos-offset="150" data-aos-duration="1000"
            data-aos-delay="200">
            <h2 class="text-text48 mb-4 font-bold text-colorAzulOscuro">{{ $nosotros?->title }}</h2>
            <div class="prose prose-lg max-w-7xl text-text18 text-colorParrafo">
                {!! $nosotros?->breve_historia !!}
            </div>

            <img class="w-full my-16 rounded-xl object-cover h-[400px] lg:h-[629px]" src="{{ asset($nosotros?->imagen) }}"
                alt="{{ $nosotros?->title }}" data-aos="fade-up" data-aos-offset="150" data-aos-duration="1000"
                data-aos-delay="200" />
        </section>
        <!--Seccion Mision y vision-->
        <section class="bg-colorBackgroundAzulClaro">
            <div class="w-11/12 lg:max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8 py-12 " data-aos="fade-up"
                data-aos-offset="150" data-aos-duration="1000" data-aos-delay="200">

                <div class="flex justify-center">
                    <div class="flex flex-col gap-12  justify-center w-9/12 items-center">
                        <div class="flex flex-col gap-2 items-center text-center" data-aos="fade-up" data-aos-offset="150"
                            data-aos-duration="1000" data-aos-delay="200">

                            <i
                                class="fa-regular fa-lightbulb fa-xl  bg-colorBackgroundRed  rounded-full px-5 py-7 text-white"></i>

                            <h2 class="text-text32 text-colorAzulOscuro font-bold">Nuestra Misión</h2>
                            <p class="text-text18 text-colorParrafo">{{ $nosotros?->mision }}</p>

                        </div>
                        <div class="flex flex-col gap-2 items-center text-center" data-aos="fade-up" data-aos-offset="150"
                            data-aos-duration="1000" data-aos-delay="200">

                            <i
                                class="fa-regular fa-lightbulb fa-xl  bg-colorBackgroundRed  rounded-full px-5 py-7 text-white"></i>

                            <h2 class="text-text32 text-colorAzulOscuro font-bold">Nuestra Visión</h2>
                            <p class="text-text18 text-colorParrafo">{{ $nosotros?->vision }}</p>

                        </div>
                    </div>
                </div>
                <div>
                    <img src="{{ asset($nosotros?->imagen_vision_mision) }}" alt="Nuestra vision y mision"
                        class="w-full h-[400px] lg:h-[770px] object-cover rounded-xl">
                </div>
            </div>
        </section>
        <section>
            <div class="w-11/12 lg:max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8 py-12 mt-8" data-aos="fade-up"
                data-aos-offset="150" data-aos-duration="1000" data-aos-delay="200">
                <div>
                    <img src="{{ asset($nosotros?->imagen_sello_garantia) }}" alt="{{ $nosotros?->sello_garantia_titulo }}"
                        class="w-full  lg:h-[518px] object-contain lg:object-cover rounded-xl">
                </div>

                <div class="flex flex-col gap-12">

                    <div class="flex flex-col gap-2 items-start">

                        <span class="text-text18 text-colorRojo">{{ $nosotros?->sello_garantia_subtitulo }}</span>

                        <h2 class="text-text32 text-colorAzulOscuro font-bold">{{ $nosotros?->sello_garantia_titulo }}</h2>

                        <div class="prose text-text18 text-colorParrafo">
                            {!! $nosotros?->sello_garantia_contenido !!}
                        </div>
                    </div>

                </div>

            </div>
        </section>
        <!-- Newsletter Section -->
        @include('components.custom.newsletter-section')










    </main>

@section('scripts_importados')


@stop

@stop

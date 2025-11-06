<div class="hidden md:grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach ($beneficios as $index => $beneficio)
        <div data-aos="fade-up" data-aos-offset="150" data-aos-duration="1000" data-aos-delay="200"
            class=" cursor-pointer bg-colorBackgroundAzulClaro p-6 text-start flex flex-col items-start rounded-xl">
            <div class=" h-10 w-10 bg-colorBackgroundRed"
                style="mask-image: url('{{ asset($icono) }}'); mask-size: cover; mask-repeat: no-repeat;"">
            </div>
            <h4 class="font-semibold mb-2 text-colorAzulOscuro text-text28">Beneficio {{ $index + 1 }}</h4>
            <p class="text-colorParrafo text-text16">{{ $beneficio }}</p>
        </div>
    @endforeach
</div>
<div class="md:hidden w-full">
    <div class="swiper beneficios-mobile-swiper">
        <div class="swiper-wrapper">
            @foreach ($beneficios as $index => $beneficio)
                <div class="swiper-slide">
                    <div class="cursor-pointer bg-colorBackgroundAzulClaro p-4 text-start flex flex-col items-start rounded-xl w-full h-full min-h-[160px]">
                        <div class="h-8 w-8 bg-colorBackgroundRed mb-3 flex-shrink-0"
                            style="mask-image: url('{{ asset($icono) }}'); mask-size: cover; mask-repeat: no-repeat;">
                        </div>
                        <h4 class="font-semibold mb-2 text-colorAzulOscuro text-lg">Beneficio {{ $index + 1 }}</h4>
                        <p class="text-colorParrafo text-sm flex-grow">{{ $beneficio }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination mt-4"></div>
    </div>
</div>
<style>
    .beneficios-mobile-swiper {
        width: 100%;
        height: auto;
    }

    .beneficios-mobile-swiper .swiper-slide {
        height: auto;
        display: flex;
        min-width: 250px;
    }

    .beneficios-mobile-swiper .swiper-pagination {
        position: static !important;
        margin-top: 20px;
    }

    .beneficios-mobile-swiper .swiper-pagination-bullet {
        background-color: #ed1b2f;
        opacity: 0.4;
        width: 8px;
        height: 8px;
    }

    .beneficios-mobile-swiper .swiper-pagination-bullet-active {
        opacity: 1;
        background-color: #ed1b2f;
    }
</style>

<script>
// Función global para inicializar el swiper de beneficios
function initBeneficiosSwiper() {
    if (typeof Swiper !== 'undefined') {
        // Destruir instancia anterior si existe
        const existingSwiper = document.querySelector('.beneficios-mobile-swiper');
        if (existingSwiper && existingSwiper.swiper) {
            existingSwiper.swiper.destroy(true, true);
        }
        
        // Crear nueva instancia
        if (document.querySelector('.beneficios-mobile-swiper')) {
            const beneficiosSwiper = new Swiper('.beneficios-mobile-swiper', {
                slidesPerView: 1.2,
                spaceBetween: 16,
                centeredSlides: false,
                pagination: {
                    el: '.beneficios-mobile-swiper .swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    480: {
                        slidesPerView: 2,
                        spaceBetween: 16,
                    },
                    640: {
                        slidesPerView: 2.5,
                        spaceBetween: 20,
                    }
                }
            });
        }
    }
}

// Inicializar cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(initBeneficiosSwiper, 100);
});

// Inicializar cuando se carga contenido nuevo via AJAX
window.addEventListener('contenidoCargado', function() {
    setTimeout(initBeneficiosSwiper, 200);
});
</script>

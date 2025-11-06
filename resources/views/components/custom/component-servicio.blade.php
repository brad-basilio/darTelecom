   <style>
       .swiper {
           width: 100%;
           height: 100%;
       }

       .swiper-slide {
           text-align: center;
           font-size: 18px;
           background: #fff;
           display: flex;
           justify-content: center;
           align-items: center;
       }

       .swiper-slide img {
           display: block;
           width: 100%;
           height: 100%;
           object-fit: cover;
       }

       .swiper-pagination-bullet {
           height: 15px;
           width: 15px;
           background-color: #eff1fb;


       }

       .swiper-pagination-bullet-active {
           background-color: #ed1b2f;
       }
   </style>


   <div class="flex flex-col md:flex-row items-start md:justify-between md:items-center mb-4 md:mb-0" data-aos="fade-up"
       data-aos-offset="150" data-aos-duration="1000" data-aos-delay="200">
       <div class="max-w-[90%]">
           <h2 class="text-colorRojo text-text32 font-extrabold">{{ $servicio->title }}</h2>
           <h3 class="text-text32 font-semibold mb-4">{{ $servicio->subtitle }}</h3>
       </div>
       <x-custom.button-cotizar :general="$general" text="CONTÁCTANOS" />
   </div>

   @if($album && $album->images && $album->images->count() > 0)
   <div class="mb-8" data-aos="fade-up" data-aos-offset="150" data-aos-duration="1000" data-aos-delay="200">
       <div x-data="{}" x-init="new Swiper('.mySwiper', {
           loop: true,
           slidesPerView: 1,
           spaceBetween: 30,
           pagination: {
               el: '.swiper-pagination',
               clickable: true,
           },
           navigation: {
               nextEl: '.swiper-button-next',
               prevEl: '.swiper-button-prev',
           },
       });">
           <div class="swiper mySwiper">
               <div class="swiper-wrapper">
                   @foreach ($album->images as $image)
                       <div class="swiper-slide">
                           <div class="rounded-xl overflow-hidden w-full">
                               <img class="w-full !aspect-square lg:!aspect-video rounded-lg cursor-pointer object-cover"
                                   src="{{ asset($image->url_image) }}" alt="{{ $image->name_image }}">
                           </div>
                       </div>
                   @endforeach
               </div>

               <!-- Paginación -->
               <div class="swiper-pagination"></div>


           </div>
       </div>
   </div>
   @endif





   <div id="descripcion_extensa" class="prose prose-lg max-w-7xl text-colorParrafo text-text18" data-aos="fade-up"
       data-aos-offset="150" data-aos-duration="1000" data-aos-delay="200">
       {!! $servicio->descripcion_extensa !!}
   </div>

   <!-- Benefits Section -->
   <x-custom.servicio-beneficio :text="$servicio->beneficios" :icono="$servicio->icono" />

   <!-- Call to Action -->
   <div class="text-start mt-8" hidden>
       <x-custom.button-cotizar :general="$general" text="Cotizar Servicio" />
   </div>

<style>
    /* Estilos básicos para los modales */
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100vw;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        overflow: auto;

    }

    .modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 20px;
        border-radius: 8px;
        width: 90%;
        max-width: 900px;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .close-modal {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close-modal:hover {
        color: #000;
    }

    /* Asegúrate de que el modal-body tenga scroll */
    .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }
</style>

<footer class="bg-colorBackgroundAzulOscuro relative  overflow-hidden z-10 ">
    <div class="absolute left-0   transform  rotate-[60deg] -z-10 ">
        <img src="{{ asset('images/img/background/bg-footer.png') }}" alt="" class="w-full">
    </div>
    <div class="grid grid-cols-1 w-11/12 lg:max-w-7xl mx-auto   py-10 lg:py-16 gap-10 md:gap-5 z-50">
        <div class=" grid grid-cols-1  lg:grid-cols-2  gap-10 lg:gap-5 col-span-1">
            <div>
                <a href="{{ route('index') }}">
                    <img src="{{ asset('images/img/logo/DarTelecom.png') }}" class="w-48 h-auto object-cover" />
                </a>
                <p class="text-white mt-8">
                    {{ $general?->aboutus }}
                </p>
            </div>
            <div class="grid grid-cols-1  md:grid-cols-2 gap-4">
                <div class="flex flex-col gap-5">

                    <div class="flex flex-col gap-4 text-white font-gotham_light text-base font-bold">
                        <a href="{{ route('index') }}">Inicio</a>
                        <a href="{{ route('nosotros') }}">Nosotros</a>
                        <a href="{{ route('servicios') }}">Servicios</a>
                        <a href="{{ route('catalogo.all') }}">Equipos</a>
                        <a href="{{ route('blog.all') }}">Blogs</a>
                        <a href="{{ route('contacto') }}">Contacto</a>
                    </div>
                </div>




                <div class="flex flex-col gap-5 pt-4 border-t-2 md:border-none md:pt-0">

                    <div class="flex flex-col gap-4 text-white font-gotham_light text-base">
                        <a>{{ $general?->cellphone }}</a>
                        <a>{{ $general?->email }}</a>
                        <a>{{ $general?->schedule }}</a>


                        <a> {{ $general?->address }} -

                            {{ $general?->district }} - {{ $general?->city }}</a>


                    </div>
                    <div class="flex gap-4 mt-4">
                        <a target="_blank" href="{{ $general?->instagram }}"
                            class="flex justify-start items-center gap-2 text-white font-roboto font-normal text-text14">
                            <i class="fa-brands fa-instagram fa-xl"></i>

                        </a>
                        <a target="_blank" href="{{ $general?->facebook }}"
                            class="flex justify-start items-center gap-2 text-white font-roboto font-normal text-text14">
                            <i class="fa-brands fa-facebook-f fa-xl"></i>
                        </a>
                        <a target="_blank" href="{{ $general?->linkedin }}"
                            class="flex justify-start items-center gap-2 text-white font-roboto font-normal text-text14">
                            <i class="fa-brands fa-linkedin-in fa-xl"></i>
                        </a>
                        <a target="_blank" href="{{ $general?->tiktok }}"
                            class="flex justify-start items-center gap-2 text-white font-roboto font-normal text-text14">
                            <i class="fa-brands fa-tiktok fa-xl"></i>
                        </a>
                        <a target="_blank"
                            href="https://wa.me/{{ $general?->whatsaap }}?text={{ $general?->mensaje_whatsapp }}."
                            class="flex justify-start items-center gap-2 text-white font-roboto font-normal text-text14">
                            <i class="fa-brands fa-whatsapp fa-xl"></i>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div
        class="flex flex-col lg:flex-row justify-between items-start  gap-3 w-11/12 lg:max-w-7xl mx-auto py-12 border-t-2 border-white z-50">
        <a href="#" target="_blank" class="text-white  text-sm ">Copyright &copy;
            2025 Dar Telecom. Reservados todos los derechos</a>

        <div class="flex w-full lg:w-1/2 justify-between items-center lg:justify-end lg:gap-16 text-white">
            <a class="block cursor-pointer text-text12 lg:text-text16 text-colorParrafo" id="linkTerminos">
                Terminos de servicios
            </a>
            <a class="block cursor-pointer text-text12 lg:text-text16 text-colorParrafo" id="linkPoliticas">
                Políticas de privacidad
            </a>
        </div>
    </div>

    <!-- Añade esto en tu footer, antes del cierre </footer> -->
    <div id="modalTerminosCondiciones" class="modal" style="display: none;max-width: 100vw;">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-gotham_bold text-2xl">Términos y condiciones</h2>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body p-4" style="height: 70vh; overflow-y: auto;">
                <div class="font-gotham_book p-2 prose">{!! $termsAndCondicitions?->content ?? '' !!}</div>
            </div>
        </div>
    </div>

    <div id="modalPoliticasDev" class="modal" style="display: none; max-width: 100vw;">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-gotham_bold text-2xl">Políticas de privacidad</h2>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body p-4" style="height: 70vh; overflow-y: auto;">
                <div class="font-gotham_book p-2 prose">{!! $politicDev?->content ?? '' !!}</div>
            </div>
        </div>
    </div>
    <div class="md:hidden absolute left-0 bottom-0   transform  rotate-[0deg] -z-10 ">
        <img src="{{ asset('images/img/background/bg-footer.png') }}" alt="" class="w-full">
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Función para abrir modal
        function openModal(modalId) {
            $('#' + modalId).fadeIn(400);
            $('body').css('overflow', 'hidden');
        }

        // Función para cerrar modal
        function closeModal(modalId) {
            $('#' + modalId).fadeOut(400);
            $('body').css('overflow', 'auto');
        }

        // Eventos para abrir modales
        $('#linkTerminos').on('click', function() {
            openModal('modalTerminosCondiciones');
        });

        $('#linkPoliticas').on('click', function() {
            openModal('modalPoliticasDev');
        });

        // Cerrar al hacer clic en la X
        $('.close-modal').on('click', function() {
            closeModal($(this).closest('.modal').attr('id'));
        });

        // Cerrar al hacer clic fuera del modal
        $(window).on('click', function(event) {
            if ($(event.target).hasClass('modal')) {
                closeModal($(event.target).attr('id'));
            }
        });
    });
</script>

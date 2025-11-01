<x-app-layout title="Servicios">
    <div class="px-4 sm:px-6 lg:px-8 w-full max-w-9xl mx-auto border-b border-gray-200 dark:border-gray-700">
        <!-- Navegación de Tabs -->
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
            <!-- Tab CRUD Servicios -->
            <li class="me-2">
                <a href="#"
                    class="tab-link text-colorAzulOscuro font-semibold border-b-2 border-[#000f25] inline-flex items-center justify-center p-4 rounded-t-lg group"
                    data-target="tab-crud-servicios">
                    <i class="fa-solid fa-database fa-lg mr-4"></i>
                    Gestión de Servicios
                </a>
            </li>
            <!-- Tab Página de Servicios -->
            <li class="me-2">
                <a href="#"
                    class="tab-link inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg font-semibold hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group"
                    data-target="tab-pagina-servicios">
                    <i class="fa-solid fa-pager fa-lg mr-4"></i>
                    Contenido de Página
                </a>
            </li>
        </ul>
    </div>


    <div class="tab-content px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto" id="tab-crud-servicios">

        <section class="py-4 border-b border-slate-100 dark:border-slate-700">
            <a href="{{ route('servicios.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded text-sm">Crear
                servicio</a>
        </section>


        <div
            class="col-span-full xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">


            <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                <h2 class="font-semibold text-slate-800 dark:text-slate-100 text-2xl tracking-tight">Servicios</h2>
            </header>
            <div class="p-3">

                <!-- Table -->
                <div class="overflow-x-auto">

                    <table id="tabladatos" class="display text-lg" style="width:100%">
                        <thead>
                            <tr>
                                <th>Titulo</th>
                                <th class="w-80">Descripcion Breve</th>
                                <th>Icono</th>
                                <th class="w-56">Imagen Principal</th>
                                <th>Subservicios</th>
                                <th>Visible</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($servicios as $item)
                                <tr>
                                    <td>{{ $item->title }}</td>
                                    <td class="w-80 line-clamp-2">{{ $item->descripcion_breve }}</td>
                                    <td class="px-3 py-2 ">
                                        <div class=" h-10 w-10 bg-colorBackgroundAzulOscuro"
                                            style="mask-image: url('{{ asset($item->icono) }}'); mask-size: contain; mask-repeat: no-repeat;"">
                                        </div>
                                    </td>
                                    <td class="w-56">
                                        @if($item->imagen_principal)
                                            <img src="{{ asset($item->imagen_principal) }}" alt="{{ $item->title }}" 
                                                 class="w-20 h-12 object-cover rounded">
                                        @else
                                            <span class="text-gray-500 text-sm">Sin imagen</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $item->subServices->count() }} subservicios
                                        </span>
                                        <br>
                                        <a href="{{ route('subservicios.index', $item->id) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-xs mt-1 inline-block">
                                            Gestionar
                                        </a>
                                    </td>
                                    <td>
                                        <input type="checkbox" id="hs-basic-usage"
                                            class="check_v btn_swithc relative w-[3.25rem] h-7 p-px bg-gray-100 border-transparent text-transparent 
        rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none 
        checked:bg-none checked:text-blue-600 checked:border-blue-600 focus:checked:border-blue-600 dark:bg-gray-800 dark:border-gray-700 
        dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-600 before:inline-block before:size-6
        before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow 
        before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-gray-400 dark:checked:before:bg-blue-200"
                                            data-field="visible" data-idService="{{ $item->id }}"
                                            data-titleService="{{ $item->title }}"
                                            {{ $item->visible == 1 ? 'checked' : '' }}>
                                        <label for="v_{{ $item->id }}"></label>
                                    </td>
                                    <td class="flex flex-row justify-end items-center gap-5">

                                        <a href="{{ route('servicios.edit', $item->id) }}"
                                            class="bg-yellow-400 px-3 py-2 rounded text-white  "><i
                                                class="fa-regular fa-pen-to-square"></i></a>
                                        {{-- {{  route('servicios.destroy', $item->id) }} --}}
                                        <form action="" method="POST">
                                            @csrf
                                            <a data-idService='{{ $item->id }}'
                                                class="btn_delete bg-red-600 px-3 py-2 rounded text-white cursor-pointer"><i
                                                    class="fa-regular fa-trash-can"></i></a>
                                            <!-- <a href="" class="bg-red-600 p-2 rounded text-white"><i class="fa-regular fa-trash-can"></i></a> -->
                                        </form>

                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Titulo</th>
                                <th>Descripcion Breve</th>
                                <th>Icono</th>
                                <th>Imagen Principal</th>
                                <th>Subservicios</th>
                                <th>Visible</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>

    </div>
    <div class="tab-content px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto hidden" id="tab-pagina-servicios">


        <div class="p-3 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
            <div class="rounded  p-4 px-4 ">
                <form id="update-servicio-page-form" action="{{ route('servicio.page.update', $servicioPage->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <header class=" py-4 border-b border-slate-100 dark:border-slate-700">
                        <h2 class="font-semibold text-slate-800 dark:text-slate-100 text-2xl tracking-tight">
                            Actualizar
                            contenido de la Web</h2>
                    </header>
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                        <div class="md:col-span-5">
                            <label for="titulo">Título de página</label>
                            <div class="relative mb-2  mt-2">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </div>
                                <input type="text" id="titulo" name="titulo" value="{{ $servicioPage->titulo }}"
                                    class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Titulo">
                            </div>
                        </div>
                        <div class="md:col-span-5">
                            <label for="subtitulo">Subtítulo de página</label>
                            <div class="relative mb-2  mt-2">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </div>
                                <textarea type="text" id="subtitulo" name="subtitulo"
                                    class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Subtitulo">{{ $servicioPage->subtitulo }}</textarea>
                            </div>
                        </div>
                        <div class="md:col-span-5 ">
                            <label>Imagen Banner </label>
                            <div
                                class="h-40 mt-2 py-4 flex flex-row justify-center border items-center border-gray-300 rounded-xl bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                                <img src="{{ asset($servicioPage->imagen) }}" alt=""
                                    class="w-full h-full object-cover ">
                            </div>

                        </div>

                        <div class="md:col-span-5">
                            <label for="imagen">Actualizar Imagen</label>
                            <div class="relative mb-2  mt-2">

                                <input name="imagen"
                                    class="p-2.5 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                    id="imagen" type="file" accept="image/*">
                            </div>
                        </div>
                        <div class="md:col-span-5 text-right mt-6 flex justify-between">

                            <div class="inline-flex items-end">
                                <a href="{{ URL::previous() }}"
                                    class="bg-red-500 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded">Volver</a>
                            </div>

                            <div class="inline-flex items-end">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- Estilos para SweetAlert2 -->
    <style>
        .swal2-confirm {
            background-color: #dc2626 !important;
            color: white !important;
            border: none !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem 1rem !important;
            font-weight: 500 !important;
            margin-right: 0.5rem !important;
        }
        
        .swal2-confirm:hover {
            background-color: #b91c1c !important;
        }
        
        .swal2-cancel {
            background-color: #6b7280 !important;
            color: white !important;
            border: none !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem 1rem !important;
            font-weight: 500 !important;
            margin-left: 0.5rem !important;
        }
        
        .swal2-cancel:hover {
            background-color: #4b5563 !important;
        }
        
        .swal2-actions {
            gap: 0.5rem !important;
        }
    </style>

    <script>
        $('document').ready(function() {

            new DataTable('#tabladatos', {
                responsive: true
            });

            $(document).on("click", ".btn_delete", function(e) {

                var id = $(this).attr('data-idService');

                Swal.fire({
                    title: "¿Seguro que deseas eliminar?",
                    text: "Eliminaras el Servicio y sus recursos asociados, ¿Desea continuar?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({

                            url: '{{ route('servicio.borrar') }}',
                            method: 'POST',
                            data: {
                                _token: $('input[name="_token"]').val(),
                                id: id,

                            }

                        }).done(function(res) {

                            Swal.fire({
                                title: res.message,
                                icon: "success"
                            });

                            location.reload();

                        })


                    }
                });

            });


            $(document).on("change", ".btn_swithc", function() {
                var visible = 0;
                var id = $(this).attr('data-idService');
                var titleService = $(this).attr('data-titleService'); // Agregar titleService aquí

                // Verifica si está marcado o no
                if ($(this).is(':checked')) {
                    visible = 1; // Establecer status como 1 si está marcado
                } else {
                    visible = 0; // Establecer status como 0 si no está marcado
                }

                $.ajax({
                    url: "{{ route('servicio.updateVisible') }}",
                    method: 'POST',
                    data: {
                        _token: $('input[name="_token"]').val(),
                        visible: visible,
                        id: id
                    },
                    success: function(res) {
                        // Mostrar el mensaje usando el título del servicio que regresamos desde el backend
                        Swal.fire({

                            icon: "success",
                            title: titleService + " ahora es " + (visible == 1 ?
                                "Visible" : "No Visible"
                            ), // Mostrar el mensaje dinámico
                            showConfirmButton: true,
                            timer: 1500
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Algo salió mal, por favor intente de nuevo.'
                        });
                    }
                });
            });

            // Enviar formulario con AJAX
            $('#update-servicio-page-form').on('submit', function(e) {
                e.preventDefault(); // Evitar que se envíe el formulario normalmente

                var formData = new FormData(this); // Recoger todos los datos del formulario

                $.ajax({
                    url: "{{ route('servicio.page.update', $servicioPage->id) }}", // URL de la ruta
                    type: 'POST', // Usamos POST
                    data: formData, // Los datos a enviar
                    processData: false, // No procesar los datos
                    contentType: false, // No definir el tipo de contenido (para que FormData maneje los archivos correctamente)
                    success: function(response) {
                        // Si la actualización es exitosa
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Página actualizada correctamente.',
                            showConfirmButton: true
                        }).then(() => {
                            // Redirigir o realizar alguna otra acción después de la confirmación
                            window.location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        // Si ocurre un error
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: 'Ocurrió un error al actualizar los datos.',
                            showConfirmButton: true
                        });
                    }
                });
            });


        })
    </script>
    <script>
        const tabs = document.querySelectorAll('.tab-link');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();

                // Remover clases activas de todos los tabs y ocultar contenidos
                tabs.forEach(t => t.classList.remove('text-colorAzulOscuro', 'border-[#000f25]'));
                tabContents.forEach(content => content.classList.add('hidden'));

                // Agregar clase activa al tab seleccionado
                tab.classList.add('text-colorAzulOscuro', 'border-[#000f25]');

                // Mostrar el contenido relacionado con el tab seleccionado
                const target = tab.getAttribute('data-target');
                document.getElementById(target).classList.remove('hidden');
            });
        });
    </script>
</x-app-layout>

<x-app-layout title="Subservicios de {{ $service->title }}">
    <div class="px-4 sm:px-6 lg:px-8 w-full max-w-9xl mx-auto pt-8">
        <!-- Header con información del servicio padre -->
        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="h-12 w-12 bg-blue-600 mr-4"
                         style="mask-image: url('{{ asset($service->icono) }}'); mask-size: contain; mask-repeat: no-repeat;">
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $service->title }}</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $service->descripcion_breve }}</p>
                    </div>
                </div>
                <a href="{{ route('servicios.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded">
                    Volver a Servicios
                </a>
            </div>
        </div>

        <section class="py-4 border-b border-slate-100 dark:border-slate-700">
            <a href="{{ route('subservicios.create', $service->id) }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded text-sm">
                Crear Subservicio
            </a>
        </section>

        <div class="col-span-full xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
            <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                <h2 class="font-semibold text-slate-800 dark:text-slate-100 text-2xl tracking-tight">
                    Subservicios de {{ $service->title }}
                </h2>
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
                                <th class="w-56">Beneficios</th>
                                <th>Visible</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subservicios as $item)
                                <tr>
                                    <td>{{ $item->title }}</td>
                                    <td class="w-80 line-clamp-2">{{ $item->descripcion_breve }}</td>
                                    <td class="px-3 py-2">
                                        @if($item->icono)
                                        <div class="h-10 w-10 bg-colorBackgroundAzulOscuro"
                                             style="mask-image: url('{{ asset($item->icono) }}'); mask-size: contain; mask-repeat: no-repeat;">
                                        </div>
                                        @else
                                        <span class="text-gray-500 text-sm">Sin icono</span>
                                        @endif
                                    </td>
                                    <td class="w-56 line-clamp-2">{{ $item->beneficios }}</td>
                                    <td>
                                        <input type="checkbox" id="hs-basic-usage"
                                            class="check_v btn_swithc relative w-[3.25rem] h-7 p-px bg-gray-100 border-transparent text-transparent 
                                                   rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none 
                                                   checked:bg-none checked:text-blue-600 checked:border-blue-600 focus:checked:border-blue-600 dark:bg-gray-800 dark:border-gray-700 
                                                   dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-600 before:inline-block before:size-6
                                                   before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow 
                                                   before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-gray-400 dark:checked:before:bg-blue-200"
                                            data-field="visible" data-idSubService="{{ $item->id }}"
                                            data-titleSubService="{{ $item->title }}"
                                            {{ $item->visible == 1 ? 'checked' : '' }}>
                                    </td>
                                    <td class="flex flex-row justify-end items-center gap-5">
                                        <a href="{{ route('subservicios.edit', [$service->id, $item->id]) }}"
                                            class="bg-yellow-400 px-3 py-2 rounded text-white">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <form action="" method="POST">
                                            @csrf
                                            <a data-idSubService='{{ $item->id }}'
                                                class="btn_delete bg-red-600 px-3 py-2 rounded text-white cursor-pointer">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
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
                                <th>Beneficios</th>
                                <th>Visible</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
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
                var id = $(this).attr('data-idSubService');

                Swal.fire({
                    title: "¿Seguro que deseas eliminar?",
                    text: "Eliminaras el Subservicio y sus recursos asociados, ¿Desea continuar?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('subservicio.borrar', $service->id) }}',
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
                var id = $(this).attr('data-idSubService');
                var titleSubService = $(this).attr('data-titleSubService');

                if ($(this).is(':checked')) {
                    visible = 1;
                } else {
                    visible = 0;
                }

                $.ajax({
                    url: "{{ route('subservicio.updateVisible') }}",
                    method: 'POST',
                    data: {
                        _token: $('input[name="_token"]').val(),
                        visible: visible,
                        id: id
                    },
                    success: function(res) {
                        Swal.fire({
                            icon: "success",
                            title: titleSubService + " ahora es " + (visible == 1 ? "Visible" : "No Visible"),
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
        })
    </script>
</x-app-layout>
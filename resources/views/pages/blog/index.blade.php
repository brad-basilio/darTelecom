<x-app-layout title="Blogs">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <section class="py-4 border-b border-slate-100 dark:border-slate-700">
            <a href="{{ route('blog.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded text-sm">Crear post</a>
        </section>


        <div
            class="col-span-full xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">


            <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                <h2 class="font-semibold text-slate-800 dark:text-slate-100 text-2xl tracking-tight">Publicaciones</h2>
            </header>
            <div class="p-3">

                <!-- Table -->
                <div class="overflow-x-auto">

                    <table id="tabladatos" class="display text-lg" style="width:100%">
                        <thead>
                            <tr>
                                <th>Titulo</th>
                                <th>Categoría</th>
                                <th>Imagen</th>
                                <th>Visible</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($posts as $item)
                                <tr>
                                    <td>{{ $item->titulo }}</td>
                                    <td>{{ $item->category->nombre }}</td>
                                    <td class="px-3 py-2"><img class="w-20" src="{{ asset($item->imagen) }}"
                                            alt=""></td>
                                    <td>
                                        <form method="POST" action="">
                                            @csrf
                                            <input type="checkbox" id="hs-basic-usage"
                                                class="check_v btn_swithc relative w-[3.25rem] h-7 p-px bg-gray-100 border-transparent text-transparent 
                                            rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none 
                                            checked:bg-none checked:text-blue-600 checked:border-blue-600 focus:checked:border-blue-600 dark:bg-gray-800 dark:border-gray-700 
                                            dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-600 before:inline-block before:size-6
                                            before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow 
                                            before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-gray-400 dark:checked:before:bg-blue-200"
                                                id='{{ 'v_' . $item->id }}' data-field='visible'
                                                data-idService='{{ $item->id }}'
                                                data-titleService='{{ $item->title }}'
                                                {{ $item->visible == 1 ? 'checked' : '' }}>
                                            <label for="{{ 'v_' . $item->id }}"></label>
                                        </form>



                                    </td>
                                    <td class="flex flex-row justify-end items-center gap-5">

                                        <a href="{{ route('blog.edit', $item) }}"
                                            class="bg-yellow-400 px-3 py-2 rounded text-white  "><i
                                                class="fa-regular fa-pen-to-square"></i></a>
                                        {{-- {{  route('servicios.destroy', $item->id) }} --}}
                                        <form action=" " method="POST">
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
                                <th>Categoría</th>
                                <th>Imagen</th>
                                <th>Visible</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {

            // Inicializar DataTable
            new DataTable('#tabladatos', {
                responsive: true
            });

            // Evento de eliminación
            $(document).on("click", ".btn_delete", function(e) {
                e.preventDefault();

                let id = $(this).attr('data-idService');
                let row = $(this).closest('tr'); // Captura la fila

                Swal.fire({
                    title: "¿Seguro que deseas eliminar?",
                    text: "Vas a eliminar una publicación.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sí, borrar!",
                    cancelButtonText: "Cancelar",
                    customClass: {
                        confirmButton: "bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded",
                        cancelButton: "bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded ml-3"
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('blog.deleteBlog') }}",
                            method: "POST",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                id: id
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: "Eliminado!",
                                        text: response.message,
                                        icon: "success"
                                    });

                                    // Remover la fila sin recargar
                                    row.fadeOut(500, function() {
                                        $(this).remove();
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: response.message,
                                        icon: "error"
                                    });
                                }
                            },
                            error: function(xhr) {
                                let errorMessage = "Error desconocido al eliminar.";
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }

                                Swal.fire({
                                    title: "Error!",
                                    text: errorMessage,
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });


            // Evento para actualizar visibilidad
            $(document).on("change", ".btn_swithc", function() {
                let status = $(this).is(':checked') ? 1 : 0;
                let id = $(this).attr('data-idService');
                let titleService = $(this).attr('data-titleService');
                let field = $(this).attr('data-field');

                $.ajax({
                    url: "{{ route('blog.updateVisible') }}",
                    method: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        status: status,
                        id: id,
                        field: field
                    },
                    success: function(res) {
                        Swal.fire({

                            icon: "success",
                            title: titleService + " ha sido modificado",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: "Error!",
                            text: "No se pudo actualizar la visibilidad.",
                            icon: "error"
                        });
                    }
                });
            });

        });
    </script>


</x-app-layout>

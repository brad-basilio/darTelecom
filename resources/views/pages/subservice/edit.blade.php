<x-app-layout title="Editar Subservicio: {{ $subservicio->title }}">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Header con información del servicio padre -->
        <br/>
        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="h-12 w-12 bg-blue-600 mr-4"
                         style="mask-image: url('{{ asset($service->icono) }}'); mask-size: contain; mask-repeat: no-repeat;">
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $service->title }}</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Editando: {{ $subservicio->title }}</p>
                    </div>
                </div>
                <a href="{{ route('subservicios.index', $service->id) }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded">
                    Volver a Subservicios
                </a>
            </div>
        </div>

        <form id="subservice-form" action="{{ route('subservicios.update', [$service->id, $subservicio->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-span-full xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                    <h2 class="font-semibold text-slate-800 dark:text-slate-100 text-2xl tracking-tight">
                        Edición del subservicio: {{ $subservicio->title }}
                    </h2>
                </header>

                <div class="p-3">
                    <div class="rounded p-4 px-4">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                            <div class="col-span-3">
                                <!-- Título -->
                                <div class="md:col-span-5">
                                    <label for="title">Título del Subservicio</label>
                                    <div class="relative mb-2 mt-2">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </div>
                                        <input type="text" id="title" name="title" value="{{ old('title', $subservicio->title) }}"
                                            class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Título del subservicio" required>
                                    </div>
                                    @error('title')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Subtítulo -->
                                <div class="md:col-span-5">
                                    <label for="subtitle">Subtítulo del Subservicio</label>
                                    <div class="relative mb-2 mt-2">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </div>
                                        <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $subservicio->subtitle) }}"
                                            class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Subtítulo">
                                    </div>
                                    @error('subtitle')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Descripción Breve -->
                                <div class="md:col-span-5">
                                    <label for="descripcion_breve">Descripción Breve del subservicio</label>
                                    <span class="text-colorRojo ml-4 text-xs">( Menciona a la brevedad sobre el subservicio )</span>
                                    <div class="relative mb-2 mt-2">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none top-0">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </div>
                                        <textarea type="text" rows="2" id="descripcion_breve" name="descripcion_breve"
                                            class="mt-1 min-h-24 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Descripción Breve">{{ old('descripcion_breve', $subservicio->descripcion_breve) }}</textarea>
                                    </div>
                                    @error('descripcion_breve')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Beneficios -->
                                <div class="md:col-span-5">
                                    <label for="beneficios">Beneficios del subservicio</label>
                                    <span class="text-colorRojo ml-4 text-xs">( Menciona los beneficios separados por punto y coma ";")</span>
                                    <div class="relative mb-2 mt-2">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </div>
                                        <textarea type="text" rows="2" id="beneficios" name="beneficios"
                                            class="mt-1 min-h-24 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Ej. Implementación rápida; Soporte técnico prioritario">{{ old('beneficios', $subservicio->beneficios) }}</textarea>
                                    </div>
                                    @error('beneficios')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Descripción Extensa -->
                                <div class="md:col-span-5">
                                    <label for="descripcion_extensa">Descripción Extensa</label>
                                    <div class="relative mb-2 mt-2">
                                        <div id="description-editor" class="w-full min-h-[200px]"></div>
                                        <input type="hidden" name="descripcion_extensa" id="descripcion_extensa">
                                    </div>
                                    @error('descripcion_extensa')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-2">
                                <!-- Icono actual -->
                                @if($subservicio->icono)
                                <div class="md:col-span-5">
                                    <label for="description">Icono actual del subservicio</label>
                                    <div class="relative mb-2 mt-2">
                                        <div class=" h-10 w-10 bg-colorBackgroundAzulOscuro"
                                            style="mask-image: url('{{ asset($subservicio->icono) }}'); mask-size: cover; mask-repeat: no-repeat;">
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Actualizar Icono -->
                                <div class="md:col-span-5">
                                    <label for="icono">Actualizar Icono</label>
                                    <div class="relative mb-2 mt-2">
                                        <input name="icono"
                                            class="p-2.5 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                            id="icono" type="file" accept="image/svg+xml">
                                    </div>
                                    @error('icono')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Galería de imágenes -->
                                <div class="md:col-span-5 mt-4">
                                    <div class="w-full">
                                        <label for="fileAlbum"
                                            class="cursor-pointer text-center p-4 md:p-8 block border-2 border-dashed rounded-lg">
                                            <i class="fa-solid fa-cloud-arrow-up fa-3x text-colorAzul"></i>
                                            <p class="mt-3 text-colorParrafo max-w-xs mx-auto">
                                                Haga clic para <span class="font-medium text-indigo-600">Cargar su archivo</span> o arrastre y suelte su archivo aquí
                                            </p>
                                        </label>
                                        <input type="file" id="fileAlbum" name="images[]" multiple accept="image/*"
                                            class="hidden">
                                    </div>
                                </div>

                                <div class="md:col-span-5">
                                    <label for="album">Galería de imágenes</label>
                                    <div class="border p-4 rounded shadow mt-1" id="gallery-container">
                                        <!-- Imágenes existentes -->
                                        @if ($album && $album->images->isNotEmpty())
                                            <div class="grid grid-cols-3 gap-4">
                                                @foreach ($album->images as $image)
                                                    <div class="relative group" id="image-{{ $image->id }}">
                                                        <img src="{{ asset($image->url_image) }}"
                                                            alt="{{ $image->name_image }}"
                                                            class="w-auto h-32 object-cover rounded-xl">
                                                        <button
                                                            onclick="deleteImage('{{ route('subservicio.images.destroy', $image) }}', {{ $image->id }})"
                                                            class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-gray-500">No hay imágenes en este álbum.</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Visible -->
                                <div class="md:col-span-5 mt-4" hidden>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="visible" name="visible" value="1" 
                                               {{ old('visible', $subservicio->visible) ? 'checked' : '' }}
                                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="visible" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                            Visible en la web
                                        </label>
                                    </div>
                                    @error('visible')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="md:col-span-5 text-right mt-6 flex justify-between">
                                <div class="inline-flex items-end">
                                    <a href="{{ route('subservicios.index', $service->id) }}"
                                        class="bg-red-500 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded">Volver</a>
                                </div>
                                <div class="inline-flex items-end">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Actualizar subservicio</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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

    <!-- Scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote'],
                ['link', 'image', 'video'],
                [{'list': 'ordered'}, {'list': 'bullet'}, {'list': 'check'}],
                [{'script': 'sub'}, {'script': 'super'}],
                [{'indent': '-1'}, {'indent': '+1'}],
                [{'header': [1, 2, 3, 4, 5, 6, false]}],
                [{'color': []}, {'background': []}],
                [{'align': []}]
            ];

            // Inicializar Quill para Descripción Extensa
            const quillDescription = new Quill('#description-editor', {
                modules: {
                    toolbar: toolbarOptions
                },
                placeholder: 'Escriba la descripción aquí...',
                theme: 'snow',
                height: 300
            });

            // 1️⃣ **Recuperar contenido desde la base de datos**
            const descriptionData = `{!! $subservicio->descripcion_extensa ?? '' !!}`;

            // 2️⃣ **Insertar contenido en Quill (usar clipboard.dangerouslyPasteHTML)**
            quillDescription.clipboard.dangerouslyPasteHTML(descriptionData);

            // Obtener los valores de Quill antes de enviar el formulario
            document.getElementById("subservice-form").addEventListener("submit", function() {
                document.getElementById("descripcion_extensa").value = quillDescription.root.innerHTML;
            });
        });
    </script>

    <script>
        document.getElementById('fileAlbum').addEventListener('change', function(event) {
            uploadImages(event.target.files);
        });

        function asset(path) {
            return `${window.location.origin}/${path}`;
        }

        function uploadImages(files) {
            if (files.length === 0) return;

            let formData = new FormData();
            for (let i = 0; i < files.length; i++) {
                formData.append('images[]', files[i]);
            }

            fetch('{{ route('subservicio.uploadImages', $album?->id ?? 0) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    console.log("Respuesta completa del servidor:", response);
                    return response.json().catch(() => {
                        throw new Error("La respuesta no es JSON válido");
                    });
                })
                .then(data => {
                    console.log("Datos procesados:", data);

                    if (data.success) {
                        Swal.fire('¡Imágenes agregadas!', data.message, 'success');
                        updateGallery(data.album);
                    } else {
                        Swal.fire('Error', data.message || 'Hubo un problema al agregar las imágenes', 'error');
                    }
                })
                .catch(error => {
                    console.error("Error en la subida:", error);
                    Swal.fire('Error', 'Ocurrió un error al procesar la solicitud', 'error');
                });
        }

        function updateGallery(album) {
            const galleryContainer = document.getElementById('gallery-container');
            
            // Solo actualizar si recibimos datos válidos del álbum
            if (!album || !album.images) {
                console.warn("No se recibieron datos válidos del álbum, manteniendo galería actual.");
                return;
            }

            // Limpiar solo si tenemos imágenes para mostrar o si está explícitamente vacío
            galleryContainer.innerHTML = '';

            if (album.images.length === 0) {
                galleryContainer.innerHTML = '<p class="text-gray-500">No hay imágenes en este álbum.</p>';
                return;
            }

            const grid = document.createElement('div');
            grid.classList.add('grid', 'grid-cols-3', 'gap-4');

            album.images.forEach(image => {
                const imageWrapper = document.createElement('div');
                imageWrapper.classList.add('relative', 'group');
                imageWrapper.id = `image-${image.id}`;

                const img = document.createElement('img');
                img.src = asset(image.url_image);
                img.alt = image.name_image;
                img.classList.add('w-auto', 'h-36', 'object-cover', 'rounded-xl');

                const deleteButton = document.createElement('button');
                deleteButton.classList.add('absolute', 'top-2', 'right-2', 'bg-red-600', 'text-white', 'px-2',
                    'py-1', 'rounded-full', 'opacity-0', 'group-hover:opacity-100', 'transition-opacity');
                deleteButton.innerHTML = '<i class="fa-solid fa-trash"></i>';
                deleteButton.onclick = function() {
                    deleteImage(`/admin/subservicios/images/${image.id}`, image.id);
                };

                imageWrapper.appendChild(img);
                imageWrapper.appendChild(deleteButton);
                grid.appendChild(imageWrapper);
            });

            galleryContainer.appendChild(grid);
        }

        function deleteImage(deleteUrl, imageId) {
            event.preventDefault();

            Swal.fire({
                title: "¿Seguro que deseas eliminar?",
                text: "Esta acción no se puede deshacer.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(deleteUrl, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("Eliminado", data.message, "success");
                                // Eliminar solo la imagen específica del DOM
                                const imageElement = document.getElementById(`image-${imageId}`);
                                if (imageElement) {
                                    imageElement.remove();
                                }
                                
                                // Verificar si ya no hay más imágenes y mostrar mensaje
                                const galleryContainer = document.getElementById('gallery-container');
                                const remainingImages = galleryContainer.querySelectorAll('[id^="image-"]');
                                if (remainingImages.length === 0) {
                                    galleryContainer.innerHTML = '<p class="text-gray-500">No hay imágenes en este álbum.</p>';
                                }
                            } else {
                                Swal.fire("Error", data.message, "error");
                            }
                        })
                        .catch(error => {
                            console.error("Error al eliminar:", error);
                            Swal.fire("Error", "No se pudo eliminar la imagen.", "error");
                        });
                }
            });
        }
    </script>
</x-app-layout>
<x-app-layout title="Editar {{ $producto->producto }}">

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <form id="product-form" action="{{ route('products.update', $producto->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div
                class="col-span-full xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                    <h2 class="font-semibold text-slate-800 dark:text-slate-100 text-2xl tracking-tight">
                        Editar Producto: {{ $producto->producto }}
                    </h2>
                </header>
                <div class="flex flex-col gap-2 p-3">
                    <div class="flex gap-2 p-3">
                        <div class="basis-0 md:basis-3/5">
                            <div class="rounded p-4 px-4">
                                <div id='general' class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                    <div class="md:col-span-5 mt-2">
                                        <label for="producto">Producto<span class="text-red-500">
                                                (Obligatorio)</span></label>
                                        <input type="text" id="producto" name="producto"
                                            value="{{ $producto->producto }}"
                                            class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    </div>

                                    <div class="md:col-span-5 mt-2">
                                        <label for="extract">Descripción Breve</label>
                                        <textarea id="extract" name="extract"
                                            class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">{{ $producto->extract }}</textarea>
                                    </div>

                                    <div class="md:col-span-5">
                                        <label for="description">Descripción Extensa</label>
                                        <div class="relative mb-2 mt-2">
                                            <div id="description-editor" class="w-full min-h-[200px]"></div>
                                            <input type="hidden" name="description" id="description">
                                        </div>
                                    </div>

                                    <div class="md:col-span-5">
                                        <label for="especificaciones_json">Especificaciones</label>
                                        <div class="relative mb-2 mt-2">
                                            <div id="especificaciones-container" class="space-y-4">
                                                <!-- Se llenará dinámicamente con JavaScript -->
                                            </div>
                                            <button type="button" onclick="addSpecificationField()"
                                                class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded text-sm">
                                                <i class="fas fa-plus mr-1"></i> Agregar Especificación
                                            </button>
                                            <input type="hidden" name="especificaciones_json"
                                                id="especificaciones_json"
                                                value="{{ is_array($producto->especificaciones_json) ? json_encode($producto->especificaciones_json) : $producto->especificaciones_json ?? '[]' }}">
                                        </div>
                                    </div>

                                    @if ($producto->manuales)
                                        <div class="md:col-span-5">
                                            <div id="pdfPreview" class="mt-2">
                                                <p class="text-gray-700 dark:text-gray-300">Ficha técnica actual:</p>
                                                <embed id="pdfViewer" src="{{ asset($producto->manuales) }}"
                                                    type="application/pdf" width="100%" height="600px">
                                                <a href="{{ asset($producto->manuales) }}" target="_blank"
                                                    class="text-colorRojo">Ver en pantalla completa</a>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="md:col-span-5">
                                        <label for="manuales">Ficha Técnica</label>
                                        <input name="manuales" type="file" accept="application/pdf"
                                            class="p-2.5 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="basis-0 md:basis-2/5">
                            <div class="grid gap-4 text-sm grid-cols-1 md:grid-cols-5 rounded p-4 px-4">
                                <div class="md:col-span-5">
                                    <label for="categoria_id">Categoría</label>
                                    <select name="categoria_id"
                                        class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="">Seleccionar Categoría</option>
                                        @foreach ($categorias as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $producto->categoria_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="md:col-span-5">
                                    <label for="brand_id">Marca</label>
                                    <select name="brand_id"
                                        class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="">Seleccionar Marca</option>
                                        @foreach ($marcas as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $producto->brand_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="md:col-span-5 mt-2">
                                    <label for="stock">Stock<span class="text-red-500">(Obligatorio)</span></label>
                                    <input type="number" id="stock" name="stock" value="{{ $producto->stock }}"
                                        placeholder="Ingrese Stock" pattern="[0-9]+" title="Solo números"
                                        class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5">
                                </div>

                                <div class="md:col-span-5 mt-2">
                                    <label for="precio">Precio (si es 0 o vacio no se mostrará)</label>
                                    <input type="number" id="precio" name="precio" value="{{ $producto->precio }}"
                                        placeholder="Ingrese Precio"
                                        class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5">
                                </div>

                                <div class="md:col-span-5 mt-2">
                                    <label for="peso_empaque">Peso del Empaque<span
                                            class="text-red-500">(Obligatorio)</span></label>
                                    <input type="number" id="peso_empaque" name="peso_empaque"
                                        value="{{ $producto->peso_empaque }}" placeholder="Ingrese Peso Empaque"
                                        class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5">
                                </div>

                                <div class="md:col-span-5 mt-2">
                                    <label for="tipo_vendedor">Tipo de Vendedor<span
                                            class="text-red-500">(Obligatorio)</span></label>
                                    <input type="text" id="tipo_vendedor" name="tipo_vendedor"
                                        value="{{ $producto->tipo_vendedor }}" placeholder="Ingrese Tipo de Vendedor"
                                        class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5">
                                </div>

                                <div x-data="{ enOferta: {{ $producto->en_oferta ? 'true' : 'false' }} }" class="md:col-span-5 mt-2">
                                    <div class="relative flex mb-2 mt-2">
                                        <input type="checkbox" id="en_oferta" name="en_oferta" x-model="enOferta"
                                            class="flex relative w-[3.25rem] h-7 p-px bg-gray-100 border-transparent text-transparent 
                              rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none 
                              checked:bg-none checked:text-blue-600 checked:border-blue-600 focus:checked:border-blue-600 dark:bg-gray-800 dark:border-gray-700 
                              dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-600 before:inline-block before:size-6
                              before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow 
                              before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-gray-400 dark:checked:before:bg-blue-200"
                                            {{ $producto->en_oferta ? 'checked' : '' }} />
                                        <label for="en_oferta" class="ml-4">Producto en Oferta</label>
                                    </div>

                                    <div class="md:col-span-5 mt-2" x-show="enOferta">
                                        <label for="precio_oferta">Precio en Oferta <span
                                                class="text-red-500">(Obligatorio)</span></label>
                                        <input type="number" id="precio_oferta" name="precio_oferta"
                                            value="{{ $producto->precio_oferta }}"
                                            placeholder="Ingrese Precio Oferta"
                                            class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5">
                                    </div>
                                </div>

                                <div class="md:col-span-5">
                                    <div class="relative mb-2 mt-2">
                                        <input type="checkbox"
                                            class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 p-2.5"
                                            id='destacado' name='destacado'
                                            {{ $producto->destacado ? 'checked' : '' }} />
                                        <label for="destacado" class="ml-4">Producto Destacado</label>
                                    </div>
                                </div>

                                <div class="md:col-span-5">
                                    <div class="relative mb-2 mt-2">
                                        <input type="checkbox"
                                            class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 p-2.5"
                                            id='garantia_entrega' name='garantia_entrega'
                                            {{ $producto->garantia_entrega ? 'checked' : '' }} />
                                        <label for="garantia_entrega" class="ml-4">Garantia de Entrega</label>
                                    </div>
                                </div>

                                <div class="md:col-span-5">
                                    <div class="relative mb-2 mt-2">
                                        <input type="checkbox"
                                            class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 p-2.5"
                                            id='envio_gratis' name='envio_gratis'
                                            {{ $producto->envio_gratis ? 'checked' : '' }} />
                                        <label for="envio_gratis" class="ml-4">Envío Gratis</label>
                                    </div>
                                </div>

                                <div class="md:col-span-5">
                                    <div class="relative mb-2 mt-2">
                                        <input type="checkbox"
                                            class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 p-2.5"
                                            id='devolucion' name='devolucion'
                                            {{ $producto->devolucion ? 'checked' : '' }} />
                                        <label for="devolucion" class="ml-4">Devolución</label>
                                    </div>
                                </div>

                                <div class="md:col-span-5">
                                    <label for="imagen">Imagen Principal (1000x1000px)</label>
                                    <img src="{{ asset($producto->imagen) }}"
                                        class="p-2.5 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" />
                                </div>

                                <div class="md:col-span-5">
                                    <label for="imagen">Actualizar Imagen Principal (1000x1000px)</label>
                                    <input id="imagen" name="imagen" type="file" accept="image/*"
                                        class="p-2.5 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
                                </div>

                                <div class="md:col-span-5">
                                    <div class="w-full">
                                        <label for="fileAlbum"
                                            class="cursor-pointer text-center p-4 md:p-8 block border-2 border-dashed rounded-lg">
                                            <i class="fa-solid fa-cloud-arrow-up fa-3x text-colorAzul"></i>
                                            <p class="mt-3 text-colorParrafo max-w-xs mx-auto">
                                                Haga clic para <span class="font-medium text-indigo-600">Cargar su
                                                    archivo</span> o arrastre y suelte su archivo aquí
                                            </p>
                                        </label>
                                        <input type="file" id="fileAlbum" name="images[]" multiple
                                            accept="image/*" class="hidden">
                                    </div>
                                </div>

                                <div class="md:col-span-5">
                                    <label for="album">Galería de imágenes</label>
                                    <div class="border p-4 rounded shadow mt-1" id="gallery-container">
                                        @if ($album->images->isNotEmpty())
                                            <div class="grid grid-cols-3 gap-4">
                                                @foreach ($album->images as $image)
                                                    <div class="relative group" id="image-{{ $image->id }}">
                                                        <img src="{{ asset($image->url_image) }}"
                                                            alt="{{ $image->name_image }}"
                                                            class="w-auto h-32 object-cover rounded-xl">
                                                        <button
                                                            onclick="deleteImage('{{ route('products.images.destroy', $image) }}', {{ $image->id }})"
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
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-5 text-right mt-6 flex justify-between px-4 pb-4">
                        <a href="{{ route('products.index') }}"
                            class="bg-red-500 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded">Volver</a>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Actualizar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Inicializar Quill para Descripción Extensa
            const quillDescription = new Quill('#description-editor', {
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote'],
                        ['link', 'image', 'video'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }, {
                            'list': 'check'
                        }],
                        [{
                            'script': 'sub'
                        }, {
                            'script': 'super'
                        }],
                        [{
                            'indent': '-1'
                        }, {
                            'indent': '+1'
                        }],
                        [{
                            'header': [1, 2, 3, 4, 5, 6, false]
                        }],
                        [{
                            'color': []
                        }, {
                            'background': []
                        }],
                        [{
                            'align': []
                        }]
                    ]
                },
                placeholder: 'Escriba la descripción aquí...',
                theme: 'snow',
                height: 300
            });

            // Cargar contenido existente
            const descriptionData = `{!! $producto->description ?? '' !!}`;
            quillDescription.clipboard.dangerouslyPasteHTML(descriptionData);

            // Cargar especificaciones existentes
            loadExistingSpecifications();

            // Configurar el formulario
            const form = document.getElementById('product-form');
            form.addEventListener('submit', function(e) {
                // Actualizar campos ocultos
                document.getElementById('description').value = quillDescription.root.innerHTML;

                // Validar y actualizar especificaciones
                if (!updateSpecificationsJSON()) {
                    e.preventDefault();
                    return false;
                }

                return true;
            });
        });

        // Función mejorada para cargar especificaciones
        function loadExistingSpecifications() {
            const container = document.getElementById('especificaciones-container');
            const especificacionesJson = document.getElementById('especificaciones_json').value;

            container.innerHTML = ''; // Limpiar contenedor primero

            try {
                const especificaciones = especificacionesJson ? JSON.parse(especificacionesJson) : [];

                if (Array.isArray(especificaciones) && especificaciones.length > 0) {
                    especificaciones.forEach(spec => {
                        addSpecificationField(spec);
                    });
                } else {
                    // Agregar al menos un campo vacío si no hay especificaciones
                    addSpecificationField();
                }
            } catch (e) {
                console.error('Error al parsear especificaciones:', e);
                // En caso de error, agregar campo vacío
                addSpecificationField();
            }
        }

        // Función para agregar especificaciones
        function addSpecificationField(spec = {
            titulo: '',
            descripcion: ''
        }) {
            const container = document.getElementById('especificaciones-container');
            const id = Date.now() + Math.floor(Math.random() * 1000);

            const specDiv = document.createElement('div');
            specDiv.className = 'specification-group border p-3 rounded-lg bg-gray-50 dark:bg-gray-700';
            specDiv.dataset.id = id;

            specDiv.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Título*</label>
                <input type="text" class="spec-title w-full p-2 border rounded focus:border-blue-500" required
                       placeholder="Ej: Color" value="${spec.titulo || ''}">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Descripción*</label>
                <input type="text" class="spec-desc w-full p-2 border rounded focus:border-blue-500" required
                       placeholder="Ej: Negro" value="${spec.descripcion || ''}">
            </div>
            <div class="md:col-span-1 flex items-end">
                <button type="button" onclick="removeSpecificationField('${id}')" 
                        class="bg-red-500 hover:bg-red-700 text-white font-semibold py-2 px-3 rounded text-sm w-full">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;

            // Agregar event listeners para remover el resaltado de error cuando se escribe
            const titleInput = specDiv.querySelector('.spec-title');
            const descInput = specDiv.querySelector('.spec-desc');

            titleInput.addEventListener('input', function() {
                this.classList.remove('border-red-500');
            });

            descInput.addEventListener('input', function() {
                this.classList.remove('border-red-500');
            });

            container.appendChild(specDiv);
            return id;
        }
        // Función para eliminar especificaciones
        function removeSpecificationField(id) {
            const element = document.querySelector(`.specification-group[data-id="${id}"]`);
            if (element) {
                element.remove();
            }
        }

        // Función para actualizar el JSON
        function updateSpecificationsJSON() {
            const groups = document.querySelectorAll('.specification-group');
            const specifications = [];
            let isValid = true;

            groups.forEach(group => {
                const title = group.querySelector('.spec-title').value.trim();
                const desc = group.querySelector('.spec-desc').value.trim();

                if (!title || !desc) {
                    isValid = false;
                    if (!title) group.querySelector('.spec-title').classList.add('border-red-500');
                    if (!desc) group.querySelector('.spec-desc').classList.add('border-red-500');
                } else {
                    specifications.push({
                        titulo: title,
                        descripcion: desc
                    });
                }
            });

            if (!isValid) {
                Swal.fire('Error', 'Por favor complete todos los campos de especificaciones', 'error');
                return false;
            }

            if (specifications.length === 0) {
                Swal.fire('Error', 'Debe agregar al menos una especificación', 'error');
                return false;
            }

            try {
                const jsonString = JSON.stringify(specifications);
                document.getElementById('especificaciones_json').value = jsonString;
                return true;
            } catch (e) {
                console.error('Error al generar JSON:', e);
                Swal.fire('Error', 'Error al generar las especificaciones', 'error');
                return false;
            }
        }

        // Resto de tus funciones para manejo de imágenes...
        // Manejo de imágenes (funciones existentes)
        function deleteImage(deleteUrl, imageId) {
            Swal.fire({
                title: "¿Estás seguro?",
                text: "Esta acción no se puede deshacer.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
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
                                document.getElementById(`image-${imageId}`).remove();
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

        // Subida de imágenes
        document.getElementById('fileAlbum').addEventListener('change', function(event) {
            uploadImages(event.target.files);
        });

        function uploadImages(files) {
            if (files.length === 0) return;

            let formData = new FormData();
            for (let i = 0; i < files.length; i++) {
                formData.append('images[]', files[i]);
            }

            fetch('{{ route('products.uploadImages', $album->id) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
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
            galleryContainer.innerHTML = '';

            if (!album || !album.images || album.images.length === 0) {
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
                img.src = `${window.location.origin}/${image.url_image}`;
                img.alt = image.name_image;
                img.classList.add('w-auto', 'h-36', 'object-cover', 'rounded-xl');

                const deleteButton = document.createElement('button');
                deleteButton.classList.add('absolute', 'top-2', 'right-2', 'bg-red-600', 'text-white', 'px-2',
                    'py-1', 'rounded-full', 'opacity-0', 'group-hover:opacity-100', 'transition-opacity');
                deleteButton.innerHTML = '<i class="fa-solid fa-trash"></i>';
                deleteButton.onclick = function() {
                    deleteImage('{{ route('products.images.destroy', '') }}/' + image.id, image.id);
                };

                imageWrapper.appendChild(img);
                imageWrapper.appendChild(deleteButton);
                grid.appendChild(imageWrapper);
            });

            galleryContainer.appendChild(grid);
        }
    </script>

    @include('_layout.scripts')
</x-app-layout>

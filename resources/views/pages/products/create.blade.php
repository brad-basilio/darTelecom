<x-app-layout title="Crear Producto">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <form id="product-form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div
                class="col-span-full xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                    <h2 class="font-semibold text-slate-800 dark:text-slate-100 text-2xl tracking-tight">
                        Agregar Producto
                    </h2>
                </header>

                <div class="flex flex-col gap-2 p-3">
                    <div class="flex gap-2 p-3">
                        <div class="basis-0 md:basis-3/5">
                            <div class="rounded p-4 px-4">
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                    <!-- Nombre del Producto -->
                                    <div class="md:col-span-5 mt-2">
                                        <label for="producto">Producto<span class="text-red-500">*</span></label>
                                        <div class="relative mb-2 mt-2">
                                            <div
                                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </div>
                                            <input type="text" id="producto" name="producto" required
                                                class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                                placeholder="Nombre del producto">
                                            @error('producto')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Descripción Corta -->
                                    <div class="md:col-span-5 mt-2">
                                        <label for="extract">Descripción Breve</label>
                                        <div class="relative mb-2 mt-2">
                                            <div
                                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </div>
                                            <textarea id="extract" name="extract"
                                                class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                                placeholder="Descripción corta que aparece en listados"></textarea>
                                            @error('extract')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Descripción Extensa -->
                                    <div class="md:col-span-5">
                                        <label for="description">Descripción Extensa<span
                                                class="text-red-500">*</span></label>
                                        <div class="relative mb-2 mt-2">
                                            <div id="description-editor" class="w-full min-h-[200px] bg-white"></div>
                                            <input type="hidden" name="description" id="description">
                                        </div>
                                    </div>

                                    <!-- Especificaciones Técnicas (JSON) -->
                                    <div class="md:col-span-5">
                                        <label for="especificaciones_json">Especificaciones Técnicas</label>
                                        <div class="relative mb-2 mt-2">
                                            <div id="especificaciones-container" class="space-y-4">
                                                <!-- Campos dinámicos se agregarán aquí -->
                                            </div>
                                            <button type="button" onclick="addSpecificationField()"
                                                class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded text-sm">
                                                <i class="fas fa-plus mr-1"></i> Agregar Especificación
                                            </button>
                                            <input type="hidden" name="especificaciones_json"
                                                id="especificaciones_json">
                                        </div>
                                    </div>

                                    <!-- Ficha Técnica -->
                                    <div class="md:col-span-5">
                                        <label for="manuales">Ficha Técnica (PDF)</label>
                                        <div class="relative mb-2 mt-2">
                                            <input name="manuales" type="file" accept="application/pdf"
                                                class="p-2.5 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
                                            <p class="mt-1 text-sm text-gray-500">Documento PDF con especificaciones
                                                técnicas</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="basis-0 md:basis-2/5">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5 rounded p-4 px-4">
                                <!-- Categoría -->
                                <div class="md:col-span-5">
                                    <label for="categoria_id">Categoría<span class="text-red-500">*</span></label>
                                    <div class="relative mb-2 mt-2">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <i class="fa-solid fa-list"></i>
                                        </div>
                                        <select name="categoria_id" required
                                            class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                                            <option value="">Seleccionar Categoría</option>
                                            @foreach ($categorias as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('categoria_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Marca -->
                                <div class="md:col-span-5">
                                    <label for="brand_id">Marca<span class="text-red-500">*</span></label>
                                    <div class="relative mb-2 mt-2">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <i class="fa-solid fa-list"></i>
                                        </div>
                                        <select name="brand_id" required
                                            class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                                            <option value="">Seleccionar Marca</option>
                                            @foreach ($marcas as $item)
                                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @error('brand_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Stock -->
                                <div class="md:col-span-5 mt-2">
                                    <label for="stock">Stock<span class="text-red-500">*</span></label>
                                    <input type="number" id="stock" name="stock" required min="0"
                                        class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="Cantidad disponible">
                                </div>

                                <!-- Precio -->
                                <div class="md:col-span-5 mt-2">
                                    <label for="precio">Precio<span class="text-red-500">*</span></label>
                                    <input type="number" id="precio" name="precio" required min="0"
                                        step="0.01"
                                        class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="Precio normal">
                                </div>

                                <!-- Peso del Empaque -->
                                <div class="md:col-span-5 mt-2">
                                    <label for="peso_empaque">Peso del Empaque (kg)<span
                                            class="text-red-500">*</span></label>
                                    <input type="number" id="peso_empaque" name="peso_empaque" required
                                        min="0" step="0.01"
                                        class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="Peso en kilogramos">
                                </div>

                                <!-- Tipo de Vendedor -->
                                <div class="md:col-span-5 mt-2">
                                    <label for="tipo_vendedor">Tipo de Vendedor<span
                                            class="text-red-500">*</span></label>
                                    <input type="text" id="tipo_vendedor" name="tipo_vendedor" required
                                        class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        value="Vendedor verificado">
                                </div>

                                <!-- Oferta -->
                                <div x-data="{ enOferta: false }" class="md:col-span-5 mt-2">
                                    <div class="relative flex mb-2 mt-2">
                                        <input type="checkbox" id="en_oferta" name="en_oferta" x-model="enOferta"
                                            class="flex relative w-[3.25rem] h-7 p-px bg-gray-100 border-transparent text-transparent 
                              rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none 
                              checked:bg-none checked:text-blue-600 checked:border-blue-600 focus:checked:border-blue-600 dark:bg-gray-800 dark:border-gray-700 
                              dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-600 before:inline-block before:size-6
                              before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow 
                              before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-gray-400 dark:checked:before:bg-blue-200" />
                                        <label for="en_oferta" class="ml-4">Producto en Oferta</label>
                                    </div>

                                    <div class="md:col-span-5 mt-2" x-show="enOferta">
                                        <label for="precio_oferta">Precio en Oferta<span
                                                class="text-red-500">*</span></label>
                                        <input type="number" id="precio_oferta" name="precio_oferta" min="0"
                                            step="0.01"
                                            class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                            placeholder="Precio promocional">
                                    </div>
                                </div>

                                <!-- Opciones Adicionales -->
                                <div class="md:col-span-5">
                                    <div class="relative mb-2 mt-2">
                                        <input type="checkbox"
                                            class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 p-2.5"
                                            id='destacado' name='destacado' value="1" />
                                        <label for="destacado" class="ml-4">Producto Destacado</label>
                                    </div>
                                </div>

                                <div class="md:col-span-5">
                                    <div class="relative mb-2 mt-2">
                                        <input type="checkbox" checked
                                            class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 p-2.5"
                                            id='garantia_entrega' name='garantia_entrega' value="1" />
                                        <label for="garantia_entrega" class="ml-4">Garantía de Entrega</label>
                                    </div>
                                </div>

                                <div class="md:col-span-5">
                                    <div class="relative mb-2 mt-2">
                                        <input type="checkbox" checked
                                            class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 p-2.5"
                                            id='envio_gratis' name='envio_gratis' value="1" />
                                        <label for="envio_gratis" class="ml-4">Envío Gratis</label>
                                    </div>
                                </div>

                                <div class="md:col-span-5">
                                    <div class="relative mb-2 mt-2">
                                        <input type="checkbox" checked
                                            class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 p-2.5"
                                            id='devolucion' name='devolucion' value="1" />
                                        <label for="devolucion" class="ml-4">Acepta Devoluciones</label>
                                    </div>
                                </div>

                                <!-- Imagen Principal -->
                                <div class="md:col-span-5">
                                    <label for="imagen">Imagen Principal<span class="text-red-500">*</span></label>
                                    <div class="relative mb-2 mt-2">
                                        <input id="imagen" name="imagen" type="file" required
                                            accept="image/*"
                                            class="p-2.5 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
                                        <p class="mt-1 text-sm text-gray-500">Recomendado: 1000x1000px, formato JPG/PNG
                                        </p>
                                    </div>
                                </div>

                                <!-- Galería de Imágenes -->
                                <div class="md:col-span-5">
                                    <div class="w-full">
                                        <label for="fileAlbum"
                                            class="cursor-pointer text-center p-4 md:p-8 block border-2 border-dashed rounded-lg">
                                            <i class="fa-solid fa-cloud-arrow-up fa-3x text-colorAzul"></i>
                                            <p class="mt-3 text-colorParrafo max-w-xs mx-auto">
                                                Haga clic para <span class="font-medium text-indigo-600">subir imágenes
                                                    adicionales</span>
                                            </p>
                                        </label>
                                        <input type="file" id="fileAlbum" name="images[]" multiple
                                            accept="image/*" class="hidden">
                                    </div>
                                </div>

                                <div class="md:col-span-5">
                                    <label>Vista Previa de Imágenes</label>
                                    <div class="border p-4 rounded shadow mt-1 grid grid-cols-3 gap-4"
                                        id="gallery-container">
                                        <!-- Las imágenes se mostrarán aquí -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-5 text-right mt-6 flex justify-between px-4 pb-4">
                        <a href="{{ route('products.index') }}"
                            class="bg-red-500 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded">Cancelar</a>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Guardar
                            Producto</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Scripts necesarios -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1. Configuración del editor Quill para descripción
            const quill = new Quill('#description-editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{
                            'header': 1
                        }, {
                            'header': 2
                        }],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
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
                            'direction': 'rtl'
                        }],
                        [{
                            'size': ['small', false, 'large', 'huge']
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
                            'font': []
                        }],
                        [{
                            'align': []
                        }],
                        ['clean'],
                        ['link', 'image', 'video']
                    ]
                },
                placeholder: 'Escribe la descripción completa del producto aquí...'
            });

            // 2. Agregar primera especificación
            addSpecificationField();

            // 3. Configurar el formulario para capturar el contenido antes de enviar
            const form = document.getElementById('product-form');
            form.addEventListener('submit', function(e) {
                // Capturar contenido del editor Quill
                const descriptionContent = document.querySelector('#description-editor .ql-editor')
                    .innerHTML;
                document.getElementById('description').value = descriptionContent;

                // Generar JSON de especificaciones
                updateSpecificationsJSON();

                return true;
            });

            // 4. Manejo de imágenes seleccionadas
            document.getElementById('fileAlbum').addEventListener('change', function(event) {
                handleImageUpload(event);
            });
        });

        // Funciones para manejar especificaciones
        function addSpecificationField(spec = {
            titulo: '',
            descripcion: ''
        }) {
            const container = document.getElementById('especificaciones-container');
            const id = Date.now();

            const specDiv = document.createElement('div');
            specDiv.className = 'specification-group border p-3 rounded-lg bg-gray-50 dark:bg-gray-700';
            specDiv.dataset.id = id;

            specDiv.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-1">Título*</label>
                        <input type="text" class="spec-title w-full p-2 border rounded" required
                               placeholder="Ej: Color" value="${spec.titulo || ''}">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-1">Descripción*</label>
                        <input type="text" class="spec-desc w-full p-2 border rounded" required
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

            container.appendChild(specDiv);
        }

        function removeSpecificationField(id) {
            const element = document.querySelector(`.specification-group[data-id="${id}"]`);
            if (element && document.querySelectorAll('.specification-group').length > 1) {
                element.remove();
            } else {
                Swal.fire('Información', 'Debe haber al menos una especificación', 'info');
            }
        }

        function updateSpecificationsJSON() {
            const groups = document.querySelectorAll('.specification-group');
            const specifications = [];

            groups.forEach(group => {
                const title = group.querySelector('.spec-title').value;
                const desc = group.querySelector('.spec-desc').value;

                if (title && desc) {
                    specifications.push({
                        titulo: title,
                        descripcion: desc
                    });
                }
            });

            document.getElementById('especificaciones_json').value = JSON.stringify(specifications);
        }

        // Funciones para manejar imágenes
        let selectedFiles = [];

        function handleImageUpload(event) {
            const files = event.target.files;
            const galleryContainer = document.getElementById('gallery-container');

            Array.from(files).forEach(file => {
                if (!file.type.match('image.*')) return;

                // Verificar si la imagen ya fue seleccionada
                if (selectedFiles.some(f => f.name === file.name && f.size === file.size && f.lastModified === file
                        .lastModified)) {
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.createElement('img');
                    imgElement.src = e.target.result;
                    imgElement.alt = file.name;
                    imgElement.classList.add('w-full', 'h-32', 'object-cover', 'rounded-lg');

                    const deleteButton = document.createElement('button');
                    deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
                    deleteButton.classList.add('absolute', 'top-2', 'right-2', 'bg-red-600', 'text-white',
                        'p-1', 'rounded-full', 'text-xs');
                    deleteButton.onclick = (e) => {
                        e.preventDefault();
                        removeImageFromPreview(file.name);
                    };

                    const imageWrapper = document.createElement('div');
                    imageWrapper.classList.add('relative', 'group', 'mb-2');
                    imageWrapper.appendChild(imgElement);
                    imageWrapper.appendChild(deleteButton);

                    galleryContainer.appendChild(imageWrapper);
                };
                reader.readAsDataURL(file);
                selectedFiles.push(file);
            });

            updateFileInput();
        }

        function removeImageFromPreview(fileName) {
            selectedFiles = selectedFiles.filter(file => file.name !== fileName);
            updateFileInput();
            refreshImagePreview();
        }

        function updateFileInput() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            document.getElementById('fileAlbum').files = dataTransfer.files;
        }

        function refreshImagePreview() {
            const galleryContainer = document.getElementById('gallery-container');
            galleryContainer.innerHTML = '';

            selectedFiles.forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.createElement('img');
                    imgElement.src = e.target.result;
                    imgElement.alt = file.name;
                    imgElement.classList.add('w-full', 'h-32', 'object-cover', 'rounded-lg');

                    const deleteButton = document.createElement('button');
                    deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
                    deleteButton.classList.add('absolute', 'top-2', 'right-2', 'bg-red-600', 'text-white',
                        'p-1', 'rounded-full', 'text-xs');
                    deleteButton.onclick = (e) => {
                        e.preventDefault();
                        removeImageFromPreview(file.name);
                    };

                    const imageWrapper = document.createElement('div');
                    imageWrapper.classList.add('relative', 'group', 'mb-2');
                    imageWrapper.appendChild(imgElement);
                    imageWrapper.appendChild(deleteButton);

                    galleryContainer.appendChild(imageWrapper);
                };
                reader.readAsDataURL(file);
            });
        }
    </script>

    @include('_layout.scripts')
</x-app-layout>

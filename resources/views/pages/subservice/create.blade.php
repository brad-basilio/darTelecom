<x-app-layout title="Crear Subservicio para {{ $service->title }}">
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
                        <p class="text-sm text-gray-600 dark:text-gray-400">Crear nuevo subservicio</p>
                    </div>
                </div>
                <a href="{{ route('subservicios.index', $service->id) }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded">
                    Volver a Subservicios
                </a>
            </div>
        </div>

        <form id="subservice-form" action="{{ route('subservicios.store', $service->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-span-full xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                    <h2 class="font-semibold text-slate-800 dark:text-slate-100 text-2xl tracking-tight">
                        Creación de nuevo subservicio
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
                                        <input type="text" id="title" name="title" value="{{ old('title') }}"
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
                                        <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle') }}"
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
                                            placeholder="Descripción Breve">{{ old('descripcion_breve') }}</textarea>
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
                                            placeholder="Ej. Implementación rápida; Soporte técnico prioritario">{{ old('beneficios') }}</textarea>
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
                                <!-- Icono -->
                                <div class="md:col-span-5">
                                    <label for="icono">Subir un Icono</label>
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
                                <div class="md:col-span-5">
                                    <div class="w-full">
                                        <label for="fileAlbum"
                                            class="cursor-pointer text-center p-4 md:p-8 block border-2 border-dashed rounded-lg">
                                            <i class="fa-solid fa-cloud-arrow-up fa-3x text-colorAzul"></i>
                                            <p class="mt-3 text-colorParrafo max-w-xs mx-auto">
                                                Haga clic para <span class="font-medium text-indigo-600">Cargar su archivo</span> o arrastre y suelte su archivo aquí
                                            </p>
                                        </label>
                                        <input type="file" id="fileAlbum" name="images[]" multiple accept="image/*"
                                            class="hidden" onchange="handleImageUpload(event)">
                                    </div>
                                </div>

                                <div class="md:col-span-5">
                                    <label for="album">Galería de imágenes</label>
                                    <div class="border p-4 rounded shadow mt-1 grid grid-cols-3 gap-4"
                                        id="gallery-container">
                                        <!-- Aquí se mostrarán las imágenes cargadas -->
                                    </div>
                                </div>

                                <!-- Visible -->
                                <div class="md:col-span-5 mt-4" hidden>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="visible" name="visible" value="1" 
                                               {{ old('visible', 1) ? 'checked' : '' }}
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
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Guardar subservicio</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

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

            // Actualizar los campos ocultos antes de enviar el formulario
            const form = document.getElementById('subservice-form');
            form.addEventListener('submit', function(event) {
                document.getElementById('descripcion_extensa').value = quillDescription.root.innerHTML;
                return true;
            });
        });

        let selectedFiles = [];

        function clearFileInput() {
            const fileInput = document.getElementById('fileAlbum');
            fileInput.value = '';
        }

        function updateFileInput() {
            const fileInput = document.getElementById('fileAlbum');
            clearFileInput();

            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => {
                dataTransfer.items.add(file);
            });

            fileInput.files = dataTransfer.files;
        }

        function handleImageUpload(event) {
            const files = event.target.files;
            const galleryContainer = document.getElementById("gallery-container");

            galleryContainer.innerHTML = "";
            selectedFiles = [];

            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.createElement("img");
                    imgElement.src = e.target.result;
                    imgElement.alt = file.name;
                    imgElement.classList.add("w-auto", "h-32", "object-cover", "rounded-xl", "mb-4");

                    const deleteButton = document.createElement("button");
                    deleteButton.classList.add("absolute", "top-2", "right-2", "bg-red-600", "text-white", "px-2", "py-1", "rounded-full");
                    deleteButton.innerHTML = '<i class="fa-solid fa-trash"></i>';
                    deleteButton.onclick = () => removeImageFromPreview(file.name);

                    const imageWrapper = document.createElement("div");
                    imageWrapper.classList.add("relative", "group", "images");
                    imageWrapper.appendChild(imgElement);
                    imageWrapper.appendChild(deleteButton);

                    galleryContainer.appendChild(imageWrapper);
                }
                reader.readAsDataURL(file);
                selectedFiles.push(file);
            });

            updateFileInput();
        }

        function removeImageFromPreview(fileName) {
            const galleryContainer = document.getElementById("gallery-container");
            const images = galleryContainer.querySelectorAll("div.images");

            images.forEach(imageWrapper => {
                if (imageWrapper.querySelector("img").alt === fileName) {
                    galleryContainer.removeChild(imageWrapper);
                }
            });

            selectedFiles = selectedFiles.filter(file => file.name !== fileName);
            updateFileInput();
        }
    </script>
</x-app-layout>
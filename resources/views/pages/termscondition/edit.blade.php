<x-app-layout>

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <form id="term-form" action="{{ route('terminos-y-condiciones.update', $terms->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div
                class="col-span-full xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
                <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
                    <h2 class="font-semibold text-slate-800 dark:text-slate-100 text-2xl tracking-tight">Editar Terminos
                        y
                        Condiciones</h2>
                </header>

                <div class="p-3">
                    <div class="rounded shadow-lg p-4 px-4 ">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">

                            <div class="md:col-span-5">
                                {{-- <label for="descripcion">Descripcion</label> --}}
                                <div class="relative mb-2  mt-2">

                                    <div class="md:col-span-5">

                                        <div class="relative mb-2 mt-2">

                                            <div id="content-editor" class="w-full min-h-[200px]"></div>
                                            <input type="hidden" name="content" id="content">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="md:col-span-5 text-right mt-6 flex justify-between">
                                <div class="inline-flex items-end">
                                    <a href="{{ URL::previous() }}"
                                        class="bg-red-500 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded">Volver</a>
                                </div>
                                <div class="inline-flex items-end">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Actualizar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>


</x-app-layout>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toolbarOptions = [
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
        ];

        // Inicializar Quill para Descripción Extensa
        const quillDescription = new Quill('#content-editor', {
            modules: {
                toolbar: toolbarOptions
            },
            placeholder: 'Escriba  aquí...',
            theme: 'snow',
            height: 300
        });



        // 1️⃣ **Recuperar contenido desde la base de datos**
        const descriptionData = `{!! $terms->content ?? '' !!}`;


        // 2️⃣ **Insertar contenido en Quill (usar clipboard.dangerouslyPasteHTML)**
        quillDescription.clipboard.dangerouslyPasteHTML(descriptionData);


        // Obtener los valores de Quill antes de enviar el formulario
        document.getElementById("term-form").addEventListener("submit", function() {
            document.getElementById("content").value = quillDescription.root.innerHTML;

        });
    });
</script>

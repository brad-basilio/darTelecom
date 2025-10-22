@extends('components.public.matrix', ['pagina' => $producto?->producto])

@section('titulo', 'Producto')

@section('css_importados')

    <style>
        /* Estilos para la tabla de especificaciones */
        .specs-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 1em;
        }

        .specs-table th {
            background-color: white;
            text-align: left;
            padding: 20px 20px;
            border: none;
            width: 40%;
        }

        .specs-table td {
            padding: 20px 20px;
            border: none;
            background-color: white;
        }

        .specs-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }

        .specs-table tr:nth-child(even) th {
            background-color: #f8fafc;
        }

        /* Estilos para la descripción */
        .product-description {
            margin-top: 30px;
        }

        .description-section {
            margin-bottom: 20px;
        }

        .description-section h3 {
            font-size: 1.2em;
            color: #1e293b;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .description-section p {
            line-height: 1.6;
            color: #334155;
        }

        /* Estilos para el botón de leer más/menos */
        .read-more-btn {
            color: #000f25;
            font-weight: 500;
            cursor: pointer;
            display: inline-block;
            margin-top: 10px;
        }

        /* Estilos para compartir */
        .share-section {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .share-title {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .share-buttons {
            display: flex;
            justify-content: end;
            gap: 10px;
        }

        .share-btn {

            height: 40px;
            width: 40px;
            border-radius: 100%;
            display: flex;

            color: white;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .whatsapp-btn {
            background-color: #25D366;
        }

        .facebook-btn {
            background-color: #3b5998;
        }

        .twitter-btn {
            background-color: #1DA1F2;
        }

        .copy-btn {
            background-color: #64748b;
        }
    </style>
@stop


@section('content')




    <main class="bg-white">
        <div class="w-11/12 lg:max-w-7xl mx-auto pt-32">
            <div class="bg-white rounded-lg flex flex-col md:flex-row gap-12">
                <div class="w-full md:w-1/2">
                    <div class="bg-colorBackgroundAzulClaro p-6 rounded-xl">
                        <img id="mainImage" class="w-full h-[550px] object-cover rounded-xl "
                            src="{{ asset($producto?->imagen) }}" alt="{{ $producto?->producto }}">
                    </div>
                    <div class="grid grid-cols-5 mt-4 gap-4">
                        <div class="bg-colorBackgroundAzulClaro p-2 rounded-xl">
                            <img class="w-full h-28  object-cover rounded-lg cursor-pointer aspect-square"
                                src="{{ asset($producto?->imagen) }}" alt="{{ $producto?->producto }}"
                                onclick="changeImage(this)">
                        </div>
                        @foreach ($album->images as $image)
                            <div class="bg-colorBackgroundAzulClaro p-2 rounded-xl aspect-square">
                                <img class="w-full h-28 object-cover rounded-lg cursor-pointer aspect-square"
                                    src="{{ asset($image->url_image) }}" alt="{{ $image->name_image }}"
                                    onclick="changeImage(this)">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <p class="text-colorParrafo text-text16 font-medium">{{ $producto?->category->name }}</p>
                    <h1 class="text-text40 font-semibold text-colorAzulOscuro ">{{ $producto?->producto }}</h1>
                    <p class="text-colorParrafo font-normal text-text16 mt-2">{{ $producto?->extract }}</p>
                    @if($producto?->precio && $producto?->precio > 0)
                    @if ($producto?->en_oferta)
                        <p class="text-colorAzulOscuro text-text28 font-bold mt-4">S/ {{ $producto?->precio_oferta }}
                            <span class="text-colorParrafo text-text20  font-medium line-through">S/
                                {{ $producto?->precio }}</span>
                        @else
                        <p class="text-colorAzulOscuro text-text28 font-bold mt-4">S/ {{ $producto?->precio }}</p>
                    @endif
                    @endif
                    </p>
                    <div class="mt-4">
                        <label for="cantidad" class="text-colorParrafo text-text14 mr-4">Cantidad</label>
                        <input type="number" id="quantity" name="cantidad" value="" placeholder="1" min="1"
                            class="mt-1 bg-gray-50 border w-20 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 
                   focus:border-blue-500  p-2.5">
                    </div>
                    <div class="flex flex-col gap-4 mt-4">
                        <p class="text-colorParrafo text-text14">Disponibilidad: @if ($producto?->stock > 0)
                                <span class="text-colorAzulOscuro">En stock</span>
                            @else
                                <span class="text-colorRojo">Agotado</span>
                            @endif
                        </p>
                        <p class="text-colorParrafo text-text14">Marca: <span
                                class="text-colorAzulOscuro">{{ $producto?->brand->nombre }}</span></p>
                        <p class="text-colorParrafo text-text14">Peso con empaque:
                            <span class="text-colorAzulOscuro">{{ $producto?->peso_empaque }}</span>
                        </p>
                        @if ($producto?->devolucion)
                            <p class="text-colorParrafo text-text14">Producto con devolución</p>
                        @else
                            <p class="text-colorParrafo text-text14">Producto sin devolución</p>
                        @endif
                        <p class="text-colorParrafo text-text14">Producto de: <span
                                class="text-colorAzulOscuro">{{ $producto?->tipo_vendedor }}</span>
                        </p>
                        <p class="text-colorParrafo text-text14">SKU: <span
                                class="text-colorAzulOscuro">{{ $producto?->sku }}</span>
                        </p>

                    </div>

                    <div class="bg-colorBackgroundAzulClaro  rounded-xl mt-4 p-4 flex flex-col gap-4">
                        <div class="flex justify-between items-center">
                          @if($producto?->precio && $producto?->precio > 0)
                            @if ($producto?->en_oferta)
                                <div>
                                    <p class="text-text12 text-colorParrafo">Precio: <span
                                            class="line-through">{{ $producto?->precio }}</span></p>
                                    <p class="text-colorAzulOscuro font-bold">Ahorras: S/
                                        {{ $producto?->precio - $producto?->precio_oferta }}
                                        ({{ number_format($producto?->porcentaje_oferta, 0) }}%) </p>
                                </div>
                            @else
                                <div>
                                    <p class="text-colorAzulOscuro font-bold">Precio: <span>{{ $producto?->precio }}</span>
                                    </p>

                                </div>
                            @endif
                            @endif

                            @if ($producto?->envio_gratis)
                                <span class="ml-2 px-4 py-1 bg-colorBackgroundAzulOscuro rounded-full text-white">Envios a
                                    todo el País</span>
                            @endif
                        </div>

                        <p class="text-colorAzulOscuro text-text14 font-medium flex gap-2 items-center"><svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17"
                                fill="none">
                                <path
                                    d="M7.66667 15.1654C4.99537 15.1654 3.65973 15.1654 2.82987 14.189C2 13.2128 2 11.6414 2 8.4987C2 5.356 2 3.78465 2.82987 2.80834C3.65973 1.83203 4.99537 1.83203 7.66667 1.83203C10.3379 1.83203 11.6736 1.83203 12.5035 2.80834C13.1715 3.59424 13.3018 4.76572 13.3272 6.83203"
                                    stroke="#141B34" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M5.33203 5.83203H9.9987M5.33203 9.16536H7.33203" stroke="#141B34"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M13.0715 12.5703C13.6334 12.1612 13.9987 11.4983 13.9987 10.75C13.9987 9.50733 12.9914 8.5 11.7487 8.5H11.582C10.3394 8.5 9.33203 9.50733 9.33203 10.75C9.33203 11.4983 9.6973 12.1612 10.2592 12.5703M13.0715 12.5703C12.7002 12.8405 12.2431 13 11.7487 13H11.582C11.0876 13 10.6305 12.8405 10.2592 12.5703M13.0715 12.5703L13.46 13.7936C13.6082 14.2602 13.6824 14.4935 13.6621 14.6388C13.6199 14.9411 13.3733 15.1656 13.0822 15.1667C12.9423 15.1672 12.7327 15.0572 12.3136 14.8373C12.1338 14.7429 12.044 14.6957 11.952 14.668C11.7647 14.6115 11.566 14.6115 11.3787 14.668C11.2868 14.6957 11.1969 14.7429 11.0172 14.8373C10.598 15.0572 10.3884 15.1672 10.2486 15.1667C9.95743 15.1656 9.71083 14.9411 9.66863 14.6388C9.64836 14.4935 9.7225 14.2602 9.8707 13.7936L10.2592 12.5703"
                                    stroke="#141B34" />
                            </svg>
                            Este producto tiene @if ($producto?->garantia_entrega)
                                <span class=" px-4 py-1 bg-white rounded-full">Garantía</span>
                            @else{
                                <span class="px-4 py-1 bg-white rounded-full">Garantía</span>
                                }
                            @endif
                        </p>
                        <p class="text-colorAzulOscuro text-text14 font-medium flex gap-2 items-center"><svg width="16"
                                height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M8.0013 1.83203C5.05578 1.83203 2.66797 3.92137 2.66797 6.4987H13.3346C13.3346 3.92137 10.9468 1.83203 8.0013 1.83203Z"
                                    stroke="#141B34" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M5.33203 12.0555C5.33203 10.7686 5.56225 10.5 6.66536 10.5H9.33203C10.4352 10.5 10.6654 10.7686 10.6654 12.0555V13.6111C10.6654 14.8981 10.4352 15.1667 9.33203 15.1667H6.66536C5.56225 15.1667 5.33203 14.8981 5.33203 13.6111V12.0555Z"
                                    stroke="#141B34" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M8.006 12.168H8" stroke="#141B34" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M2.66797 6.5L8.0013 10.5L13.3346 6.5" stroke="#141B34" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            Agrega al carrito
                            para conocer los costos de envío</p>
                        <p class="text-colorAzulOscuro text-text14 font-medium flex gap-2 items-center"><svg width="16"
                                height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6.66536 6.33333L3.51557 2.98374C3.23673 2.68298 3.28138 2.46329 3.61022 2.27308C4.22839 1.91551 4.70996 1.9058 5.36155 2.26339L8.63136 4.05781C8.86416 4.18555 9.09243 4.31504 9.33203 4.38568"
                                    stroke="#141B34" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M8.33203 9.1101L9.7389 13.6477C9.85376 14.0183 10.056 14.0854 10.3694 13.9058C10.9584 13.568 11.1959 13.178 11.2118 12.4751L11.2917 8.94784C11.3024 8.4767 11.3004 8.01564 11.6654 7.66797"
                                    stroke="#141B34" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M5.55101 7.3228L6.80897 6.40369L9.75717 4.25422L9.75977 4.25232L9.76477 4.24865C9.83437 4.19772 10.8716 3.44157 11.46 3.18385C12.183 2.86709 12.8566 3.01435 13.5813 3.21675C13.9562 3.32143 14.1436 3.37377 14.2788 3.47143C14.4934 3.62637 14.6329 3.86483 14.6616 4.12566C14.6797 4.29005 14.6319 4.47637 14.5364 4.84902C14.3516 5.56951 14.1441 6.21877 13.5046 6.67833C12.9842 7.05227 11.8017 7.56067 11.7224 7.59453L11.7168 7.597L11.7138 7.59827L8.35317 9.04293L6.9175 9.65833C6.39697 9.88147 6.1367 9.99307 5.95963 10.2001C5.54492 10.685 5.48635 11.5625 5.33157 12.1662C5.24604 12.4999 4.77702 13.078 4.35909 12.9912C4.10107 12.9377 4.09612 12.6147 4.06401 12.4087L3.75483 10.4259C3.6809 9.95173 3.67523 9.942 3.29603 9.64173L1.71041 8.38613C1.54572 8.25573 1.26472 8.09 1.3467 7.84273C1.47949 7.4422 2.22142 7.33047 2.55701 7.4242C3.16426 7.5938 3.96368 7.98247 4.59659 7.87053C4.86683 7.82273 5.0949 7.65607 5.55101 7.3228Z"
                                    stroke="#141B34" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Coordina la fecha de entrega <span class="px-4 py-1 bg-white rounded-full">Delivery no
                                incluido</span></p>

                        <div class="mt-8">
                            <button onclick="buyViaWhatsApp({{ $producto }})"
                                class=" font-semibold text-base block text-center bg-colorBackgroundRed text-white w-full px-6 py-3 rounded-full hover:bg-colorBackgroundRed transition duration-300">
                                Comprar
                            </button>
                        </div>
                    </div>
                    <!-- SECCIÓN COMPARTIR (NUEVO) -->
                    <div class="share-section">
                        <div class="share-title">Compartir producto:</div>
                        <div class="share-buttons">
                            <button onclick="shareProduct('whatsapp')" class="share-btn whatsapp-btn">
                                <i class="fab fa-whatsapp"></i>
                                <button onclick="shareProduct('facebook')" class="share-btn facebook-btn">
                                    <i class="fab fa-facebook-f"></i>
                                </button>
                                <button onclick="shareProduct('twitter')" class="share-btn twitter-btn">
                                    <i class="fab fa-twitter"></i>
                                </button>
                                <button onclick="copyProductLink()" class="share-btn copy-btn">
                                    <i class="fas fa-link"></i>
                                </button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="descriptionContainer"
                class="flex gap-8 justify-between max-h-[600px] overflow-hidden mb-4 relative border-b pb-8">
                <!-- SECCIÓN DE ESPECIFICACIONES TÉCNICAS -->
                <div class="mt-6 w-full lg:w-5/12">
                    <h2 class="text-xl font-bold text-colorAzulOscuro mb-4 pb-2 border-b">Características del producto</h2>
                    <table class="specs-table">
                        @php
                            // Procesar las especificaciones desde la base de datos
                            $specs = [];
                            if ($producto?->especificaciones_json) {
                                $specs = is_string($producto->especificaciones_json)
                                    ? json_decode($producto->especificaciones_json, true)
                                    : $producto->especificaciones_json;
                            }
                        @endphp

                        <!-- Mostrar especificaciones dinámicas primero -->
                        @if (is_array($specs) && count($specs) > 0)
                            @foreach ($specs as $spec)
                                @if (isset($spec['titulo']) && isset($spec['descripcion']))
                                    <tr>
                                        <th>{{ $spec['titulo'] }}</th>
                                        <td>{{ $spec['descripcion'] }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </table>
                </div>

                <!-- SECCIÓN DE DESCRIPCIÓN CON LECTURA EXPANDIBLE -->
                <div class="product-description mt-6 w-full lg:w-6/12">
                    <h2 class="text-xl font-bold text-colorAzulOscuro mb-4 pb-2 border-b">Descripción</h2>
                    <div class="description-content !text-colorParrafo" style="color: #334155 !important">
                        {!! $producto?->description ?? '<p>No hay descripción disponible</p>' !!}
                    </div>
                </div>


            </div>
            <div class="w-full relative">
                @if ($producto?->description && strlen(strip_tags($producto->description)) > 200)
                    <button id="readMoreBtn"
                        class="read-more-btn absolute left-1/2 -bottom-2 transform -translate-x-1/2 bg-white px-4 py-2 rounded-lg shadow-lg z-50 flex items-center gap-2 border border-gray-200">
                        <span id="readMoreText">Leer más</span>
                        <i id="chevronIcon" class="fas fa-chevron-down text-xs transition-transform duration-300"></i>
                    </button>
                @endif
            </div>
            <div class="py-10 ">
                <h2 class="text-2xl font-bold">Productos Relacionados</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                    @if ($productoRelacionado)
                        @foreach ($productoRelacionado as $producto)
                            <div
                                class="bg-colorBackgroundAzulClaro h-max p-4 shadow-md text-start group cursor-pointer rounded-xl">
                                <a href="{{ route('producto', $producto?->slug) }}">
                                    <div class="mb-4 w-full h-[212px] bg-white rounded-xl">
                                        <img src="{{ asset($producto?->imagen) }}" alt="{{ $producto?->producto }}"
                                            class=" w-full h-full object-contain">
                                    </div>
                                    <h3 class="text-text28 font-semibold mb-2 text-colorAzulOscuro">
                                        {{ $producto?->producto }}
                                    </h3>
                                    <p class="text-colorParrafo mb-4 text-text16 line-clamp-2">{{ $producto?->extract }}
                                    </p>
                                    <a href="{{ route('producto', $producto?->slug) }}"
                                        class="group-hover:w-full duration-300 ease-in-out group-hover:text-center group-hover:bg-colorBackgroundAzul bg-colorBackgroundRed  rounded-full text-white font-semibold px-4 py-2 inline-block">Ver
                                        más</a>
                                </a>
                            </div>
                        @endforeach
                    @else{
                        <p>No hay productos relacionados</p>
                        }
                    @endif
                </div>
            </div>
        </div>








    </main>
    <style>
        #descriptionContainer {
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 1rem;
            /* Ajusta según necesites */
        }

        .read-more-btn {
            transition: all 0.3s ease;
            transform: translate(-50%, 50%);
        }

        .read-more-btn:hover {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const readMoreBtn = document.getElementById('readMoreBtn');
            if (readMoreBtn) {
                const descriptionContainer = document.getElementById('descriptionContainer');
                const readMoreText = document.getElementById('readMoreText');
                const chevronIcon = document.getElementById('chevronIcon');

                readMoreBtn.addEventListener('click', function() {
                    if (descriptionContainer.classList.contains('max-h-[600px]')) {
                        // Expandir
                        descriptionContainer.classList.remove('max-h-[600px]');
                        descriptionContainer.classList.add('max-h-full');
                        readMoreText.textContent = 'Leer menos';
                        chevronIcon.classList.remove('fa-chevron-down');
                        chevronIcon.classList.add('fa-chevron-up');
                    } else {
                        // Contraer
                        descriptionContainer.classList.remove('max-h-full');
                        descriptionContainer.classList.add('max-h-[600px]');
                        readMoreText.textContent = 'Leer más';
                        chevronIcon.classList.remove('fa-chevron-up');
                        chevronIcon.classList.add('fa-chevron-down');

                        // Desplazarse suavemente a la sección
                        descriptionContainer.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });

                // Ocultar botón si no hay suficiente contenido
                if (descriptionContainer.scrollHeight <= descriptionContainer.clientHeight) {
                    readMoreBtn.style.display = 'none';
                }
            }
        });
    </script>
@section('scripts_importados')
    <script>
        function changeImage(element) {
            document.getElementById('mainImage').src = element.src;
        }


        // Función para comprar por WhatsApp
        function buyViaWhatsApp(producto) {
            console.log(producto);
            // Obtener información del product            
            const productName = producto.producto;
            const quantity = document.getElementById('quantity')?.value || 1;

            // Formatear precio desde PHP
            const price = parseFloat(
                producto.en_oferta ? producto.precio_oferta : producto.precio, 2, '.', ''
            );

            const total = (price * quantity).toFixed(2);

            // Limpiar número de WhatsApp (solo dígitos)
            const whatsappNumber = "{{ $general->whatsapp }}".replace(/\D/g, '');

            const message = `¡Hola! Estoy interesado en comprar:\n\n` +
                `*Producto:* ${productName}\n` +
                `*Cantidad:* ${quantity}\n` +
                `*Precio unitario:* S/ ${price.toFixed(2).replace('.', ',')}\n` +
                `*Total:* S/ ${total.replace('.', ',')}\n\n` +
                `Por favor, necesito más información sobre disponibilidad y formas de pago.`;

            window.open(`https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`, '_blank');
        }


        // Funciones para compartir
        function shareProduct(platform) {
            const productName = "{{ $producto?->producto }}";
            const productUrl = window.location.href;
            const message = `Mira este producto: ${productName} - ${productUrl}`;

            switch (platform) {
                case 'facebook':
                    window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(productUrl)}`, '_blank');
                    break;
                case 'twitter':
                    window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(message)}`, '_blank');
                    break;
                case 'whatsapp':
                    window.open(`https://wa.me/?text=${encodeURIComponent(message)}`, '_blank');
                    break;
            }
        }

        function copyProductLink() {
            const productUrl = window.location.href;
            navigator.clipboard.writeText(productUrl).then(() => {
                showAnimatedAlert('Enlace copiado al portapapeles');
            }).catch(err => {
                console.error('Error al copiar: ', err);
                showAnimatedAlert('Error al copiar el enlace', true);
            });
        }

        function showAnimatedAlert(message, isError = false) {
            // Crear el elemento de la alerta
            const alertBox = document.createElement('div');
            alertBox.textContent = message;
            alertBox.style.position = 'fixed';
            alertBox.style.bottom = '20px';
            alertBox.style.right = '20px';
            alertBox.style.padding = '15px 25px';
            alertBox.style.backgroundColor = isError ? '#ff4444' : '#4CAF50';
            alertBox.style.color = 'white';
            alertBox.style.borderRadius = '5px';
            alertBox.style.boxShadow = '0 4px 8px rgba(0,0,0,0.2)';
            alertBox.style.zIndex = '1000';
            alertBox.style.opacity = '0';
            alertBox.style.transition = 'opacity 0.3s, transform 0.3s';
            alertBox.style.transform = 'translateY(20px)';

            // Añadir al documento
            document.body.appendChild(alertBox);

            // Trigger de la animación
            setTimeout(() => {
                alertBox.style.opacity = '1';
                alertBox.style.transform = 'translateY(0)';
            }, 10);

            // Eliminar después de 3 segundos
            setTimeout(() => {
                alertBox.style.opacity = '0';
                alertBox.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    document.body.removeChild(alertBox);
                }, 300);
            }, 3000);
        }
    </script>
@stop

@stop

<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AttributesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CampaignController;

use App\Http\Controllers\MessageController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TestimonyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CategoryPostController;
use App\Http\Controllers\CertificadosController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ContactoViewController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\DescargablesController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\GalerieController;
use App\Http\Controllers\HomeViewController;
use App\Http\Controllers\LogosClientController;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\InnovacionViewController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LiquidacionController;
use App\Http\Controllers\MicrocategoryController;
use App\Http\Controllers\MisClientesController;
use App\Http\Controllers\MisMarcasController;
use App\Http\Controllers\NewsletterSubscriberController;
use App\Http\Controllers\NosotrosViewController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\PolyticsConditionController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProductosViewController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StrengthController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ValoresAtributosController;

use App\Http\Controllers\TagController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TermsAndConditionController;
use App\Models\AboutUs;
use App\Models\CategoryPost;
use App\Models\Microcategory;
use App\Models\NewsletterSubscriber;
use App\Models\Price;
use App\Models\Template;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Las rutas publicas */

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/nosotros', [IndexController::class, 'nosotros'])->name('nosotros');
Route::get('/innovaciones', [IndexController::class, 'innovaciones'])->name('innovaciones');
Route::get('/servicios/{slug?}', [IndexController::class, 'servicios'])->name('servicios');
// routes/web.php
Route::get('/servicios/show/{slug}', [IndexController::class, 'showServicios'])->name('servicios.view');

Route::get('/comentario', [IndexController::class, 'comentario'])->name('comentario');
Route::post('/comentario/nuevo', [IndexController::class, 'hacerComentario'])->name('nuevocomentario');
Route::get('/contacto', [IndexController::class, 'contacto'])->name('contacto');
Route::get('/descargables/{filtro}', [IndexController::class, 'catalogosDescargables'])->name('descargables');
Route::get('/blog', [IndexController::class, 'blog'])->name('blog.all');
Route::get('/blog/{filtro}', [IndexController::class, 'blog'])->name('blog');
Route::get('/post/{slug}', [IndexController::class, 'detalleBlog'])->name('detalleBlog');
//probando alpine js
Route::get('/imagenes', [IndexController::class, 'imagenes'])->name('imagenes');
Route::post('/guardarSubscriptor', [IndexController::class, ''])->name('guardarSubscriptor');






/* Proceso de pago */
Route::get('/carrito', [IndexController::class, 'carrito'])->name('carrito');
Route::get('/pago', [IndexController::class, 'pago'])->name('pago');
Route::post('/procesar/pago', [IndexController::class, 'procesarPago'])->name('procesar.pago');
Route::post('/agradecimiento', [IndexController::class, 'agradecimiento'])->name('agradecimiento');
/* Catálogo y producto */
Route::get('/producto/{slug}', [IndexController::class, 'productoShow'])->name('producto');
Route::get('/catalogo', [IndexController::class, 'catalogo'])->name('catalogo.all');
//Route::get('/catalogo/{filtro}', [IndexController::class, 'catalogo'])->name('catalogo');
// Ruta para manejar el filtrado por AJAX
Route::post('/filter-products', [IndexController::class, 'filterProducts'])->name('filter.products');


Route::post('carrito/buscarProducto', [CarritoController::class, 'buscarProducto'])->name('carrito.buscarProducto');
Route::get('/coleccion/{filtro}', [IndexController::class, 'coleccion'])->name('coleccion');
Route::get('/liquidacion', [IndexController::class, 'liquidacion'])->name('liquidacion');
Route::get('/novedades', [IndexController::class, 'novedades'])->name('novedades');
Route::get('/buscar', [IndexController::class, 'searchProduct'])->name('buscar');
Route::post('/procesarcarrito', [IndexController::class, 'procesarCarrito'])->name('procesar.carrito');
Route::post('catalogo_filtro_ajax', [IndexController::class, 'catalogoFiltroAjax'])->name('catalogo_filtro_ajax');
Route::post('cambiogaleria', [IndexController::class, 'cambioGaleria'])->name('cambioGaleria');
Route::post('/subscripciones/guardar', [NewsletterSubscriberController::class, 'saveSubscripciones'])->name('subscripciones.guardar');
Route::get('/subscripciones/{token}', [NewsletterSubscriberController::class, 'verify'])->name('verify');

Route::post('/subscripciones/guardar2', [NewsletterSubscriberController::class, 'saveSubscripciones2'])->name('subscripciones.guardar2');
Route::post('/cotizar', [CotizacionController::class, 'saveCotizaciones'])->name('cotizar');
Route::post('/obtenerdata', [IndexController::class, 'obtenerdata'])->name('obtenerdata');

/* Página 404 */
Route::get('/404', [IndexController::class, 'error'])->name('error');
/* Formulario de contacto */
Route::post('guardarContactos', [IndexController::class, 'guardarContacto'])->name('guardarContactos');
Route::post('guardarContactoWsp', [IndexController::class, 'guardarContactoWsp'])->name('guardarContactoWsp');
Route::post('guardarProducto', [IndexController::class, 'guardarProducto'])->name('guardarProducto');

Route::post('/getProvincia', [PriceController::class, 'getProvincias'])->name('prices.getProvincias');
Route::post('/getDistrito', [PriceController::class, 'getDistrito'])->name('prices.getDistrito');
Route::post('/calculeEnvio', [PriceController::class, 'calculeEnvio'])->name('prices.calculeEnvio');

Route::post('/getSubcategoria', [CategoryController::class, 'getSubcategoria'])->name('getSubcategoria');
Route::post('/getMicrocategoria', [CategoryController::class, 'getMicrocategoria'])->name('getMicrocategoria');
Route::post('/getProductMicrocategoria', [CategoryController::class, 'getProductMicrocategoria'])->name('getProductMicrocategoria');
Route::post('/getTotalProductos', [CategoryController::class, 'getTotalProductos'])->name('getTotalProductos');

/* Políticas */
Route::get('/politicas-de-devolucion', [IndexController::class, 'politicasDevolucion'])->name('politicas_dev');
Route::get('/terminos-y-condiciones', [IndexController::class, 'TerminosyCondiciones'])->name('terms_condition');

Route::redirect('/register', '/login');


Route::middleware(['auth:sanctum', 'verified', 'can:Admin'])->group(function () {

    Route::prefix('admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/analytics', [DashboardController::class, 'analytics'])->name('analytics');
        Route::get('/dashboard/fintech', [DashboardController::class, 'fintech'])->name('fintech');

        //messages
        Route::resource('/mensajes', MessageController::class); #using
        Route::post('/mensajes/borrar', [MessageController::class, 'borrar'])->name('mensajes.borrar');

        Route::resource('/politicas-de-devolucion', PolyticsConditionController::class);
        Route::resource('/terminos-y-condiciones', TermsAndConditionController::class);


        //Datos Generales
        Route::resource('/datosgenerales', GeneralController::class);
        Route::resource('/homeview', HomeViewController::class); #using
        Route::resource('/contactoview', ContactoViewController::class); #using
        Route::resource('/nosotrosview', NosotrosViewController::class); #using

        Route::resource('/productosview', ProductosViewController::class);

        //Servicios
        Route::resource('/servicios', ServiceController::class); #using
        Route::post('/servicios/deleteService', [ServiceController::class, 'deleteService'])->name('servicio.deleteService'); #using
        Route::post('/servicios/updateVisible', [ServiceController::class, 'updateVisible'])->name('servicio.updateVisible'); #using
        Route::post('/servicios/page/update/{id}', [ServiceController::class, 'updatePageServicio'])->name('servicio.page.update'); #using
        Route::post('/servicios/borrar', [ServiceController::class, 'destroy'])->name('servicio.borrar');
        Route::post('/servicios/{album}/upload', [ServiceController::class, 'uploadImages'])->name('servicio.uploadImages'); // Subir imágenes
        Route::delete('/servicios/images/{image}', [ServiceController::class, 'destroyImage'])->name('servicio.images.destroy');

        //Subservicios
        Route::get('/servicios/{service}/subservicios', [App\Http\Controllers\SubServiceController::class, 'index'])->name('subservicios.index');
        Route::get('/servicios/{service}/subservicios/create', [App\Http\Controllers\SubServiceController::class, 'create'])->name('subservicios.create');
        Route::post('/servicios/{service}/subservicios', [App\Http\Controllers\SubServiceController::class, 'store'])->name('subservicios.store');
        Route::get('/servicios/{service}/subservicios/{subservicio}/edit', [App\Http\Controllers\SubServiceController::class, 'edit'])->name('subservicios.edit');
        Route::put('/servicios/{service}/subservicios/{subservicio}', [App\Http\Controllers\SubServiceController::class, 'update'])->name('subservicios.update');
        Route::delete('/servicios/{service}/subservicios/{subservicio}', [App\Http\Controllers\SubServiceController::class, 'destroy'])->name('subservicios.destroy');
        Route::post('/subservicios/updateVisible', [App\Http\Controllers\SubServiceController::class, 'updateVisible'])->name('subservicio.updateVisible');
        Route::post('/servicios/{service}/subservicios/borrar', [App\Http\Controllers\SubServiceController::class, 'destroyAjax'])->name('subservicio.borrar');
        Route::post('/subservicios/{album}/upload', [App\Http\Controllers\SubServiceController::class, 'uploadImages'])->name('subservicio.uploadImages');
        Route::delete('/subservicios/images/{image}', [App\Http\Controllers\SubServiceController::class, 'destroyImage'])->name('subservicio.images.destroy');


        //Testimonies
        Route::resource('/testimonios', TestimonyController::class);
        Route::post('/testimonios/deleteTestimony', [TestimonyController::class, 'deleteTestimony'])->name('testimonios.deleteTestimony');
        Route::post('/testimonios/updateVisible', [TestimonyController::class, 'updateVisible'])->name('testimonios.updateVisible');

        //Categorías
        Route::resource('/categorias', CategoryController::class);
        Route::post('/categorias/deleteCategory', [CategoryController::class, 'deleteCategory'])->name('categorias.deleteCategory');
        Route::post('/categorias/updateVisible', [CategoryController::class, 'updateVisible'])->name('categorias.updateVisible');

        //Marcas
        Route::resource('/marcas', BrandController::class);
        Route::post('/marcas/deleteBrand', [BrandController::class, 'deleteBrand'])->name('marcas.deleteBrand');
        Route::post('/marcas/updateVisible', [BrandController::class, 'updateVisible'])->name('marcas.updateVisible');
        // Route::get('/categorias/contarCategorias', [CategoryController::class, 'contarCategoriasDestacadas'] )->name('categorias.contarCategoriasDestacadas');





        //Categorías Blog
        Route::resource('/categoriasPost', CategoryPostController::class);
        Route::post('/categoriasPost/deleteCategory', [CategoryPostController::class, 'deleteCategory'])->name('categoriasPost.deleteCategory');
        Route::post('/categoriasPost/updateVisible', [CategoryPostController::class, 'updateVisible'])->name('categoriasPost.updateVisible');

        //Blog
        Route::resource('/blog', BlogController::class);
        Route::post('/blog/deleteBlog', [BlogController::class, 'deleteBlog'])->name('blog.deleteBlog');
        Route::post('/blog/updateVisible', [BlogController::class, 'updateVisible'])->name('blog.updateVisible');

        //Crud Logos
        Route::resource('/logos', LogosClientController::class);
        Route::post('/logos/deleteLogo', [LogosClientController::class, 'deleteLogo'])->name('logos.deleteLogo');

        //Equipo
        Route::resource('/staff', StaffController::class);
        Route::post('/staff/updateVisible', [StaffController::class, 'updateVisible'])->name('staff.updateVisible');
        Route::post('/staff/deleteStaff', [StaffController::class, 'deleteStaff'])->name('staff.deleteStaff');

        //Beneficios    
        Route::resource('/strength', StrengthController::class);
        Route::post('/strength/updateVisible', [StrengthController::class, 'updateVisible'])->name('strength.updateVisible');
        Route::post('/strength/borrar', [StrengthController::class, 'borrar'])->name('strength.borrar');


        //Nosotros
        Route::resource('/aboutus', AboutUsController::class);
        Route::post('/aboutus/updateVisible', [AboutUsController::class, 'updateVisible'])->name('aboutus.updateVisible');
        Route::post('/aboutus/borrar', [AboutUsController::class, 'borrar'])->name('aboutus.borrar');

        //Atributes
        Route::resource('/attributes', AttributesController::class);
        Route::post('/attributes/updateVisible', [AttributesController::class, 'updateVisible'])->name('attributes.updateVisible');
        Route::post('/attributes/borrar', [AttributesController::class, 'borrar'])->name('attributes.borrar');

        //valores atributes
        Route::resource('/valoresattributes', ValoresAtributosController::class);
        Route::post('/valoresattributes/borrar', [ValoresAtributosController::class, 'borrar'])->name('valoresattributes.borrar');
        Route::post('/valoresattributes/updateVisible', [ValoresAtributosController::class, 'updateVisible'])->name('valoresattributes.updateVisible');

        //Etiquetas
        Route::resource('/tags', TagController::class);
        Route::post('/tags/deleteTags', [TagController::class, 'deleteTags'])->name('tags.deleteTags');

        //Precios
        Route::resource('/prices', PriceController::class);


        //Productos
        Route::resource('/products', ProductsController::class);
        Route::post('/products/updateVisible', [ProductsController::class, 'updateVisible'])->name('products.updateVisible');
        Route::post('/products/borrar', [ProductsController::class, 'borrar'])->name('products.borrar');
        Route::get('/products/album/{id}', [ProductsController::class, 'showAlbum'])->name('products.showAlbum');
        Route::post('/products/{album}/upload', [ProductsController::class, 'uploadImages'])->name('products.uploadImages'); // Subir imágenes
        Route::delete('/products/images/{image}', [ProductsController::class, 'destroyImage'])->name('products.images.destroy');

        //Preguntas frecuentes
        Route::resource('/faqs', FaqsController::class);
        Route::post('/faqs/updateVisible', [FaqsController::class, 'updateVisible'])->name('faqs.updateVisible');
        Route::post('/faqs/borrar', [FaqsController::class, 'borrar'])->name('faqs.borrar');



        //Suscripciones
        Route::get('/subscripciones', [NewsletterSubscriberController::class, 'showSubscripciones'])->name('subscripciones');
        Route::post('mensajes/{id}/responder', [MessageController::class, 'replyMessage'])->name('mensajes.reply');


        //Crud Album Imagenes
        Route::resource('/albums', AlbumController::class);
        Route::post('/albums/{album}/upload', [AlbumController::class, 'uploadImages'])->name('albums.upload'); // Subir imágenes
        Route::delete('/albums/images/{image}', [AlbumController::class, 'destroyImage'])->name('albums.images.destroy');

        Route::get(
            '/templates',
            fn() => view('pages.templates.index')
                ->with('regex', '/{{(.*?)}}/gs')
                ->with('llavesBegin', '{{')
                ->with('llavesEnd', '}}')
        )->name('templates.index');
        Route::get('/landings', [LandingController::class, 'index'])->name('landings.index');
        Route::get('/landings/config/{landing}', [LandingController::class, 'config'])->name('landings.config');


        Route::fallback(function () {
            return view('pages/utility/404');
        });
    });
});


Route::middleware(['auth:sanctum', 'verified', 'can:Customer'])->group(function () {

    Route::get('/micuenta', [IndexController::class, 'micuenta'])->name('micuenta');
    Route::get('/micuenta/pedidos', [IndexController::class, 'pedidos'])->name('pedidos');
    Route::get('/micuenta/direccion', [IndexController::class, 'direccion'])->name('direccion');
    Route::post('/micuenta/direccion/direccionFavorita', [IndexController::class, 'direccionFavorita'])->name('direccionFavorita');

    Route::post('/micuenta/cambiofoto', [IndexController::class, 'cambiofoto'])->name('cambiofoto');
    Route::post('/micuenta/direccion/cambiofoto', [IndexController::class, 'cambiofoto'])->name('cambiofoto');
    Route::post('/micuenta/pedidos/cambiofoto', [IndexController::class, 'cambiofoto'])->name('cambiofoto');

    Route::get('/obtenerProvincia/{departmentId}', [IndexController::class, 'obtenerProvincia'])->name('obtenerProvincia');
    Route::get('/obtenerDistritos/{provinceId}', [IndexController::class, 'obtenerDistritos'])->name('obtenerDistritos');
    Route::post('/guardarDireccion', [IndexController::class, 'guardarDireccion'])->name('guardar.direccion');

    Route::post('/micuenta/actualizarPerfil', [IndexController::class, 'actualizarPerfil'])->name('actualizarPerfil');
});

Route::fallback(fn() => response()->view('public.404', [], 404));

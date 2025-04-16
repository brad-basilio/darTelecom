<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\AlbumImage;
use App\Models\Attributes;
use App\Models\AttributesValues;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Combinacion;
use App\Models\Galerie;
use App\Models\ImagenProducto;
use App\Models\Microcategory;
use App\Models\Products;
use App\Models\Specifications;
use App\Models\Subcategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use SoDe\Extend\File as ExtendFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductsController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {



    $products =  Products::where("status", "=", true)->get(); //quiero tambien que obtenga a que categoria pertenece

    return view('pages.products.index', compact('products'));
  }


  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $marcas = Brand::all();


    $categorias = Category::all();


    return view('pages.products.create', compact('categorias', 'marcas'));
  }

  public function saveImg($file, $route, $nombreImagen)
  {
    $manager = new ImageManager(new Driver());
    $img =  $manager->read($file);


    if (!file_exists($route)) {
      mkdir($route, 0777, true); // Se crea la ruta con permisos de lectura, escritura y ejecución
    }

    $img->save($route . $nombreImagen);
  }

  /**
   * Store a newly created resource in storage.
   */

   public function store(Request $request)
   {
       $request->validate([
           'producto' => 'required|string|max:255',
           'extract' => 'nullable|string|max:255',
           'description' => 'nullable|string',
           'precio' => 'nullable|numeric|min:0',
           'stock' => 'nullable|numeric|min:0',
           'categoria_id' => 'required|exists:categories,id',
           'brand_id' => 'required|exists:brands,id',
           'especificaciones_json' => 'nullable|json', // Cambiado a validación JSON
           'destacado' => 'nullable|boolean',
           'visible' => 'nullable|boolean',
           'status' => 'nullable|boolean',
       ]);
   
       $data = $request->all();
       
       // Verificar si ya existe un producto con el mismo nombre
       $existingSlug = Products::where('slug', Str::slug($request->producto))->first();
       if ($existingSlug) {
           $data['slug'] = Str::slug($request->producto) . '-' . uniqid();
       } else {
           $data['slug'] = Str::slug($request->producto);
       }
   
       try {
           // **Paso 1: Crear la carpeta principal "Productos" si no existe**
           $mainFolder = 'Productos';
           $pathMainFolder = public_path('storage/images/albums/' . $mainFolder);
           if (!is_dir($pathMainFolder)) {
               mkdir($pathMainFolder, 0777, true);
           }
   
           // **Paso 2: Crear la subcarpeta con el nombre del producto**
           $subFolder = $data['slug'];
           $pathSubFolder = $pathMainFolder . '/' . $subFolder;
           if (!is_dir($pathSubFolder)) {
               mkdir($pathSubFolder, 0777, true);
           }
   
           // **Paso 3: Crear el álbum del producto**
           $productosAlbum = Album::firstOrCreate([
               'name' => 'Productos',
           ], [
               'description' => 'Contenedor principal para los Productos.',
           ]);
   
           $album = Album::updateOrCreate([
               'name' => $subFolder,
           ], [
               'parent_id' => $productosAlbum->id,
           ]);
   
           // **Paso 4: Manejo de la imagen**
           if ($request->hasFile("imagen")) {
               $file = $request->file('imagen');
               $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();
               $file->move($pathSubFolder, $nombreImagen);
               $data['imagen'] = 'storage/images/albums/' . $mainFolder . '/' . $subFolder . '/' . $nombreImagen;
           } else {
               $data['imagen'] = 'images/img/noimagen.jpg';
           }
   
           // **Paso 5: Manejo de manuales**
           if ($request->hasFile("manuales")) {
               $file = $request->file('manuales');
               $routearchive = 'storage/archivos/productos/';
               $nombrearchive = Str::random(10) . '_' . $file->getClientOriginalName();
   
               if (!file_exists($routearchive)) {
                   mkdir($routearchive, 0777, true);
               }
   
               $file->move($routearchive, $nombrearchive);
               $data['manuales'] = $routearchive . $nombrearchive;
           }
   
           if ($request->has('en_oferta')) {
               $data['precio_oferta'] = $request->precio_oferta;
               $data['porcentaje_oferta'] = round((100 - ($request->precio_oferta * 100) / $request->precio), 0);
           }
   
           // **Paso 6: Procesar las especificaciones JSON**
           $especificaciones = [];
           if ($request->filled('especificaciones_json')) {
               $especificaciones = json_decode($request->especificaciones_json, true);
               
               // Validar que el JSON tenga la estructura correcta
               if (!is_array($especificaciones)) {
                   throw new \Exception('El formato de las especificaciones no es válido');
               }
               
               // Filtrar especificaciones vacías
               $especificaciones = array_filter($especificaciones, function($item) {
                   return !empty($item['titulo']) && !empty($item['descripcion']);
               });
           }
   
           // **Paso 7: Guardar el producto en la base de datos**
           $producto = new Products();
           $producto->producto = $request->producto;
           $producto->extract = $request->extract;
           $producto->description = $request->description;
           $producto->precio = $request->precio;
           $producto->stock = $request->stock;
           $producto->peso_empaque = $request->peso_empaque;
           $producto->tipo_vendedor = $request->tipo_vendedor ?? 'Vendedor verificado';
           $producto->precio_oferta = $data['precio_oferta'] ?? null;
           $producto->en_oferta = $request->has('en_oferta');
           $producto->porcentaje_oferta = $data['porcentaje_oferta'] ?? null;
           $producto->devolucion = $request->has('devolucion');
           $producto->envio_gratis = $request->has('envio_gratis');
           $producto->garantia_entrega = $request->has('garantia_entrega');
           $producto->slug = $data['slug'];
           $producto->especificaciones_json = !empty($especificaciones) ? json_encode($especificaciones) : null;
           $producto->categoria_id = $request->categoria_id;
           $producto->brand_id = $request->brand_id;
           $producto->destacado = $request->has('destacado');
           $producto->album = 'storage/images/albums/' . $mainFolder . '/' . $subFolder;
           $producto->imagen = $data['imagen'] ?? null;
           $producto->manuales = $data['manuales'] ?? null;
           $producto->save();
   
           // **Paso 8: Subir imágenes adicionales si existen**
           $album = Album::where('name', $data['slug'])->withCount('images', 'children')->first();
           $this->uploadImages($request, $album);
   
           return redirect()->route('products.index')->with('success', 'Publicación creada exitosamente.');
       } catch (ValidationException $e) {
           return redirect()->back()->withErrors($e->validator)->withInput();
       } catch (\Throwable $th) {
           return redirect()->route('products.create')->with('error', 'Error al crear el producto: ' . $th->getMessage());
       }
   }

  /**
   * Display the specified resource.
   */
  public function show(Products $products)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {

    $producto =  Products::findOrFail($id);
    $marcas = Brand::all();
    $categorias = Category::all();
    // Extraer solo el nombre del producto desde la ruta en "album"
    $albumName = $producto->slug; // Ejemplo: "storage/images/albums/Productos/MiProducto"

    $album = Album::where('name', $albumName)->withCount('images', 'children')->first();
    $album->load('children', 'images');
    return view('pages.products.edit', compact('producto', 'categorias',  'marcas', 'album'));
  }

  /**
   * Update the specified resource in storage.
   */
  private function updateAlbumAndFolder($oldTitle, $newTitle)
  {
    // Actualizar el título del álbum en la base de datos
    $album = Album::where('name', $oldTitle)->first();
    if ($album) {
      $album->name = $newTitle;
      $album->save();
    }
  }

  public function update(Request $request, $id)
  {
      $request->validate([
          'producto' => 'required|string|max:255',
          'extract' => 'required|string|max:255',
          'description' => 'required|string',
          'precio' => 'required|numeric|min:0',
          'stock' => 'required|numeric|min:0',
          'categoria_id' => 'required|exists:categories,id',
          'brand_id' => 'required|exists:brands,id',
          'especificaciones_json' => ['required', function ($attribute, $value, $fail) {
            try {
                $decoded = json_decode($value, true); // Decodificar como array
                if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
                    $fail('Las especificaciones deben ser un JSON válido.');
                }
            } catch (\Exception $e) {
                $fail('Formato de especificaciones no válido');
            }
        }],
          
          'precio_oferta' => 'nullable|numeric|min:0',
          'peso_empaque' => 'required|numeric|min:0',
          'tipo_vendedor' => 'nullable|string|min:0',
      ]);
  
      $producto = Products::findOrFail($id);
  
      try {
          $data = $request->all();
  
          // Procesar especificaciones JSON
          $especificaciones = json_decode($request->especificaciones_json, true);
  
          // **Manejo de la carpeta y álbum**
          $mainFolder = 'Productos';
          $subFolder = $producto->slug;
          $pathSubFolder = public_path("storage/images/albums/{$mainFolder}/{$subFolder}");
  
          if (!is_dir($pathSubFolder)) {
              mkdir($pathSubFolder, 0777, true);
          }
  
          $productosAlbum = Album::firstOrCreate([
              'name' => 'Productos',
          ], [
              'description' => 'Contenedor principal para los Productos.',
          ]);
  
          $album = Album::updateOrCreate(
              ['name' => $subFolder],
              ['parent_id' => $productosAlbum->id]
          );
  
          // **Manejo de la imagen**
          if ($request->hasFile("imagen")) {
              if ($producto->imagen && file_exists(public_path($producto->imagen))) {
                  unlink(public_path($producto->imagen));
              }
  
              $file = $request->file('imagen');
              $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();
              $file->move($pathSubFolder, $nombreImagen);
              $data['imagen'] = "storage/images/albums/{$mainFolder}/{$subFolder}/{$nombreImagen}";
          }
  
          // **Manejo de manuales**
          if ($request->hasFile("manuales")) {
              if ($producto->manuales && file_exists(public_path($producto->manuales))) {
                  unlink(public_path($producto->manuales));
              }
  
              $file = $request->file('manuales');
              $routearchive = 'storage/archivos/productos/';
              $nombrearchive = Str::random(10) . '_' . $file->getClientOriginalName();
  
              if (!is_dir(public_path($routearchive))) {
                  mkdir(public_path($routearchive), 0777, true);
              }
  
              $file->move(public_path($routearchive), $nombrearchive);
              $data['manuales'] = $routearchive . $nombrearchive;
          }
  
          if ($request->has('en_oferta')) {
              $data['precio_oferta'] = $request->precio_oferta;
              $data['porcentaje_oferta'] = round((100 - ($request->precio_oferta * 100) / $request->precio), 0);
          }
  
          // **Actualizar el producto**
          $producto->update([
              'producto' => $request->producto,
              'extract' => $request->extract,
              'description' => $request->description,
              'precio' => $request->precio,
              'stock' => $request->stock,
              'peso_empaque' => $request->peso_empaque,
              'tipo_vendedor' => $request->tipo_vendedor ?? 'Vendedor verificado',
              'precio_oferta' => $data['precio_oferta'] ?? null,
              'en_oferta' => $request->has('en_oferta'),
              'porcentaje_oferta' => $data['porcentaje_oferta'] ?? null,
              'devolucion' => $request->has('devolucion'),
              'envio_gratis' => $request->has('envio_gratis'),
              'garantia_entrega' => $request->has('garantia_entrega'),
              'especificaciones_json' => $especificaciones, // Usar el array procesado
              'categoria_id' => $request->categoria_id,
              'brand_id' => $request->brand_id,
              'destacado' => $request->has('destacado'),
              'album' => "storage/images/albums/{$mainFolder}/{$subFolder}",
              'imagen' => $data['imagen'] ?? $producto->imagen,
              'manuales' => $data['manuales'] ?? $producto->manuales,
          ]);
  
          return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
      } catch (ValidationException $e) {
          return redirect()->back()->withErrors($e->validator)->withInput();
      } catch (\Throwable $th) {
          return redirect()->route('products.edit', $id)
              ->with('error', 'Error al actualizar el producto: ' . $th->getMessage());
      }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function borrar(Request $request)
  {
    DB::beginTransaction(); // Iniciar una transacción para asegurar la atomicidad

    try {
      // Obtener el producto
      $product = Products::findOrFail($request->id);

      // Obtener el álbum asociado al producto
      $album = Album::where('name', $product->slug)->first();

      if ($album) {
        // Eliminar las imágenes asociadas al álbum
        foreach ($album->images as $image) {
          // Eliminar el archivo de imagen del servidor
          if (file_exists(public_path($image->url_image))) {
            unlink(public_path($image->url_image));
          }
          // Eliminar el registro de la imagen
          $image->delete();
        }

        // Eliminar el álbum
        $album->delete();

        // Eliminar la carpeta del álbum
        $folderPath = public_path("storage/images/albums/Productos/{$product->slug}");
        if (is_dir($folderPath)) {
          // Eliminar la carpeta y su contenido
          array_map('unlink', glob("$folderPath/*")); // Eliminar archivos dentro de la carpeta
          rmdir($folderPath); // Eliminar la carpeta
        }
      }

      // Eliminar manuales asociados al producto
      if ($product->manuales && file_exists(public_path($product->manuales))) {
        unlink(public_path($product->manuales));
      }

      // Eliminar la imagen principal del producto
      if ($product->imagen && file_exists(public_path($product->imagen))) {
        unlink(public_path($product->imagen));
      }

      // Eliminar el producto (soft delete)
      // $product->status = 0;
      $product->delete();

      DB::commit(); // Confirmar la transacción

      return response()->json([
        'success' => true,
        'message' => 'Producto, álbum e imágenes eliminados correctamente.',
      ]);
    } catch (\Exception $e) {
      DB::rollBack(); // Revertir la transacción en caso de error

      return response()->json([
        'success' => false,
        'message' => 'Ocurrió un problema al eliminar el producto y sus recursos asociados.',
        'error' => $e->getMessage(),
      ], 500);
    }
  }

  public function updateVisible(Request $request)
  {

    // $cantidad = $this->contardestacados();

    // if($cantidad >= 1 && $request->status == 1){
    //     return response()->json(['message' => 'Solo puedes destacar un producto'], 409 );
    // }

    $id = $request->id;
    $field = $request->field;
    $status = $request->status;

    // Verificar si el producto existe
    $product = Products::find($id);

    if (!$product) {
      return response()->json(['message' => 'Producto no encontrado'], 404);
    }

    // Actualizar el campo dinámicamente
    $product->update([
      $field => $status
    ]);
    return response()->json(['message' => 'registro actualizado']);
  }

  public function uploadImages(Request $request, Album $album)
  {
    $request->validate([
      'images.*' => 'required|image|mimes:png,jpg|max:2048',
    ]);

    if ($request->hasFile('images')) {
      $manager = new ImageManager(new Driver());

      foreach ($request->file('images') as $file) {
        $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();
        $img = $manager->read($file);
        $ruta = 'storage/images/albums/Productos/' . $album->name . '/';

        if (!is_dir(public_path($ruta))) {
          mkdir(public_path($ruta), 0777, true);
        }

        $img->save(public_path($ruta . $nombreImagen));

        $album->images()->create([
          'url_image' => $ruta . $nombreImagen,
          'name_image' => $nombreImagen,
        ]);
      }

      $album = Album::findOrFail($album->id);
      $album->load('images');

      return response()->json([
        'success' => true,
        'message' => 'Imágenes cargadas exitosamente.',
        'album' => $album,
      ]);
    }

    return response()->json([
      'error' => true,
      'message' => 'No se pudo subir las imágenes.',
    ]);
  }

  public function destroyImage(AlbumImage $image)
  {
    try {
      if ($image->url_image && file_exists($image->url_image)) {
        unlink($image->url_image);
      }

      $album = $image->album; // Obtener el álbum al que pertenece la imagen
      $image->delete();

      return response()->json([
        'success' => true,
        'message' => 'Imagen eliminada correctamente.',
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Ocurrió un problema al eliminar la imagen.'
      ], 500);
    }
  }
}

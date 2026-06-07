<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Jobs\SendBlogEmailJob;
use App\Models\Album;
use App\Models\CategoryPost;
use App\Models\NewsletterSubscriber;
use App\Models\Tag;
use Illuminate\Http\Request;


use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class BlogController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $posts = Blog::where('visible', '=', true)->with('category')->get();

    return view('pages.blog.index', compact('posts'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $categories = CategoryPost::all();

    return view('pages.blog.create', compact('categories'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function saveImg($file, $route, $nombreImagen)
  {
    $manager = new ImageManager(new Driver());
    $img = $manager->read($file);
    // $img->coverDown(672, 700, 'center');
    if (!file_exists($route)) {
      mkdir($route, 0777, true); // Se crea la ruta con permisos de lectura, escritura y ejecución
    }
    $img->save($route . $nombreImagen);
  }


  public function store(Request $request)
  {
    $request->validate([
      'titulo' => 'required|string|max:255',
      'extracto' => 'nullable|string|max:255',
      'descripcion' => 'nullable|string',
      //'categoria_id' => 'required|exists:categories,id',
      'category_post_id' => 'required|exists:category_posts,id',
      'destacado' => 'nullable|boolean',

    ]);

    $data = $request->all();
    $originalSlug = Str::slug($request->titulo);
    $slug = $originalSlug;
    $count = 1;

    // Generar un slug único si ya existe
    while (Blog::where('slug', $slug)->exists()) {
        $slug = $originalSlug . '-' . $count;
        $count++;
    }
    
    $data['slug'] = $slug;

    try {
      // **Paso 1: Crear la carpeta principal "Blogs" si no existe**
      $mainFolder = 'Blogs';
      $pathMainFolder = public_path('storage/images/albums/' . $mainFolder);
      if (!is_dir($pathMainFolder)) {
        mkdir($pathMainFolder, 0777, true);
      }

      // **Paso 2: Crear la subcarpeta con el nombre del producto**
      $subFolder = ucfirst(strtolower($data['slug'])); // Convertimos el nombre para evitar errores
      $pathSubFolder = $pathMainFolder . '/' . $subFolder;
      if (!is_dir($pathSubFolder)) {
        mkdir($pathSubFolder, 0777, true);
      }

      // **Paso 3: Crear el álbum del producto**
      $blogsAlbum = Album::firstOrCreate([
        'name' => 'Blogs',
      ], [
        'description' => 'Contenedor principal para los Blogs.',
      ]);

      $album = Album::updateOrCreate([
        'name' => $subFolder,
      ], [
        'parent_id' => $blogsAlbum->id,
      ]);

      // **Paso 4: Manejo de la imagen, ahora guardada en la carpeta del producto**
      if ($request->hasFile("imagen")) {
        $file = $request->file('imagen');
        $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();
        $file->move($pathSubFolder, $nombreImagen);
        $data['imagen'] = 'storage/images/albums/' . $mainFolder . '/' . $subFolder . '/' . $nombreImagen;
      } else {
        $data['imagen'] = 'images/img/noimagen.jpg';
      }

      // **Paso 6: Guardar el producto en la base de datos**
      $blog = new Blog();
      $blog->titulo = $data['titulo'] ?? null;
      $blog->extracto = $data['extracto'] ?? null;
      $blog->descripcion = $data['descripcion'] ?? null;
      $blog->category_post_id = $data['category_post_id'] ?? null;
      $blog->destacado = $request->has('destacado');
      $blog->imagen = $data['imagen'] ?? null;
      $blog->slug = $data['slug'] ?? null;
      $blog->fecha_publicacion = date('Y-m-d');
      if ($request->has('destacado')) {
        $blog->fecha_descatado = date('Y-m-d');
      }
      $blog->save();

      // 📌 Enviar correos en lotes de 50 (Envuelto en try-catch para evitar que un error SMTP bloquee la creación)
      try {
        NewsletterSubscriber::where('active', true)->chunk(50, function ($subscribers) use ($blog) {
          foreach ($subscribers as $subscriber) {
            SendBlogEmailJob::dispatch($blog, $subscriber->email);
          }
        });
      } catch (\Throwable $emailError) {
        // Registramos el error pero no detenemos el proceso, ya que el post ya fue guardado
        \Log::error('Error enviando correos de notificación del blog: ' . $emailError->getMessage());
      }

      // 📌 DEVOLVER JSON PARA AJAX
      return response()->json([
        'success' => true,
        'message' => 'Publicación creada exitosamente.',
        'redirect' => route('blog.index')
      ]);

      //return redirect()->route('blog.index')->with('success', 'Publicación creada exitosamente.');
    } catch (ValidationException $e) {
      return redirect()->back()->withErrors($e->validator)->withInput();
    } catch (\Throwable $th) {
      return response()->json([
        'success' => false,
        'message' => 'Error: ' . $th->getMessage()
      ], 500);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Blog $blog)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  //public function edit(Blog $blog, $id)

  public function edit(Blog $blog)
  {

    $categories = CategoryPost::all();
    return view('pages.blog.edit', compact('blog', 'categories'));
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

  public function update(Request $request, Blog $blog)
  {
    $request->validate([
      'titulo' => 'required|string|max:255',
      'extracto' => 'nullable|string|max:255',
      'descripcion' => 'nullable|string',
      //'categoria_id' => 'required|exists:categories,id',
      'category_post_id' => 'required|exists:category_posts,id',
      'destacado' => 'nullable|boolean',

    ]);
    $originalSlug = Str::slug($request->titulo);
    $newTitle = $originalSlug;
    $count = 1;

    // Generar un slug único si el slug ya le pertenece a otro post
    while (Blog::where('slug', $newTitle)->where('id', '!=', $blog->id)->exists()) {
        $newTitle = $originalSlug . '-' . $count;
        $count++;
    }

    // Guardar el título anterior para actualizar el álbum y la carpeta
    $oldTitle = $blog->slug;

    \Log::info('Blog Update Debug', [
        'request_id' => $request->id,
        'blog_model_id' => $blog->id,
        'oldTitle' => $oldTitle,
        'newTitle' => $newTitle,
        'request_titulo' => $request->titulo,
    ]);
    try {
      $data = $request->all();
      // **Paso 1: Obtener la carpeta actual del producto**
      $mainFolder = 'Blogs';
      $subFolder = $oldTitle;
      $pathSubFolder = public_path("storage/images/albums/{$mainFolder}/{$subFolder}");

      if (!is_dir($pathSubFolder)) {
        mkdir($pathSubFolder, 0777, true);
      }

      // **Paso 2: Actualizar el álbum**
      $blogsAlbum = Album::firstOrCreate([
        'name' => 'Blogs',
      ], [
        'description' => 'Contenedor principal para los Productos.',
      ]);

      $album = Album::updateOrCreate(
        ['name' => $subFolder],
        ['parent_id' => $blogsAlbum->id]
      );

      // **Paso 3: Manejo de la imagen**
      if ($request->hasFile("imagen")) {
        // Eliminar la imagen anterior si existe
        if ($blog->imagen && file_exists(public_path($blog->imagen))) {
          unlink(public_path($blog->imagen));
        }

        $file = $request->file('imagen');
        $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();
        $file->move($pathSubFolder, $nombreImagen);
        $data['imagen'] = "storage/images/albums/{$mainFolder}/{$subFolder}/{$nombreImagen}";
      }

      // **Paso 5: Actualizar el Blog en la base de datos**
      $blog->update([
        'titulo' => $request->titulo,
        'extracto' => $request->extracto,
        'descripcion' => $request->descripcion,
        'destacado' => $request->has('destacado'),
        'imagen' => $data['imagen'] ?? $blog->imagen,
        'slug' => $newTitle,
        'fecha_publicacion' => $blog->fecha_publicacion,
        'fecha_descatado' => $request->has('destacado') ? date('Y-m-d') : $blog->fecha_descatado,
        'category_post_id' => $request->category_post_id
      ]);
      // Actualizar el álbum y la carpeta en el sistema de archivos
      $this->updateAlbumAndFolder($oldTitle, $newTitle);

      return redirect()->route('blog.index')->with('success', 'Post actualizado exitosamente.');
    } catch (ValidationException $e) {
      return redirect()->back()->withErrors($e->validator)->withInput();
    } catch (\Throwable $th) {
      return redirect()->route('blog.edit', $blog->id)->with('error', 'Error al actualizar el Post.');
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Blog $blog)
  {
    //
  }


  public function deleteBlog(Request $request)
  {
    try {
      $blog = Blog::find($request->id);

      if (!$blog) {
        return response()->json([
          'success' => false,
          'message' => 'Publicación no encontrada.'
        ], 404);
      }

      $blog->delete();

      return response()->json([
        'success' => true,
        'message' => 'Publicación eliminada correctamente.',
        'redirect' => route('blog.index')
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
      ], 500);
    }
  }




  public function updateVisible(Request $request)
  {
    // Lógica para manejar la solicitud AJAX
    //return response()->json(['mensaje' => 'Solicitud AJAX manejada con éxito']);
    $id = $request->id;

    $field = $request->field;

    $status = $request->status;

    $service = Blog::findOrFail($id);

    $service->$field = $status;

    $service->save();


    return response()->json(['success' => true, 'message' => 'Post Actualizado.', 'redirect' => route('blog.index')]);
  }
}

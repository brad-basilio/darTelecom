<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Album;
use App\Models\AlbumImage;
use App\Models\ClientLogos;
use App\Models\General;
use App\Models\Service;
use App\Models\ServiceView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

use Intervention\Image\Drivers\Gd\Driver;
//use Illuminate\Support\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use Intervention\Image\ImageManager;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $servicios = Service::all();
        $servicioPage = ServiceView::first();

        return view('pages.service.index', compact('servicios', 'servicioPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('pages.service.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'icono' => 'required|file|mimes:svg',
            'descripcion_breve' => 'required|string',
            'descripcion_extensa' => 'nullable|string',
            'imagen_principal' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            // Generar slug único
            $slug = Str::slug($request->title);
            while (Service::where('slug', $slug)->exists()) {
                $slug = Str::slug($request->title) . '-' . uniqid();
            }

            // Crear la carpeta principal "Servicios" si no existe
            $mainFolder = 'Servicios';
            $pathMainFolder = public_path('storage/images/albums/' . $mainFolder);
            if (!is_dir($pathMainFolder)) {
                mkdir($pathMainFolder, 0777, true);
            }

            // Crear la subcarpeta con el nombre del servicio
            $subFolder = $slug;
            $pathSubFolder = $pathMainFolder . '/' . $subFolder;
            if (!is_dir($pathSubFolder)) {
                mkdir($pathSubFolder, 0777, true);
            }

            // Crear el álbum del servicio
            $ServicesAlbum = Album::firstOrCreate(
                ['name' => 'Servicios'],
                ['description' => 'Contenedor principal para los Servicios.']
            );

            $album = Album::updateOrCreate(
                ['name' => $subFolder],
                ['parent_id' => $ServicesAlbum->id]
            );

            // Guardar el servicio
            $service = new Service();
            $service->title = $request->title;
            $service->slug = $slug;
            $service->subtitle = $request->subtitle;
            $service->descripcion_breve = $request->descripcion_breve;
            $service->descripcion_extensa = $request->descripcion_extensa;


            // Guardar el icono
            if ($request->hasFile("icono")) {
                $file = $request->file('icono');
                $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();
                $ruta = 'storage/images/servicios/';

                if (!file_exists(public_path($ruta))) {
                    mkdir(public_path($ruta), 0777, true);
                }

                $file->move(public_path($ruta), $nombreImagen);
                $service->icono = $ruta . $nombreImagen;
            }

            // Guardar la imagen principal
            if ($request->hasFile("imagen_principal")) {
                $file = $request->file('imagen_principal');
                $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();
                $ruta = 'storage/images/servicios/principales/';

                if (!file_exists(public_path($ruta))) {
                    mkdir(public_path($ruta), 0777, true);
                }

                $file->move(public_path($ruta), $nombreImagen);
                $service->imagen_principal = $ruta . $nombreImagen;
            }

            $service->save();

            // Subir imágenes de la galería
            $this->uploadImages($request, $album);

            return redirect()->route('servicios.index')->with('success', 'Servicio creado exitosamente.');
        } catch (\Throwable $th) {
            return redirect()->route('servicios.create')
                ->with('error', 'Error al crear el servicio: ' . $th->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service, $id)
    {

        $servicios = Service::find($id);
        $albumName = $servicios->slug;
        $album = Album::where('name', $albumName)->withCount('images', 'children')->first();

        if ($album) {
            $album->load('children', 'images');
        }
        return view('pages.service.edit', compact('servicios', 'album'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'descripcion_breve' => 'nullable|string',
            'descripcion_extensa' => 'nullable|string',
            'icono' => 'nullable|file|mimes:svg',
            'imagen_principal' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $service = Service::findOrfail($id);
        $service->title = $request->title;
        $service->subtitle = $request->subtitle;
        $service->descripcion_breve = $request->descripcion_breve;
        $service->descripcion_extensa = $request->descripcion_extensa;


        // Si el usuario sube un nuevo icono
        if ($request->hasFile("icono")) {
            // Elimina el archivo anterior si existe
            if (File::exists(public_path($service->icono))) {
                File::delete(public_path($service->icono));
            }

            // Obtiene el nuevo archivo
            $file = $request->file('icono');
            $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();
            $ruta = 'storage/images/servicios/';

            // Mueve el archivo a la carpeta deseada
            $file->move(public_path($ruta), $nombreImagen);

            // Actualiza el campo icono con la nueva ruta
            $service->icono = $ruta . $nombreImagen;
        }

        // Si el usuario sube una nueva imagen principal
        if ($request->hasFile("imagen_principal")) {
            // Elimina el archivo anterior si existe
            if ($service->imagen_principal && File::exists(public_path($service->imagen_principal))) {
                File::delete(public_path($service->imagen_principal));
            }

            // Obtiene el nuevo archivo
            $file = $request->file('imagen_principal');
            $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();
            $ruta = 'storage/images/servicios/principales/';

            if (!file_exists(public_path($ruta))) {
                mkdir(public_path($ruta), 0777, true);
            }

            // Mueve el archivo a la carpeta deseada
            $file->move(public_path($ruta), $nombreImagen);

            // Actualiza el campo imagen_principal con la nueva ruta
            $service->imagen_principal = $ruta . $nombreImagen;
        }

        $service->update();

        return redirect()->route('servicios.index')->with('success', 'Servicio actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction(); // Iniciar una transacción para asegurar la atomicidad

        try {
            // Obtener el producto
            $servicio = Service::findOrFail($request->id);

            // Obtener el álbum asociado al producto
            $album = Album::where('name', $servicio->slug)->first();

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
                $servicio->delete();

                // Eliminar la carpeta del álbum
                $folderPath = public_path("storage/images/albums/Servicios/{$servicio->slug}");
                if (is_dir($folderPath)) {
                    // Eliminar la carpeta y su contenido
                    array_map('unlink', glob("$folderPath/*")); // Eliminar archivos dentro de la carpeta
                    rmdir($folderPath); // Eliminar la carpeta
                }
            }

            if (File::exists(public_path($servicio->icono))) {
                File::delete(public_path($servicio->icono));
            }
            // Eliminar el producto (soft delete)
            // $product->status = 0;
            $servicio->delete();

            DB::commit(); // Confirmar la transacción

            return response()->json([
                'success' => true,
                'message' => 'Servicio, álbum e imágenes eliminados correctamente.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // Revertir la transacción en caso de error

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Ocurrió un problema al eliminar el producto y sus recursos asociados.',
                    'error' => $e->getMessage(),
                ],
                500
            );
        }
    }


    public function deleteService(Request $request)
    {
        //Recupero el id mandado mediante ajax
        $id = $request->id;
        //Busco el servicio con id como parametro
        $service = Service::findOrfail($id);
        // Elimina el archivo anterior si existe


        $service->delete();

        // Devuelvo una respuesta JSON u otra respuesta según necesites
        return response()->json(['message' => 'Servicio eliminado.']);
    }



    public function updateVisible(Request $request)
    {
        $id = $request->id;
        $visible = $request->visible;

        // Encontrar el servicio
        $service = Service::findOrFail($id);

        // Actualizar la visibilidad
        $service->visible = $visible;
        $service->save();

        // Obtener el título del servicio para enviar en la respuesta
        $titleService = $service->title;

        // Retornar la respuesta JSON con el mensaje y el título del servicio
        return response()->json([
            'message' =>
            $service->visible == 1 ? 'Servicio Visible.' : 'Servicio No Visible.',
            'titleService' => $titleService
        ]);
    }

    public function updatePageServicio(Request $request, $id)
    {
        $servicioPage = ServiceView::findOrfail($id);


        // Verificar si se ha subido una nueva imagen
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $routeImg = 'storage/images/servicios/';
            $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();

            // Si existe una imagen anterior, eliminarla
            if ($servicioPage->image && File::exists(public_path($routeImg . $servicioPage->image))) {
                File::delete(public_path($routeImg . $servicioPage->image));
            }

            // Procesar la imagen (redimensionar y hacer crop)
            $manager = new ImageManager(new Driver());
            $img = $manager->read($file);
            if (!file_exists(public_path($routeImg))) {
                mkdir(public_path($routeImg), 0777, true); // Crear la ruta si no existe
            }

            // Mover la nueva imagen a la carpeta de destino
            $file->move(public_path($routeImg), $nombreImagen);


            // Actualizar el campo de imagen en la base de datos
            $servicioPage->imagen = $routeImg . $nombreImagen;  // Solo el nombre de la imagen
        }

        // Actualizar otros campos
        $servicioPage->titulo = $request->titulo;
        $servicioPage->subtitulo = $request->subtitulo;

        // Guardar los cambios
        $servicioPage->save();

        return back()->with('success', 'Registro actualizado correctamente');
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
                $ruta = 'storage/images/albums/Servicios/' . $album->name . '/';

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
            $album->load('images');
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

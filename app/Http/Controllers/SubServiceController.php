<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\SubService;
use App\Models\Album;
use App\Models\AlbumImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($serviceId)
    {
        $service = Service::findOrFail($serviceId);
        $subservicios = $service->subServices;
        
        return view('pages.subservice.index', compact('service', 'subservicios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($serviceId)
    {
        $service = Service::findOrFail($serviceId);
        return view('pages.subservice.create', compact('service'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $serviceId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'icono' => 'nullable|file|mimes:svg',
            'descripcion_breve' => 'nullable|string',
            'beneficios' => 'nullable|string',
            'descripcion_extensa' => 'nullable|string',
            'visible' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $service = Service::findOrFail($serviceId);
            
            // Crear el álbum contenedor principal para subservicios
            $SubservicesAlbum = Album::firstOrCreate(
                ['name' => 'Subservicios'],
                ['description' => 'Contenedor principal para los Subservicios.']
            );

            // Generar slug único (verificar tanto en SubService como en Album globalmente)
            $baseSlug = Str::slug($request->title);
            $slug = $baseSlug;
            
            while (
                SubService::where('slug', $slug)->exists() || 
                Album::where('name', $slug)->exists()
            ) {
                $slug = $baseSlug . '-' . Str::random(6);
            }

            // Crear las carpetas necesarias
            $mainFolder = 'Subservicios';
            $pathMainFolder = public_path('storage/images/albums/' . $mainFolder);
            if (!is_dir($pathMainFolder)) {
                mkdir($pathMainFolder, 0777, true);
            }

            $subFolder = $slug;
            $pathSubFolder = $pathMainFolder . '/' . $subFolder;
            if (!is_dir($pathSubFolder)) {
                mkdir($pathSubFolder, 0777, true);
            }

            // Crear el álbum del subservicio
            $album = Album::create([
                'name' => $subFolder,
                'parent_id' => $SubservicesAlbum->id
            ]);

            // Crear el subservicio
            $data = $request->all();
            $data['visible'] = $request->has('visible') ? 1 : 0;
            $data['service_id'] = $service->id;
            $data['slug'] = $slug;
            $data['album_id'] = $album->id;

            // Guardar el icono
            if ($request->hasFile("icono")) {
                $file = $request->file('icono');
                $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();
                $ruta = 'storage/images/subservicios/';

                if (!file_exists(public_path($ruta))) {
                    mkdir(public_path($ruta), 0777, true);
                }

                $file->move(public_path($ruta), $nombreImagen);
                $data['icono'] = $ruta . $nombreImagen;
            }

            $subService = SubService::create($data);

            // Subir imágenes de la galería
            $this->uploadImages($request, $album);

            return redirect()->route('subservicios.index', $service->id)
                            ->with('success', 'Subservicio creado exitosamente.');
        } catch (\Throwable $th) {
            return redirect()->route('subservicios.create', $service->id)
                ->with('error', 'Error al crear el subservicio: ' . $th->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($serviceId, $id)
    {
        $service = Service::findOrFail($serviceId);
        $subservicio = SubService::where('service_id', $serviceId)->findOrFail($id);
        
        // Asegurarse de que exista un álbum para este subservicio (crear si no existe)
        $albumName = $subservicio->slug;

        // Álbum contenedor principal para subservicios
        $parentAlbum = Album::firstOrCreate(
            ['name' => 'Subservicios'],
            ['description' => 'Contenedor principal para los Subservicios.']
        );

        // Crear o recuperar el álbum específico del subservicio bajo el contenedor
        $album = Album::firstOrCreate(
            ['name' => $albumName, 'parent_id' => $parentAlbum->id],
            ['description' => 'Álbum para el subservicio: ' . $subservicio->title]
        );

        $album->load('children', 'images');

        return view('pages.subservice.edit', compact('service', 'subservicio', 'album'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $serviceId, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'icono' => 'nullable|file|mimes:svg',
            'descripcion_breve' => 'nullable|string',
            'beneficios' => 'nullable|string',
            'descripcion_extensa' => 'nullable|string',
            'visible' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $service = Service::findOrFail($serviceId);
            $subService = SubService::where('service_id', $serviceId)->findOrFail($id);

            $data = $request->all();
            $data['visible'] = $request->has('visible') ? 1 : 0;

            // Actualizar slug si el título cambió
            if ($subService->title !== $request->title) {
                $slug = Str::slug($request->title);
                while (SubService::where('slug', $slug)->where('id', '!=', $subService->id)->exists()) {
                    $slug = Str::slug($request->title) . '-' . uniqid();
                }
                $data['slug'] = $slug;
            }

            // Guardar nuevo icono si se subió
            if ($request->hasFile("icono")) {
                // Eliminar icono anterior si existe
                if ($subService->icono && file_exists(public_path($subService->icono))) {
                    unlink(public_path($subService->icono));
                }

                $file = $request->file('icono');
                $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();
                $ruta = 'storage/images/subservicios/';

                if (!file_exists(public_path($ruta))) {
                    mkdir(public_path($ruta), 0777, true);
                }

                $file->move(public_path($ruta), $nombreImagen);
                $data['icono'] = $ruta . $nombreImagen;
            }

            $subService->update($data);

            // Subir nuevas imágenes de la galería si existen
            if ($request->hasFile('images') && $subService->album) {
                $this->uploadImages($request, $subService->album);
            }

            return redirect()->route('subservicios.index', $service->id)
                            ->with('success', 'Subservicio actualizado exitosamente.');
        } catch (\Throwable $th) {
            return redirect()->route('subservicios.edit', [$service->id, $subService->id])
                ->with('error', 'Error al actualizar el subservicio: ' . $th->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($serviceId, $id)
    {
        $service = Service::findOrFail($serviceId);
        $subService = SubService::where('service_id', $serviceId)->findOrFail($id);
        
        $subService->delete();

        return redirect()->route('subservicios.index', $service->id)
                        ->with('success', 'Subservicio eliminado exitosamente.');
    }

    /**
     * Remove the specified resource from storage via AJAX
     */
    public function destroyAjax(Request $request, $serviceId)
    {
        $service = Service::findOrFail($serviceId);
        $subService = SubService::where('service_id', $serviceId)->findOrFail($request->id);
        
        $subService->delete();

        return response()->json([
            'success' => true,
            'message' => 'Subservicio eliminado exitosamente.'
        ]);
    }

    /**
     * Update visibility of subservice
     */
    public function updateVisible(Request $request)
    {
        $subService = SubService::findOrFail($request->id);
        $subService->visible = $request->visible;
        $subService->save();

        return response()->json([
            'success' => true,
            'message' => 'Visibilidad actualizada exitosamente.'
        ]);
    }

    /**
     * Upload images to subservice album
     */
    public function uploadImages(Request $request, Album $album)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();
                $ruta = 'storage/images/albums/Subservicios/' . $album->name . '/';

                if (!is_dir(public_path($ruta))) {
                    mkdir(public_path($ruta), 0777, true);
                }

                $file->move(public_path($ruta), $nombreImagen);

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

    /**
     * Remove specified image from album
     */
    public function destroyImage(AlbumImage $image)
    {
        try {
            // Eliminar el archivo físico
            if (file_exists(public_path($image->url_image))) {
                unlink(public_path($image->url_image));
            }

            // Eliminar el registro de la base de datos
            $image->delete();

            return response()->json([
                'success' => true,
                'message' => 'Imagen eliminada exitosamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la imagen: ' . $e->getMessage()
            ]);
        }
    }
}

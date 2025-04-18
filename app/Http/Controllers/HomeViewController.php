<?php

namespace App\Http\Controllers;

use App\Models\HomeView;
use App\Http\Requests\StoreHomeViewRequest;
use App\Http\Requests\UpdateHomeViewRequest;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class HomeViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHomeViewRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(HomeView $homeView)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomeView $homeView)
    {
        $homeview = HomeView::first();
        if (!$homeview) {
            $homeview = HomeView::create();
        }
        return view('pages.homeview.edit', compact('homeview'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $homeview = HomeView::findOrfail($id);
        try {
            $data = $request->all();
            // **Paso 1: Obtener la carpeta actual del Home**
            $mainFolder = 'HomeView';
            $subFolder = "image";
            $pathSubFolder = public_path("storage/images/albums/{$mainFolder}/{$subFolder}");

            if (!is_dir($pathSubFolder)) {
                mkdir($pathSubFolder, 0777, true);
            }

            // **Paso 2: Actualizar el álbum**
            $blogsAlbum = Album::firstOrCreate(
                [
                    'name' => 'HomeView',
                ],
                [
                    'description' => 'Contenedor principal para los Productos.',
                ]
            );

            $album = Album::updateOrCreate(
                ['name' => $subFolder],
                ['parent_id' => $blogsAlbum->id]
            );

            // **Paso 3: Manejo de la imagen**
            if ($request->hasFile("imageNewsletter")) {
                // Eliminar la imagen anterior si existe
                if ($homeview->imageNewsletter && file_exists(public_path($homeview->imageNewsletter))) {
                    unlink(public_path($homeview->imageNewsletter));
                }

                $file = $request->file('imageNewsletter');
                $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();
                $file->move($pathSubFolder, $nombreImagen);
                $data['imageNewsletter'] = "storage/images/albums/{$mainFolder}/{$subFolder}/{$nombreImagen}";
            }

            // **Paso 5: Actualizar el Blog en la base de datos**
            $homeview->update([
                //hero section
                'titleHero' => $request->titleHero,
                'subtitleHero' => $request->subtitleHero,
                'titleServicios' => $request->titleServicios,
                'subtitleServicios' => $request->subtitleServicios,
                'titleProductos' => $request->titleProductos,
                'subtitleProductos' => $request->subtitleProductos,
                'titleBlogs' => $request->titleBlogs,
                'subtitleBlogs' => $request->subtitleBlogs,
                'titleNewsletter' => $request->titleNewsletter,
                'imageNewsletter' => $data['imageNewsletter'] ?? $homeview->imageNewsletter,
            ]);
            $homeview->save();
            return back()->with('success', 'Registro actualizado correctamente');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Throwable $th) {

            return redirect()->route('homeview.edit', $id)->with('error', 'Error al actualizar el Post.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomeView $homeView)
    {
        //
    }
}

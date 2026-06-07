<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Blog;

class CleanupDuplicateBlogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blogs:cleanup-duplicates {slug?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpia los blogs duplicados que tengan el mismo slug, conservando solo el visible o el primero.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $targetSlug = $this->argument('slug') ?? 'arquitectura-mixta-para-un-isp-como-construir-una-red-estable-y-escalable';
        
        $this->info("Buscando duplicados para el slug: " . $targetSlug);

        $blogs = Blog::where('slug', $targetSlug)->get();

        if ($blogs->count() <= 1) {
            $this->info("No se encontraron duplicados. Solo hay " . $blogs->count() . " post(s) con ese slug.");
            return;
        }

        $keepId = null;

        // 1. Buscamos cuál es el que está visible para conservarlo
        foreach ($blogs as $blog) {
            if (isset($blog->visible) && $blog->visible) {
                $keepId = $blog->id;
                break;
            }
        }

        // 2. Si ninguno está visible, conservamos el primero
        if (!$keepId) {
            $keepId = $blogs->first()->id;
        }

        // 3. Borramos todos los demás
        $deletedCount = 0;
        foreach ($blogs as $blog) {
            if ($blog->id !== $keepId) {
                $this->warn("Borrando duplicado ID: " . $blog->id);
                $blog->delete();
                $deletedCount++;
            }
        }

        $this->info("✅ Limpieza completada. Se eliminaron {$deletedCount} duplicados.");
        $this->info("✅ Se conservó únicamente el Blog con ID: {$keepId}.");
    }
}

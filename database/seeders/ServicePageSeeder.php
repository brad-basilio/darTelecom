<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicePageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si ya existe un registro para la página de servicios
        $exists = DB::table('service_pages')->where('id', 1)->exists();
        
        if (!$exists) {
            DB::table('service_pages')->insert([
                'id' => 1,
                'titulo' => 'Nuestros Servicios ISP',
                'subtitulo' => 'Soluciones integrales para proveedores de servicios de internet. Desde gestión proactiva hasta consultoría especializada, tenemos todo lo que necesitas para hacer crecer tu ISP.',
                'imagen' => 'images/banners/servicios-banner.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $this->command->info('Página de servicios creada exitosamente!');
        } else {
            $this->command->info('La página de servicios ya existe.');
        }
    }
}

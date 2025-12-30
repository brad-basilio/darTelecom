<?php

namespace App\View\Components\Custom;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ServicioBeneficio extends Component
{
    /**
     * Create a new component instance.
     */
    public $beneficios;
    public $icono;
    public function __construct($text, $icono)
    {
        // Convertir el string en un array de beneficios con títulos personalizables
        // Formato: "Título 1|Descripción 1;Título 2|Descripción 2" o "Descripción 1;Descripción 2" (títulos por defecto)
        $this->icono = $icono;
        $items = explode(';', $text);
        $this->beneficios = [];
        
        foreach ($items as $index => $item) {
            $item = trim($item);
            if (empty($item)) continue;
            
            // Verificar si tiene el formato título|descripción
            if (strpos($item, '|') !== false) {
                $parts = explode('|', $item, 2);
                $this->beneficios[] = [
                    'titulo' => trim($parts[0]),
                    'descripcion' => trim($parts[1] ?? '')
                ];
            } else {
                // Formato antiguo: solo descripción, título por defecto
                $this->beneficios[] = [
                    'titulo' => 'Beneficio ' . ($index + 1),
                    'descripcion' => $item
                ];
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.custom.servicio-beneficio', ['beneficios' => $this->beneficios, 'icono' => $this->icono]);
    }
}

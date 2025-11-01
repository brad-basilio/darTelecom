<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\SubService;
use App\Models\Album;
use Illuminate\Support\Str;

class ServicesAndSubServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar datos existentes para evitar duplicados
        $this->command->info('Limpiando datos existentes...');
        
        SubService::whereHas('service', function($query) {
            $query->whereIn('slug', [
                'gestion-proactiva-isp',
                'integracion-isp-automatizacion', 
                'infraestructura-segura-optimizada',
                'soporte-consultoria-tecnica'
            ]);
        })->delete();
        
        Service::whereIn('slug', [
            'gestion-proactiva-isp',
            'integracion-isp-automatizacion', 
            'infraestructura-segura-optimizada',
            'soporte-consultoria-tecnica'
        ])->delete();
        
        Album::whereIn('name', [
            'gestion-proactiva-isp',
            'integracion-isp-automatizacion',
            'infraestructura-segura-optimizada', 
            'soporte-consultoria-tecnica'
        ])->delete();

        // Crear el álbum principal para Subservicios
        $SubservicesAlbum = Album::firstOrCreate(
            ['name' => 'Subservicios'],
            ['description' => 'Contenedor principal para los Subservicios.']
        );

        // 1. SERVICIO: Gestión Proactiva ISP
        $service1 = Service::create([
            'title' => 'Gestión Proactiva ISP',
            'slug' => 'gestion-proactiva-isp',
            'subtitle' => 'Monitoreo y gestión avanzada para proveedores de internet',
            'icono' => 'images/icons/gestion-proactiva.svg',
            'descripcion_breve' => 'Solución integral de monitoreo y gestión proactiva diseñada específicamente para proveedores de servicios de internet, garantizando máxima disponibilidad y rendimiento óptimo de la red.',
            'descripcion_extensa' => '<p>Nuestro servicio de <strong>Gestión Proactiva ISP</strong> ofrece una solución completa para el monitoreo, administración y optimización continua de infraestructuras de proveedores de servicios de internet.</p><p>Mediante herramientas especializadas y un equipo técnico altamente capacitado, proporcionamos supervisión 24/7, detección temprana de problemas, y respuesta inmediata ante incidencias que puedan afectar la calidad del servicio.</p><p>Esta solución incluye dashboards personalizados, alertas inteligentes, análisis predictivo y reportes detallados que permiten tomar decisiones informadas para mejorar la experiencia del cliente final.</p>',
            'imagen_principal' => 'images/services/gestion-proactiva-principal.jpg',
            'visible' => 1
        ]);

        // Crear álbum para subservicios del servicio 1
        $album1 = Album::create([
            'name' => 'gestion-proactiva-isp',
            'parent_id' => $SubservicesAlbum->id
        ]);

        // Subservicios del Servicio 1
        SubService::create([
            'service_id' => $service1->id,
            'album_id' => $album1->id,
            'title' => 'Monitoreo Proactivo',
            'slug' => 'monitoreo-proactivo',
            'subtitle' => 'Supervisión continua 24/7 de su infraestructura de red',
            'icono' => 'images/icons/monitoreo-proactivo.svg',
            'descripcion_breve' => 'Monitoreo continuo de todos los elementos críticos de su red con alertas tempranas y análisis predictivo para prevenir incidencias antes de que afecten a los usuarios.',
            'beneficios' => 'Detección temprana de problemas; Reducción del 95% en tiempo de inactividad; Alertas inteligentes personalizables; Dashboards en tiempo real; Análisis predictivo avanzado; Reportes automáticos detallados',
            'descripcion_extensa' => '<p>El <strong>Monitoreo Proactivo</strong> es la base fundamental de una gestión eficiente de redes ISP. Nuestro sistema supervisa de forma continua todos los componentes críticos de su infraestructura.</p><p><strong>Características principales:</strong></p><ul><li>Monitoreo 24/7 de equipos, enlaces y servicios</li><li>Alertas inteligentes con escalamiento automático</li><li>Análisis de tendencias y predicción de fallos</li><li>Integración con sistemas de ticketing</li><li>Reportes de disponibilidad y rendimiento</li></ul><p>Con esta solución, anticipamos problemas antes de que impacten a sus clientes, garantizando una experiencia de servicio excepcional.</p>',
            'visible' => 1
        ]);

        SubService::create([
            'service_id' => $service1->id,
            'album_id' => $album1->id,
            'title' => 'Hub Center ISP',
            'slug' => 'hub-center-isp',
            'subtitle' => 'Centro de comando y control centralizado para ISPs',
            'icono' => 'images/icons/hub-center-isp.svg',
            'descripcion_breve' => 'Plataforma centralizada de gestión que integra todos los aspectos operativos de su ISP en un solo lugar, optimizando la eficiencia y control de sus operaciones.',
            'beneficios' => 'Gestión centralizada de toda la red; Interfaz intuitiva y personalizable; Integración con múltiples sistemas; Automatización de procesos operativos; Reducción de costos operativos; Mayor eficiencia del equipo técnico',
            'descripcion_extensa' => '<p>El <strong>Hub Center ISP</strong> es una plataforma integral que centraliza la gestión de todos los aspectos operativos de su proveedor de servicios de internet.</p><p><strong>Funcionalidades clave:</strong></p><ul><li>Dashboard unificado con métricas en tiempo real</li><li>Gestión centralizada de clientes y servicios</li><li>Control de inventario y activos de red</li><li>Automatización de procesos rutinarios</li><li>Integración con sistemas de facturación y CRM</li><li>Reportes ejecutivos y operativos</li></ul><p>Esta herramienta transforma la manera en que opera su ISP, proporcionando visibilidad completa y control total desde una sola plataforma.</p>',
            'visible' => 1
        ]);

        SubService::create([
            'service_id' => $service1->id,
            'album_id' => $album1->id,
            'title' => 'Asistencia Técnica Especializada',
            'slug' => 'asistencia-tecnica-especializada',
            'subtitle' => 'Soporte técnico experto disponible 24/7',
            'icono' => 'images/icons/asistencia-tecnica.svg',
            'descripcion_breve' => 'Equipo de ingenieros especializados en tecnologías ISP disponible las 24 horas para resolver incidencias críticas y brindar soporte técnico avanzado.',
            'beneficios' => 'Soporte técnico 24/7/365; Ingenieros certificados especializados; Tiempo de respuesta garantizado; Resolución remota de incidencias; Escalamiento automático; Documentación detallada de casos',
            'descripcion_extensa' => '<p>Nuestro servicio de <strong>Asistencia Técnica Especializada</strong> pone a su disposición un equipo de ingenieros altamente capacitados en tecnologías ISP.</p><p><strong>Servicios incluidos:</strong></p><ul><li>Soporte técnico 24/7 con diferentes niveles de escalamiento</li><li>Resolución remota de incidencias complejas</li><li>Análisis de causa raíz de problemas recurrentes</li><li>Asesoría en optimización de configuraciones</li><li>Soporte en actualizaciones y mantenimientos</li><li>Documentación técnica y procedimientos</li></ul><p>Con tiempos de respuesta garantizados y un equipo experto, aseguramos que su operación técnica funcione sin contratiempos.</p>',
            'visible' => 1
        ]);

        // 2. SERVICIO: Integración ISP & Automatización
        $service2 = Service::create([
            'title' => 'Integración ISP & Automatización',
            'slug' => 'integracion-isp-automatizacion',
            'subtitle' => 'Integración perfecta con las principales plataformas ISP',
            'icono' => 'images/icons/integracion-automatizacion.svg',
            'descripcion_breve' => 'Servicios especializados de integración con las principales plataformas de gestión ISP del mercado, automatizando procesos y sincronizando datos para máxima eficiencia operativa.',
            'descripcion_extensa' => '<p>Nuestro servicio de <strong>Integración ISP & Automatización</strong> conecta de manera fluida su infraestructura con las principales plataformas de gestión ISP del mercado.</p><p>Especializados en integrar sistemas como Wishub, SmartOLT y Mikrowisp, eliminamos silos de información y automatizamos procesos críticos para su operación.</p><p>Estas integraciones permiten sincronización en tiempo real de datos, automatización de aprovisionamiento de servicios, y una visión unificada de toda su operación ISP desde múltiples plataformas.</p>',
            'imagen_principal' => 'images/services/integracion-automatizacion-principal.jpg',
            'visible' => 1
        ]);

        // Crear álbum para subservicios del servicio 2
        $album2 = Album::create([
            'name' => 'integracion-isp-automatizacion', 
            'parent_id' => $SubservicesAlbum->id
        ]);

        // Subservicios del Servicio 2
        SubService::create([
            'service_id' => $service2->id,
            'album_id' => $album2->id,
            'title' => 'Integración con Wishub',
            'slug' => 'integracion-wishub',
            'subtitle' => 'Conectividad completa con la plataforma Wishub',
            'icono' => 'images/icons/wishub-integration.svg',
            'descripcion_breve' => 'Integración especializada con Wishub para automatizar la gestión de clientes, facturación y aprovisionamiento de servicios, maximizando la eficiencia operativa.',
            'beneficios' => 'Sincronización automática de datos; Aprovisionamiento instantáneo de servicios; Facturación automatizada; Gestión unificada de clientes; APIs robustas y confiables; Actualizaciones en tiempo real',
            'descripcion_extensa' => '<p>La <strong>Integración con Wishub</strong> conecta su infraestructura de red directamente con esta poderosa plataforma de gestión ISP.</p><p><strong>Capacidades de integración:</strong></p><ul><li>Sincronización bidireccional de datos de clientes</li><li>Aprovisionamiento automático de servicios de internet</li><li>Facturación automatizada basada en uso real</li><li>Gestión de inventario sincronizada</li><li>Reportes unificados y análisis avanzado</li><li>APIs personalizadas para necesidades específicas</li></ul><p>Esta integración elimina la necesidad de entrada manual de datos y reduce significativamente los errores operativos.</p>',
            'visible' => 1
        ]);

        SubService::create([
            'service_id' => $service2->id,
            'album_id' => $album2->id,
            'title' => 'Integración con SmartOLT',
            'slug' => 'integracion-smartolt',
            'subtitle' => 'Gestión automatizada de equipos OLT con SmartOLT',
            'icono' => 'images/icons/smartolt-integration.svg',
            'descripcion_breve' => 'Integración avanzada con SmartOLT para automatizar la gestión de equipos OLT, aprovisionamiento de ONTs y monitoreo de redes FTTH.',
            'beneficios' => 'Gestión automatizada de OLTs; Aprovisionamiento masivo de ONTs; Monitoreo en tiempo real; Configuración centralizada; Diagnósticos automáticos; Reportes de rendimiento FTTH',
            'descripcion_extensa' => '<p>Nuestra <strong>Integración con SmartOLT</strong> optimiza la gestión de su infraestructura de fibra óptica y equipos OLT.</p><p><strong>Funcionalidades principales:</strong></p><ul><li>Aprovisionamiento automático y masivo de ONTs</li><li>Monitoreo continuo de señales ópticas</li><li>Gestión centralizada de múltiples OLTs</li><li>Diagnósticos automáticos de problemas de conectividad</li><li>Reportes detallados de rendimiento FTTH</li><li>Integración con sistemas de ticketing</li></ul><p>Esta solución reduce drásticamente el tiempo de activación de servicios y mejora la calidad del servicio FTTH.</p>',
            'visible' => 1
        ]);

        SubService::create([
            'service_id' => $service2->id,
            'album_id' => $album2->id,
            'title' => 'Integración con Mikrowisp',
            'slug' => 'integracion-mikrowisp',
            'subtitle' => 'Conectividad perfecta con la plataforma Mikrowisp',
            'icono' => 'images/icons/mikrowisp-integration.svg',
            'descripcion_breve' => 'Integración completa con Mikrowisp para automatizar la gestión de redes inalámbricas, control de ancho de banda y administración de clientes.',
            'beneficios' => 'Gestión automática de QoS; Control dinámico de ancho de banda; Autenticación centralizada; Monitoreo de enlaces wireless; Reportes de uso detallados; Gestión de hotspots',
            'descripcion_extensa' => '<p>La <strong>Integración con Mikrowisp</strong> potencia su infraestructura inalámbrica con automatización avanzada y control granular.</p><p><strong>Características destacadas:</strong></p><ul><li>Control automático de calidad de servicio (QoS)</li><li>Gestión dinámica de ancho de banda por cliente</li><li>Autenticación centralizada y segura</li><li>Monitoreo en tiempo real de enlaces wireless</li><li>Gestión avanzada de hotspots y puntos de acceso</li><li>Reportes detallados de consumo y rendimiento</li></ul><p>Esta integración optimiza el rendimiento de su red inalámbrica y mejora significativamente la experiencia del usuario final.</p>',
            'visible' => 1
        ]);

        // 3. SERVICIO: Infraestructura Segura y Optimizada
        $service3 = Service::create([
            'title' => 'Infraestructura Segura y Optimizada',
            'slug' => 'infraestructura-segura-optimizada',
            'subtitle' => 'Infraestructura robusta, segura y de alto rendimiento',
            'icono' => 'images/icons/infraestructura-segura.svg',
            'descripcion_breve' => 'Implementación y gestión de infraestructura de red segura y optimizada, incluyendo servidores de pruebas de velocidad, sistemas de monitoreo avanzado y soluciones de seguridad IDS/IPS.',
            'descripcion_extensa' => '<p>Nuestro servicio de <strong>Infraestructura Segura y Optimizada</strong> proporciona las bases sólidas que su ISP necesita para operar con máxima eficiencia y seguridad.</p><p>Implementamos y gestionamos infraestructura crítica que incluye servidores de pruebas de velocidad para validar la calidad del servicio, sistemas de monitoreo proactivo para detectar problemas antes de que afecten a los usuarios, y soluciones avanzadas de seguridad DNS con protección IDS/IPS.</p><p>Esta infraestructura está diseñada para escalar con su crecimiento, mantener altos niveles de disponibilidad y proteger su red contra amenazas modernas de ciberseguridad.</p>',
            'imagen_principal' => 'images/services/infraestructura-segura-principal.jpg',
            'visible' => 1
        ]);

        // Crear álbum para subservicios del servicio 3
        $album3 = Album::create([
            'name' => 'infraestructura-segura-optimizada',
            'parent_id' => $SubservicesAlbum->id
        ]);

        // Subservicios del Servicio 3
        SubService::create([
            'service_id' => $service3->id,
            'album_id' => $album3->id,
            'title' => 'Implementación de Servidores SpeedTest',
            'slug' => 'servidores-speedtest',
            'subtitle' => 'Servidores de pruebas de velocidad dedicados y optimizados',
            'icono' => 'images/icons/speedtest-servers.svg',
            'descripcion_breve' => 'Implementación y gestión de servidores SpeedTest dedicados para medir con precisión la velocidad real de conexión de sus clientes y validar la calidad del servicio.',
            'beneficios' => 'Mediciones precisas de velocidad; Servidores dedicados optimizados; Múltiples ubicaciones geográficas; Reportes detallados de rendimiento; Integración con sistemas de monitoreo; Validación de SLA automática',
            'descripcion_extensa' => '<p>La <strong>Implementación de Servidores SpeedTest</strong> proporciona a su ISP la capacidad de medir con precisión la velocidad real de conexión que reciben sus clientes.</p><p><strong>Beneficios clave:</strong></p><ul><li>Servidores SpeedTest dedicados y optimizados</li><li>Múltiples ubicaciones para pruebas geográficamente distribuidas</li><li>Mediciones precisas sin interferencia de terceros</li><li>Reportes automáticos de rendimiento por zona</li><li>Validación automática de cumplimiento de SLA</li><li>Integración con sistemas de monitoreo existentes</li></ul><p>Estos servidores le permiten demostrar la calidad real de su servicio y identificar proactivamente áreas que necesitan optimización.</p>',
            'visible' => 1
        ]);

        SubService::create([
            'service_id' => $service3->id,
            'album_id' => $album3->id,
            'title' => 'Monitoreo',
            'slug' => 'monitoreo-infraestructura',
            'subtitle' => 'Sistema avanzado de monitoreo de infraestructura',
            'icono' => 'images/icons/monitoreo-infraestructura.svg',
            'descripcion_breve' => 'Sistema integral de monitoreo que supervisa todos los componentes críticos de su infraestructura, proporcionando visibilidad completa y alertas proactivas.',
            'beneficios' => 'Monitoreo integral 24/7; Alertas proactivas personalizables; Dashboards en tiempo real; Análisis histórico de tendencias; Reportes automáticos; Integración con múltiples plataformas',
            'descripcion_extensa' => '<p>Nuestro sistema de <strong>Monitoreo</strong> de infraestructura proporciona visibilidad completa de todos los componentes críticos de su red ISP.</p><p><strong>Capacidades de monitoreo:</strong></p><ul><li>Supervisión 24/7 de equipos de red, servidores y enlaces</li><li>Alertas inteligentes con escalamiento automático</li><li>Dashboards personalizables con métricas en tiempo real</li><li>Análisis histórico y predicción de tendencias</li><li>Reportes automáticos de disponibilidad y rendimiento</li><li>Integración con sistemas de ticketing y notificaciones</li></ul><p>Este sistema le permite mantener alta disponibilidad y detectar problemas antes de que impacten a sus clientes.</p>',
            'visible' => 1
        ]);

        SubService::create([
            'service_id' => $service3->id,
            'album_id' => $album3->id,
            'title' => 'DNS y Seguridad IDS/IPS',
            'slug' => 'dns-seguridad-ids-ips',
            'subtitle' => 'Soluciones avanzadas de DNS seguro y protección IDS/IPS',
            'icono' => 'images/icons/dns-security.svg',
            'descripcion_breve' => 'Implementación de servidores DNS seguros con protección avanzada IDS/IPS para detectar y prevenir amenazas de seguridad en tiempo real.',
            'beneficios' => 'DNS seguro y confiable; Protección IDS/IPS avanzada; Detección de amenazas en tiempo real; Filtrado de contenido malicioso; Logs detallados de seguridad; Actualizaciones automáticas de reglas',
            'descripcion_extensa' => '<p>Nuestro servicio de <strong>DNS y Seguridad IDS/IPS</strong> protege su infraestructura y usuarios contra amenazas modernas de ciberseguridad.</p><p><strong>Componentes de seguridad:</strong></p><ul><li>Servidores DNS seguros con filtrado de amenazas</li><li>Sistema IDS/IPS para detección y prevención de intrusiones</li><li>Filtrado automático de contenido malicioso</li><li>Análisis de tráfico en tiempo real</li><li>Logs detallados de eventos de seguridad</li><li>Actualizaciones automáticas de bases de datos de amenazas</li></ul><p>Esta solución integral protege tanto su infraestructura como a sus clientes contra malware, phishing y otros ataques cibernéticos.</p>',
            'visible' => 1
        ]);

        // 4. SERVICIO: Soporte y Consultoría Técnica
        $service4 = Service::create([
            'title' => 'Soporte y Consultoría Técnica',
            'slug' => 'soporte-consultoria-tecnica',
            'subtitle' => 'Expertise técnico especializado para optimizar su operación',
            'icono' => 'images/icons/soporte-consultoria.svg',
            'descripcion_breve' => 'Servicios especializados de soporte técnico y consultoría experta en tecnologías Mikrotik y diseño de redes, proporcionando el conocimiento técnico necesario para optimizar su infraestructura ISP.',
            'descripcion_extensa' => '<p>Nuestro servicio de <strong>Soporte y Consultoría Técnica</strong> pone a su disposición años de experiencia y expertise especializado en tecnologías ISP.</p><p>Ofrecemos desde soporte técnico especializado en equipos Mikrotik hasta consultoría integral en diseño y optimización de redes. Nuestro equipo de ingenieros certificados trabaja como extensión de su equipo técnico, proporcionando conocimiento especializado y mejores prácticas de la industria.</p><p>Ya sea que necesite resolver problemas técnicos complejos, optimizar configuraciones existentes, o planificar el crecimiento de su infraestructura, nuestro equipo está preparado para brindar soluciones efectivas y estratégicas.</p>',
            'imagen_principal' => 'images/services/soporte-consultoria-principal.jpg',
            'visible' => 1
        ]);

        // Crear álbum para subservicios del servicio 4  
        $album4 = Album::create([
            'name' => 'soporte-consultoria-tecnica',
            'parent_id' => $SubservicesAlbum->id
        ]);

        // Subservicios del Servicio 4
        SubService::create([
            'service_id' => $service4->id,
            'album_id' => $album4->id,
            'title' => 'Helpdesk Mikrotik',
            'slug' => 'helpdesk-mikrotik',
            'subtitle' => 'Soporte técnico especializado en equipos Mikrotik',
            'icono' => 'images/icons/mikrotik-helpdesk.svg',
            'descripcion_breve' => 'Soporte técnico especializado para equipos Mikrotik con ingenieros certificados disponibles para resolver configuraciones complejas y optimizar el rendimiento de su red.',
            'beneficios' => 'Ingenieros certificados Mikrotik; Soporte técnico especializado 24/7; Resolución remota de configuraciones; Optimización de rendimiento; Actualizaciones y mantenimiento; Documentación técnica detallada',
            'descripcion_extensa' => '<p>Nuestro <strong>Helpdesk Mikrotik</strong> proporciona soporte técnico especializado para todos los equipos RouterOS y equipos Mikrotik de su infraestructura.</p><p><strong>Servicios especializados:</strong></p><ul><li>Soporte técnico por ingenieros certificados Mikrotik</li><li>Configuración y optimización de RouterOS</li><li>Resolución remota de problemas complejos</li><li>Implementación de políticas de QoS avanzadas</li><li>Configuración de VPNs y túneles seguros</li><li>Actualizaciones y mantenimiento preventivo</li><li>Capacitación técnica para su equipo</li></ul><p>Con años de experiencia en tecnología Mikrotik, resolvemos eficientemente cualquier desafío técnico que pueda presentarse.</p>',
            'visible' => 1
        ]);

        SubService::create([
            'service_id' => $service4->id,
            'album_id' => $album4->id,
            'title' => 'Consultoría en Redes y Sistemas',
            'slug' => 'consultoria-redes-sistemas',
            'subtitle' => 'Asesoría experta en diseño y optimización de redes',
            'icono' => 'images/icons/consultoria-redes.svg',
            'descripcion_breve' => 'Consultoría especializada en diseño, implementación y optimización de redes ISP, proporcionando estrategias técnicas para maximizar la eficiencia y escalabilidad de su infraestructura.',
            'beneficios' => 'Análisis técnico especializado; Diseño de arquitecturas escalables; Optimización de rendimiento; Planificación de crecimiento; Mejores prácticas de la industria; ROI mejorado en inversiones técnicas',
            'descripcion_extensa' => '<p>Nuestra <strong>Consultoría en Redes y Sistemas</strong> proporciona expertise estratégico para optimizar y hacer crecer su infraestructura ISP de manera eficiente.</p><p><strong>Áreas de consultoría:</strong></p><ul><li>Análisis y auditoría de infraestructura actual</li><li>Diseño de arquitecturas de red escalables</li><li>Planificación estratégica de crecimiento</li><li>Optimización de rendimiento y costos</li><li>Implementación de mejores prácticas de la industria</li><li>Evaluación de tecnologías emergentes</li><li>Desarrollo de estrategias de migración tecnológica</li></ul><p>Nuestros consultores senior trabajan estrechamente con su equipo para desarrollar soluciones personalizadas que impulsen el crecimiento y la eficiencia de su ISP.</p>',
            'visible' => 1
        ]);

        $this->command->info('Servicios y subservicios creados exitosamente!');
        $this->command->info('Se crearon 4 servicios principales con 10 subservicios en total.');
    }
}

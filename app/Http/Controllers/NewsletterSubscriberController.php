<?php

namespace App\Http\Controllers;

use App\Helpers\EmailConfig;
use App\Models\NewsletterSubscriber;
use App\Http\Requests\StoreNewsletterSubscriberRequest;
use App\Http\Requests\UpdateNewsletterSubscriberRequest;
use App\Models\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use SoDe\Extend\Crypto;

class NewsletterSubscriberController extends Controller
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
  public function store(StoreNewsletterSubscriberRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(NewsletterSubscriber $newsletterSubscriber)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(NewsletterSubscriber $newsletterSubscriber)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateNewsletterSubscriberRequest $request, NewsletterSubscriber $newsletterSubscriber)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(NewsletterSubscriber $newsletterSubscriber)
  {
    //
  }

  public function showSubscripciones()
  {

    $subscripciones = NewsletterSubscriber::orderBy('created_at', 'desc')->get();

    return view('pages.subscripciones.index', compact('subscripciones'));
  }


  public function saveSubscripciones(Request $request)
  {
      $request->validate([
          'email' => 'required|email',
      ]);
  
      $email = $request->input('email');
      
      // Verificar si ya existe un suscriptor activo y verificado
      $activeSubscriber = NewsletterSubscriber::where('email', $email)
          ->where('active', 1)
          ->where('is_verified', 1)
          ->first();
  
      if ($activeSubscriber) {
          return redirect()->route('index')->with('info', $request->input('email').' ya está suscrito');
      }
  
      // Verificar si existe un suscriptor no verificado
      $unverifiedSubscriber = NewsletterSubscriber::where('email', $email)
          ->where(function($query) {
              $query->where('active', 0)
                    ->orWhere('is_verified', 0);
          })
          ->first();
  
      if ($unverifiedSubscriber) {
          // Regenerar token y enviar nuevo correo de verificación
          $token = Crypto::randomUUID();
          $unverifiedSubscriber->update([
              'verification_token' => $token,
          ]);
          
          $verificationLink = route('verify', ['token' => $token]);
          $this->validarCorreo(['email' => $email], $verificationLink);
          
          return redirect()->route('index')->with('info', 'Ya existe una suscripción no verificada. Hemos enviado un nuevo enlace de verificación.');
      }
  
      // Crear nuevo suscriptor
      $token = Crypto::randomUUID();
      NewsletterSubscriber::create([
          'email' => $email,
          'verification_token' => $token,
          'active' => 0,
          'is_verified' => 0,
      ]);
  
      $verificationLink = route('verify', ['token' => $token]);
      $this->validarCorreo(['email' => $email], $verificationLink);
      
      return redirect()->route('index')->with('success', 'Enlace de verificación enviado a su bandeja de entrada');
  }

  public function verify($token)
  {
    $subscriber = NewsletterSubscriber::where('verification_token', $token)->first();

    if (!$subscriber) {
      session()->flash('error', 'Token de verificación inválido o ya confirmado.');
      return redirect('/');
    }

    $subscriber->update([
      'is_verified' => true,
      'verification_token' => null,
      'active' => 1,
    ]);

    $this->envioCorreoAdmin($subscriber);
    //  $this->envioCorreoCliente($subscriber);

    session()->flash('success', 'Tu suscripción ha sido confirmada.');
    return redirect('/');
  }


  private function validarCorreo($data, $verificationLink)
  {

    $generales = General::first();
    $appUrl = env('APP_URL');
    $name = env('MAIL_FROM_NAME');
    $mensaje = "Confirmacion de correo electrónico";
    $mail = EmailConfig::config($name, $mensaje);

    try {
      $mail->addAddress($data['email']);
      // Adjuntar imagen con CID
      $mail->addEmbeddedImage(public_path('images/img/logo/DarTelecom.png'), 'logo_img', 'DarTelecom.png');

      // Renderizar la vista Blade como string
      $html = View::make('emails.validar_correo', [
        'message' => (object) ['email' => $data['email']], // Pasamos el nombre
        'verificationLink' => $verificationLink // Enlace de verificación
      ])->render();

      // Asignar el contenido HTML al cuerpo del correo
      $mail->Body = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
      $mail->isHTML(true);

      $mail->send();
    } catch (\Throwable $th) {
    }
  }

  private function envioCorreoAdmin($data)
  {
    $generales = General::first();
    $emailadmin = $generales->email;
    $appUrl = env('APP_URL');
    $name = 'Administrador';
    $mensaje = "Nueva suscriptor - Dar Telecom";
    $mail = EmailConfig::config($name, $mensaje);

    $baseUrl = 'https://' . $_SERVER['HTTP_HOST'] . '/mail';
    $baseUrllink = 'https://' . $_SERVER['HTTP_HOST'] . '/';


    try {
      $mail->addAddress($emailadmin);
      $mail->Body =
        '<html lang="en">
                <head>
                  <meta charset="UTF-8" />
                  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                  <title>Dimensión Lider</title>
                  <link rel="preconnect" href="https://fonts.googleapis.com" />
                  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
                  <link
                    href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
                    rel="stylesheet"
                  />
                  <style>
                    * {
                      margin: 0;
                      padding: 0;
                      box-sizing: border-box;
                    }
                  </style>
                </head>
                <body>
                  <main>
                    <table
                      style="
                        width: 600px;
                        margin: 0 auto;
                        text-align: center;
                        background-image: url(' .
        $appUrl .
        '/mail/fondo.png);
                        background-repeat: no-repeat;
                        background-position: center;
                        background-size: cover;
                      "
                    >
                      <thead>
                        <tr>
                          <th
                            style="
                              display: flex;
                              flex-direction: row;
                              justify-content: center;
                              align-items: center;
                              margin-top: 40px;
                              padding: 0 200px;
                            "
                          >
                              <a href="' .
        $appUrl .
        '" target="_blank" style="text-align:center" ><img src="' .
        $appUrl .
        '/mail/logo.png" alt="hpi" /></a>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <p
                              style="
                                color: #ffffff;
                                font-size: 40px;
                                line-height: normal;
                                font-family: Google Sans;
                                font-weight: bold;
                              "
                            >
                              Nuevo
                              <span style="color: #ffffff">suscriptor</span>
                            </p>
                          </td>
                        </tr>
      
                        <tr>
                          <td>
                            <p
                              style="
                                color: #ffffff;
                                font-weight: 500;
                                font-size: 18px;
                                text-align: center;
                                width: 500px;
                                margin: 0 auto;
                                padding: 20px 0 5px 0;
                                font-family: Google Sans;
                              "
                            >
                              <span style="display: block">Hola ' . $name . '</span>
                            </p>
                          </td>
                        </tr>
                        
                        <tr>
                          <td>
                            <p
                              style="
                                color: #ffffff;
                                font-weight: 500;
                                font-size: 18px;
                                text-align: center;
                                width: 500px;
                                margin: 0 auto;
                                padding: 0px 10px 5px 0px;
                                font-family: Google Sans;
                              "
                            >
                              Tienes un nuevo suscriptor.
                            </p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <a
                               target="_blank"
                              href="' .
        $appUrl .
        '"
                              style="
                                text-decoration: none;
                                background-color: #E29720;
                                color: #21149E;
                                padding: 13px 20px;
                                display: inline-flex;
                                justify-content: center;
                                border-radius: 32px;
                                align-items: center;
                                gap: 10px;
                                font-weight: 600;
                                font-family: Google Sans;
                                font-size: 16px;
                                margin-bottom: 350px;
                              "
                            >
                              <span>Visita nuestra web</span>
                            </a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </main>
                </body>
              </html>
          ';

      $mail->isHTML(true);
      $mail->send();
    } catch (\Throwable $th) {
      //throw $th;
    }
  }



  private function envioCorreoCliente($data)
  {
    $generales = General::first();
    // $name = $data['full_name'];
    $name = 'Suscriptor';
    $mensaje = 'Gracias por suscribirte - Dar Telecom';
    $mail = EmailConfig::config($name, $mensaje);
    $appUrl = env('APP_URL');
    $baseUrl = 'https://' . $_SERVER['HTTP_HOST'] . '/mail';
    $baseUrllink = 'https://' . $_SERVER['HTTP_HOST'] . '/';

    try {
      $mail->addAddress($data['email']);
      // Adjuntar imagen con CID
      $mail->addEmbeddedImage(public_path('images/img/logo/DarTelecom.png'), 'logo_img', 'DarTelecom.png');

      // Renderizar la vista Blade como string
      $html = View::make('emails.verficacion_success', [
        'message' => (object) ['email' => $data['email']], // Pasamos el nombre
      ])->render();

      // Asignar el contenido HTML al cuerpo del correo
      $mail->Body = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
      $mail->isHTML(true);

      $mail->send();
    } catch (\Throwable $th) {
      //throw $th;
    }
  }
}

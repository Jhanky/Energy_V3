<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PanelSolarController;
use App\Http\Controllers\InversorController;
use App\Http\Controllers\CotizacionesController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\BateriaController;
use App\Http\Controllers\CableController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitaController;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\UserSessionController;

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['web']], function () {


    //Pagina de inicio
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //Rutas de clientes
    Route::get('/clientes', [ClienteController::class, 'listar_clientes'])->name('clientes.listar');
    Route::post('/clientes/crear', [ClienteController::class, 'crear'])->name('cliente.crear');
    Route::delete('/clientes/eliminar/{id}', [ClienteController::class, 'eliminar'])->name('cliente.eliminar');
    Route::put('/clientes/actualizar/{id}', [ClienteController::class, 'actualizar'])->name('cliente.actualizar');
    Route::post('/clientes/informacion/{id}', [ClienteController::class, 'info'])->name('cliente.informacion');

    //Ruta usuarios
    Route::get('/usuarios', [UserController::class, 'listarUsuarios'])->name('usuarios.listar');
    Route::post('/usuarios/crear', [UserController::class, 'crearUsuario'])->name('usuarios.crear');
    Route::delete('/usuarios/eliminar/{id}', [UserController::class, 'eliminar'])->name('usuarios.eliminar');
    Route::put('/usuarios/actualizar/{id}', [UserController::class, 'actualizar'])->name('usuarios.actualizar');

    //Rutas de paneles
    Route::get('/paneles', [PanelSolarController::class, 'listar'])->name('paneles.index');
    Route::post('/panel/crear', [PanelSolarController::class, 'crear'])->name('panel.crear_panel');
    Route::delete('/panel/eliminar/{id}', [PanelSolarController::class, 'eliminar'])->name('solar_panel.delete');
    Route::put('/panel/actualizar/{id}', [PanelSolarController::class, 'actualizar'])->name('panel.actualizar');

    //Rutas de cables
    Route::get('/cables', [CableController::class, 'listar'])->name('cable.listar');
    Route::post('/cable/crear', [CableController::class, 'crear'])->name('cable.crear');
    Route::delete('/cable/eliminar/{id}', [CableController::class, 'eliminar'])->name('cable.delete');
    Route::put('/cable/actualizar/{id}', [CableController::class, 'actualizar'])->name('cable.actualizar');

    //Rutas de baterias
    Route::get('/baterias', [BateriaController::class, 'listar'])->name('baterias.listar_bateria');
    Route::post('/bateria/crear', [BateriaController::class, 'crear'])->name('baterias.crear_bateria');
    Route::delete('/baterias/eliminar/{id}', [BateriaController::class, 'eliminar'])->name('baterias.eliminar');
    Route::put('/bateria/actualizar/{id}', [BateriaController::class, 'actualizar'])->name('baterias.actualizar');

    //Ruta de inversores
    Route::get('/inversores', [InversorController::class, 'listar'])->name('inversores.listar_inversor');
    Route::post('/inversor/crear', [InversorController::class, 'crear'])->name('inversores.crear_inversor');
    Route::delete('/inversor/eliminar/{id}', [InversorController::class, 'eliminar'])->name('inversores.eliminar');
    Route::put('/inversor/actualizar/{id}', [InversorController::class, 'actualizar'])->name('inversores.actualizar');

    //Rutas de cotizaciones
    Route::get('/cotizaciones', [CotizacionesController::class, 'listar'])->name('cotizaciones.listar');
    Route::get('/cotizacionesF', [CotizacionesController::class, 'listarFinaciado'])->name('cotizacionesF.listar');
    Route::post('/cotizaciones/crear', [CotizacionesController::class, 'crear'])->name('cotizaciones.crear');
    Route::post('/cotizaciones/info/{id}', [CotizacionesController::class, 'info'])->name('cotizaciones.info');
    Route::post('/cotizaciones/descuento/{id}', [CotizacionesController::class, 'descuento'])->name('cotizaciones.descuento');
    Route::delete('/presupuestos/eliminar/{id}', [CotizacionesController::class, 'eliminar'])->name('presupuestos.eliminar');
    Route::put('/presupuestos/editar/{id}', [CotizacionesController::class, 'editar'])->name('presupuestos.editar');
    Route::post('/actualizar-estado/{id}', [CotizacionesController::class, 'actualizarEstado'])->name('estado.actualizar');

    //Rutas de Subir graficas
    Route::post('/formulario/{id}', [CotizacionesController::class, 'grafica'])->name('imagen.grafica');

    //Ruta del PDF
    Route::post('/presupuestos/info/{id}/pdf', [PdfController::class, 'descargarPDF'])->name('pdf.pdf');

    //Rutas de Visitas
    Route::get('/visitas', [VisitaController::class, 'listar_visitas'])->name('visita.listar');
    Route::get('/visitas/formulario', [VisitaController::class, 'formulario'])->name('visita.formulario');
    Route::post('/visitas/crear', [VisitaController::class, 'crear'])->name('visita.crear');
    Route::post('/visitas/info/{id}', [VisitaController::class, 'info'])->name('visita.info');

    //Ruta de correos
    Route::get('/send-test-email', function () {
        Mail::to('jhaniluminati@gmail.com')->send(new TestEmail());
        return 'Correo de prueba enviado';
    });
    
    //Ruta de exportacion de excel
    Route::get('/cotizaciones/export', [CotizacionesController::class, 'export'])->name('data.export');

    //Chat bot
    Route::get('/chatbot', [ChatController::class, 'chat'])->name('chat');

    // Rutas de Proyectos
    Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyectos.index');
    Route::get('/proyectos/create', [ProyectoController::class, 'create'])->name('proyectos.crear');
    Route::post('/proyectos', [ProyectoController::class, 'store'])->name('proyectos.guardar');
    Route::get('/proyectos/{proyecto}', [ProyectoController::class, 'show'])->name('proyectos.mostrar');
    Route::get('/proyectos/{proyecto}/edit', [ProyectoController::class, 'edit'])->name('proyectos.editar');
    Route::put('/proyectos/{proyecto}', [ProyectoController::class, 'update'])->name('proyectos.actualizar');
    Route::delete('/proyectos/{proyecto}', [ProyectoController::class, 'destroy'])->name('proyectos.eliminar');

    //Monitoreo
    Route::get('/user-sessions', [UserSessionController::class, 'index'])->name('user.sessions');

    Route::get('/trello/test-connection', [ProyectoController::class, 'probarConexion']);
    Route::post('/update-checklist-item/{cardId}/{checkItemId}', [ProyectoController::class, 'updateChecklistItem'])->name('updateChecklistItem');

});

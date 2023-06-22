<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TradingController;
use App\Http\Controllers\PedidosController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/**
 * Ruta que se utiliza para cambiar el idioma de la aplicación i guardar la selección en la sesión del usuario
 *
 * setLocale() establece el idioma activo de la aplicación para el idioma seleccionado actual
 * La segunda línea guarda el idioma activo en la sesión de la aplicación utilizando el método 'put' de la instancia de sesión (session()),
 * de esta manera, el idioma activo persistirá en todas las solicitudes posteriores.
 *
 * @param $locale representa que el usurio quiere establecer en la aplicación
 * @return back devuelve al usuario a la página donde se encuentraba antes de cambiar el idioma de la aplicación
 */

//Cambiar idioma
Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});

//Ruta vista dashboard cliente
Route::get('home', [UserController::class, 'dashboardUser'])->middleware(['auth', 'check_access_client']);

// login / logout
Route::get('/', [AuthController::class, 'index'])->name('index')->middleware('guest');
Route::post('/', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::get('lost-password', [AuthController::class, 'rememberPassword'])->middleware('guest')->name('rememberPassword');
Route::post('lost-password', [AuthController::class, 'rememberSend'])->name('rememberSend');
Route::get('reset-password/{token}', [AuthController::class, 'activateUser'])->middleware('guest')->name('password.reset');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.store');
Route::get('logout', [LogoutController::class, 'logout'])->name('logout');



//Rutes per al perfil Personal i editarPerfil
Route::get('Es_Mio', [UserController::class, 'show_user'])->name('Es_Mio')->middleware('auth');
Route::get('User-info', [UserController::class, 'userInfo'])->name('userInfo')->middleware('auth');
Route::post('change-password', [UserController::class, 'changePassword'])->name('changePassword');
Route::get('contacte', [UserController::class, 'contacte'])->name('contacte')->middleware('auth');

Route::get('comercio', [UserController::class, 'view_comercio'])->name('comercio')->middleware('auth');
Route::get('Robot', [UserController::class, 'robots'])->name('robots')->middleware('auth');
Route::get('Mis_pedidos', [PedidosController::class, 'mis_pedidos'])->name('pedidos')->middleware('auth');
Route::get('Pedidos_finalizados', [PedidosController::class, 'pedidosFinalizados'])->name('pedidosFinalizados')->middleware('auth');
Route::get('allPedidos', [PedidosController::class, 'allPedidos'])->name('allPedidos')->middleware('auth');
Route::get('allPedidosTerminados', [PedidosController::class, 'allPedidosFinished'])->name('allPedidosTerminados')->middleware('auth');
Route::get('pedidoActual', [PedidosController::class, 'pedidoActual'])->name('pedidoActual')->middleware('auth');


Route::get('allRobots', [UserController::class, 'allRobots'])->name('allrobots')->middleware('auth');
Route::get('statusPedido', [PedidosController::class, 'statusPedido'])->name('statusPedido')->middleware('auth');
Route::post('saveWallet', [UserController::class, 'saveWallet'])->name('saveWallet');
Route::post('deleteWallet', [UserController::class, 'deleteWallet'])->name('deleteWallet');
Route::post('createPaymentPassword', [UserController::class, 'PaymentPassword'])->name('PaymentPassword');
Route::get('TransferUsers', [UserController::class, 'TransferUsers'])->name('TransferUsers')->middleware('auth');

Route::post('save-robot', [UserController::class, 'saveRobot'])->name('saveRobot');
Route::post('/crear-pedido', [PedidosController::class, 'newPedido'])->name('crear-pedido');




Route::post('/quantitative-trading', [TradingController::class, 'processQuantitativeTrading'])->name('quantitative-trading');


Route::get('phpinfo', fn () => phpinfo())->middleware('auth', 'check_access_admin');

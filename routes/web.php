<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\EmblemController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\RulesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DevicesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RestoreController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ImageDeviceController;


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
Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});

//Ruta vista dashboard cliente
Route::get('/home', [UserController::class, 'dashboardUser'])->middleware(['auth', 'check_access_client']);


Route::get('/Perfil_Personal/Editar_Perfil', [UserController::class, 'editarUsuario'])->name('Editar-Perfil')->middleware('auth');

Route::patch('/Perfil_Personal/Editar_Perfil', [UserController::class, 'updateProfile'])->name('profile.update')->middleware('auth');





Route::get('/request', function () {
    return view('http.show');
})->middleware(['auth', 'check_access_client']);

Route::get('/llistatEmpreses', [CompanyController::class, 'index'])->middleware('auth');

Route::get('/', [AuthController::class, 'index'])->name('index')->middleware('guest');

Route::get('/lost-password', [AuthController::class, 'rememberPassword'])->middleware('guest')->name('rememberPassword');

Route::post('/lost-password', [AuthController::class, 'rememberSend'])->name('rememberSend');

//Crud Usuari
Route::get('/userList', [UserController::class, 'userList'])->name('userList')->middleware('auth');
Route::get('userList/userListing', [UserController::class, 'userListing'])->middleware('auth');
Route::get('userList/userListingHidden', [UserController::class, 'userListing'])->middleware('auth');

Route::post('/addUser', [UserController::class, 'addUser'])->name('addUser')->middleware('auth');
Route::post('/userDown', [UserController::class, 'userDown'])->middleware('auth');
Route::post('/editUser', [UserController::class, 'editUser'])->middleware('auth');


Route::get('/reset-password/{token}', [AuthController::class, 'activateUser'])->middleware('guest')->name('password.reset');

Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.store');

Route::post('/', [AuthController::class, 'login'])->middleware('guest')->name('login'); #test

Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('listadoEmpresas/listCompanies', [CompanyController::class, 'listCompanies'])->middleware('auth');
Route::post('listadoEmpresas/createCompany', [CompanyController::class, 'storeCompany'])->middleware('auth');
Route::post('listadoEmpresas/editCompany', [CompanyController::class, 'editCompany'])->middleware('auth');
Route::post('listadoEmpresas/unsuscribeCompany', [CompanyController::class, 'unsuscribeCompany'])->middleware('auth');

//Rutes per al perfil Personal i editarPerfil
Route::get('/Personal_Profile', [UserController::class, 'show_user'])->name('Personal-Profile')->middleware('auth');
Route::get('/PerfilPersonal_Admin', [UserController::class, 'show_user_admin'])->name('PerfilPersonal_Admin')->middleware('auth');
Route::get('/user-info', [UserController::class, 'userInfo'])->name('userInfo')->middleware('auth');
Route::get('/Perfil_Personal/Editar_Perfil', [UserController::class, 'editarUsuario'])->name('Editar-Perfil')->middleware('auth');
Route::post('/Perfil_Personal/Editar_Perfil', [UserController::class, 'updateProfile'])->name('profile.update')->middleware('auth');
Route::post('/update-profile-image', [UserController::class, 'updateProfileImage'])->name('updateProfileImage')->middleware('auth');
Route::post('/delete-profile-image', [UserController::class, 'delete'])->name('deleteProfileImage')->middleware('auth');
Route::post('/change-password', [UserController::class, 'changePassword'])->name('changePassword');
Route::get('/contacte', [UserController::class, 'contacte'])->name('contacte')->middleware('auth');
//Admin
Route::get('/PerfilPersonal_Admin/EditarPerfilAdmin', [UserController::class, 'EditarPerfilAdmin'])->name('EditarPerfilAdmin')->middleware('auth');
//Ruta para editar el usuario admin
Route::post('/PerfilPersonal_Admin/Editar_Perfil/update', [UserController::class, 'updateUserAdmin'])->name('updateUserAdmin')->middleware('auth');

//Worker
Route::get('/PerfilPersonal_Worker/EditarPerfilWorker', [UserController::class, 'EditarPerfilWorker'])->name('EditarPerfilWorker')->middleware('auth');
Route::post('/PerfilPersonal_Worker/Editar_Perfil/update', [UserController::class, 'updateUserWorker'])->name('updateUserWorker')->middleware('auth');
Route::get('/PerfilPersonal_Worker', [UserController::class, 'show_user_worker'])->name('PerfilPersonal_Worker')->middleware('auth');



///////

Route::get('/privacy_policy', [RulesController::class, 'indexPrivacy'])->name('index.privacy')->middleware('auth');
Route::get('/cookies_policy', [RulesController::class, 'indexCookies'])->name('index.cookies')->middleware('auth');
Route::get('/terms', [RulesController::class, 'indexTerms'])->name('index.terms')->middleware('auth');
Route::get('/edit_terms', [RulesController::class, 'indexEditTerms'])->name('edit.terms')->middleware('auth');
Route::post('/edit_terms', [RulesController::class, 'storeTerms'])->name('store.terms')->middleware('auth');
Route::get('/edit_terms/get', [RulesController::class, 'listTerms'])->name('list.terms')->middleware('auth');

Route::get('/edit_cookies', [RulesController::class, 'indexEditCookies'])->name('edit.cookies')->middleware('auth');
Route::post('/edit_cookies', [RulesController::class, 'storeCookies'])->name('store.cookies')->middleware('auth');
Route::get('/edit_cookies/get', [RulesController::class, 'listCookies'])->name('list.cookies')->middleware('auth');

Route::get('/edit_privacy', [RulesController::class, 'indexEditPrivacy'])->name('edit.privacy')->middleware('auth');
Route::post('/edit_privacy', [RulesController::class, 'storePrivacy'])->name('store.privacy')->middleware('auth');
Route::get('/edit_privacy/get', [RulesController::class, 'listPrivacy'])->name('list.privacy')->middleware('auth');

Route::get('/admin', function () {
    return view('admin.dashboardAdmin');
})->middleware(['auth', 'check_access_admin']); #admin

// grup2
/* Grup de rutes per a CRUD Informe */
Route::resource('report', ReportController::class)->middleware('auth');
Route::get('/report/{id}/pdf', [ReportController::class, 'pdf'])->name('report.pdf')->middleware('auth');


/* Grup de rutes per a CRUD Respostes */
Route::resource('answer', QuestionController::class)->middleware('auth');

//Question ROUTES
Route::resource('question', QuestionController::class)->except(['show'])->middleware('auth');
Route::get('/question/{id}/activate', [QuestionController::class, 'activate'])->name('question.activate')->middleware('auth');
Route::get('/question/{id}/unActivate', [QuestionController::class, 'unActivate'])->name('question.unActivate')->middleware('auth');
Route::get('question/hidden', [QuestionController::class, 'hidden'])->name('question.hidden')->middleware('auth');

//Questionnaire ROUTES
Route::resource('questionnaire', QuestionnaireController::class)->except(['show'])->middleware('auth');
Route::get('questionnaire/hidden', [QuestionnaireController::class, 'hidden'])->name('questionnaire.hidden')->middleware('auth');
Route::get('questionnaire/{id}/activate', [QuestionnaireController::class, 'activate'])->name('questionnaire.activate')->middleware('auth');
Route::get('questionnaire/{id}/unActivate', [QuestionnaireController::class, 'unActivate'])->name('questionnaire.unActivate')->middleware('auth');
Route::post('questionnaire/{questionnaire}/updateQuestion', [QuestionnaireController::class, 'updateQuestion'])->name('questionnaire.updateQuestion')->middleware('auth');
Route::post('questionnaire/{questionnaire}/assignQuestion', [QuestionnaireController::class, 'assignQuestion'])->name('questionnaire.assignQuestion')->middleware('auth');
Route::post('questionnaire/{questionnaire}/unassignQuestion', [QuestionnaireController::class, 'unassignQuestion'])->name('questionnaire.unassignQuestion')->middleware('auth');

//Audits ROUTES
Route::get('/audit', [AuditController::class, 'index'])->name('audit.index')->middleware('auth');
Route::get('/audit/{id}', [AuditController::class, 'show'])->name('audit.survey')->middleware('auth');
Route::post('/audit/save/{id}', [AuditController::class, 'store'])->name('audit.store')->middleware('auth');

// final grup 2---------------------------------------- ///

//EQUIP3 ----------------------------------/////////////////
//Part Admin Crear visualitzar
Route::resource('course', CourseController::class)->except('show')->middleware('auth');
Route::put('course/update_hidden/{id}', [CourseController::class, 'update_hidden'])->name('course.update_hidden')->middleware('auth');
Route::get('course/index_data', [CourseController::class, 'index_data'])->name('course.index_data')->middleware('auth');
Route::get('course/users', [CourseController::class, 'users'])->name('course.users')->middleware('auth');
Route::get('course/hidden', [CourseController::class, 'hidden'])->name('course.hidden')->middleware('auth');
Route::get('course/hidden_data', [CourseController::class, 'hidden_data'])->name('course.hidden_data')->middleware('auth');

Route::get('course/{id}/hide', [CourseController::class, 'hide'])->name('course.hide')->middleware('auth');
Route::get('course/{id}/unHide', [CourseController::class, 'unHide'])->name('course.unHide')->middleware('auth');

//Part Client Crear Cursos + visualitzar
Route::get('/course/client', [CourseController::class, 'index_client'])->name('course.client')->middleware('auth');
Route::get('course/client_data', [CourseController::class, 'client_data'])->name('course.client_data')->middleware('auth');



Route::get('/emblems', [EmblemController::class, 'index'])->name('emblems.index')->middleware('auth');
Route::get('/emblems/create', [EmblemController::class, 'create'])->name('emblems.create')->middleware('auth');
Route::post('/emblems/store', [EmblemController::class, 'store'])->name('emblems.store')->middleware('auth');
Route::get('/emblems/{emblem}/edit', [EmblemController::class, 'edit'])->name('emblems.edit')->middleware('auth');
Route::post('/emblems/{emblem}', [EmblemController::class, 'update'])->name('emblems.update')->middleware('auth');
Route::get('/emblems/restaurar', [EmblemController::class, 'restaurar'])->name('emblems.restaurar')->middleware('auth');
Route::get('emblems/restaurar/{emblem}', [EmblemController::class, 'restaurarhide'])->name('restaurar.hide')->middleware('auth');
Route::get('emblems/eliminar/{emblem}', [EmblemController::class, 'eliminar'])->name('emblems.eliminar')->middleware('auth');

Route::get('/updateHiddenDate/{id}', [CourseController::class, 'updateHiddenDate'])->name('updateHiddenDate')->middleware('auth');


Route::get('/recursos', [ResourceController::class, 'index'])->name('recourse.index')->middleware('auth');


//Part de Evaluacións
Route::get('/CursosCalificar', [DeliveryController::class, 'CursosCalificar'])->name('Evaluar.Cursoss')->middleware('auth'); //Vista pagina tots els cursos
Route::get('/CursosCalificar/{id}/activities', [DeliveryController::class, 'courseActivities'])->name('courseActivities')->middleware('auth'); //Vista categories i activitats del curs triat
Route::get('/activitiesProva/{id}/activities-Datos', [DeliveryController::class, 'courseActivitiesDatos'])->name('courseActivitiesDatos')->middleware('auth'); //Dades JSON categories i activitats del curs triat
Route::get('/CursosCalificar/{id}/activities/{activityId}', [DeliveryController::class, 'show'])->name('ActivityDeliveries')->middleware('auth'); //Vista alumnes amb la nota i feedback sobre la activitat triada
Route::get('/CursosCalificar/{id}/activities-Datos/{activityId}', [DeliveryController::class, 'indexDatos'])->name('ActivityDeliveries.datos')->middleware('auth'); //Dades JSON sobre els alumnes nota i feedback sobre la activitat triada
Route::post('/activity/{activityId}/user/{userId}/qualify', [DeliveryController::class, 'qualify'])->name('deliveries.qualify')->middleware('auth'); //Acció per qualificar i posar comentari a un alumne
//FIN EQUIP 3



/** ------ EQUIP 4 ------ */

Route::get('/acceptacio-tasques', [TaskController::class, 'acceptacioTasques'])->name('acceptacio-tasques')->middleware('auth'); //con name() le asignas un nombre para llamarlo en los diferentes archivos

Route::get('/my-tasks', function () {
    return view('Presupuestos/modificar_presupuesto/index');
})->name('my-tasks')->middleware('auth');

Route::get('/modificar_presupuesto', function () {
    return view('Presupuestos/modificar_presupuesto/index');
})->name('modificar_presupuesto')->middleware('auth');

Route::get('/gantt', function () {
    return view('Tareas/gantt/index');
})->name('gantt')->middleware('auth');

Route::get('select', function () {
    return view('select');
})->middleware('auth');
Route::get('radio', function () {
    return view('radio');
})->middleware('auth');

// Asignar Precios
Route::get('/Asignar-Precios/{id}', [TaskController::class, 'asignarPrecios'])->name('Asignar-Precios')->middleware('auth'); //Vista para la pagina Aceptar-Presupuestos
Route::get('/mostrar-tareas/{id}', [TaskController::class, 'mostrarTareas'])->name('mostrarTareas')->middleware('auth'); //Datos que le paso a la vista de la pagina Aceptar-Presupuestos

// Kanban
Route::get('/kanban', [TaskController::class, 'kanban'])->name('vista-kanban')->middleware('auth');
Route::get('/tasks', [TaskController::class, 'tasksKanban'])->name('tasks-kanban')->middleware('auth');
Route::put('/tasks-update/{id}', [TaskController::class, 'updateState'])->name('update-state')->middleware('auth');

// Gantt
Route::get('/tasks-gantt', [TaskController::class, 'tasksGantt'])->name('tasks-gantt')->middleware('auth');

// Listar Presuspuestos
Route::get('/listaPresupuestos', [BudgetController::class, 'LlistatPresupuestos'])->middleware('auth');
Route::get('/llista_pressupostos', [BudgetController::class, 'index'])->middleware('auth');
Route::get('/listado_presupuestos', [BudgetController::class, 'list'])->middleware('auth');

/** ----- FINAL EQUIP 4 ------  */


/** ------ EQUIP 5 ------ */

Route::get('/index', HomeController::class)->middleware('auth');

// Restaurar
Route::get('/restore', function () {
    return view('restaurar');
})->middleware('auth');
Route::get('/restaurar', [RestoreController::class, 'devices'])->name('restaurar')->middleware('auth');
Route::post('/restore/{id}', [RestoreController::class, 'restoreDevice'])->name('restaurar')->middleware('auth');
Route::get('/restore/{id}', [RestoreController::class, 'getIdDevice'])->name('restaurar')->middleware('auth');

//Mapa
Route::get('/map', function () {
    return view('mapa');
})->middleware('auth');


//Mostrar Dispositivos
Route::get('/devices', function () {
    return view('listdevices');
})->middleware('auth');
Route::get('/devices/list', [DevicesController::class, 'devices'])->middleware('auth');
Route::get('/devices/type_devices', [DevicesController::class, 'type_devices'])->middleware('auth');
Route::post('/devices/create', [DevicesController::class, 'create'])->middleware('auth');
Route::post('/devices/edit', [DevicesController::class, 'edit'])->middleware('auth');
//Route::post('/devices/delete', [DevicesController::class, 'delete']);

//Mostrar inventari
Route::get('/inventario', function () {
    return view('inventario');
})->middleware('auth');
Route::get('/mapa', function () {
    return view('mapa');
})->middleware('auth');

Route::get('/listInventory', [InventoryController::class, 'listInventary'])->middleware('auth');

// Imatges
Route::get('/imagenes', [ImageDeviceController::class, 'index'])->name('image.index')->middleware('auth');
Route::post('/imagenes', [ImageDeviceController::class, 'guardar'])->name('image.guardar')->middleware('auth');
Route::get('/imagenes/{id}', [ImageDeviceController::class, 'mostrar'])->name('image.mostrar')->middleware('auth');

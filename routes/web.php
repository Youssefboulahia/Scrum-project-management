<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('dashboard/userStory/{id}', 'DashboardController@start')->name('dashboard.start');
Route::get('dashboard/sprint/{id}', 'DashboardController@sprint')->name('dashboard.sprint');
Route::get('home', 'HomeController@index')->name('home');

Route::resource('project', 'ProjectController')->middleware('auth');
Route::resource('dashboard', 'DashboardController')->middleware('auth');

Route::get('dashboard/userStory/{id}', 'DashboardController@start')->name('dashboard.start')->middleware('auth');
Route::get('dashboard/sprint/{id}', 'DashboardController@sprint')->name('dashboard.sprint');
Route::get('dashboard/fichier/{id}', 'DashboardController@fichier')->name('dashboard.fichier');
Route::get('dashboard/groupeDiscussion/{id}', 'DashboardController@groupeDiscussion')->name('dashboard.groupeDiscussion');
Route::get('dashboard/burndownChart/{id}', 'DashboardController@burndownChart')->name('dashboard.burndownChart');
Route::get('dashboard/calendrier/{id}', 'DashboardController@calendrier')->name('dashboard.calendrier');

Route::resource('profile', 'ProfileController')->middleware('auth');


Route::get('login/{provider}', 'Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');

Route::post('register/social/{id}', 'Auth\SocialAccountController@registerSocial')->name('register.social');

Route::post('invitation/inviter' , 'invitationController@inviter')->name('invitation.inviter');
Route::post('invitation/annuler' , 'invitationController@annuler')->name('invitation.annuler');
Route::post('invitation/accepter' , 'invitationController@accepter')->name('invitation.accepter');

Route::post('userStroy/store/{id}' , 'UserStoryController@store')->name('userStory.store');
Route::post('userStroy/delete/{id}' , 'UserStoryController@delete')->name('userStory.delete');
Route::post('userStroy/done/{id}' , 'UserStoryController@done')->name('userStory.done');
Route::post('userStroy/undone/{id}' , 'UserStoryController@undone')->name('userStory.undone');
Route::post('userStroy/update/{id}' , 'UserStoryController@update')->name('userStory.update');

Route::get('sprint/index/{id}' , 'SprintController@open')->name('sprint.open');
Route::post('sprint/store/{id}' , 'SprintController@store')->name('sprint.store');
Route::post('sprint/comment/{project_id}{sprint_id}' , 'SprintController@comment')->name('sprint.comment');
Route::post('sprint/comment/{id}' , 'SprintController@delete')->name('comment.delete');
Route::post('sprint/delete/{id}' , 'SprintController@sprintDelete')->name('sprint.delete');
Route::post('sprint/start/{id}' , 'SprintController@start')->name('sprint.start');

Route::post('userStroy/undone/sprint/{id}' , 'UserStoryController@undoneSprint')->name('userStory.undoneSprint');
Route::post('userStroy/done/sprint/{id}' , 'UserStoryController@doneSprint')->name('userStory.doneSprint');


Route::post('fichier/Envoyer/{id}', 'FichierController@fichierEnvoyer')->name('fichier.envoyer');
Route::get('fichier/download/{id}', 'FichierController@fichierDownload')->name('fichier.download');
Route::get('fichier/voir/{id}', 'FichierController@fichierVoir')->name('fichier.voir');
Route::get('fichier/filtrer/{id}', 'FichierController@fichierFiltrer')->name('fichier.filtrer');
Route::post('fichier/supprimer/{id}', 'FichierController@fichierSupprimer')->name('fichier.supprimer');


Route::post('chat/create/{id}', 'GroupeDiscussionController@create')->name('chat.create');
Route::get('chat/room/{project_id}/{groupe_id}', 'GroupeDiscussionController@chat')->name('chat.index');

Route::post('message/create/{id}', 'GroupeDiscussionController@message')->name('message.create');

Route::post('groupe/delete/{id}', 'GroupeDiscussionController@groupeDelete')->name('groupe.delete');



Route::post('/ajax-request', 'AjaxController@store');

Route::get('/allData', 'ChartController@getData');

Route::get('/allDataAgenda', 'AgendaController@getData');
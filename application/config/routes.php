<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['registros/sms'] = 'registros/sms';
$route['registros/altas_bajas'] = 'registros/altas_bajas';
$route['registros/web_service'] = 'registros/web_service';
$route['registros/cobros'] = 'registros/cobros';
$route['clientes/pedir_baja'] = 'clientes/pedir_baja';
$route['clientes/mandar_sms'] = 'clientes/mandar_sms';
$route['clientes/pedir_alta'] = 'clientes/pedir_alta';
$route['usuarios/cerrar_sesion'] = 'usuarios/cerrar_sesion';
$route['usuarios/iniciar_sesion_post'] = 'usuarios/iniciar_sesion_post';
$route['usuarios/iniciar_sesion'] = 'usuarios/iniciar_sesion';
$route['usuarios/iniciar_sesion_post'] = 'usuarios/iniciar_sesion_post';
$route['default_controller'] = 'inicio';
$route['404_override'] = 'error404';
$route['translate_uri_dashes'] = FALSE;

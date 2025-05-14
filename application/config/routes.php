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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//auth 
$route['logout'] = 'auth/logout';
$route['forgot'] = 'auth/forgot';
$route['change_pass'] = 'auth/reset';
$route['change_password'] = 'auth/change_forgot';


//Admin
$route['console/dashboard'] = 'dashboard/index';
$route['console/users'] = 'user/index';
$route['console/add_user'] = 'user/add';
$route['console/edit_user/(:num)'] = 'user/update/$1';
$route['console/delete_user/(:num)'] = 'user/delete/$1';

//Dev
$route['dev/dashboard'] = 'dashboard/index';
$route['dev/setting'] = 'auth/change_pass';
$route['dev/NFRs'] = 'nfr/index';
$route['dev/add_nfr'] = 'nfr/add';
$route['dev/edit_nfr/(:num)'] = 'nfr/update/$1';
$route['dev/delete_nfr/(:num)'] = 'nfr/delete/$1';

$route['dev/systems'] = 'system/index';
$route['dev/add_system'] = 'system/add';
$route['dev/edit_system/(:num)'] = 'system/update/$1';
$route['dev/delete_system/(:num)'] = 'system/delete/$1';

$route['dev/domains'] = 'domain/index';
$route['dev/add_domain'] = 'domain/add';
$route['dev/edit_domain/(:num)'] = 'domain/update/$1';
$route['dev/delete_domain/(:num)'] = 'domain/delete/$1';

$route['dev/iso'] = 'iso/index';
$route['dev/add_iso'] = 'iso/add';
$route['dev/edit_iso/(:num)'] = 'iso/update/$1';
$route['dev/delete_iso/(:num)'] = 'iso/delete/$1';

$route['dev/projects'] = 'project/index';
$route['dev/add_project'] = 'project/add';
$route['dev/edit_project/(:num)'] = 'project/update/$1';
$route['dev/projects/detail/(:num)'] = 'project/detail/$1';
$route['dev/projects/elicitation/(:num)'] = 'project/elicitation/$1';
$route['dev/delete_eli/(:num)/(:num)'] = 'project/delete_eli/$1/$2';
$route['dev/nfr_update/(:num)'] = 'project/nfr_update/$1';
$route['dev/projects/analysis/(:num)'] = 'project/analysis/$1';
$route['dev/add_fr'] = 'fr/add';
$route['dev/add_nfr_eli'] = 'project/add_nfr';
$route['dev/delete_fr/(:num)/(:num)'] = 'fr/delete/$1/$2';
$route['dev/add_mapp_fr'] = 'mapping_fr/add';
$route['dev/add_mapp_nfr'] = 'mapping_nfr/add';
$route['dev/projects/doc/(:num)'] = 'project/doc/$1';
$route['dev/projects/doc/fr_userstory/(:num)'] = 'fr_user_story/index/$1';
$route['dev/edit_fus/(:num)/(:num)'] = 'fr_user_story/update/$1/$2';
$route['dev/edit_nus/(:num)/(:num)'] = 'nfr_user_story/update/$1/$2';
$route['dev/projects/doc/nfr_decision/(:num)'] = 'nfr_decision/index/$1';
$route['dev/add_decision'] = 'nfr_decision/add';
$route['dev/edit_dec/(:num)/(:num)'] = 'nfr_decision/update/$1/$2';
$route['dev/delete_dec/(:num)/(:num)'] = 'nfr_decision/delete/$1/$2';

$route['dev/projects/val/(:num)'] = 'project/val/$1';
$route['dev/add_quest'] = 'val_quest/add';

$route['dev/add_val'] = 'validation/add';
$route['dev/delete_quest/(:num)/(:num)'] = 'val_quest/delete/$1/$2';

$route['dev/projects/doc/nfr_userstory/(:num)'] = 'nfr_user_story/index/$1';
$route['dev/edit_nus/(:num)/(:num)'] = 'nfr_user_story/update/$1/$2';
$route['dev/projects/val/categories/(:num)'] = 'categories/index/$1';
$route['dev/add_cat'] = 'categories/add';
$route['dev/edit_cat/(:num)/(:num)'] = 'categories/update/$1/$2';
$route['dev/delete_cat/(:num)/(:num)'] = 'categories/delete/$1/$2';

$route['dev/projects/confirm/(:num)'] = 'project/confirm/$1';
$route['dev/confirm'] = 'project/update_nfr';
$route['dev/delete_project/(:num)'] = 'project/delete/$1';
$route['dev/edit_fr/(:num)/(:num)'] = 'fr/update/$1/$2';






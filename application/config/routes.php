<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = 'frontend/main';
$route['404_override'] = 'error404';



$route['[a-z]{2}'] = $route['default_controller'];




// Backend
$route['([a-z]{2}/)?backend'] = 'backend/main';
$route['([a-z]{2}/)?backend/characters/(:num)/items/(:num)'] = 'backend/characters/items';
$route['([a-z]{2}/)?backend/characters/(:num)/del_item/(:num)/char_id/(:num)'] = 'backend/characters/del_item';
$route['([a-z]{2}/)?backend/characters/(:num)/characters_in_account/(:any)'] = 'backend/characters/characters_in_account';
$route['([a-z]{2}/)?backend/(:any)/(:num)'] = 'backend/$2';
$route['([a-z]{2}/)?backend/(:any)'] = 'backend/$2';

// Cabinet
$route['([a-z]{2}/)?cabinet'] = 'cabinet/main';
$route['([a-z]{2}/)?cabinet/account/(:any)/(:num)'] = 'cabinet/account';
$route['([a-z]{2}/)?cabinet/shop/(:num)'] = 'cabinet/shop';
$route['([a-z]{2}/)?cabinet/shop/(:any)'] = 'cabinet/shop/$2';
$route['([a-z]{2}/)?cabinet/character_info/(:num)/(:num)'] = 'cabinet/character_info';
$route['([a-z]{2}/)?cabinet/(:any)/(:num)'] = 'cabinet/$2';
$route['([a-z]{2}/)?cabinet/(:any)'] = 'cabinet/$2';


// Frontend

// Статистика
$route['([a-z]{2}/)?stats'] = 'frontend/stats';
$route['([a-z]{2}/)?stats/(:num)/(:any)'] = 'frontend/stats';


$route['([a-z]{2}/)?page/(:any)'] = 'frontend/page/index';
$route['([a-z]{2}/)?(:num)'] = $route['default_controller'];
$route['([a-z]{2}/)?(:any)/(:num)'] = 'frontend/$2';
$route['([a-z]{2}/)?(:any)'] = 'frontend/$2';




/* End of file routes.php */
/* Location: ./application/config/routes.php */
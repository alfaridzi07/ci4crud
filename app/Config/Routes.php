<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->get('/', 'Pages::index');
 $routes->get('/about', 'Pages::about');
 $routes->get('/karyawan', 'Pages::employee');
 $routes->get('/karyawan/(:num)', 'Pages::employee/$1');
 $routes->get('/karyawan/(:any)', 'Pages::secret/$1');
 $routes->get('/insert-karyawan', 'Pages::insertEmployee');


 $routes->post('/save-karyawan', 'Pages::saveEmployee');
 $routes->post('/edit-karyawan', 'Pages::editEmployee');
 $routes->post('/delete-karyawan', 'Pages::deleteEmployee');

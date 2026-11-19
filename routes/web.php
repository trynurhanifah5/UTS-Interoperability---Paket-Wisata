<?php

$router->get('/', function () {
    return response()->json([
        'service_name' => 'Paket Wisata REST API Service',
        'status'       => 'Running'
    ]);
});

// ================= ENDPOINT PUBLIK (GET) =================
$router->get('/destinasi', 'DestinasiController@index');
$router->get('/destinasi/{destinasiId}', 'DestinasiController@show');

$router->get('/paket-wisata', 'PaketWisataController@index');
$router->get('/paket-wisata/{paketId}', 'PaketWisataController@show');

// ============ ENDPOINT TERPROTEKSI BASIC AUTH ============
$router->group(['middleware' => 'basic.auth'], function () use ($router) {
    // CRUD Destinasi (Create, Update, Delete)
    $router->post('/destinasi', 'DestinasiController@store');
    $router->put('/destinasi/{destinasiId}', 'DestinasiController@update');
    $router->delete('/destinasi/{destinasiId}', 'DestinasiController@destroy');

    // CRUD Paket Wisata (Create, Update, Delete)
    $router->post('/paket-wisata', 'PaketWisataController@store');
    $router->put('/paket-wisata/{paketId}', 'PaketWisataController@update');
    $router->delete('/paket-wisata/{paketId}', 'PaketWisataController@destroy');
});
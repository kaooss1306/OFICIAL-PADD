<?php
   // Función para hacer peticiones cURL
function makeRequest($url) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'apikey: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
            'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc'
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}

// Obtener datos
$campaign = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Campania?select=*');

$clientes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Clientes?select=*');

$productos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Productos?select=*');

$soportes  = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Soportes?select=*');

$anios = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Anios?select=*');

$agencias = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Agencias?select=*');

$productos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Productos?select=*');

$temas = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Temas?select=*');

$planes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/PlanesPublicidad?select=*');

$anio = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Anios?select=*');

$medios = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Medios?select=*');

$ordenesCompra = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/OrdenDeCompra?select=*');

$Anios = array_column($anio, 'years', 'id');
// Crear un mapa completo de cliente
$clientesMap = [];
foreach ($clientes as $cliente) {
    $clientesMap[$cliente['id_cliente']] = $cliente;
}

// Crear un mapa completo de producto
$productosMap = [];
foreach ($productos as $producto) {
    $productosMap[$producto['id']] = $producto;
}
// Crear un mapa completo de soporte
$soportesMap = [];
foreach ($soportes as $soporte) {
    $psoportesMap[$soporte['id_soporte']] = $soporte;
}

$aniosMap = [];
foreach ($anios as $anio) {
    $aniosMap[$anio['id']] = $anio;
}

$agenciasMap = [];
foreach ($agencias as $agencia) {
    $agenciasMap[$agencia['id']] = $agencia;
}

$productosMap = [];

foreach ($productos as $producto) {
    $productosMap[$producto['id']] = $producto;
}


$temasMap = [];
foreach ($temas as $tema) {
    $temasMap[$tema['id_tema']] = $tema;
}

$planesMap = [];
foreach ($planes as $plan) {
    $planesMap[$plan['id_planes_publicidad']] = $plan;
}

$anioMap = [];

foreach ($anios as $anio) {
    $anioMap[$anio['id']] = $anio;
}

$mediosMap = [];

foreach ($medios as $medio) {
    $mediosMap[$medio['id']] = $medio;
}

$ordenesCompraMap = [];
foreach ($ordenesCompra as $oc) {
    $ordenesCompraMap[$oc['id_orden_compra']] = $oc;
}


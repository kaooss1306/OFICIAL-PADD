<?php
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
    $soporte_medios = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/soporte_medios?select=*');
    // Obtener datos+
    $medios = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Medios?select=*');
    $programas = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Programas?select=*');
    $soportes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Soportes?select=*');
    $agencias = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Agencias?select=*');
    $clientes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Clientes?select=*');
    $tiposCliente = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/TipoCliente?select=*');
    $regiones = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Region?select=*');
    $comunas = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Comunas?select=*');
    $formatoComision = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/formatoComision?select=*');
    $tipoMoneda = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/TipoMoneda?select=*');
    $proveedores = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Proveedores?select=*');   
    $calendar = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/json?select=*');   
    // Crear arrays asociativos para búsqueda rápida
    $tiposClienteMap = array_column($tiposCliente, 'nombreTipoCliente', 'id_tyipoCliente');
    $regionesMap = array_column($regiones, 'nombreRegion', 'id');
    $comunasMap = array_column($comunas, 'nombreComuna', 'id_comuna');

    $productos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Productos?select=*');
   

    $clientesMap = [];
foreach ($clientes as $cliente) {
    $clientesMap[$cliente['id_cliente']] = $cliente;    
}
$soportesMap = [];
foreach ($soportes as $soporte) {
    $soportesMap[$soporte['id_soporte']] = $soporte;
}
$proveedoresMap = [];
foreach ($proveedores as $proveedore) {
    $proveedoresMap[$proveedore['id_proveedor']] = $proveedore;
}
$programasMap = [];
foreach ($programas as $prom) {
    $programasMap[$prom['id']] = $prom;
}
$tipoclientesMap2 = [];
foreach ($tiposCliente as $tipocliente) {
    $tipoclientesMap[$tipocliente['id_tyipoCliente']] = $tipocliente;
}
$formatoComisionMap = [];
foreach ($formatoComision as $comisionFormato) {
    $formatoComisionMap[$comisionFormato['id_formatoComision']] = $comisionFormato;
}
$tipoMonedaMap = [];
foreach ($tipoMoneda as $tipozMoneda) {
    $tipoMonedaMap[$tipozMoneda['id_moneda']] = $tipozMoneda;
}
$productosMap2 = [];
foreach ($productos as $producto) {
    $productosMap2[$producto['id']] = $producto['NombreDelProducto'];
}
$calendarMap = [];
foreach ($calendar as $calendario) {
    $calendarMap[$calendario['id_calendar']] = $calendario['matrizCalendario'];
}

$mediosMap = [];
foreach ($medios as $medio) {
    $mediosMap[$medio['id']] = $medio;
}
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

$clasificaciones = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Clasificacion?select=*');          
$provedorsoportes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/proveedor_soporte?select=*');
$planes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/PlanesPublicidad?select=*');
$programas = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Programas?select=*');
$anios = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Anios?select=*');
$anios2 = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Anios?select=*');
$meses = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Meses?select=*');
$productos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Productos?select=*');
$soportes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Soportes?select=*');
$campaigns = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Campania?select=*');
$clientes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Clientes?select=*');
$contratos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Contratos?select=*');
$campania_temas = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/campania_temas?select=*');
$temas = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Temas?select=*');
$jsonData = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/json?select=*');
$ordenpublicidad = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/OrdenesDePublicidad');
$medios = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Medios?select=*');
$clasimedios = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/ClasificacionMedios?select=*');
$calendarMap2 = [];
$ordenes = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/OrdenDeCompra?select=*');
$ordenes2 = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/OrdenDeCompra?select=*');
$ordenepublicidad = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/OrdenesDePublicidad?select=*');

$clasificacionesMap = [];
foreach ($clasificaciones as $clasi){
    $clasificacionesMap[] = [
        'id' => $clasi['id'],
        'NombreClasificacion' => $clasi['NombreClasificacion']
    ];
}



$ordenespuMap = [];
foreach ($ordenpublicidad as $ordenpu){
    $ordenespuMap[] = [
        'id_ordenespu' => $ordenpu['id_ordenes_de_comprar'],
        'datosrecopilados' => $ordenpu['datosRecopiladosb'],
        'idplanorden' => $ordenpu['id_plan'],
        'estadoorden' => $ordenpu['estadoorden'],
        'tipo_item' => $ordenpu['tipo_item']
    ];
}

$ordenMap = [];
foreach ($ordenes as $orden) {
    $ordenMap[] = [
        'id_orden_compra' => $orden['id_orden_compra'],
        'NombreOrden' => $orden['NombreOrden'],
        'id_campania' => $orden['id_campania'],
        // Agrega otros campos que sean necesarios
    ];
}



foreach ($jsonData as $calendar) {
    // Aquí asumimos que `id_calendar` es único y usamos su valor como clave en nuestro mapa
    $calendarMap2[$calendar['id_calendar']] = $calendar['matrizCalendario'];
}
$campaniaTemasMap = [];
foreach ($campania_temas as $relacion) {
    $campaniaTemasMap[$relacion['id_campania']][] = $relacion['id_temas'];
}
    $temasMap = [];
    foreach ($temas as $tema) {
        if ($tema['estado'] === true) {
        $temasMap[] = [
            'id' => $tema['id_tema'],
            'nombreTema' => $tema['NombreTema'],
            'CodigoMegatime' => $tema['CodigoMegatime'],
            'id_medio' => $tema['id_medio'],
            'Duracion' => $tema['Duracion']
        ];
    }
    }




$soportesMap = [];
foreach ($soportes as $soporte) {
    if ($soporte['estado'] === true) {
    $soportesMap[] = [
        'id' => $soporte['id_soporte'],
        'nombreSoporte' => $soporte['nombreIdentficiador'],
        'idProveedor' => $soporte['id_proveedor']
    ];
}
}

$programasMap = [];
foreach ($programas as $programa) {
    $programasMap[] = [
        'id' => $programa['id'],
        'descripcion' => $programa['descripcion'],
        'soporteId' => $programa['soporte_id'],
        'codmegatime' => $programa['cod_prog_megatime'],
        'horaini' => $programa['hora_inicio'],
        'horafn' => $programa['hora_fin']
    ];
}

$aniosMap = [];
foreach ($anios as $anio) {
    $aniosMap[$anio['id']] = [
        'id' => $anio['id'],
        'years' => $anio['years']
    ];
}
$mesesMap = [];
foreach ($meses as $mes) {
    $mesesMap[$mes['Id']] = $mes;
}


$contratosMap = [];
foreach ($contratos as $contrato) {  
    $contratosMap[] = [
        'id' => $contrato['id'],
        'nombreContrato' => $contrato['NombreContrato'],
        'idCliente' => $contrato['IdCliente'],
        'idProveedor' => $contrato['IdProveedor'], 
        'num_contrato' => $contrato['num_contrato'],
        'id_Anio' => $contrato['id_Anio'], 
        'id_Mes' => $contrato['id_Mes']    
    ];
}  
$clientesMap = [];
foreach ($clientes as $cliente) {  
    if ($cliente['estado'] === true) {
        $clientesMap[] = [
            'id' => $cliente['id_cliente'],
            'nombreCliente' => $cliente['nombreCliente'], 
            'razonSocial' => $cliente['razonSocial']
        ];
    }
}
$productosMap = [];
foreach ($productos as $producto) {
    if ($producto['Estado'] === true) {
    $productosMap[] = [
        'id' => $producto['id'],
        'nombreProducto' => $producto['NombreDelProducto'],
        'razonSocial' => $producto['razonSocial'],
        'idCliente' => $producto['Id_Cliente']
    ];
}
}
$campaignsMap = [];
foreach ($campaigns as $campaign) {
    if ($campaign['estado'] === true) {
        $campaignsMap[] = [
            'id' => $campaign['id_campania'],
            'nombreCampania' => $campaign['NombreCampania'],
            'idCliente' => $campaign['id_Cliente'],
            'IdAgencias' => $campaign['Id_Agencia'] // Asegúrate de que el valor sea correcto
        ];
    }
}
$productosMap2 = [];
foreach ($productos as $producto) {
    if ($producto['Estado'] === true) {
    $productosMap2[$producto['id']] = $producto['NombreDelProducto'];
}}
$clientesMap2 = [];
foreach ($clientes as $cliente) {
    if ($cliente['estado'] === true) {
    $clientesMap2[$cliente['id_cliente']] = $cliente['nombreCliente'];
}}
$contratosMap2 = [];
foreach ($contratos as $contrato) {
    $contratosMap2[$contrato['id']] = $contrato['NombreContrato'];
}
$soportesMap2 = [];
foreach ($soportes as $soporte) {
    if ($soporte['estado'] === true) {
    $soportesMap2[$soporte['id_soporte']] = $soporte['nombreIdentficiador'];
}}
$campaignsMap2 = [];
foreach ($campaigns as $campaign) {
    if ($campaign['estado'] === true) {
    $campaignsMap2[$campaign['id_campania']] = $campaign['NombreCampania'];
}}
$temasMap2 = [];
foreach ($temas as $tema) {
    if ($tema['estado'] === true) {
        // Agrega un array con el nombre del tema y el id_medio como valor
        $temasMap2[$tema['id_tema']] = [
            'NombreTema' => $tema['NombreTema'],
            'id_medio' => $tema['id_medio']  // Asegúrate de que 'id_medio' sea un campo válido en tu array $tema
        ];
    }
}
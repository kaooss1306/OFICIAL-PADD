<?php
// Iniciar sesión
session_start();

//include '../../querys/qcontratos.php';
include '../../querys/qclientes.php';
include '../../componentes/header.php';
include '../../componentes/sidebar.php';


// Obtener el ID de la orden de la URL
$idOrdenPlan = isset($_GET['id_orden']) ? $_GET['id_orden'] : null;

$ordenpublicidad = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/OrdenesDePublicidad');
$clasificaciones = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Clasificacion?select=*');   
$temas = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Temas?select=*');
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
$meses = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Meses?select=*');
$anios = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Anios?select=*');
$programas = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Programas?select=*');
$programasMap = [];
foreach ($programas as $programa) {
    $programasMap[] = [
        'id' => $programa['id'],
        'descripcion' => $programa['descripcion'],
        'soporteId' => $programa['soporte_id'],
        'codmegatime' => $programa['cod_prog_megatime'],
        'horaini' => $programa['hora_inicio'],
        'descripcion' => $programa['descripcion'],
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


$url = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/OrdenesDePublicidad?id_ordenes_de_comprar=eq.$idOrdenPlan&select=*";
$planPublicidad = makeRequest($url);
$datosPublicidad = $planPublicidad[0] ?? [];

$idCliente = $datosPublicidad['id_cliente'] ?? '';

$url2 = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/PlanesPublicidad?id_cliente=eq.$idCliente&select=*";
$productoPublicidad = makeRequest($url2);
$datosProductos = $productoPublicidad[0] ?? [];

$url4 = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Contratos?IdCliente=eq.$idCliente&select=*";
$contrato = makeRequest($url4);
$formaspago = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/FormaDePago?id=eq.1&select=*";
$datosContrato = $contrato[0] ?? [];
$idFormaDePago = $datosContrato['id_FormadePago'] ?? null;

// Variable para almacenar el nombre de la Forma de Pago
$nombreFormaDePago = '';

// Verificar si hay un ID de Forma de Pago
if ($idFormaDePago !== null) {
    // Construir la URL para consultar la Forma de Pago específica
    $formaspago = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/FormaDePago?id=eq." . $idFormaDePago . "&select=*";
    
    // Realizar la solicitud (asumiendo que tienes una función makeRequest)
    $resultadoFormaPago = makeRequest($formaspago);
    
    // Verificar si se encontró la Forma de Pago
    if (!empty($resultadoFormaPago)) {
        // Obtener el nombre de la primera (y generalmente única) entrada
        $nombreFormaDePago = $resultadoFormaPago[0]['NombreFormadePago'] ?? '';
    }
}

$idCampania = $datosProductos['id_campania'] ?? null;
$url3 = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Campania?id_campania=eq.$idCampania&select=*";
$campania = makeRequest($url3);
$datosCampania = $campania[0] ?? [];


$contratos = makeRequest('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Contratos?select=*');
$contratosMap = [];
foreach ($contratos as $contrato) {
    $contratosMap[$contrato['id']] = $contrato;
}

$cliente = $clientesMap[$idCliente] ?? [];
$idComuna = $cliente['id_comuna'] ?? '';
$idRegion = $cliente['id_region'] ?? '';
$nombreComuna = $comunasMap[$idComuna] ?? 'N/A';
$nombreRegion = $regionesMap[$idRegion] ?? 'N/A';

// Corregir la obtención del nombre del producto
$id_producto = $datosProductos['id_producto'] ?? null;
$nombreProducto = $productosMap2[$id_producto] ?? "Nombre no disponible";

// Si $productosMap2[$id_producto] es un array, intentamos obtener el nombre del producto
if (is_array($nombreProducto)) {
    $nombreProducto = $nombreProducto['NombreDelProducto'] ?? $nombreProducto['nombre'] ?? "Nombre no disponible";
}

$idOrdenPlan = isset($_GET['id_orden']) ? $_GET['id_orden'] : null;
$ordenespuMap = [];
foreach ($ordenpublicidad as $ordenpu){
    $ordenespuMap[] = [
        'id_ordenespu' => $ordenpu['id_ordenes_de_comprar'],
        'datosrecopilados' => $ordenpu['datosRecopiladosb'],
        'tipo_item' => $ordenpu['tipo_item'],
        'nombreusuario' => $ordenpu['usuarioregistro']['nombreusuario'] ?? '', 
        'correousuario' => $ordenpu['usuarioregistro']['correousuario'] ?? '', 
        'remplaza' => $ordenpu['remplaza'],
        'numerodeordenremplaza' => $ordenpu['numerodeordenremplaza'],
        'numerodeorden' => $ordenpu['numerodeorden'],
        'copia' => $ordenpu['copia']

    ];
}
// Obtener el tipo_item para el idOrdenPlan específico
$tipo_item = null;
foreach ($ordenespuMap as $orden) {
    if ($orden['id_ordenespu'] == $idOrdenPlan) {
        $tipo_item = $orden['tipo_item'];
        break;
    }
}
// Obtener el remplaza para el idOrdenPlan específico
$remplaza = null;
$remplazado = null;
$copias = null;
$numordenn = null;
foreach ($ordenespuMap as $orden) {     
    if ($orden['id_ordenespu'] == $idOrdenPlan) {         
        $remplaza = $orden['remplaza'];
        $remplazado = $orden['numerodeordenremplaza'];      
        $copias = $orden['copia']; 
        $numordenn = $orden['numerodeorden'];
        
        break;     
    } 
}

$nombresMeses = [
  1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
  5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
  9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
];

// Encontrar la orden específica
$ordenActual = null;
foreach ($ordenespuMap as $orden) {
    if ($orden['id_ordenespu'] == $idOrdenPlan) {
        $ordenActual = $orden;
        break;
    }
}

// Función para obtener mes y año del primer grupo
function obtenerPrimerMesYAnio($datosRecopilados) {
    if (!$datosRecopilados) return ['mes' => null, 'anio' => null];
    
    // Decodificar JSON si es necesario
    $datos = is_string($datosRecopilados) ? json_decode($datosRecopilados, true) : $datosRecopilados;
    
    // Verificar si hay un campo 'datos' en el nuevo formato
    if (isset($datos['datos'])) {
        $datos = $datos['datos'];
    }
    
    // Verificar si hay datos y si el primer elemento tiene calendario
    if (!empty($datos) && isset($datos[0]['calendario']) && !empty($datos[0]['calendario'])) {
        $primerFecha = $datos[0]['calendario'][0];
        return [
            'mes' => $primerFecha['mes'] ?? null,
            'anio' => $primerFecha['anio'] ?? null
        ];
    }
    
    return ['mes' => null, 'anio' => null];
}

// Obtener mes y año
$fechas = obtenerPrimerMesYAnio($ordenActual['datosrecopilados']);

// Obtener el nombre del mes
$nombreMes = isset($fechas['mes']) && isset($nombresMeses[$fechas['mes']]) 
    ? $nombresMeses[$fechas['mes']] 
    : '';

// Obtener el año de la tabla Anios
$anioId = $fechas['anio'] ?? null;
$nombreAnio = isset($anioId) && isset($aniosMap[$anioId]) 
    ? $aniosMap[$anioId]['years'] 
    : '';
?>
<style>
    table.table.table-bordered {
    border: black !important;
}
.table.table-bordered td, .table.table-bordered th {
    border-color: black;
}
    .table:not(.table-sm) thead th {background-color:white; }
    .spn1-1{color:#0000ff; font-weight:bold;}
    .spn1-2{ color:black; font-weight:bold;}
    .titulot2{font-weight:700;   padding-left: 15%;}
    .fanil{padding-left: 12%;}
    .primeracolumnatds{font-size: 12px;
        font-weight: 500;}
.calendario-header {
    padding: 2px !important;
    font-size: 0.85em;
    min-width: 30px;

}
.fainlu th{height:50px; font-size:9px;} .fainlu tr{font-size:9px;}
.nameusu{color: #6878f2; font-weight: 700; font-size: 20px;}
.correusu{font-size:16px; color:black;}
.table-responsive {
        width: 100%;
        overflow-x: auto;
    }
    .table-fixed {
        table-layout: fixed;
        width: 100%;
    }
    .table-fixed th, .table-fixed td {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .table-fixed td {
        word-wrap: break-word;
    }
    #tabdelcal td{font-size:10px !important;}
    #tabdelcal th{font-size:10px !important;}
th.text-center.calendario-header {
    border:1px solid black;
}
.dia-semana {
    font-size: 0.8em;
    color: #666;
    border-bottom: 1px solid #eee;
}
.dia-numero {
    font-size: 0.8em;
    color: #333;
    font-weight: bold;
}
 
.calendario-celda {
    font-size:10px;
    padding: 2px !important;
    font-weight: normal;
}
.normal{font-size:28px;}
.anulacion{font-size: 28px; color:#ff0000;}
.table th {
    vertical-align: bottom;
}
.trfound{border:1px solid black;}
.trfound th{border:1px solid black;}
</style>
<div class="main-content">

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>dashboard">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>ListOrdenes.php">Ver Ordenes de Publicidad</a> </li>
        <li class="breadcrumb-item active" aria-current="page">Orden de Publicidad - <?php echo $clientesMap[$datosPublicidad['id_cliente'] ?? '']['nombreCliente'];?></li>
    </ol>
</nav>
<section class="section">
    <div class="section-body">
        <div class="row mt-sm-4">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                <div class="card-header milinea">
                            <div class="titulox">
                                <h4>Información de la orden de Publicidad</h4>
                            </div>
                            <div class="agregar">
                            <button id="generatePdfButton"><i class="fas fa-file-pdf"></i> Generar PDF</button>
                            </div>
                        </div>
                    <div class="card-body">
                        <div class="author-box-center">
                        <div class="contentable">
<table class="espaciador" width="100%" border="0">
  <tr>
    <td class="azul" width="25%">RUT <?php $rutOrden = $clientesMap[$datosPublicidad['id_cliente'] ?? '']['RUT'];
                                        echo $rutOrden;
    ?></td>
    <td class="titulot" width="50%"><div align="center"><span class="normal">ORDEN DE PUBLICIDAD  <?php echo $numordenn; if (!empty($remplaza)) { echo "   -  " . $remplazado;}?></span> <br>  <span class="anulacion"><?php if (!empty($remplaza)) {echo "ANULA Y REMPLAZA ORDEN N° " . $numordenn . " / " . $copias;} ?></span></div></td>
    <td class="titulot2" width="25%">AÑO /<?php echo htmlspecialchars($nombreAnio); ?> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="titulot3"></td>
    <td>&nbsp;</td>
  </tr>
  <tr class="trencabezado">
    <td class="primeracolumnatds">
    <span class="titulosordentab"><strong>CLIENTE:</strong> <?php echo $clientesMap[$datosPublicidad['id_cliente'] ?? '']['nombreCliente'];?></span><br>
    <span class="titulosordentab"><strong>RUT:</strong> <?php echo $clientesMap[$datosPublicidad['id_cliente'] ?? '']['RUT'];?></span><br>
    <span class="titulosordentab"><strong>DIRECCIÓN:</strong> <?php echo $clientesMap[$datosPublicidad['id_cliente'] ?? '']['direccionEmpresa'];?></span><br>
    <span class="titulosordentab"><strong>COMUNA:</strong> <?php echo $nombreComuna; ?></span><br>
    <span class="titulosordentab"><strong>PRODUCTO:</strong> <?php echo htmlspecialchars($nombreProducto); ?></span><br>
    <span class="titulosordentab"><strong>AÑO:</strong> <?php echo htmlspecialchars($nombreAnio); ?></span><br>
    <span class="titulosordentab"><strong>MES:</strong> <?php echo htmlspecialchars($nombreMes); ?></span><br>
    <span class="titulosordentab"><strong>N° CONTRATO:</strong> <?php echo $datosContrato['num_contrato'] ?? 'No disponible'; ?></span><br>
    <span class="titulosordentab"><strong class="titulosordentabpago">FORMA DE PAGO:</strong> <?php echo $nombreFormaDePago ?? 'No disponible'; ?></span><br>
    <span class="titulosorden2"><strong class="titulosorden3">TIPO ITEM:</strong> <?php echo htmlspecialchars($tipo_item); ?></span></td>


    <td  style="text-align:center;"><span class="titulosordentab"><strong>CAMPAÑA:</strong> <?php echo $datosCampania['NombreCampania'] ?? 'Nombre no disponible'; ?></span><br>
    
    <span class="titulosordentab"><strong>PLAN DE MEDIOS:</strong> <?php echo $datosProductos['NombrePlan'] ?? 'Nombre no disponible'; ?></span><br>
    <?php if (!empty($datosContrato['Descuento1']) && $datosContrato['Descuento1'] > 0) : ?>
  <div class="thebordex">
  <span class="titulosordentab"><strong>DESCUENTO:</strong> <?php echo '$' . number_format($datosContrato['Descuento1'], 0, ',', '.'); ?><span><br>
  </div>
<?php endif; ?>
</td>


    <td class="primeracolumnatds fanil" valign="top">
    <span class="titulosordentab"><strong>PROVEEDOR:</strong> <?php 
    $idProveedor = $datosPublicidad['id_proveedor'] ?? $datosContrato['id_proveedor'] ?? null;
    echo $idProveedor ? ($proveedoresMap[$idProveedor]['nombreProveedor'] ?? 'Proveedor no encontrado') : 'ID de proveedor no disponible';
?></span><br>
    <span class="titulosordentab"><strong>RUT:</strong> <?php 
    $rutProveedor = $datosPublicidad['id_proveedor'] ?? $datosContrato['id_proveedor'] ?? null;
    echo $rutProveedor ? ($proveedoresMap[$rutProveedor]['rutProveedor'] ?? 'Proveedor no encontrado') : 'ID de proveedor no disponible';
?></span><br>
    <span class="titulosorden2"><strong class="titulosorden3">SOPORTE:</strong> <?php 
        $idSoporte = $datosPublicidad['id_soporte'] ?? $datosContrato['id_soporte'] ?? null;
        echo $idSoporte ? ($soportesMap[$idSoporte]['nombreIdentficiador'] ?? 'Soporte no encontrado') : 'ID de soporte no disponible';
    ?></span><br>
    <span class="titulosordentab"><strong>DIRECCIÓN:</strong> <?php 
    echo $idProveedor ? ($proveedoresMap[$idProveedor]['direccionFacturacion'] ?? 'Dirección no disponible') : 'ID de proveedor no disponible';
?></span>
    <br>
    
    <span class="titulosordentab"><strong>COMUNA:</strong> <?php 
    if ($idProveedor && isset($proveedoresMap[$idProveedor])) {
        $idComuna = $proveedoresMap[$idProveedor]['id_comuna'] ?? null;
        if ($idComuna && isset($comunasMap[$idComuna])) {
            echo $comunasMap[$idComuna];
        } else {
            echo 'Comuna no encontrada';
        }
    } else {
        echo 'Información del proveedor no disponible';
    }
?></span>
    <br>
    
    <span class="titulosordentab"><strong>AGENCIA CREATIVA:</strong> AGENCIA DE PRUEBAS</span>  
</td>
  </tr>
</table>
<?php
function procesarDatosPublicidad($idOrdenPlan, $ordenespuMap, $temasMap, $programasMap) {
    $datosPorTema = [];
    
    // Encontrar la orden específica
    $ordenActual = null;
    foreach ($ordenespuMap as $orden) {
        if ($orden['id_ordenespu'] == $idOrdenPlan) {
            $ordenActual = $orden;
            break;
        }
    }
    
    if (!$ordenActual) return [];
    
    // Decodificar el JSON si es necesario
    $datosRecopilados = is_string($ordenActual['datosrecopilados']) 
        ? json_decode($ordenActual['datosrecopilados'], true) 
        : $ordenActual['datosrecopilados'];
     
    // Verificar la estructura del nuevo formato
    if (isset($datosRecopilados['datos']) && is_array($datosRecopilados['datos'])) {
        $datosRecopilados = $datosRecopilados['datos'];
    } elseif (!is_array($datosRecopilados)) {
        error_log("Error: datosrecopilados no es un array válido");
        return [];
    }

    // Agrupar por tema_id
    foreach ($datosRecopilados as $dato) {
        $temaId = $dato['tema_id'];
        
        // Encontrar el tema en temasMap
        $temaNombre = '';
        $temaduracion = '';
        foreach ($temasMap as $tema) {
            if ($tema['id'] == $temaId) {
                $temaNombre = $tema['nombreTema'];
                $temaduracion = $tema['Duracion'];
                break;
            }
        }
        
        // Encontrar el programa
        $programaInfo = null;
        foreach ($programasMap as $programa) {
            if ($programa['id'] == $dato['programa_id']) {
                $programaInfo = $programa;
                break;
            }
        }
        
        // Calcular total de días
        $totalDias = 0;
        foreach ($dato['calendario'] as $cal) {
            $totalDias += $cal['cantidad'];
        }
        
        if (!isset($datosPorTema[$temaId])) {
            $datosPorTema[$temaId] = [
                'nombre' => $temaNombre,
                'duracion' => $temaduracion,
                'programas' => []
            ];
        }
        
        $datosPorTema[$temaId]['programas'][] = [
            'hora' => $programaInfo['horaini'] . ' - ' . $programaInfo['horafn'],
            'codMegatime' => $programaInfo['codmegatime'],
            'nombrep' => $programaInfo['descripcion'],
            'calendario' => $dato['calendario'],
            'totalDias' => $totalDias,
            'tarifaBruta' => $dato['valor_bruto'],
            'descuento' => $dato['descuento'],
            'tarifaNegociada' => $dato['valor_bruto'],
            'clasi' => $dato['clasificacion'],
            'totalNeto' => $dato['valor_neto']
        ];
    }
    
    return $datosPorTema;
}


// Función para generar el encabezado del calendario con días de la semana
function generarEncabezadoCalendario($mes, $anio) {
    $diasSemana = ['D', 'L', 'M', 'Mi', 'J', 'V', 'S'];
    $html = '';
    
    // Generar encabezados del calendario
    for ($dia = 1; $dia <= 31; $dia++) {
        $fecha = mktime(0, 0, 0, $mes, $dia, $anio);
        $diaSemana = $diasSemana[date('w', $fecha)];
        
        $html .= "
            <th class='text-center calendario-header'>
                <div class='dia-semana'>{$diaSemana}</div>
                <div class='dia-numero'>{$dia}</div>
            </th>";
    }
    
    return $html;
}

// Función simplificada para generar las celdas del calendario
function generarCeldasCalendario($calendario) {
    $celdasHtml = '';
    $diasDelMes = 31;
    
    // Crear un array asociativo para acceso rápido
    $calendarioMap = [];
    foreach ($calendario as $cal) {
        $key = "{$cal['dia']}-{$cal['mes']}-{$cal['anio']}";
        $calendarioMap[$key] = $cal['cantidad'];
    }
    
    // Generar celdas solo con las cantidades
    for ($dia = 1; $dia <= $diasDelMes; $dia++) {
        $key = "$dia-{$calendario[0]['mes']}-{$calendario[0]['anio']}";
        $cantidad = isset($calendarioMap[$key]) ? $calendarioMap[$key] : '';
        $celdasHtml .= "<td class='text-center calendario-celda'>{$cantidad}</td>";
    }
    
    return $celdasHtml;
}

// Obtener el ID de la orden
$idOrdenPlan = isset($_GET['id_orden']) ? $_GET['id_orden'] : null;









// Procesar los datos
$datosProcesados = procesarDatosPublicidad($idOrdenPlan, $ordenespuMap, $temasMap, $programasMap);
// Calcular totales



// Nueva función para calcular los totales
function calcularTotales($datosProcesados) {
    $totalNeto = 0;
    
    foreach ($datosProcesados as $tema) {
        foreach ($tema['programas'] as $programa) {
            $totalNeto += $programa['totalNeto'];
        }
    }
    
    $iva = $totalNeto * 0.19; // Calcula el IVA del 19%
    $totalOrden = $totalNeto + $iva; // Total final con IVA
    
    return [
        'totalNeto' => $totalNeto,
        'iva' => $iva,
        'totalOrden' => $totalOrden
    ];
}

$totales = calcularTotales($datosProcesados);
?>

<!-- Tabla HTML -->
<div class="table-responsive">
<?php
function agruparPorMes($datosPorTema) {
    $agrupadosPorMes = [];

    foreach ($datosPorTema as $temaId => $tema) {
        foreach ($tema['programas'] as $programa) {
            $primerMes = $programa['calendario'][0]['mes'];
            $primerAnio = $programa['calendario'][0]['anio'];

            $mesClave = "$primerMes-$primerAnio"; // Crear clave única por mes

            if (!isset($agrupadosPorMes[$mesClave])) {
                $agrupadosPorMes[$mesClave] = [];
            }

            $agrupadosPorMes[$mesClave][$temaId]['nombre'] = $tema['nombre'];
            $agrupadosPorMes[$mesClave][$temaId]['duracion'] = $tema['duracion'];
            $agrupadosPorMes[$mesClave][$temaId]['programas'][] = $programa;
        }
    }

    return $agrupadosPorMes;
}

// Agrupar los datos por mes
$datosAgrupadosPorMes = agruparPorMes($datosProcesados);

// Generar tablas separadas por mes
foreach ($datosAgrupadosPorMes as $mesClave => $datosPorMes) {
    list($mes, $anio) = explode('-', $mesClave);
    $meses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];
    $nombreMes = isset($meses[(int)$mes]) ? $meses[(int)$mes] : "Mes desconocido";
    
    echo "<h3 class='text-center'>Calendario: $nombreMes</h3>";
    echo "<table class='table table-bordered fainlu'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th style='width:120px;' rowspan='2'>Programas</th>";
    echo "<th>Hora</th>";
    echo "<th>Cod. Megatime</th>";
    echo "<th>Seg/ Clas</th>";
    echo generarEncabezadoCalendario($mes, $anio); // Encabezado solo para el mes actual
    echo "<th>Total días</th>";
    echo "<th>Tarifa Bruta</th>";
    echo "<th>Dto</th>";
    echo "<th>Tarifa Negociada</th>";
    echo "<th>TOTAL NETO</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    // Imprimir filas de programas por tema
    foreach ($datosPorMes as $temaId => $tema) {
        foreach ($tema['programas'] as $index => $programa) {
            echo "<tr>";
            echo "<td>";
            if ($index === 0) {
                echo "<span class='spn1-1'><strong class='spn1-2'>TEMA:</strong> {$tema['nombre']}</span><br>";
            }
            echo $programa['nombrep'];
            echo "</td>";

            echo "<td>{$programa['hora']}</td>";
            echo "<td>{$programa['codMegatime']}</td>";
            echo "<td>{$tema['duracion']}</td>";
            echo generarCeldasCalendario($programa['calendario']); // Solo celdas del mes actual
            echo "<td class='text-center'>{$programa['totalDias']}</td>";
            echo "<td class='text-end'>$" . number_format($programa['tarifaBruta'], 0, ',', '.') . "</td>";
            echo "<td class='text-center'>$" . $programa['descuento'] . "</td>";
            echo "<td class='text-end'>$" . number_format($programa['tarifaNegociada'], 0, ',', '.') . "</td>";
            echo "<td class='text-end'>$" . number_format($programa['totalNeto'], 0, ',', '.') . "</td>";
            echo "</tr>";
        }
    }

    echo "</tbody>";
    echo "</table>";
}

?>
</div>
<!-- Nueva tabla de totales -->
<div class="table-responsive mt-4">
    <table class="table table-bordered" style="width: auto; margin-left: auto;">
        <tbody>
            <tr>
                <td class="fw-bold">TOTAL NETO:</td>
                <td class="text-end">$<?php echo number_format($totales['totalNeto'], 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <td class="fw-bold">IVA 19%:</td>
                <td class="text-end">$<?php echo number_format($totales['iva'], 0, ',', '.'); ?></td>
            </tr>
            <tr class="table-active">
                <td class="fw-bold">TOTAL ORDEN($):</td>
                <td class="text-end fw-bold">$<?php echo number_format($totales['totalOrden'], 0, ',', '.'); ?></td>
            </tr>
        </tbody>
    </table>
</div>
<div style="margin-top:30px; display: flex; justify-content: flex-end; text-align: center; width: 100%;">
                                            <div>
                                                <input class="nombreuser" hidden value="<?php echo $nombre_usuario ?>">
                                                <input class="correouser" hidden value="<?php echo $correoUsuario ?>">
                                                <span class="nameusu"><?php echo $ordenespuMap[0]['nombreusuario']; ?></span><br>
                                                <span class="correusu"><?php echo $ordenespuMap[0]['correousuario']; ?></span>
                                            </div>
                                        </div>

</div>

                        </div>
                    </div>
                </div>


        </div>
    </div>
</section>
<div class="settingSidebar">
    <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
    </a>
    <div class="settingSidebar-body ps-container ps-theme-default">
        <div class=" fade show active">
            <div class="setting-panel-header">Setting Panel
            </div>
            <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Select Layout</h6>
                <div class="selectgroup layout-color w-50">
                    <label class="selectgroup-item">
                        <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
                        <span class="selectgroup-button">Light</span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
                        <span class="selectgroup-button">Dark</span>
                    </label>
                </div>
            </div>
            <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Sidebar Color</h6>
                <div class="selectgroup selectgroup-pills sidebar-color">
                    <label class="selectgroup-item">
                        <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
                        <span class="selectgroup-button selectgroup-button-icon" data-bs-toggle="tooltip" data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
                        <span class="selectgroup-button selectgroup-button-icon" data-bs-toggle="tooltip" data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                    </label>
                </div>
            </div>
            <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Color Theme</h6>
                <div class="theme-setting-options">
                    <ul class="choose-theme list-unstyled mb-0">
                        <li title="white" class="active">
                            <div class="white"></div>
                        </li>
                        <li title="cyan">
                            <div class="cyan"></div>
                        </li>
                        <li title="black">
                            <div class="black"></div>
                        </li>
                        <li title="purple">
                            <div class="purple"></div>
                        </li>
                        <li title="orange">
                            <div class="orange"></div>
                        </li>
                        <li title="green">
                            <div class="green"></div>
                        </li>
                        <li title="red">
                            <div class="red"></div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                    <label class="m-b-0">
                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" id="mini_sidebar_setting">
                        <span class="custom-switch-indicator"></span>
                        <span class="control-label p-l-10">Mini Sidebar</span>
                    </label>
                </div>
            </div>
            <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                    <label class="m-b-0">
                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" id="sticky_header_setting">
                        <span class="custom-switch-indicator"></span>
                        <span class="control-label p-l-10">Sticky Header</span>
                    </label>
                </div>
            </div>
            <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                    <i class="fas fa-undo"></i> Restore Default
                </a>
            </div>
        </div>
    </div>

</div>
</div>
<script>
function generatePDF() {
    // Crear una nueva instancia de jsPDF en orientación horizontal
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
        orientation: 'landscape',
        unit: 'mm',
        format: 'a4'
    });

    // Obtener el contenido del div
    const content = document.querySelector('.contentable');

    // Definir el padding en milímetros
    const padding = 10; // Puedes ajustar este valor según necesites

    // Usar html2canvas para convertir el contenido HTML a una imagen
    html2canvas(content, {
        scale: 4, // Aumenta la escala para mejorar la calidad
        useCORS: true // Permite cargar imágenes de otros dominios si es necesario
    }).then(canvas => {
        const imgData = canvas.toDataURL('image/jpeg', 1.0);
        
        // Obtener las dimensiones de la página
        const pageWidth = doc.internal.pageSize.getWidth();
        const pageHeight = doc.internal.pageSize.getHeight();
        
        // Calcular las dimensiones de la imagen para que ocupe toda la página menos el padding
        const maxWidth = pageWidth - (2 * padding);
        const maxHeight = pageHeight - (2 * padding);
        
        const widthRatio = maxWidth / canvas.width;
        const heightRatio = maxHeight / canvas.height;
        const ratio = Math.min(widthRatio, heightRatio);
        
        const imgWidth = canvas.width * ratio;
        const imgHeight = canvas.height * ratio;
        
        // Centrar la imagen en la página, considerando el padding
        const x = (pageWidth - imgWidth) / 2;
        const y = (pageHeight - imgHeight) / 2;

        // Añadir la imagen al PDF
        doc.addImage(imgData, 'JPEG', x, y, imgWidth, imgHeight);

        // Guardar el PDF
        doc.save('orden_publicidad_horizontal_con_padding.pdf');
    });
}

// Añadir el evento click al botón
document.getElementById('generatePdfButton').addEventListener('click', generatePDF);
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <?php include '../../componentes/settings.php'; ?>

      <?php include '../../componentes/footer.php'; ?>
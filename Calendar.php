<?php
session_start();

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
$user_name = $_SESSION['user_name'];

include 'componentes/header.php';
include 'querys/qcontratos.php';
include 'componentes/sidebar.php';

// Verificar si $mesesMap y $aniosMap están disponibles
if (!isset($mesesMap) || !isset($aniosMap)) {
    die("Error: No se pudieron obtener los datos de meses y años.");
}

?>

<style>
    .calendario {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        padding: 20px;
        max-width: 100%;
        width: 100%;
    }
    .selectores {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }
    #mesSelector, #anioSelector {
        flex: 1;
        padding: 10px;
        font-size: 16px;
        background-color: white;
        border: 1px solid #d2d2d2;
    }
    .dias {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 10px;
    }
    .dia {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }
    .dia input {
        width: 100%;
        padding: 5px;
        margin-top: 5px;
        box-sizing: border-box;
    }
    .dia-numero {
        font-size: 14px;
        color: #888;
        margin-bottom: 5px;
    }
    #submitButton {
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    #submitButton:hover {
        background-color: #0056b3;
    }
</style>

<div class="main-content">
    <div class="calendario">
        <div class="selectores">
            <select id="mesSelector">
                <?php foreach ($mesesMap as $id => $mes): ?>
                    <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($mes['Nombre']); ?></option>
                <?php endforeach; ?>
            </select>
            <select id="anioSelector">
                <?php foreach ($aniosMap as $id => $anio): ?>
                    <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($anio['years']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div id="diasContainer" class="dias"></div>
        <button id="submitButton">Enviar datos</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mesSelector = document.getElementById('mesSelector');
    const anioSelector = document.getElementById('anioSelector');
    const diasContainer = document.getElementById('diasContainer');
    const submitButton = document.getElementById('submitButton');


    if (!mesSelector || !anioSelector || !diasContainer || !submitButton) {
        console.error('No se pudieron encontrar todos los elementos necesarios');
        return;
    }

    const mesesMap = <?php echo json_encode($mesesMap); ?>;
    const aniosMap = <?php echo json_encode($aniosMap); ?>;

    function inicializarCalendario() {
    const matrizCalendario = calendarMap2[idCalendar] || [];

    if (matrizCalendario.length > 0) {
        // Tomar el primer elemento de la matriz para el mes y año por defecto
        const primerElemento = matrizCalendario[0];
        const mes = primerElemento.mes;
        const anio = primerElemento.anio;

        console.log('Inicializando con mes y año:', mes, anio);

        // Buscar el Id correspondiente en los mapas de meses y años
        const mesId = Object.keys(mesesMap).find(key => parseInt(mesesMap[key].Id) === mes);
        const anioId = Object.keys(aniosMap).find(key => parseInt(aniosMap[key].years) === anio);

        console.log('Mes Id:', mesId, 'Año Id:', anioId);

        if (mesId !== undefined && anioId !== undefined) {
            // Establecer los valores seleccionados en los selectores
            mesSelector.value = mesId;
            anioSelector.value = anioId;

            console.log('Mes y año seleccionados automáticamente:', mesSelector.value, anioSelector.value);

            // Actualizar el calendario con estos valores
            actualizarCalendario();
        } else {
            console.error('No se pudo encontrar el mes y/o año en los mapas.');
        }
    } else {
        console.error('Matriz de calendario vacía para el ID:', idCalendar);
    }
}

    

    function recopilarDatos() {
        const mesId = parseInt(mesSelector.value);
        const anioId = parseInt(anioSelector.value);
        const mes = parseInt(mesesMap[mesId]['Id']);
        const anio = parseInt(aniosMap[anioId]['years']);
        const diasEnMes = new Date(anio, mes, 0).getDate();

        const matrizCalendario = [];

        for (let dia = 1; dia <= diasEnMes; dia++) {
            const input = document.getElementById(`input-${anio}-${mes}-${dia}`);
            if (input && input.value) {
                matrizCalendario.push({
                    mes: mes,
                    anio: anio,
                    dia: dia,
                    cantidad: parseInt(input.value)
                });
            }
        }

        return {
            id_cliente: 23, // ID de cliente por defecto
            matrizCalendario: matrizCalendario
        };
    }

    function enviarDatos() {
        const datos = recopilarDatos();
        console.log('Datos a enviar:', JSON.stringify(datos));

        fetch('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/json', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'apikey': 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc',
                'Prefer': 'return=minimal'
            },
            body: JSON.stringify(datos)
        })
        .then(response => {
            console.log('Respuesta completa:', response);
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`HTTP error! status: ${response.status}, message: ${text}`);
                });
            }
            return response.text();
        })
        .then(data => {
            console.log('Respuesta del servidor:', data);
            if (data === '' || data === '{}') {
                console.log('Datos guardados con éxito');
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Los datos se han guardado correctamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload(); // Recarga la página
                    }
                });
            } else {
                console.log('Respuesta inesperada del servidor');
                Swal.fire({
                    title: 'Error',
                    text: 'Respuesta inesperada del servidor. Por favor, verifica los logs.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error al guardar los datos:', error);
            Swal.fire({
                title: 'Error',
                text: 'Error al guardar los datos: ' + error.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }

    mesSelector.addEventListener('change', actualizarCalendario);
    anioSelector.addEventListener('change', actualizarCalendario);
    submitButton.addEventListener('click', enviarDatos);
    inicializarCalendario();
  
});
</script>

<?php include 'componentes/settings.php'; ?>
<script src="<?php echo $ruta; ?>assets/js/app.min.js"></script>
<?php include 'componentes/footer.php'; ?>
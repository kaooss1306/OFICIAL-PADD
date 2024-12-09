<?php
session_start();

//Verificar si el usuario ha iniciado sesión//
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
  // Si no ha iniciado sesión, redirigir al login
  header("Location: index.php");
  exit();
}
// Usar el nombre del usuario
$user_name = $_SESSION['user_name'];


// Función para obtener los clientes desde la API de Supabase
function fetchClientes($page = 1, $per_page = 6) {
  $offset = ($page - 1) * $per_page;
  $url = 'https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Clientes';
  
  // URL para obtener el total de registros
  $countUrl = $url . '?select=count';
  // URL para obtener los registros paginados
  $url .= "?select=*&offset=$offset&limit=$per_page";
  
  $options = [
      'http' => [
          'header' => "apikey: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc\n" .
                      "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc"
      ]
  ];
  
  $context = stream_context_create($options);
  
  // Obtener el total de registros
  $countResponse = file_get_contents($countUrl, false, $context);
  $totalCount = 0;
  if ($countResponse !== FALSE) {
      $countData = json_decode($countResponse, true);
      $totalCount = count($countData);
  }
  
  // Obtener los registros paginados
  $response = file_get_contents($url, false, $context);
  
  if ($response === FALSE) {
      return ['data' => [], 'total' => 0, 'pages' => 0];
  }
  
  $data = json_decode($response, true);
  $total_pages = ceil($totalCount / $per_page);
  
  return [
      'data' => $data,
      'total' => $totalCount,
      'pages' => $total_pages,
      'current_page' => $page
  ];
}

// Obtener la página actual
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) $current_page = 1;

// Obtener los clientes con paginación
$result = fetchClientes($current_page);
$clientes = $result['data'];
$total_pages = $result['pages'];

include 'componentes/header.php';
include 'componentes/sidebar.php';
include 'querys/qdashboard.php';
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-3d"></script>





<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="row ">
      <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
 
        <div class="card">
          <div class="card-statistic-4">
            <div class="align-items-center justify-content-between">
              <div class="row align-items-center">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 pr-0 pt-3">
                  <div class="card-content">
                    <h5 class="font-15">N° Agencias</h5>
                    <h2 class="mb-3 font-18 sinfont"><?php echo $agenciasCount; ?></h2>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pl-0">
                  <div class="banner-img ">
                    <i class="fas fa-sort-numeric-up"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
          <div class="card-statistic-4">
            <div class="align-items-center justify-content-between">
              <div class="row align-items-center">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 pr-0 pt-3">
                  <div class="card-content">
                    <h5 class="font-15">N° de Clientes</h5>
                    <h2 class="mb-3 font-18 sinfont"><?php echo $clientesCount; ?></h2>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pl-0">
                  <div class="banner-img">
                    <i class="fas fa-users"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
          <div class="card-statistic-4">
            <div class="align-items-center justify-content-between">
              <div class="row align-items-center">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 pr-0 pt-3">
                  <div class="card-content">
                    <h5 class="font-15">N° campañas</h5>
                    <h2 class="mb-3 font-18 sinfont"><?php echo $campaignsCount; ?></h2>

                  </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pl-0">
                  <div class="banner-img">
                    <i class="fas fa-chart-bar"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
          <div class="card-statistic-4">
            <div class="align-items-center justify-content-between">
              <div class="row align-items-center">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 pr-0 pt-3">
                  <div class="card-content">
                    <h5 class="font-15">N° de medios</h5>
                    <h2 class="mb-3 font-18 sinfont"><?php echo $mediosCount; ?></h2>

                  </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pl-0">
                  <div class="banner-img">
                    <i class="fas fa-image"></i>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-6 col-sm-6 col-lg-4">
        <div class="card">
          <div class="card-header">
            <h4 class="peque">Productos</h4>
          </div>
          <div class="card-body">
            <canvas id="myPieChart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-6 col-sm-6 col-lg-4">

        <div class="card">
          <div class="card-header">
            <h4 class="peque">Listado de Clientes</h4>
          </div>
          <div class="card-body">
            <ul class="list-unstyled list-unstyled-border user-list" id="clients-list">
              <?php foreach ($clientes as $cliente): ?>
                <li class="items-list-compo cliente-item" style="display: none;">
                  <i class="fas fa-user"></i>
                  <div class="media-body w-100">
                    <div class="mt-0 fw-bold ttc"><?php echo htmlspecialchars($cliente['nombreCliente']); ?></div>
                    <div class="text-small">Dirección Empresa: <?php echo htmlspecialchars($cliente['direccionEmpresa']); ?></div>
                    <div class="text-small">Teléfono Fijo: <?php echo htmlspecialchars($cliente['telFijo']); ?></div>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
            
            <!-- Controles de paginación -->
            <div class="card-footer text-center">
              <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center" id="pagination">
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-sm-6 col-lg-4">

        <div class="card">
          <div class="card-header">
            <h4 class="peque">Mensajes</h4>
          </div>
          <div class="card-body">
            <ul class="list-unstyled list-unstyled-border user-list" id="message-list">
              <?php foreach ($avisos as $aviso): ?>
                <li class="items-list-compo mensaje-item" style="display: none;">
                  <i class="fas fa-inbox"></i>
                  <div class="media-body w-100">
                    <div class="mt-0 fw-bold ttc"><?php echo $aviso['mensaje'] ?></div>
                    <div  class="text-small"> Fecha de creación: <?php echo formatDate($aviso['created_at']); ?></div>
       
                  </div>
                </li>
                </tr>
              <?php endforeach; ?>


            </ul>
            
            <!-- Controles de paginación para mensajes -->
            <div class="card-footer text-center">
              <nav aria-label="Message navigation">
                <ul class="pagination justify-content-center" id="message-pagination">
                </ul>
              </nav>
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
              <span class="selectgroup-button selectgroup-button-icon" data-bs-toggle="tooltip"
                data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
            </label>
            <label class="selectgroup-item">
              <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
              <span class="selectgroup-button selectgroup-button-icon" data-bs-toggle="tooltip"
                data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
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
              <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                id="mini_sidebar_setting">
              <span class="custom-switch-indicator"></span>
              <span class="control-label p-l-10">Mini Sidebar</span>
            </label>
          </div>
        </div>
        <div class="p-15 border-bottom">
          <div class="theme-setting-options">
            <label class="m-b-0">
              <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                id="sticky_header_setting">
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

</div>
</div>

<script>
  // Datos para el gráfico
  const labels = <?php echo json_encode($labels); ?>;
  const data = <?php echo json_encode($data); ?>;

  const ctx = document.getElementById('myPieChart').getContext('2d');
  const myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: labels, // Aquí los nombres de los clientes
      datasets: [{
        data: data, // Aquí la cantidad de productos por cliente
        backgroundColor: [
          'rgba(255, 99, 132)',
          'rgba(54, 162, 235)',
          'rgba(255, 206, 86)',
          'rgba(75, 192, 192)',
          'rgba(153, 102, 255)',
          'rgba(255, 159, 64)'
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'left',
        },

        tooltip: {
          callbacks: {
            label: function(context) {
              let label = context.label || '';
              let value = context.raw;
              let sum = context.dataset.data.reduce((a, b) => a + b, 0);
              let percentage = (value * 100 / sum).toFixed(2) + "%";
              return `${label}: ${value} productos (${percentage})`;
            }
          }
        },
        datalabels: {
          formatter: (value, ctx) => {
            let sum = ctx.dataset.data.reduce((a, b) => a + b, 0);
            let percentage = (value * 100 / sum).toFixed(2) + "%";
            return percentage;
          },
          color: '#fff',
        },
        // Opciones para el 3D
        '3d': {
          enabled: true,
          effect: '3d',
          depth: 20,
          alphaAngle: 45
        }
      }
    },
    plugins: [ChartDataLabels]
  });
</script>

<script>
  // Configuración de la paginación para clientes
  const itemsPerPage = 6;
  let currentPage = 1;
  let currentMessagePage = 1;

  // Función para mostrar los elementos de la página actual (clientes)
  function showCurrentPageItems() {
      const items = document.querySelectorAll('.cliente-item');
      showItems(items, currentPage, 'cliente-item');
  }

  // Función para mostrar los elementos de la página actual (mensajes)
  function showCurrentMessageItems() {
      const items = document.querySelectorAll('.mensaje-item');
      showItems(items, currentMessagePage, 'mensaje-item');
  }

  // Función genérica para mostrar elementos
  function showItems(items, page, itemClass) {
      const startIndex = (page - 1) * itemsPerPage;
      const endIndex = startIndex + itemsPerPage;

      items.forEach((item, index) => {
          if (index >= startIndex && index < endIndex) {
              item.style.display = 'flex';
          } else {
              item.style.display = 'none';
          }
      });
  }

  // Función para crear los botones de paginación (clientes)
  function setupPagination() {
      const items = document.querySelectorAll('.cliente-item');
      setupPaginationButtons(items, 'pagination', currentPage, (page) => {
          currentPage = page;
          showCurrentPageItems();
          updatePaginationButtons('pagination', currentPage);
      });
  }

  // Función para crear los botones de paginación (mensajes)
  function setupMessagePagination() {
      const items = document.querySelectorAll('.mensaje-item');
      setupPaginationButtons(items, 'message-pagination', currentMessagePage, (page) => {
          currentMessagePage = page;
          showCurrentMessageItems();
          updatePaginationButtons('message-pagination', currentMessagePage);
      });
  }

  // Función genérica para crear botones de paginación
  function setupPaginationButtons(items, containerId, currentPage, onClick) {
      const pageCount = Math.ceil(items.length / itemsPerPage);
      const paginationElement = document.getElementById(containerId);
      paginationElement.innerHTML = '';

      // Botón anterior
      if (pageCount > 1) {
          const prevButton = document.createElement('li');
          prevButton.className = 'page-item';
          prevButton.innerHTML = `<a class="page-link" href="#" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
          </a>`;
          prevButton.addEventListener('click', (e) => {
              e.preventDefault();
              if (currentPage > 1) {
                  onClick(currentPage - 1);
              }
          });
          paginationElement.appendChild(prevButton);
      }

      // Botones de número de página
      for (let i = 1; i <= pageCount; i++) {
          const button = document.createElement('li');
          button.className = `page-item ${currentPage === i ? 'active' : ''}`;
          button.innerHTML = `<a class="page-link" href="#">${i}</a>`;
          button.addEventListener('click', (e) => {
              e.preventDefault();
              onClick(i);
          });
          paginationElement.appendChild(button);
      }

      // Botón siguiente
      if (pageCount > 1) {
          const nextButton = document.createElement('li');
          nextButton.className = 'page-item';
          nextButton.innerHTML = `<a class="page-link" href="#" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
          </a>`;
          nextButton.addEventListener('click', (e) => {
              e.preventDefault();
              if (currentPage < pageCount) {
                  onClick(currentPage + 1);
              }
          });
          paginationElement.appendChild(nextButton);
      }
  }

  // Función para actualizar el estado activo de los botones
  function updatePaginationButtons(containerId, currentPage) {
      const buttons = document.querySelectorAll(`#${containerId} .page-item`);
      buttons.forEach((button, index) => {
          // Saltamos los botones de anterior y siguiente
          if (index === 0 || index === buttons.length - 1) return;
          
          const pageNumber = index;
          if (pageNumber === currentPage) {
              button.classList.add('active');
          } else {
              button.classList.remove('active');
          }
      });
  }

  // Inicializar la paginación cuando se carga la página
  document.addEventListener('DOMContentLoaded', () => {
      // Inicializar paginación de clientes
      showCurrentPageItems();
      setupPagination();
      
      // Inicializar paginación de mensajes
      showCurrentMessageItems();
      setupMessagePagination();
  });
</script>
<?php include 'componentes/footer.php'; ?>

<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Grades for {{ $subject }}</title>  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">  
</head>  
<body>  
  
<main id="main" class="main">    
  <div class="pagetitle">    
      <h1>Grades for {{ $subject }}</h1>    
      <nav>    
          <ol class="breadcrumb">    
              <li class="breadcrumb-item"><a href="{{ url('index') }}">Home</a></li>    
              <li class="breadcrumb-item active">Grades for {{ $subject }}</li>    
          </ol>    
      </nav>    
  </div><!-- End Page Title -->    
  
  <section class="section">  
      <div class="row">  
        <div class="col-lg-12">  
          <div class="card" style="overflow-x: auto; padding: 20px; max-height: 100%; width: 100%; min-width: 1500px;">  
            <div class="card-body" style="overflow-x: auto; padding: 40px; max-height: 100%; width: 100%; min-width: 1500px;">  
              <h5 class="card-title">Datatables</h5>  
  
              <table class="table table-bordered">  
                <thead>  
                    <tr>  
                        <th rowspan="3" class="text-center">No</th>  
                        <th rowspan="3" class="text-center">Nama Siswa</th>  
                        <th colspan="10" class="text-center">ASESMEN FORMATIF</th>  
                        <th colspan="10" class="text-center">ASESMEN SUMATIF AKHIR LINGKUP MATERI</th>  
                        <th colspan="10" class="text-center">ASESMEN SUMATIF AKHIR SEMESTER *</th>  
                        <th rowspan="3" class="text-center">Nilai Rapor</th>  
                    </tr>  
                    <tr>  
                        <th colspan="10" class="text-center">TP 1 - TP 10</th>  
                        <th colspan="10" class="text-center">TP 1 - TP 10</th>  
                        <th colspan="10" class="text-center">TP 1 - TP 10</th>  
                    </tr>  
                    <tr>  
                        <th class="text-center">TP 1</th>  
                        <th class="text-center">TP 2</th>  
                        <th class="text-center">TP 3</th>  
                        <th class="text-center">TP 4</th>  
                        <th class="text-center">TP 5</th>  
                        <th class="text-center">TP 6</th>  
                        <th class="text-center">TP 7</th>  
                        <th class="text-center">TP 8</th>  
                        <th class="text-center">TP 9</th>  
                        <th class="text-center">TP 10</th>  
                        <th class="text-center">TP 1</th>  
                        <th class="text-center">TP 2</th>  
                        <th class="text-center">TP 3</th>  
                        <th class="text-center">TP 4</th>  
                        <th class="text-center">TP 5</th>  
                        <th class="text-center">TP 6</th>  
                        <th class="text-center">TP 7</th>  
                        <th class="text-center">TP 8</th>  
                        <th class="text-center">TP 9</th>  
                        <th class="text-center">TP 10</th>  
                        <th class="text-center">TP 1</th>  
                        <th class="text-center">TP 2</th>  
                        <th class="text-center">TP 3</th>  
                        <th class="text-center">TP 4</th>  
                        <th class="text-center">TP 5</th>  
                        <th class="text-center">TP 6</th>  
                        <th class="text-center">TP 7</th>  
                        <th class="text-center">TP 8</th>  
                        <th class="text-center">TP 9</th>  
                        <th class="text-center">TP 10</th>  
                    </tr>  
                </thead>  
                <tbody>  
                    <tr>  
                        <td class="text-center">1</td>  
                        <td class="text-center">Nama Siswa</td>  
                        <td class="text-center">0</td>  
                        <td class="text-center">0</td>  
                        <td class="text-center">0</td>  
                        <td class="text-center">0</td>  
                        <td class="text-center">0</td>  
                        <td class="text-center">0</td>  
                        <td class="text-center">0</td>  
                        <td class="text-center">0</td>  
                        <td class="text-center">0</td>  
                        <td class="text-center">0</td>  
                        <td class="text-center">0</td>  
                        <td class="text-center">0</td>  
                        <td class="text-center">0</td>  
                        <td class="text-center">0</td>  
                        <td class="text-center">0</td>  
                        <td class="text-center">0</td>  
                        <td class="text-center">0</td>  
                        <td class="text-center">0</td>  
                        <td class="text-center">0</td>  
                    </tr>  
                    <!-- Add more rows as needed -->  
                </tbody>  
            </table>  
          </div>  
        </div>              
      </div>  
    </section>  
  
</main>  
<script>
// Function to add subject to sidebar  
function addSubjectToSidebar(subjectName) {    
    const sidebarNav = document.getElementById('nilai-siswa-nav');    
    const newNavItem = document.createElement('li');    
    newNavItem.className = 'nav-item';    
    newNavItem.innerHTML = `    
        <a class="nav-link collapsed" href="{{ url('nilaisiswa') }}?subject=${encodeURIComponent(subjectName)}">    
            <i class="bi bi-circle"></i><span>${subjectName}</span>    
        </a>    
    `;    
    sidebarNav.appendChild(newNavItem);    
} 
</script> 
  
</body>  
</html>  

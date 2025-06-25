@extends('layouts.app2')

@section('title', 'Dashboard')

@section('content')
 <div class="container-fluid py-2">

  <div class="row g-4">
    <div class="col-12 col-md-6">
      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4 py-3">
          <h5 class="mb-0 fw-semibold">Distribusi User (Pie Chart)</h5>
        </div>
        <div class="card-body p-4">
          <canvas id="pieChart" style="min-height: 300px;"></canvas>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6">
      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-success text-white rounded-top-4 py-3">
          <h5 class="mb-0 fw-semibold">Jumlah User per Role (Bar Chart)</h5>
        </div>
        <div class="card-body p-4">
          <canvas id="barChart" style="min-height: 750px;"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const userCounts = @json($userCounts);
  const roles = Object.keys(userCounts);
  const counts = Object.values(userCounts);

  const colors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'];

  // Pie Chart
  const ctxPie = document.getElementById('pieChart').getContext('2d');
  new Chart(ctxPie, {
    type: 'pie',
    data: {
      labels: roles,
      datasets: [{
        data: counts,
        backgroundColor: colors,
        borderColor: '#ffffff',
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            font: { size: 14, weight: '600' },
            color: '#444'
          }
        },
        tooltip: {
          enabled: true,
          bodyFont: { size: 14 },
          padding: 8,
          cornerRadius: 6
        }
      }
    }
  });

  // Bar Chart
  const ctxBar = document.getElementById('barChart').getContext('2d');
  new Chart(ctxBar, {
    type: 'bar',
    data: {
      labels: roles,
      datasets: [{
        label: 'Jumlah User',
        data: counts,
        backgroundColor: colors,
        borderRadius: 6,
        maxBarThickness: 45,
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1,
            color: '#555',
            font: { size: 13 }
          },
          grid: {
            color: '#eee',
            borderDash: [4, 4]
          }
        },
        x: {
          ticks: {
            color: '#555',
            font: { size: 13, weight: '600' }
          },
          grid: { display: false }
        }
      },
      plugins: {
        legend: { display: false },
        tooltip: {
          enabled: true,
          bodyFont: { size: 14 },
          padding: 8,
          cornerRadius: 6
        }
      }
    }
  });
</script>

<style>
  /* Typography */
  h3, h5 {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  /* Card hover effect */
  .card {
    transition: box-shadow 0.3s ease;
  }
  .card:hover {
    box-shadow: 0 12px 24px rgba(0,0,0,0.12);
  }

  /* Responsive spacing */
  @media (max-width: 768px) {
    .card-body {
      padding: 2rem !important;
    }
  }

  /* Container padding */
  .container {
    max-width: 1140px;
  }
</style>
@endsection

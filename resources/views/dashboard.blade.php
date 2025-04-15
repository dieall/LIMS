@extends('layouts.app')
  
@section('title', 'Dashboard - Laravel Admin Panel With Login and Registration')
  
@section('contents')

<style>
    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
        padding-top: 60px;
    }

    .modal-content {
        background-color: white;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 1200px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        position: relative;
    }

    .close-btn {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        position: absolute;
        top: 10px;
        right: 25px;
        cursor: pointer;
    }

    .close-btn:hover,
    .close-btn:focus {
        color: black;
        text-decoration: none;
    }

    #modalTitle {
        text-align: center;
        margin-bottom: 20px;
        font-size: 20px;
        font-weight: bold;
    }
    
    /* Card animations */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
    }
    
    /* Badge styling */
    .badge {
        font-size: 85%;
    }
</style>


<div class="row">
    <!-- First Column -->


    <!-- Second Column -->
    <div class="col-sm-4">
    <div class="card mb-4">
        <div class="card-body">
            <!-- Judul dan Ikon -->
            <div class="row">
                <div class="col mt-0">
                    <h5 class="card-title">Jumlah Pengajuan Data Solder

                    </h5>
                </div>
                <div class="col-auto">
                    <div class="stat text-success">
                        <i class="align-middle" data-feather="check-circle"></i>
                    </div>
                </div>
            </div>
            <!-- Jumlah Data -->
            <h1 class="mt-1 mb-3">{{ $jumlahApprovedHariIni }}</h1>
            <!-- Deskripsi Tambahan -->
            <div class="mb-0">
                <span class="text-success">
                    <i class="mdi mdi-check-circle"></i>
                </span>
                <span class="text-muted">Jumlah data yang sudah disetujui pada hari ini.</span>
            </div>
        </div>
    </div>
</div>






   <div class="col-sm-4">
    <div class="card mb-4">
        <div class="card-body">
            <!-- Judul dan Ikon -->
            <div class="row">
                <div class="col mt-0">
                    <h5 class="card-title">Jumlah Pengajuan Data Chemical</h5>
                </div>
                <div class="col-auto">
                    <div class="stat text-info">
                        <i class="align-middle" data-feather="check-circle"></i>
                    </div>
                </div>
            </div>
            <!-- Jumlah Data -->
            <h1 class="mt-1 mb-3">{{ $jumlahApprovedChemicalHariIni }}</h1>
            <!-- Deskripsi Tambahan -->
            <div class="mb-0">
                <span class="text-info">
                    <i class="mdi mdi-check-circle"></i>
                </span>
                <span class="text-muted">Jumlah data yang sudah disetujui pada hari ini.</span>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-4">
    <div class="card mb-4">
        <div class="card-body">
            <!-- Judul dan Ikon -->
            <div class="row">
                <div class="col mt-0">
                    <h5 class="card-title">Jumlah Pengajuan Data Rawmat</h5>
                </div>
                <div class="col-auto">
                <div class="stat text-success">
                        <i class="align-middle" data-feather="check-circle"></i>
                    </div>
                </div>
            </div>
            <!-- Jumlah Data -->
            <h1 class="mt-1 mb-3">{{ $jumlahRawmatHariIni }}</h1>
            <!-- Deskripsi Tambahan -->
            <div class="mb-0">
                <span class="text-warning">
                    <i class="mdi mdi-plus-circle"></i>
                </span>
                <span class="text-muted">Jumlah data raw material yang masuk hari ini.</span>
            </div>
        </div>
    </div>
</div>

</div>


<div class="row">


    



</div>

<div class="row">
            <div class="col-12 col-lg-6">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <h5 class="card-title">Grafik Data Total Keseluruhan</h5>
                        <h6 class="card-subtitle text-muted">Total pengajuan gabungan berdasarkan bulan</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="chartjs-line"></canvas>
                        </div>
                    </div>
                </div>
            </div>



	<div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Grafik Data Approve Keseluruhan</h5>
                <h6 class="card-subtitle text-muted">Jumlah Pengajuan per Bulan untuk Tahun</h6>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="monthly-bar-chart"></canvas>
                </div>
            </div>
        </div>
	 </div>
    <!-- Tabel Data Pengajuan Solder -->
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Data Pengajuan Solder - Hari Ini</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Category</th>
                                <th>Tipe Sampel</th>
                                <th>Batch</th>
                                <th>Waktu</th>
                                <th>Nama</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuanSolder as $key => $solder)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $solder->categorysolder->nama_kategori }}</td>
                                    <td>{{ $solder->tipe_solder }}</td>
                                    <td>{{ $solder->batch }}</td>
                                    <td>{{ $solder->created_at->format('H:i') }}</td>
                                    <td>{{ $solder->nama }}</td>
                                    <td>
                                        @if ($solder->status == 'Pengajuan')
                                            <span class="badge bg-primary">{{ $solder->status }}</span>
                                        @elseif ($solder->status == 'Proses Analisa')
                                            <span class="badge bg-info">{{ $solder->status }}</span>
                                        @elseif ($solder->status == 'Selesai Analisa')
                                            <span class="badge bg-secondary">{{ $solder->status }}</span>
                                        @elseif ($solder->status == 'Review Hasil')
                                            <span class="badge bg-warning">{{ $solder->status }}</span>
                                        @elseif ($solder->status == 'Approve')
                                            <span class="badge bg-success">{{ $solder->status }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $solder->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada Data Pengajuan solder yang di proses hari ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Data Pengajuan Chemical -->
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Data Pengajuan Chemical - Hari Ini</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Category</th>
                                <th>Nama Sampel</th>
                                <th>Batch</th>
                                <th>Waktu</th>
                                <th>Nama</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuanChemical as $key => $chemical)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $chemical->nama_chemical }}</td>
                                    <td>{{ $chemical->nama }}</td>
                                    <td>{{ $chemical->batch }}</td>
                                    <td>{{ $chemical->created_at->format('H:i') }}</td>
                                    <td>{{ $chemical->orang }}</td>
                                    <td>
                                        @if ($chemical->status == 'Pengajuan')
                                            <span class="badge bg-primary">{{ $chemical->status }}</span>
                                        @elseif ($chemical->status == 'Proses Analisa')
                                            <span class="badge bg-info">{{ $chemical->status }}</span>
                                        @elseif ($chemical->status == 'Selesai Analisa')
                                            <span class="badge bg-secondary">{{ $chemical->status }}</span>
                                        @elseif ($chemical->status == 'Review Hasil')
                                            <span class="badge bg-warning">{{ $chemical->status }}</span>
                                        @elseif ($chemical->status == 'Approve')
                                            <span class="badge bg-success">{{ $chemical->status }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $chemical->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada Data Pengajuan Chemical yang di proses hari ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="col-sm-6">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Data Operator Laboratorium - Solder</h5>
        </div>
        <div class="card-body">
            <!-- Filter Bulan -->
            <form method="GET" action="{{ url()->current() }}">
                <div class="form-group">
                    <label for="month">Pilih Bulan:</label>
                    <select name="month" id="month" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Bulan --</option>
                        <option value="1" {{ request('month') == 1 ? 'selected' : '' }}>Januari</option>
                        <option value="2" {{ request('month') == 2 ? 'selected' : '' }}>Februari</option>
                        <option value="3" {{ request('month') == 3 ? 'selected' : '' }}>Maret</option>
                        <option value="4" {{ request('month') == 4 ? 'selected' : '' }}>April</option>
                        <option value="5" {{ request('month') == 5 ? 'selected' : '' }}>Mei</option>
                        <option value="6" {{ request('month') == 6 ? 'selected' : '' }}>Juni</option>
                        <option value="7" {{ request('month') == 7 ? 'selected' : '' }}>Juli</option>
                        <option value="8" {{ request('month') == 8 ? 'selected' : '' }}>Agustus</option>
                        <option value="9" {{ request('month') == 9 ? 'selected' : '' }}>September</option>
                        <option value="10" {{ request('month') == 10 ? 'selected' : '' }}>Oktober</option>
                        <option value="11" {{ request('month') == 11 ? 'selected' : '' }}>November</option>
                        <option value="12" {{ request('month') == 12 ? 'selected' : '' }}>Desember</option>
                    </select>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama</th>
                            <th>Rata Rata</th>
                            <th>Jumlah Sampel</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groupedHistoriesSolder as $userName => $histories)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $userName }}</td>
                                <td>{{ $histories->first()->totalInterval ?? 'N/A' }}</td> <!-- Menampilkan total interval -->
                                <td>{{ $histories->first()->totalSampel ?? 0 }}</td> <!-- Menampilkan total jumlah sampel -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div class="col-sm-6">
    <div class="card">
        <div class="card-header">
        <h5 class="card-title">Data Operator Laboratorium - Chemical</h5>
        </div>
        <div class="card-body">
            <!-- Filter Bulan -->
            <form method="GET" action="{{ url()->current() }}">
                <div class="form-group">
                    <label for="month">Pilih Bulan:</label>
                    <select name="month" id="month" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Bulan --</option>
                        <option value="1" {{ request('month') == 1 ? 'selected' : '' }}>Januari</option>
                        <option value="2" {{ request('month') == 2 ? 'selected' : '' }}>Februari</option>
                        <option value="3" {{ request('month') == 3 ? 'selected' : '' }}>Maret</option>
                        <option value="4" {{ request('month') == 4 ? 'selected' : '' }}>April</option>
                        <option value="5" {{ request('month') == 5 ? 'selected' : '' }}>Mei</option>
                        <option value="6" {{ request('month') == 6 ? 'selected' : '' }}>Juni</option>
                        <option value="7" {{ request('month') == 7 ? 'selected' : '' }}>Juli</option>
                        <option value="8" {{ request('month') == 8 ? 'selected' : '' }}>Agustus</option>
                        <option value="9" {{ request('month') == 9 ? 'selected' : '' }}>September</option>
                        <option value="10" {{ request('month') == 10 ? 'selected' : '' }}>Oktober</option>
                        <option value="11" {{ request('month') == 11 ? 'selected' : '' }}>November</option>
                        <option value="12" {{ request('month') == 12 ? 'selected' : '' }}>Desember</option>
                    </select>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama</th>
                            <th>Rata Rata</th>
                            <th>Jumlah Sampel</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groupedHistoriesChemical as $userName => $histories)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $userName }}</td>
                                <td>{{ $histories->first()->totalInterval ?? 'N/A' }}</td> <!-- Menampilkan total interval -->
                                <td>{{ $histories->first()->totalSampel ?? 0 }}</td> <!-- Menampilkan total jumlah sampel -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection
























<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ambil canvas
        const ctx = document.getElementById("chartjs-line").getContext("2d");

        // Gradient untuk area di bawah garis
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, "rgba(54, 162, 235, 0.5)"); // Warna biru dengan transparansi
        gradient.addColorStop(1, "rgba(54, 162, 235, 0)");   // Transparan di bagian bawah

        // Line chart
        new Chart(ctx, {
            type: "line",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"], // Label bulan
                datasets: [
                    {
                        label: "Total Pengajuan",
                        fill: true, // Aktifkan area di bawah garis
                        backgroundColor: gradient, // Gradient untuk area
                        borderColor: "rgba(54, 162, 235, 1)",
                        pointBackgroundColor: "rgba(54, 162, 235, 1)",
                        pointBorderColor: "#fff", // Warna border titik
                        data: @json($totalMonthlyData) // Ambil data total dari controller
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        gridLines: {
                            color: "rgba(0, 0, 0, 0.05)"
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true, // Mulai dari 0
                            stepSize: 10 // Langkah (ubah sesuai data)
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0.05)"
                        }
                    }]
                },
                legend: {
                    display: true // Tampilkan legenda
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return "Total Keseluruhan Data : " + tooltipItem.yLabel;
                        }
                    }
                }
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById("monthly-bar-chart").getContext("2d");

        // Gradient for each dataset
        const gradientGreen = ctx.createLinearGradient(0, 0, 0, 400);
        gradientGreen.addColorStop(0, "#4caf50");
        gradientGreen.addColorStop(1, "#81c784");

        const gradientBlue = ctx.createLinearGradient(0, 0, 0, 400);
        gradientBlue.addColorStop(0, "#2196f3");
        gradientBlue.addColorStop(1, "#64b5f6");

        const gradientOrange = ctx.createLinearGradient(0, 0, 0, 400);
        gradientOrange.addColorStop(0, "#ff9800");
        gradientOrange.addColorStop(1, "#ffb74d");

        const tbsData = @json($tbsMonthlyData);
        const tbrData = @json($tbrMonthlyData);
        const tbcData = @json($tbcMonthlyData);

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [
                    {
                        label: "Data Solder",
                        backgroundColor: gradientGreen,
                        borderColor: "#4caf50",
                        data: tbsData,
                        barPercentage: 0.75,
                        categoryPercentage: 0.5
                    },
                    {
                        label: "Data Rawmat",
                        backgroundColor: gradientBlue,
                        borderColor: "#2196f3",
                        data: tbrData,
                        barPercentage: 0.75,
                        categoryPercentage: 0.5
                    },
                    {
                        label: "Data Chemical",
                        backgroundColor: gradientOrange,
                        borderColor: "#ff9800",
                        data: tbcData,
                        barPercentage: 0.75,
                        categoryPercentage: 0.5
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: "top", // Posisi legend di atas
                        labels: {
                            font: {
                                size: 14 // Ukuran font untuk legend
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: "#f5f5f5",
                        titleColor: "#333",
                        bodyColor: "#666",
                        borderWidth: 1,
                        borderColor: "#ddd"
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                return parseInt(value); // Hanya angka satuan
                            },
                            font: {
                                size: 12 // Ukuran font axis Y
                            }
                        },
                        grid: {
                            drawBorder: false,
                            color: "rgba(200, 200, 200, 0.2)"
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12 // Ukuran font axis X
                            }
                        },
                        grid: {
                            drawBorder: false,
                            color: "rgba(200, 200, 200, 0.2)"
                        }
                    }
                }
            }
        });
    });
</script>




<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Pie chart
        new Chart(document.getElementById("chartjs-pie1"), {
            type: "pie",
            data: {
                labels: {!! json_encode($labels) !!},  // Memasukkan labels dari controller
                datasets: [{
                    data: {!! json_encode($data) !!},   // Memasukkan data dari controller
                    backgroundColor: [
                        window.theme.primary,
                        window.theme.warning,
                        window.theme.danger,
                        "#dee2e6",
                        window.theme.success,
                        "#ffce56",
                        "#36a2eb",
                        "#ff6384",
                        "#4bc0c0"
                    ],
                    borderColor: "transparent"
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                }
            }
        });
    });
</script>

<!-- Fetch Pegawai Count -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Data dari controller
        const chartData = @json($chartData);
        const labels = Object.keys(chartData); // Ambil ID dari chartData sebagai label
        const data = Object.values(chartData); // Ambil total count sebagai data

        // Pie chart dengan data dinamis
        new Chart(document.getElementById("dmtChartPie"), {
            type: "pie",
            data: {
                labels: labels, // ID sebagai label
                datasets: [{
                    label: 'Distribusi DMT',
                    data: data, // Total count sebagai data
                    backgroundColor: [
                        window.theme.primary,
                        window.theme.warning,
                        window.theme.danger,
                        "#dee2e6"
                    ],
                    borderColor: "transparent"
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: true
                }
            }
        });
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Pie chart configuration
    new Chart(document.getElementById("data-statistics-chart"), {
        type: "pie", // Chart type
        data: {
            labels: ["MT-630", "MT-620"], // Labels for categories
            datasets: [{
                data: [
                    {{ $dataCounts['MT-630']['total'] }}, 
                    {{ $dataCounts['MT-620']['total'] }}
                ], // Data from the controller
                backgroundColor: [
                    "#4caf50", // Color for MT-630 (Green)
                    "#ff9800"  // Color for MT-620 (Orange)
                ],
                borderColor: "transparent" // No border for slices
            }]
        },
        options: {
            maintainAspectRatio: false, // Ensure responsive layout
            plugins: {
                legend: {
                    display: true, // Display the legend
                    position: "bottom" // Position it at the bottom
                }
            }
        }
    });
});
</script>


<!-- Radar Chart -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    new Chart(document.getElementById("chartjs-radar"), {
        type: "radar",
        data: {
            labels: ["Speed", "Reliability", "Comfort", "Safety", "Efficiency"],
            datasets: [{
                label: "Model X",
                backgroundColor: "rgba(0, 123, 255, 0.2)",
                borderColor: window.theme.primary,
                pointBackgroundColor: window.theme.primary,
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: window.theme.primary,
                data: [70, 53, 82, 60, 33]
            }, {
                label: "Model S",
                backgroundColor: "rgba(220, 53, 69, 0.2)",
                borderColor: window.theme.danger,
                pointBackgroundColor: window.theme.danger,
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: window.theme.danger,
                data: [35, 38, 65, 85, 84]
            }]
        },
        options: { maintainAspectRatio: false }
    });
});
</script>

<!-- Polar Area Chart -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    new Chart(document.getElementById("chartjs-polar-area"), {
        type: "polarArea",
        data: {
            labels: ["Speed", "Reliability", "Comfort", "Safety", "Efficiency"],
            datasets: [{
                label: "Model S",
                data: [35, 38, 65, 70, 24],
                backgroundColor: [
                    window.theme.primary,
                    window.theme.success,
                    window.theme.danger,
                    window.theme.warning,
                    window.theme.info
                ]
            }]
        },
        options: { maintainAspectRatio: false }
    });
});
</script>
<script>
<script>
    // Modal functions
    function openModal() {
        document.getElementById('statusHistoryModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('statusHistoryModal').style.display = 'none';
    }

    function viewDetail(solder_id) {
        fetch(`/getStatusHistory?solder_id=${solder_id}`)
            .then(response => response.json())
            .then(data => {
                let historyList = "";
                
                data.forEach(item => {
                    historyList += `
                        <div class="status-entry card mb-3">
                            <div class="card-body">
                                <p><strong>Status:</strong> ${item.status || 'Unknown'}</p>
                                <p><strong>Waktu Perubahan:</strong> ${item.changed_at || 'Unknown'}</p>
                                <p><strong>Nama Pengguna:</strong> ${item.user ? item.user.name : 'Unknown'}</p>
                                <p><strong>Interval Waktu:</strong> ${item.interval || 'Unknown'}</p>
                                <p><strong>Nama Pengaju:</strong> ${item.pengajuan_solder ? item.pengajuan_solder.nama : 'Unknown'}</p>
                            </div>
                        </div>
                    `;
                });
                
                document.getElementById('historyDetails').innerHTML = historyList;
                openModal();
            })
            .catch(error => {
                console.error('Error fetching status history:', error);
            });
    }

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        const modal = document.getElementById('statusHistoryModal');
        if (event.target === modal) {
            closeModal();
        }
    };
</script>
</script>
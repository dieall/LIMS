@extends('layouts.app')
  
@section('title', 'Dashboard - Laravel Admin Panel With Login and Registration')
  
@section('contents')
<div class="row">
    <!-- First Column -->
    <div class="col-sm-3">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Jumlah Pegawai</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="users"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3" id="jumlahPegawai">Memuat...</h1>
                <div class="mb-0">
                    <span class="text-muted">Jumlah pegawai saat ini</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Column -->
    <div class="col-sm-3">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Belum Di Konfirmasi</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="users"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">$21.300</h1>
                <div class="mb-0">
                    <span class="text-success">
                        <i class="mdi mdi-arrow-bottom-right"></i> 6.65%
                    </span>
                    <span class="text-muted">Since last week</span>
                </div>
            </div>
        </div>
    </div>



    <!-- Third Column -->
    <div class="col-sm-3">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Earnings</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="dollar-sign"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">$21.300</h1>
                <div class="mb-0">
                    <span class="text-success">
                        <i class="mdi mdi-arrow-bottom-right"></i> 6.65%
                    </span>
                    <span class="text-muted">Since last week</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Fourth Column -->
    <div class="col-sm-3">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Earnings</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="dollar-sign"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">$21.300</h1>
                <div class="mb-0">
                    <span class="text-success">
                        <i class="mdi mdi-arrow-bottom-right"></i> 6.65%
                    </span>
                    <span class="text-muted">Since last week</span>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <!-- Card for Data Tinstab -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header text-center">
                <h5 class="card-title">Data Tinstab</h5>
                <h6 class="card-subtitle text-muted">Data Tinstab Saat ini</h6>
            </div>
            <div class="card-body">
                <div class="chart chart-sm">
                    <canvas id="chartjs-pie" width="100" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card for Pie Chart -->
    <div class="col-lg-4 mb-4">
        <div class="card">
        <div class="card-header text-center">
    <h5 class="card-title">Data Tinchem</h5>
    <h6 class="card-subtitle text-muted">Data Tinchem Saat ini</h6>
</div>
            <div class="card-body">
                <div class="chart chart-sm">
                    <canvas id="chartjs-pie1"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Card for Data DMT -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header text-center">
                <h5 class="card-title">Data DMT</h5>
                <h6 class="card-subtitle text-muted">Data DMT Saat ini</h6>
            </div>
            <div class="card-body">
                <div class="chart chart-sm">
                    <canvas id="dmtChartPie" width="100" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
						<div class="col-12 col-lg-6">
							<div class="card flex-fill w-100">
								<div class="card-header">
									<h5 class="card-title">Line Chart</h5>
									<h6 class="card-subtitle text-muted">A line chart is a way of plotting data points on a line.</h6>
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
									<h5 class="card-title">Bar Chart</h5>
									<h6 class="card-subtitle text-muted">A bar chart provides a way of showing data values represented as vertical bars.</h6>
								</div>
								<div class="card-body">
									<div class="chart">
										<canvas id="chartjs-bar"></canvas>
									</div>
								</div>
							</div>
						</div>

					</div>
@endsection
<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Line chart
			new Chart(document.getElementById("chartjs-line"), {
				type: "line",
				data: {
					labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
					datasets: [{
						label: "Sales ($)",
						fill: true,
						backgroundColor: "transparent",
						borderColor: window.theme.primary,
						data: [2115, 1562, 1584, 1892, 1487, 2223, 2966, 2448, 2905, 3838, 2917, 3327]
					}, {
						label: "Orders",
						fill: true,
						backgroundColor: "transparent",
						borderColor: "#adb5bd",
						borderDash: [4, 4],
						data: [958, 724, 629, 883, 915, 1214, 1476, 1212, 1554, 2128, 1466, 1827]
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					tooltips: {
						intersect: false
					},
					hover: {
						intersect: true
					},
					plugins: {
						filler: {
							propagate: false
						}
					},
					scales: {
						xAxes: [{
							reverse: true,
							gridLines: {
								color: "rgba(0,0,0,0.05)"
							}
						}],
						yAxes: [{
							ticks: {
								stepSize: 500
							},
							display: true,
							borderDash: [5, 5],
							gridLines: {
								color: "rgba(0,0,0,0)",
								fontColor: "#fff"
							}
						}]
					}
				}
			});
		});
	</script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Bar chart
			new Chart(document.getElementById("chartjs-bar"), {
				type: "bar",
				data: {
					labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
					datasets: [{
						label: "Last year",
						backgroundColor: window.theme.primary,
						borderColor: window.theme.primary,
						hoverBackgroundColor: window.theme.primary,
						hoverBorderColor: window.theme.primary,
						data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79],
						barPercentage: .75,
						categoryPercentage: .5
					}, {
						label: "This year",
						backgroundColor: "#dee2e6",
						borderColor: "#dee2e6",
						hoverBackgroundColor: "#dee2e6",
						hoverBorderColor: "#dee2e6",
						data: [69, 66, 24, 48, 52, 51, 44, 53, 62, 79, 51, 68],
						barPercentage: .75,
						categoryPercentage: .5
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					scales: {
						yAxes: [{
							gridLines: {
								display: false
							},
							stacked: false,
							ticks: {
								stepSize: 20
							}
						}],
						xAxes: [{
							stacked: false,
							gridLines: {
								color: "transparent"
							}
						}]
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
    fetch('/api/pegawai/count')
        .then(response => response.json())
        .then(data => {
            document.getElementById('jumlahPegawai').innerText = data.jumlahPegawai;
        })
        .catch(error => {
            console.error('Error fetching jumlah pegawai:', error);
            document.getElementById('jumlahPegawai').innerText = 'Data tidak tersedia';
        });
});
</script>

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
        // Pie chart
        new Chart(document.getElementById("chartjs-pie"), {
            type: "pie",
            data: {
                labels: ["MT-630", "MT-620"], // Labels for the chart
                datasets: [{
                    data: [{{ $dataCounts['MT-630']['total'] }}, {{ $dataCounts['MT-620']['total'] }}], // Data from your controller
                    backgroundColor: [
                        window.theme.primary, // Color for MT-630
                        window.theme.warning  // Color for MT-620
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

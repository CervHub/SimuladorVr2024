@extends('Supervisor.main')


@section('content')
    <div class="row">
        <div class="col-lg-8 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 col-lg-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                    <h4 class="card-title card-title-dash">Rendimiento Anual</h4>
                                    <h5 class="card-subtitle card-subtitle-dash">Análisis del rendimiento a lo largo del año
                                    </h5>
                                </div>

                            </div>
                            <div class="chartjs-wrapper mt-5">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas id="lineChart" width="573" height="300"
                                    style="display: block; height: 150px; width: 459px;"
                                    class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-md-6 col-lg-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body pb-0">
                            <h4 class="card-title card-title-dash mb-4">Resumen Anual</h4>
                            <div class="chartjs-wrapper mt-5">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas id="donutChartAnual" width="573" height="187"
                                    style="display: block; height: 150px; width: 459px;"
                                    class="chartjs-render-monitor"></canvas>
                            </div>
                            <div class="mt-4 mb-4">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <p class="mb-1">Total de Inscripciones</p>
                                        <h2 id="totalInscripcionesAnuales" class="text-info">1000</h2>
                                        <!-- Reemplaza con tus datos reales -->
                                    </li>
                                    <li class="list-group-item">
                                        <p class="mb-1">Aprobados</p>
                                        <h2 id="totalAprobadosAnuales" class="text-success">700</h2>
                                        <!-- Reemplaza con tus datos reales -->
                                    </li>
                                    <li class="list-group-item">
                                        <p class="mb-1">Desaprobados</p>
                                        <h2 id="totalDesaprobadosAnuales" class="text-danger">200</h2>
                                        <!-- Reemplaza con tus datos reales -->
                                    </li>
                                    <li class="list-group-item">
                                        <p class="mb-1">Pendientes de Notas</p>
                                        <h2 id="totalPendientesAnuales" class="text-warning">100</h2>
                                        <!-- Reemplaza con tus datos reales -->
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 col-lg-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                    <h4 class="card-title card-title-dash">Rendimiento Semanal</h4>
                                    <h5 class="card-subtitle card-subtitle-dash">Análisis del rendimiento en los últimos 7
                                        días</h5>
                                </div>
                            </div>
                            <div class="chartjs-wrapper mt-5">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas id="lineChartUltimos7Dias" width="573" height="187"
                                    style="display: block; height: 150px; width: 459px;"
                                    class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-md-6 col-lg-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body pb-0">
                            <h4 class="card-title card-title-dash mb-4">Resumen de los Últimos 7 Días</h4>
                            <div class="chartjs-wrapper mt-5">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas id="donutChartUltimos7Dias" width="573" height="187"
                                    style="display: block; height: 150px; width: 459px;"
                                    class="chartjs-render-monitor"></canvas>
                            </div>
                            <div class="mt-4">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <p class="mb-1">Aprobados</p>
                                        <h2 class="text-success">250</h2> <!-- Reemplaza con tus datos reales -->
                                    </li>
                                    <li class="list-group-item">
                                        <p class="mb-1">Desaprobados</p>
                                        <h2 class="text-danger">50</h2> <!-- Reemplaza con tus datos reales -->
                                    </li>
                                    <li class="list-group-item">
                                        <p class="mb-1">Pendientes de Notas</p>
                                        <h2 class="text-warning">50</h2> <!-- Reemplaza con tus datos reales -->
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const iconSuperAdmin = document.querySelector('#dashboard-supervisor');
        iconSuperAdmin.classList.add('active');
    </script>

    <script>
        var dataporMes = @json($induccionesPorMes);
        console.log(dataporMes);

        var labelsGrafica = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre",
            "Octubre", "Noviembre", "Diciembre"
        ];

        var aprobados = dataporMes.map(function(induccion) {
            return induccion.estadoTrabajadores.approved;
        });

        var desaprobados = dataporMes.map(function(induccion) {
            return induccion.estadoTrabajadores.disapproved;
        });

        var pendientes = dataporMes.map(function(induccion) {
            return induccion.estadoTrabajadores.pending;
        });

        var totalAprobadosAnuales = aprobados.reduce(function(a, b) {
            return a + b;
        }, 0);

        var totalDesaprobadosAnuales = desaprobados.reduce(function(a, b) {
            return a + b;
        }, 0);

        var totalPendientesAnuales = pendientes.reduce(function(a, b) {
            return a + b;
        }, 0);

        var totalInscripcionesAnuales = totalAprobadosAnuales + totalDesaprobadosAnuales + totalPendientesAnuales;

        $('#totalAprobadosAnuales').text(totalAprobadosAnuales);
        $('#totalDesaprobadosAnuales').text(totalDesaprobadosAnuales);
        $('#totalPendientesAnuales').text(totalPendientesAnuales);
        $('#totalInscripcionesAnuales').text(totalInscripcionesAnuales);

        if (window.lineChart instanceof Chart) {
            window.lineChart.destroy();
        }

        var lineChartCtx = document.getElementById("lineChart").getContext("2d");
        window.lineChart = new Chart(lineChartCtx, {
            type: "line",
            data: {
                labels: labelsGrafica,
                datasets: [{
                        label: "Aprobados",
                        data: aprobados,
                        fill: false,
                        borderColor: "#2196f3",
                        backgroundColor: "#2196f3",
                        borderWidth: 1,
                        smooth: 0.4,
                    },
                    {
                        label: "Desaprobados",
                        data: desaprobados,
                        fill: false,
                        borderColor: "#f32196",
                        backgroundColor: "#f32196",
                        borderWidth: 1,
                        smooth: 0.4,
                    },
                    {
                        label: "Pendientes",
                        data: pendientes,
                        fill: false,
                        borderColor: "#4caf50",
                        backgroundColor: "#4caf50",
                        borderWidth: 1,
                        smooth: 0.4,
                    },
                ],
            },
            options: {
                title: {
                    display: true,
                    text: 'Evolución de Aprobados, Desaprobados y Pendientes de Nota a lo largo del año'
                },
                tooltips: {
                    callbacks: {
                        title: function(tooltipItem, data) {
                            var index = tooltipItem[0]['index'];
                            return labelsGrafica[index];
                        },
                        label: function(tooltipItem, data) {
                            var dataset = data['datasets'][tooltipItem['datasetIndex']];
                            return dataset['data'][tooltipItem['index']];
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                }
            }
        });
    </script>

    <script>
        var donutChartCtxAnual = document.getElementById("donutChartAnual").getContext("2d");

        var dataDonutChartAnual = {
            labels: ["Aprobados", "Desaprobados", "Pendientes de Notas"],
            datasets: [{
                data: [totalAprobadosAnuales, totalDesaprobadosAnuales, totalPendientesAnuales],
                backgroundColor: ["#28a745", "#dc3545", "#ffc107"],
                hoverBackgroundColor: ["#218838", "#c82333", "#ffb21a"],
                borderWidth: 1,
            }],
        };

        var donutChartOptionsAnual = {
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 60,
            legend: {
                position: 'bottom',
            },
        };

        var donutChartAnual = new Chart(donutChartCtxAnual, {
            type: 'doughnut',
            data: dataDonutChartAnual,
            options: donutChartOptionsAnual,
        });
    </script>

    <script>
        var donutChartCtxUltimos7Dias = document.getElementById("donutChartUltimos7Dias").getContext("2d");

        var dataDonutChart = {
            labels: ["Aprobados", "Desaprobados", "Pendientes de Notas"],
            datasets: [{
                data: [250, 50, 50], // Reemplaza con tus datos reales
                backgroundColor: ["#28a745", "#dc3545", "#ffc107"],
                hoverBackgroundColor: ["#218838", "#c82333", "#ffb21a"],
                borderWidth: 1,
            }],
        };

        var donutChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 60, // Ajusta el tamaño del agujero en el gráfico de dona
            legend: {
                position: 'bottom',
            },
        };

        var donutChartUltimos7Dias = new Chart(donutChartCtxUltimos7Dias, {
            type: 'doughnut',
            data: dataDonutChart,
            options: donutChartOptions,
        });
    </script>

    <script>
        // Datos genéricos
        var labelsGrafica = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];
        var aprobados = [25, 30, 35, 40, 38, 42, 37];
        var desaprobados = [5, 3, 7, 2, 6, 4, 8];
        var pendientes = [8, 6, 10, 12, 9, 11, 7];

        // Cambia el ID del canvas a "lineChartUltimos7Dias"
        if (window.lineChartUltimos7Dias instanceof Chart) {
            window.lineChartUltimos7Dias.destroy();
        }

        var lineChartCtxUltimos7Dias = document.getElementById("lineChartUltimos7Dias").getContext("2d");
        window.lineChartUltimos7Dias = new Chart(lineChartCtxUltimos7Dias, {
            type: "line",
            data: {
                labels: labelsGrafica,
                datasets: [{
                        label: "Aprobados",
                        data: aprobados,
                        fill: false,
                        borderColor: "#2196f3",
                        backgroundColor: "#2196f3",
                        borderWidth: 1,
                    },
                    {
                        label: "Desaprobados",
                        data: desaprobados,
                        fill: false,
                        borderColor: "#f32196",
                        backgroundColor: "#f32196",
                        borderWidth: 1,
                    },
                    {
                        label: "Pendientes",
                        data: pendientes,
                        fill: false,
                        borderColor: "#4caf50",
                        backgroundColor: "#4caf50",
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                title: {
                    display: true,
                    text: 'Evolución de Aprobados, Desaprobados y Pendientes de Nota en los últimos 7 días'
                },
                tooltips: {
                    callbacks: {
                        title: function(tooltipItem, data) {
                            var index = tooltipItem[0]['index'];
                            return labelsGrafica[index];
                        },
                        label: function(tooltipItem, data) {
                            var dataset = data['datasets'][tooltipItem['datasetIndex']];
                            return dataset['data'][tooltipItem['index']];
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                }
            }
        });
    </script>
@endsection

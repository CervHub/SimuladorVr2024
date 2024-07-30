@extends('Supervisor.main')


@section('content')
    <div class="row">
        <div class="col-lg-6 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 col-lg-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                    <h4 class="card-title card-title-dash">Número de trabajadores por servicio</h4>
                                    <h5 class="card-subtitle card-subtitle-dash">Análisis del número de trabajadores por cada servicio</h5>
                                </div>
                            </div>
                            <div class="chartjs-wrapper mt-5">
                                <div id="container"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 col-lg-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                    <h4 class="card-title card-title-dash">Número de trabajadores por servicio</h4>
                                    <h5 class="card-subtitle card-subtitle-dash">Análisis del número de trabajadores por cada servicio</h5>
                                </div>
                            </div>
                            <div class="chartjs-wrapper mt-5">
                                <div id="container-talleres-inducciones"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 col-lg-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                    <h4 class="card-title card-title-dash">Número de trabajadores por servicio</h4>
                                    <h5 class="card-subtitle card-subtitle-dash">Análisis del número de trabajadores por cada servicio</h5>
                                </div>
                            </div>
                            <div class="chartjs-wrapper mt-5">
                                <div id="container-talleres-trabajadores"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 col-lg-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                    <h4 class="card-title card-title-dash">Número de trabajadores por servicio</h4>
                                    <h5 class="card-subtitle card-subtitle-dash">Análisis del número de trabajadores por cada servicio</h5>
                                </div>
                            </div>
                            <div class="chartjs-wrapper mt-5">
                                <div id="containertalleresyear"></div>
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

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>


<script>
    // Para mostrar los servicios
    let data = @json($data);
    console.log(data);

    let chartData = data.servicios.map(function(e) {
       return {
           name: e.name,
           y: e.numero_workers,
           color: 'rgb(' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ')'
       };
    });

    const chart = Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Número de trabajadores por servicio'
        },
        xAxis: {
            categories: data.servicios.map(function(e) { return ''; }),
            title: {
                text: 'Servicios'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Número de trabajadores',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' trabajadores'
        },
        plotOptions: {
            column: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: chartData.map(function(e) {
            return {
                name: e.name,
                data: [e.y],
                color: e.color
            };
        }),
        exporting: {
            enabled: true
        }
    });

    // Agrupar por alias y contar el número de talleres y trabajadores
    let groupedData = data.inducciones.reduce(function(acc, curr) {
        if (typeof acc[curr.alias] == 'undefined') {
            acc[curr.alias] = { talleres: 1, trabajadores: curr.workers_count };
        } else {
            acc[curr.alias].talleres += 1;
            acc[curr.alias].trabajadores += curr.workers_count;
        }
        return acc;
    }, {});

    // Preparar los datos para el gráfico de talleres
    let chartDataTalleres = Object.keys(groupedData).map(function(alias) {
        return {
            name: alias,
            data: [groupedData[alias].talleres],
            color: 'rgb(' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ')'
        };
    });

    // Crear el gráfico de talleres
    const chartTalleres = Highcharts.chart('container-talleres-inducciones', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Número de talleres creados'
        },
        xAxis: {
            categories: [''],
            title: {
                text: 'Talleres'
            }

        },
        yAxis: {
            min: 0,
            title: {
                text: 'Número de talleres',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' talleres'
        },
        plotOptions: {
            column: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: chartDataTalleres,
        exporting: {
            enabled: true
        }
    });

    // Crear el gráfico de trabajadores
    // Preparar los datos para el gráfico de trabajadores
    let chartDataTrabajadores = Object.keys(groupedData).map(function(alias) {
        return {
            name: alias,
            data: [groupedData[alias].trabajadores],
            color: 'rgb(' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ')'
        };
    });

    const chartTrabajadores = Highcharts.chart('container-talleres-trabajadores', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Número de trabajadores por taller'
        },
        xAxis: {
            categories: [''],
            title: {
                text: 'Talleres'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Número de trabajadores',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' trabajadores'
        },
        plotOptions: {
            column: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: chartDataTrabajadores,
        exporting: {
            enabled: true
        }
    });
    let inducciones = data.inducciones;
    let meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

    let dataMeses = inducciones.reduce((acc, curr) => {
        let year = curr.year;
        if (!acc[year]) {
            acc[year] = {};
            meses.forEach(month => {
                acc[year][month] = { Aprobados: 0, Desaprobados: 0, SinNota: 0 };
            });
        }
        let month = curr.month;
        acc[year][month].Aprobados += curr.aprovados;
        acc[year][month].Desaprobados += curr.reprobados;
        acc[year][month].SinNota += curr.sinNota;
        return acc;
    }, {});

    // Crear un select para los años
    // Crear un select para los años
    let selectYear = document.createElement('select');
    Object.keys(dataMeses).forEach(year => {
        let option = document.createElement('option');
        option.value = year;
        option.text = year;
        selectYear.appendChild(option);
    });

    // Obtener el elemento donde quieres insertar el select
    let container = document.getElementById('containertalleresyear');

    // Insertar el select antes del container
    container.parentNode.insertBefore(selectYear, container);

    // El resto de tu código sigue aquí...

    // Cuando se selecciona un año, actualizar el gráfico
    selectYear.addEventListener('change', (event) => {
        let year = event.target.value;
        let dataYear = dataMeses[year];

        // Actualizar el gráfico
        chartMeses.update({
            xAxis: {
                categories: Object.keys(dataYear)
            },
            series: [
                {
                    name: 'Aprobados',
                    data: Object.keys(dataYear).map(month => dataYear[month].Aprobados)
                },
                {
                    name: 'Desaprobados',
                    data: Object.keys(dataYear).map(month => dataYear[month].Desaprobados)
                },
                {
                    name: 'Sin Nota',
                    data: Object.keys(dataYear).map(month => dataYear[month].SinNota)
                }
            ]
        });
    });

    // Crear el gráfico inicial con el primer año
    let firstYear = Object.keys(dataMeses)[0];
    let dataFirstYear = dataMeses[firstYear];

    const chartMeses = Highcharts.chart('containertalleresyear', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Número de aprobados, desaprobados y sin nota por mes'
        },
        xAxis: {
            categories: Object.keys(dataFirstYear),
            title: {
                text: 'Meses'
            }
        },
        yAxis: {
            title: {
                text: 'Cantidad',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' estudiantes'
        },
        plotOptions: {
            column: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: [
            {
                name: 'Aprobados',
                data: Object.keys(dataFirstYear).map(month => dataFirstYear[month].Aprobados),
                color: 'rgb(0, 123, 255)'
            },
            {
                name: 'Desaprobados',
                data: Object.keys(dataFirstYear).map(month => dataFirstYear[month].Desaprobados),
                color: 'rgb(220, 53, 69)'
            },
            {
                name: 'Sin Nota',
                data: Object.keys(dataFirstYear).map(month => dataFirstYear[month].SinNota),
                color: 'rgb(255, 193, 7)'
            }
        ],
        exporting: {
            enabled: true
        }
    });
</script>
@endsection

@extends('layout.plantilla')

@section('title')
Dasboard
@endsection

@section('header')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
  google.charts.load('current', {
    packages: ['corechart', 'bar']
  });
  google.charts.setOnLoadCallback(drawInitialChart);

  function drawInitialChart() {
    // Datos desde Laravel
    const monthlyData = @json($monthlyData);
    const weeklyData = @json($weeklyData1);

    // Preparar datos mensuales para Google Charts
    let monthlyChartData = [
      ['Mes', 'Propuestas', {
        role: 'annotation'
      }]
    ];
    
    if (monthlyData.length === 0) {
      monthlyChartData.push(['Sin registros', 0, '0']);
    } else {
      monthlyData.forEach(item => {
        monthlyChartData.push([item.mes, item.total, item.total.toString()]);
      });
    }

    // Preparar datos semanales para Google Charts
    let weeklyChartData = {};
    Object.keys(weeklyData).forEach(month => {
      weeklyChartData[month] = [
        ['Semana', 'Propuestas', {
          role: 'annotation'
        }]
      ];
      if (weeklyData[month].length === 0) {
        weeklyChartData[month].push(['Sin registros', 0, '0']);
      } else {
        weeklyData[month].forEach(item => {
          weeklyChartData[month].push([`Semana ${item.semana}`, item.total, item.total.toString()]);
        });
      }
    });

    // Crear gráfico mensual
    let data = google.visualization.arrayToDataTable(monthlyChartData);

    let options = {
      backgroundColor: 'transparent',
      colors: ['#FFFFFF'],
      titleTextStyle: {
        color: '#FFFFFF',
        fontSize: 20
      },
      chartArea: {
        width: '90%',
        height: '60%',
        top: 60
      },
      hAxis: {
        title: 'Mes',
        titleTextStyle: {
          color: '#FFFFFF'
        },
        minValue: 0,
        textStyle: {
          color: '#FFFFFF'
        }
      },
      vAxis: {
        title: 'Propuestas',
        titleTextStyle: {
          color: '#FFFFFF'
        },
        textStyle: {
          color: '#FFFFFF'
        },
        format: 'decimal'
      },
      legend: {
        position: 'none'
      },
      animation: {
        startup: true,
        duration: 1000,
        easing: 'out'
      },
      annotations: {
        textStyle: {
          color: '#FFFFFF'
        },
        alwaysOutside: true,
        highContrast: true
      }
    };

    let chart = new google.visualization.ColumnChart(document.getElementById('propuestas'));

    google.visualization.events.addListener(chart, 'select', function() {
      let selectedItem = chart.getSelection()[0];
      if (selectedItem) {
        let month = monthlyChartData[selectedItem.row + 1][0];
        updateChart(weeklyChartData[month], `Semana de ${month}`);
      }
    });

    chart.draw(data, options);
  }

  function updateChart(newData, newTitle) {
    let data = google.visualization.arrayToDataTable(newData);

    let options = {
      backgroundColor: 'transparent',
      colors: ['#FFFFFF'],
      title: newTitle,
      titleTextStyle: {
        color: '#FFFFFF',
        fontSize: 20
      },
      chartArea: {
        width: '90%',
        height: '60%',
        top: 60
      },
      hAxis: {
        title: 'Semana',
        titleTextStyle: {
          color: '#FFFFFF'
        },
        minValue: 0,
        textStyle: {
          color: '#FFFFFF'
        }
      },
      vAxis: {
        title: 'Propuestas',
        titleTextStyle: {
          color: '#FFFFFF'
        },
        textStyle: {
          color: '#FFFFFF'
        },
        format: 'decimal'
      },
      legend: {
        position: 'none'
      },
      animation: {
        startup: true,
        duration: 1000,
        easing: 'out'
      },
      annotations: {
        textStyle: {
          color: '#FFFFFF'
        },
        alwaysOutside: true,
        highContrast: true
      }
    };

    let chart = new google.visualization.ColumnChart(document.getElementById('propuestas'));
    chart.draw(data, options);
  }

  function resetChart() {
    drawInitialChart();
  }
</script>

<script type="text/javascript">
  google.charts.load("current", {
    packages: ["corechart"]
  });
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    // Datos desde Laravel
    const tiposClientes = @json($tiposClientes);

    // Preparar datos para Google Charts
    let data = new google.visualization.DataTable();
    data.addColumn('string', 'Tipo');
    data.addColumn('number', 'kW');

    tiposClientes.forEach(cliente => {
      data.addRow([cliente.tipo, parseFloat(cliente.total_kW)]);
    });

    var options = {
      is3D: true,
      backgroundColor: 'transparent',
      legend: {
        position: 'bottom',
        textStyle: {
          color: '#FFFFFF'
        }
      },
      pieSliceTextStyle: {
        color: '#FFFFFF'
      },
      titleTextStyle: {
        color: '#FFFFFF'
      },
      annotations: {
        textStyle: {
          fontSize: 12,
          color: '#FFFFFF'
        },
        boxStyle: {
          stroke: '#888',
          strokeWidth: 1,
          gradient: {
            color1: '#fbf6a7',
            color2: '#33b679',
            x1: '0%',
            y1: '0%',
            x2: '100%',
            y2: '100%',
            useObjectBoundingBoxUnits: true
          }
        }
      }
    };

    var chart = new google.visualization.PieChart(document.getElementById('tipo_cliente'));

    google.visualization.events.addListener(chart, 'ready', function() {
      var slices = document.getElementById('tipo_cliente').getElementsByTagName('text');
      for (var i = 0; i < slices.length; i++) {
        slices[i].setAttribute('fill', '#FFFFFF');
      }
    });

    chart.draw(data, options);

    window.addEventListener('resize', function() {
      chart.draw(data, options);
    });
  }
</script>

<script type="text/javascript">
  google.charts.load('current', {
    packages: ['corechart', 'line']
  });
  google.charts.setOnLoadCallback(drawInitialLineChart);

  let monthlyLineData = @json($monthlyLineData);
  let weeklyLineData = @json($weeklyLineData);

  function drawInitialLineChart() {
    let data = google.visualization.arrayToDataTable(monthlyLineData);

    let options = {
      backgroundColor: 'transparent',
      hAxis: {
        title: 'Meses',
        textStyle: {
          color: '#FFF'
        },
        titleTextStyle: {
          color: '#FFF'
        },
        baselineColor: '#FFF'
      },
      vAxis: {
        title: 'Clientes',
        textStyle: {
          color: '#FFF'
        },
        titleTextStyle: {
          color: '#FFF'
        },
        baselineColor: '#FFF'
      },
      series: {
        0: {
          curveType: 'function',
          color: '#FFF'
        }
      },
      legend: 'none',
      annotations: {
        textStyle: {
          color: '#FFF'
        },
        alwaysOutside: true,
        highContrast: true
      }
    };

    let chart = new google.visualization.LineChart(document.getElementById('clientes'));

    google.visualization.events.addListener(chart, 'select', function() {
      let selectedItem = chart.getSelection()[0];
      if (selectedItem) {
        let month = monthlyLineData[selectedItem.row + 1][0];
        updateLineChart(weeklyLineData[month], `Semana de ${month}`);
      }
    });

    chart.draw(data, options);
  }

  function updateLineChart(newData, newTitle) {
    let data = google.visualization.arrayToDataTable(newData);

    let options = {
      backgroundColor: 'transparent',
      title: newTitle,
      titleTextStyle: {
        color: '#FFFFFF',
        fontSize: 20
      },
      hAxis: {
        title: 'Semanas',
        textStyle: {
          color: '#FFF'
        },
        titleTextStyle: {
          color: '#FFF'
        },
        baselineColor: '#FFF'
      },
      vAxis: {
        title: 'Clientes',
        textStyle: {
          color: '#FFF'
        },
        titleTextStyle: {
          color: '#FFF'
        },
        baselineColor: '#FFF'
      },
      series: {
        0: {
          curveType: 'function',
          color: '#FFF'
        }
      },
      legend: 'none',
      annotations: {
        textStyle: {
          color: '#FFF'
        },
        alwaysOutside: true,
        highContrast: true
      }
    };

    let chart = new google.visualization.LineChart(document.getElementById('clientes'));
    chart.draw(data, options);
  }

  function resetLineChart() {
    drawInitialLineChart();
  }
</script>

<!-- graficas -->
<style>
  .chart {
    width: 100%;
    height: 0;
    padding-bottom: 56.25%;
    /* Aspect ratio 16:9 */
    position: relative;
  }

  .chart>div {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }
</style>
@endsection

@section('base')
@if(auth()->user()->hasRole('SUPERADMIN') || auth()->user()->hasRole('ADMINISTRADOR'))
@include('dashboard.admin')
@endif

@if(auth()->user()->hasRole('COMERCIAL'))
@include('dashboard.comercial')
@endif

@endsection

@section('scripts')

@endsection
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
        slices[i.setAttribute('fill', '#FFFFFF');
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

@if(auth()->user()->hasRole('TECNICO'))
@include('dashboard.tecnico')
@endif
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chatButton = document.getElementById('chatButton');
        const chatModal = document.getElementById('chatModal');
        const closeChat = document.getElementById('closeChat');
        const chatForm = document.getElementById('chatForm');
        const messageInput = document.getElementById('messageInput');
        const chatMessages = document.getElementById('chatMessages');

        chatButton.addEventListener('click', function () {
            chatModal.style.display = 'flex';
        });

        closeChat.addEventListener('click', function () {
            chatModal.style.display = 'none';
        });

        function appendMessage(content, isPersonal = false) {
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('message');
            if (isPersonal) messageDiv.classList.add('personal');

            const contentDiv = document.createElement('div');
            contentDiv.classList.add('content');
            contentDiv.textContent = content;

            messageDiv.appendChild(contentDiv);
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        async function sendMessage(msg) {
            let botResponded = false;

            const timeout = setTimeout(() => {
                if (!botResponded) {
                    appendMessage('El bot no respondió en el tiempo esperado.', false);
                }
            }, 30000);

            try {
                const response = await fetch('https://energy40.app.n8n.cloud/webhook/chat', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Basic ' + btoa('jhanky:1007795243'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ chatInput: msg })
                });

                if (!response.ok) {
                    throw new Error(`Error en la solicitud: ${response.status} ${response.statusText}`);
                }

                const data = await response.json();

                if (data.reply) {
                    botResponded = true;
                    clearTimeout(timeout);
                    appendMessage(data.reply);
                } else {
                    appendMessage('El bot no envió una respuesta.', false);
                }
            } catch (error) {
                console.error('Error:', error.message);
                appendMessage('Error al enviar el mensaje. Por favor, inténtalo de nuevo.', false);
            }
        }

        chatForm.addEventListener('submit', function (e) {
            e.preventDefault();
            sendUserMessage();
        });

        messageInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendUserMessage();
            }
        });

        function sendUserMessage() {
            const msg = messageInput.value.trim();
            if (!msg) return;

            appendMessage(msg, true);
            messageInput.value = '';
            sendMessage(msg);
        }
    });
</script>

<style>
    .chat-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        background: #248A52;
        color: #fff;
        border: none;
        border-radius: 50%;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        font-size: 24px;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .chat-modal {
        position: fixed;
        bottom: 0;
        right: 20px;
        width: 400px;
        height: 600px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        display: none;
        flex-direction: column;
        z-index: 1000;
    }

    .chat-header {
        background: #248A52;
        color: #fff;
        padding: 15px;
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        border-radius: 10px 10px 0 0;
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 15px;
        background: #f9f9f9;
    }

    .message {
        margin-bottom: 15px;
        display: flex;
        align-items: flex-end;
    }

    .message.personal {
        justify-content: flex-end;
    }

    .message .content {
        max-width: 70%;
        padding: 10px 15px;
        border-radius: 10px;
        font-size: 14px;
    }

    .message.personal .content {
        background: #248A52;
        color: #fff;
        border-radius: 10px 10px 0 10px;
    }

    .message .content {
        background: #e0e0e0;
        color: #000;
        border-radius: 10px 10px 10px 0;
    }

    .chat-input {
        display: flex;
        padding: 15px;
        background: #fff;
        border-top: 1px solid #ddd;
        border-radius: 0 0 10px 10px;
    }

    .chat-input textarea {
        flex: 1;
        resize: none;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        font-size: 14px;
        outline: none;
    }

    .chat-input button {
        margin-left: 10px;
        background: #248A52;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    .chat-input button:hover {
        background: #1d6f43;
    }
</style>

<!-- Botón flotante del chat -->
<button class="chat-button" id="chatButton">
    <img src="{{ asset('img/icons/Agent.svg') }}" alt="Chat Bot" style="width: 30px; height: 30px;">
</button>

<!-- Modal del chat -->
<div class="chat-modal" id="chatModal">
    <div class="chat-header">
        <img src="{{ asset('img/icons/Agent.svg') }}" alt="Chat Bot" style="width: 24px; height: 24px; margin-right: 10px;"> Agent IA
        <button style="float: right; background: none; border: none; color: #fff; font-size: 18px; cursor: pointer;" id="closeChat">&times;</button>
    </div>
    <div class="chat-messages" id="chatMessages"></div>
    <form class="chat-input" id="chatForm">
        <textarea id="messageInput" placeholder="Escribe un mensaje..." rows="1"></textarea>
        <button type="submit">Enviar</button>
    </form>
</div>
@endsection
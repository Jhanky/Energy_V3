<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Documento</title>
    <style>
        /* Estilo para el encabezado */
        #header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100px;
            /* Altura del membrete */
            background-image: url('img/membrete.png');
            /* URL de la imagen del membrete */
            background-size: contain;
            /* Ajustar el tamaño de la imagen para que se ajuste al contenedor */
            background-repeat: no-repeat;
            /* No repetir la imagen */
            background-position: center top;
            /* Posición de la imagen */
            text-align: center;
            padding: 10px;
        }

        #footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            padding: 5px;
        }

        #footer img {
            max-width: 1500px;
            /* Ajusta el ancho máximo de la imagen según tus necesidades */
            max-height: 60px;
            /* Ajusta la altura máxima de la imagen según tus necesidades */
            vertical-align: middle;
            /* Alinea la imagen verticalmente en el centro del pie de página */
            margin-right: 0px;
            /* Espaciado a la derecha de la imagen */
        }

        /* Estilo para las páginas */
        .pagina {
            page-break-after: always;
            /* Forzar salto de página después de cada .pagina */
            margin-top: 100px;
            /* Espacio para el membrete */
        }

        /* Estilo para las páginas excepto la primera */
        .pagina:not(:first-of-type) {
            margin-top: 0;
            /* Eliminar espacio para el membrete en las páginas siguientes */
        }

        /* Estilo para el contenido de cada página */
        .contenido {
            padding: 20px;
            /* Añadir relleno para el contenido */
        }

        /* Estilo para los párrafos */
        p {
            font-family: Calibri, sans-serif;
            /* Cambio de la fuente a Calibri */
            font-size: 11pt;
            /* Tamaño de fuente 10 */
            text-align: justify;
            /* Justificar el texto */
        }

        /* Estilo para todas las celdas */
        td,
        th {
            border: 1px solid #000000;
            padding: 10px;
            text-align: left;
        }

        /* Estilo para las celdas con clase "fondo" */
        td.fondo,
        th.fondo {
            background-color: #c1dfb4;
            /* Color de fondo verde más claro (#eaf7d8) */
        }
    </style>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
</head>

<body>
    <div class="pagina">
        <div id="header"></div>
        <div class="contenido">
            <div>
                <label class="negrita">
                    {{ $results->first()->ciudad }}, {{ Carbon\Carbon::now()->translatedFormat('F j \d\e Y') }}
                </label><br>
                <label class="negrita"><b>{{ $results->first()->nombre }}</b></label> <br>
                <label class="negrita"><b>E.S.M</b></label><br>
            </div>
            <br><br>
            <div style="text-align: right;">
                <label class="negrita"><b>Ref.:</b></label>
                <label class="negrita">{{ $results->first()->codigo_propuesta }}</label><br>
            </div>

            <p>Cordial saludo,</p> <br><br>

            <p>Agradecemos de antemano su amabilidad y el interés en recibir nuestra propuesta técnico-económica para el proyecto de autogeneración de energía a través de paneles solares fotovoltaicos.</p>
            <p>Esta propuesta está diseñada para que usted conozca los detalles de la capacidad de producción de energía de la planta fotovoltaica y el ahorro estimado que esta generaría bajo las condiciones meteorológicas estándar, teniendo como base la tarifa actual para {{ $results->first()->nombre }} del proyecto <b>{{ $results->first()->nombre_proyecto }}</b> en {{ $results->first()->ciudad }}, {{ $results->first()->departamento }}.</p>
            <p>A través de esta propuesta ponemos a su consideración nuestros servicios, esperando que esta satisfaga sus expectativas, necesidades e intereses. Estamos atentos a las inquietudes que se generen a partir de esta propuesta.<br>
                Agradecemos su amable atención y estaremos atentos a sus comentarios.</p> <br><br>

            <p>Cordialmente, <br>
                Tomás Mojica<br>
                Gerente Comercial<br>
                Energy 4.0</p>

        </div>
        <div id="footer">
            <img src="img/pie.png" alt="Imagen de pie de página">
        </div>
    </div>

    <div class="pagina">
        <div id="header"></div>
        <div class="contenido">
            <div class="indice">
                <h1 style="text-align: center;">Índice</h1>
                <p><b>1. Análisis económico del proyecto</b>....................................................................................................3</p>
                <p style="margin-left: 20px;">1.1. Ahorros generados planta solar fotovoltaica...............................................................................3</p>
                <p style="margin-left: 20px;">1.2. Análisis económico tarifas de energía región caribe...................................................................4</p>
                <p style="margin-left: 20px;">1.3. Degradación anual planta solar..................................................................................................5</p>
                <p style="margin-left: 20px;">1.4. Proyección ahorros planta solar fotovoltaica 25 años.................................................................6</p>
                <p><b>2. Análisis técnico del proyecto solar fotovoltaico</b>...........................................................................7</p>
                <p style="margin-left: 20px;">2.1. Materiales y equipos proyecto fotovoltaico.................................................................................7</p>
                <p style="margin-left: 20px;">2.2. Diseño Preliminar de la planta fotovoltaica.................................................................................8</p>
                <p><b>3. Valor de la inversión</b>.........................................................................................................................9</p>
                <p style="margin-left: 20px;">3.1. Retorno de la inversión...............................................................................................................9</p>
                <p style="margin-left: 20px;">3.2. Forma de pago..........................................................................................................................10</p>
            </div>
        </div>
        <div id="footer" style="position: fixed; bottom: 0; right: 0;">
            <img src="img/pie.png" alt="Imagen de pie de página">
        </div>
    </div>

    <div class="pagina">
        <div id="header"></div>
        <div class="contenido">
            <div id="analisis-economico">
                <h3>1. Análisis económico del proyecto</h3>
                <h4><b> 1.1. Ahorros generados planta solar fotovoltaica</b></h4>
                <p>Tomando como referencia el análisis de generación de la planta fotovoltaica, nuestro equipo ha diseñado una propuesta técnica-económica que le permitirá generar un ahorro equivalente a <b>${{ number_format($ahorro, 0, ',', '.') }}</b> ({{ $ahorro_letra }}) mensuales en su factura de energía en {{ $results->first()->ciudad }}, {{ $results->first()->departamento }}. Bajo una tarifa de <b>${{ $results->first()->tarifa }}.</b></p>
                <p>Bajo estas condiciones, calculamos e identificamos la oportunidad de instalar una planta fotovoltaica conectada a la red con una capacidad instalada de <b>{{ number_format($results->first()->sugerida, 2, ',', '.') }}kWp.</b></p>

                <br><br><br>
                <div style="text-align: center;">
                    <img src="{{ $grafica_3 }}" alt="Imagen de pie de página" style="max-width: 700px; max-height: 450px;">
                </div>
                <div style="text-align: center;">
                    <p style="text-align: center; font-size: 9pt;">Grafica 1. Genarcion fotovoltaica de {{ number_format($results->first()->sugerida, 2, ',', '.') }}kWp en {{ $results->first()->ciudad }}.</p>
                </div>

            </div>
        </div>
        <div id="footer">
            <img src="img/pie.png" alt="Imagen de pie de página">
        </div>
    </div>

    <div class="pagina">
        <div id="header"></div>
        <div class="contenido">
            <p>En la <b>Gráfica 1</b>, se visualiza el estimado de generación de energía promedio mensual de enero a diciembre de una instalación <b>conectada a la red de {{ number_format($results->first()->sugerida, 2, ',', '.') }}kW</b>. En esta se identifica que los meses de enero a marzo y el diciembre son los de mayor generación, con una energía promedio mensual de <b>{{ number_format($promedio, 0, ',', '.') }}kWh</b>, lo que generaría anualmente un estimado de <b>{{ number_format($anual, 0, ',', '.') }}kWh</b>.</b></p>
            <h4><b> 1.2. Análisis económico tarifas de energía región caribe</b></h4>

            <p>En la siguiente grafica se visualiza la variación de las tarifas de energía en la ciudad de Barranquilla desde junio de 2019 a la fecha. Lo cual representa una <b>variación del 108,52%</b> en este periodo.</p>
            <br><br><br>
            <div style="text-align: center;">
                <img src="{{ $tarifa }}" alt="tarifa de luz" style="max-width: 620px; max-height: 450px;">

            </div>
            <div style="text-align: center;">
                <p style="text-align: center; font-size: 9pt;">Grafica 2. Variación de la tarifa región caribe.</p>
            </div>

        </div>
        <div id="footer">
            <img src="img/pie.png" alt="Imagen de pie de página">
        </div>
    </div>

    <div class="pagina">
        <div id="header"></div>
        <div class="contenido">
            <h4><b> 1.3. Degradación anual planta solar</b></h4>
            <p>Las plantas solares fotovoltaica sufren una degradación anual, disminuyendo así su producción de energía. Esta es de un 2% en el primer año y posteriormente de un 0.5% como se visualiza en la gráfica a continuación.</p>
            <!-- Agui va una grafica -->
            <br><br><br>
            <div style="text-align: center;">
                <img src="{{ $grafica_2 }}" alt="Imagen de pie de página" style="max-width: 700px; max-height: 450px;">
            </div>
            <div style="text-align: center;">
                <p style="text-align: center; font-size: 9pt;">Grafica 3. Energía generada vs degradación planta fotovoltaica {{ number_format($results->first()->sugerida, 2, ',', '.') }}kWp.</p>
            </div>
        </div>
        <div id="footer">
            <img src="img/pie.png" alt="Imagen de pie de página">
        </div>
    </div>

    <div class="pagina">
        <div id="header"></div>
        <div class="contenido">
            <h4><b> 1.4. Proyección ahorros planta solar fotovoltaica 25 años</b></h4>
            <p>La vida útil de una planta solar fotovoltaica es de 25 a 30 años en condiciones adecuadas y estándares de funcionamiento, esto garantiza la rentabilidad de la inversión realizada y la maximización de ingresos en ahorros anuales de energía. En la siguiente grafica se presenta el desplazamiento de los costos anuales de energía por autogeneración con energía solar para una planta de <b>{{ number_format($results->first()->sugerida, 2, ',', '.') }}kWp.</b></p>
            <!-- Agui va una grafica -->
            <br><br><br>
            <div style="text-align: center;">

                <img src="{{ $grafica_1 }}" alt="Imagen de pie de página" style="max-width: 700px; max-height: 450px;">
            </div>
            <div style="text-align: center;">
                <p style="text-align: center; font-size: 9pt;">Gráfica 4. Costo de la energía desplazada anualmente, planta fotovoltaica de {{ number_format($results->first()->sugerida, 2, ',', '.') }}kWp.</p>
            </div>
        </div>
        <div id="footer">
            <img src="img/pie.png" alt="Imagen de pie de página">
        </div>
    </div>

    <div class="pagina">
        <div id="header"></div>
        <div class="contenido">
            <h3>2. Análisis técnico del proyecto solar fotovoltaico</h3>

            <h4><b> 2.1. Equipos principales del sistema fotovoltaico</b></h4>

            <p>El proyecto fotovoltaico incluye los siguientes equipos y trámites administrativos.</p>
            <div class="table-responsive">
                <table id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-success border-success">
                        <tr>
                            <th class="fondo negrita"><b>Equipo</b></th>
                            <th class="fondo negrita"><b>Características</b></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>{{ number_format($results->first()->numero_inversores, 0, ',', '.') }} @if($results->first()->numero_inversores < 2) Inversor @endif @if($results->first()->numero_inversores > 1) Inversores @endif {{$results->first()->investor_marca}} {{$results->first()->tipo_sistema}} de {{$results->first()->poder_investor}}kW</td>
                            <td>Este inversor permite convertir la energía que viene de los paneles solares en energía que utilizamos en la cotidianidad. Este inversor no opera en situaciones donde no hay suministro de energía de la red.</td>
                        </tr>
                        @if($results->first()->id_bateria != 1)
                        <tr>
                            <td>{{ number_format($results->first()->numero_baterias, 0, ',', '.') }} @if($results->first()->numero_baterias < 2) Batería @endif @if($results->first()->numero_baterias > 1) Baterías @endif {{$results->first()->batterie_marca}} de {{$results->first()->tipo}} con capacidad de {{$results->first()->amperios_hora}}Ah {{$results->first()->voltaje}}V</td>
                            <td>@if($results->first()->numero_baterias < 2) Batería @endif @if($results->first()->numero_baterias > 1) Baterías @endif de {{$results->first()->tipo}} de {{$results->first()->amperios_hora}}Ah, conforman el banco de baterías, las cuales brindaran autonomía @if($results->first()->numero_inversores < 2)al inversor @endif @if($results->first()->numero_inversores > 1)a los inversores @endif {{$results->first()->investor_marca}} en el momento que no haya energía de la red.</td>
                        </tr>
                        @endif

                        <tr>
                            <td>{{ number_format($results->first()->numero_paneles, 0, ',', '.') }} Paneles solares {{$results->first()->solar_panel_marca}} {{$results->first()->modelo}} con capacidad de {{ number_format($results->first()->poder, 0, ',', '.') }}W</td>
                            <td>Paneles solares de alta calidad y mayor durabilidad, con respaldo nacional e internacional, captan la energía del sol generando energía directa.</td>
                        </tr>

                        <tr>
                            <td>Sistemas de protección DC y AC</td>
                            <td>Protege al sistema fotovoltaico de sobretensiones y daños a inversores o equipos de la planta fotovoltaica.</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div id="footer">
            <img src="img/pie.png" alt="Imagen de pie de página">
        </div>
    </div>

    <div class="pagina">
        <div id="header"></div>
        <div class="contenido">

            <h4><b> 2.1.1 Mano de obra, materiales eléctricos y trámites administrativos</b></h4>
            <!-- Agui va una grafica -->
            <table id="dataTable" width="100%" cellspacing="0">
                <thead class="table-success border-success">
                    <tr>
                        <th class="fondo negrita"><b>Equipo</b></th>
                        <th class="fondo negrita"><b>Características</b></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Mano de obra y material eléctrico</td>
                        <td>Material eléctrico de alta calidad para el montaje y funcionamiento de la planta fotovoltaica, mano de obra calificada en el montaje y energización de sistemas fotovoltaicos.</td>
                    </tr>
                    <tr>
                        <td>Estudio de conexión ante el operador de red local y cambio de medidor convencional a medidor bidireccional (venta de excedentes)</td>
                        <td>Trámites administrativos ante el operador de red para la legalización de la planta fotovoltaica y el respectivo cambio de medidor, con el fin de que el cliente pueda vender sus excedentes a la red (en caso de que la producción de la planta fotovoltaica sea mayor al consumo del cliente).</td>
                    </tr>
                </tbody>
            </table>
            <p style="font-size: 10pt;"><b>NOTA 1:</b> Las lecturas de consumo serán responsabilidad del operador de red como también la instalación del medidor bidireccional. La empresa hará el acompañamiento en la realización de los tramites respectivos ante el operador de red.</p>
            <p style="font-size: 10pt;"><b>NOTA 2:</b> En la propuesta se incluye el valor de la estructura de soporte de paneles solares, en el caso de en qué el cliente opte por hacer el montaje en una sobre estructura esta tendrá un costo adicional.</p>
        </div>
        <div id="footer">
            <img src="img/pie.png" alt="Imagen de pie de página">
        </div>
    </div>
    <div class="pagina">
        <div id="header"></div>
        <div class="contenido">
            <h4><b> 2.2. Diseño Preliminar de la planta fotovoltaica</b></h4>
            <p>Después de obtener los resultados del vuelo fotogramétrico sobre el lugar donde se instalará la planta fotovoltaica, diseñamos preliminarmente un área conforme a la disponibilidad de espacio para una planta solar fotovoltaica de <b>{{ number_format($results->first()->sugerida, 2, ',', '.') }}kWp</b>. Las áreas demarcadas en azul representan los paneles solares que se instalarán para la generación de energía.</p>
            <br><br><br>
            <div style="text-align: center;">

                <img src="{{ $design_5 }}" alt="Imagen de pie de página" style="max-width: 620px; max-height: 450px;">
            </div>
            <div style="text-align: center;">
                <p style="text-align: center; font-size: 9pt;">Gráfica 5. Diseño preliminar sistema fotovoltaico de {{ number_format($results->first()->sugerida, 2, ',', '.') }}kWp {{ $results->first()->nombre }} - {{ $results->first()->ciudad }}, {{ $results->first()->departamento }}.</p>
            </div>
        </div>
        <div id="footer">
            <img src="img/pie.png" alt="Imagen de pie de página">
        </div>
    </div>

    <div class="pagina">
        <div id="header"></div>
        <div class="contenido">
            <h3>3.Valor de la inversión</h3>
            <p>La inversión para este sistema fotovoltaico de <b>{{ number_format($results->first()->sugerida, 2, ',', '.') }}kWp {{ $results->first()->tipo_sistema }}</b> es de <b>${{ number_format($results->first()->TOTAL_PROYECTO, 0, ',', '.') }}</b> ({{ $presupuesto_letra }}, mcte) (Paneles solares, inversores se encuentran exentos de IVA a partir circular UPME del 4 de junio 2019), este valor incluye (estudio de conexión ante el operador de red, materiales y equipos, instalación y puesta en marcha de la planta fotovoltaica, certificado RETIE de la planta fotovoltaica y solicitud de medidor bidireccional ante el operador de red), pólizas de cumplimiento y de manejo de anticipo.</p>
            <h4><b> 3.1. Retorno de la inversión</b></h4>
            <p>En la siguiente gráfica, se visualiza el flujo de caja del proyecto en los primeros cinco años. En el año uno, se tiene el valor de la inversión y un saldo por recuperar de <b>${{ number_format($retorno1, 0, ',', '.') }}</b>, calculado a partir del valor de la inversión menos el ahorro generado en el primer año de funcionamiento de la planta. En el año {{ $year }}, se ha retornado el 100% de la inversión, generando ingresos adicionales de <b>${{ number_format($valor_year, 0, ',', '.') }}</b>. En los años siguientes, el flujo es positivo y ascendente, con incrementos anuales de un 10% en las tarifas de energía por año. Finalizado el quinto año de funcionamiento de la planta solar fotovoltaica, generará ingresos estimados por <b>${{ number_format($year_5, 0, ',', '.') }}</b>, mcte ({{ $year_letras }}, mcte).</p>


            <div style="text-align: center;">
                <img src="{{ $grafica_4 }}" alt="Imagen de pie de página" style="max-width: 500px; max-height: 400px;">
            </div>
            <div style="text-align: center;">
                <p style="text-align: center; font-size: 9pt;">Gráfica 6. Retorno de la inversión sistema fotovoltaico de {{ number_format($results->first()->sugerida, 2, ',', '.') }}kWp {{ $results->first()->nombre }} - {{ $results->first()->ciudad }}, {{ $results->first()->departamento }}.</p>
            </div>

        </div>
        <div id="footer">
            <img src="img/pie.png" alt="Imagen de pie de página">
        </div>
    </div>

    <div class="pagina">
        <div id="header"></div>
        <div class="contenido">
            <h4><b> 3.1. Forma de pago</b></h4>
            <p>El 35%, del valor total del proyecto con la firma del presente contrato.</p>
            <p>El 35%, del valor total del proyecto con la disposición de paneles solares y estructura para el sistema fotovoltaico.</p>
            <p>El 30 %, del valor total del proyecto con la puesta en marcha del sistema fotovoltaico.</p>
            <br>
            <p>Nota 1: El valor de esta oferta está calculado con una TRM máxima de $4200 y los valores aquí detallados pueden variar si esta se encuentra más allá de este límite máximo.</p>
            <p>-----------------------------------------------------Fin de la propuesta ----------------------------------------------------</p>
        </div>
        <div id="footer">
            <img src="img/pie.png" alt="Imagen de pie de página">
        </div>
    </div>
</body>

</html>
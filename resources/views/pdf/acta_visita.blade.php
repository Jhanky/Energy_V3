<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documento</title>
    <style>
        #header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background-image: url('img/membrete.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center top;
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
            max-height: 60px;
            vertical-align: middle;
            margin-right: 0px;
        }

        .pagina {
            page-break-after: always;
            margin-top: 100px;
        }

        .pagina:not(:first-of-type) {
            margin-top: 0;
        }

        .contenido {
            padding: 20px;
        }

        p {
            font-family: Calibri, sans-serif;
            font-size: 11pt;
            text-align: justify;
        }

        td,
        th {
            border: 1px solid #000000;
            padding: 10px;
            text-align: left;
        }

        td.fondo,
        th.fondo {
            background-color: #c1dfb4;
        }

        .imagenes-sitio img {
            margin: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .imagenes-sitio {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
    </style>
</head>

<body>
    <div class="pagina">
        <div id="header"></div>
        <div class="contenido">
            <div>
                <label class="negrita">
                    {{ $visita->ciudad }}, {{ Carbon\Carbon::now()->translatedFormat('F j \d\e Y') }}
                </label><br>
                <label class="negrita"><b>{{ $visita->nombre }}</b></label> <br>
                <label class="negrita"><b>E.S.M</b></label><br>
            </div>
            <br><br>
            <div style="text-align: right;">
                <label class="negrita">Ref.: Acta de Visita Técnica - {{ $visita->nombre }} </label><br>

                <p>Cordial saludo,</p> <br><br>

                <p>En el marco del desarrollo de su interés en la implementación de un sistema fotovoltaico, hemos
                    realizado una visita técnica a la dirección proporcionada para evaluar las condiciones actuales del
                    sitio. Esta visita tiene como objetivo identificar las características técnicas necesarias para
                    garantizar el diseño y la instalación óptima de la planta solar.</p>
                <p>Durante la visita se han recopilado los siguientes datos:</p>
                <p>A través de esta propuesta ponemos a su consideración nuestros servicios, esperando que esta
                    satisfaga sus expectativas, necesidades e intereses. Estamos atentos a las inquietudes que se
                    generen a partir de esta propuesta.<br>
                    Agradecemos su amable atención y estaremos atentos a sus comentarios.</p> <br>
                <p>Asimismo, se verificó el tipo de medidor actual y el sistema de medición, lo cual se detalla en el
                    informe anexo.</p>
                <p>Este documento resume los hallazgos y observaciones realizadas durante la visita, sirviendo como base
                    para el diseño técnico y la propuesta económico-comercial que será enviada posteriormente.</p>
                <p>Estamos atentos a resolver cualquier inquietud o duda que pueda surgir de la información aquí
                    registrada.</p>
                <br>

            </div>
            <div id="footer">
                <img src="img/pie.png" alt="Imagen de pie de página">
            </div>
        </div>
    </div>

    <div class="pagina">
        <div id="header"></div>
        <div class="contenido">
            <h3>1. Información del cliente</h3>
            <div class="table-responsive">
                <table id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-success border-success">
                    </thead>
                    <tbody>

                        <tr>
                            <td class="fondo negrita">Nombre completo</td>
                            <td>{{ $visita->nombre }}</td>
                        </tr>

                        <tr>
                            <td class="fondo negrita">NIC</td>
                            <td>{{ $visita->NIC }}</td>
                        </tr>

                        <tr>
                            <td class="fondo negrita">Ubicación</td>
                            <td>La visita se realizó en la siguiente dirección {{ $visita->direccion }} en
                                {{ $visita->ciudad }}, {{ $visita->departamento }}</td>
                        </tr>
                        <tr>
                            <td class="fondo negrita">Teléfono</td>
                            <td>{{ $visita->telefono }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <h3>2. Área Disponible para Instalación de Paneles</h3>
            @php
                $area = $visita->ancho * $visita->largo;
            @endphp
            <p>
                El área disponible para la instalación de paneles solares es de <b>{{ $area }} m&sup2;</b>, distribuida en
                dimensiones de
                {{ $visita->ancho }}  m x {{ $visita->largo }}  m. La superficie es de loza. A continuación, se adjuntan imágenes que ilustran las
                condiciones del sitio:
            </p>
            <br>
            <br>
            <div class="imagenes-sitio">
                @foreach ($fotos as $foto)
                    @if ($foto->tipo == 'instalacion')
                        <img src="{{ public_path($foto->ruta) }}" alt="Imagen de la instalación" width="305" height="200">
                    @endif
                @endforeach
            </div>
            <p>
                Además de la medición del área, se realizó una inspección de los soportes del tejado para evaluar si
                es necesario
                implementar refuerzos({{ $visita->refuerzo }}) o una sobreestructura adicional({{ $visita->sobre_estructura }}).
            </p>

        </div>
        <div id="footer">
            <img src="img/pie.png" alt="Imagen de pie de página">
        </div>
    </div>

    <div class="pagina">
        <div id="header"></div>
        <div class="contenido">
            <h3>3. Puntos de bajantes y distancia al inversor</h3>
            <p>El lugar de bajante será por Lugar y la distancia del recorrido es de x metros aproximadamente</p>

            <div class="imagenes-sitio">
                @foreach ($fotos as $foto)
                    @if ($foto->tipo == 'instalacion')
                        <img src="{{ public_path($foto->ruta) }}" alt="Imagen de la instalación" width="600" height="355">
                    @endif
                @endforeach
            </div>
            <p style="font-size: 10pt;">
                <b>Observaciones:</b> Las lecturas de consumo serán responsabilidad del operador de red, al igual
                que la instalación
                del medidor bidireccional. La empresa brindará acompañamiento en la gestión de los trámites
                correspondientes ante el
                operador de red.
            </p>
        </div>
        <div id="footer">
            <img src="img/pie.png" alt="Imagen de pie de página">
        </div>
    </div>

    <div class="pagina">
        <div id="header"></div>
        <div class="contenido">
            <h3>Distancia del Tablero Fotovoltaico al Tablero Principal</h3>
            <p>
                La distancia aproximada desde el tablero fotovoltaico al tablero principal es de <b>x metros</b>.
            </p>

            <h3>Área para la Instalación del Inversor</h3>
            <p>
                El lugar seleccionado para la instalación del inversor será <b>especificar lugar aquí</b>.
                Este lugar cumple con las condiciones mínimas requeridas para la instalación segura y eficiente.
            </p>

            <h3>Fotografía del Área de Instalación</h3>
            <div class="imagenes-sitio">
                @foreach ($fotos as $foto)
                    @if ($foto->tipo == 'instalacion')
                        <img src="{{ public_path($foto->ruta) }}" alt="Fotografía del lugar de instalación" width="600" height="355">
                    @endif
                @endforeach
            </div>

            <h3>Observaciones</h3>
            <p>
                Las lecturas de consumo serán responsabilidad del operador de red, al igual que la instalación del
                medidor bidireccional.
                La empresa brindará acompañamiento en la gestión de los trámites correspondientes ante el operador de
                red.
            </p>
        </div>
        <div id="footer">
            <img src="img/pie.png" alt="Pie de página">
        </div>
    </div>

    <div class="pagina">
        <div id="header"></div>
        <div class="contenido">

            <h4>Revisión del Tablero Existente</h4>
            <table width="100%" cellspacing="0" style="border-collapse: collapse; margin-bottom: 20px;">
                <tbody>
                    <tr>
                        <td class="fondo negrita">Tipo de Red</td>
                        <td>{{ $visita->tipo_red }}</td>
                    </tr>
                    <tr>
                        <td class="fondo negrita">Espacio para los breakers</td>
                        <td>{{ $visita->espacio_breaker }}</td>
                    </tr>
                    <tr>
                        <td class="fondo negrita">Espacio para el breaker de inyección solar</td>
                        <td>{{ $visita->espacio_ct }}</td>
                    </tr>
                    <tr>
                        <td class="fondo negrita">Cuenta con puesta a tierra</td>
                        <td>{{ $visita->spt }}</td>
                    </tr>
                    <tr>
                        <td class="fondo negrita">Cuenta con neutro</td>
                        <td>{{ $visita->neutro }}</td>
                    </tr>
                    <tr>
                        <td class="fondo negrita">Calibre de Cable de fase</td>
                        <td>{{ $visita->calibre_cable }} AWG</td>
                    </tr>
                    <tr>
                        <td class="fondo negrita">Calibre de Cable de tierra</td>
                        <td>{{ $visita->largo }} AWG</td>
                    </tr>
                    <tr>
                        <td class="fondo negrita">Totalizador (Capacidad en Amperios)</td>
                        <td>{{ $visita->totalizador }} A</td>
                    </tr>
                    <tr>
                        <td class="fondo negrita">Tipo de medidor</td>
                        <td>{{ $visita->tipo_medidor }} A</td>
                    </tr>
                    <tr>
                        <td class="fondo negrita">Tipo de medicion</td>
                        <td>{{ $visita->tipo_medicion }} A</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="footer">
            <img src="img/pie.png" alt="Pie de página">
        </div>
    </div>
</body>

</html>

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
                <label class="negrita">xxx, {{ Carbon\Carbon::now()->translatedFormat('F j \d\e Y') }}</label><br>
                <label class="negrita"><b>xx</b></label><br>
                <label class="negrita"><b>E.S.M</b></label><br>
            </div>
            <br><br>
            <div style="text-align: right;">
                <label class="negrita">Ref.: Acta de Visita Técnica - Proyecto Fotovoltaico</label><br>
            </div>

            <p>Cordial saludo,</p> <br><br>
            <p>En el marco del desarrollo de su interés en la implementación de un sistema fotovoltaico, hemos realizado una visita técnica a la dirección proporcionada para evaluar las condiciones actuales del sitio. Esta visita tiene como objetivo identificar las características técnicas necesarias para garantizar el diseño y la instalación óptima de la planta solar.</p>
            <p>Durante la visita se han recopilado los siguientes datos:</p>
            <p>A través de esta propuesta ponemos a su consideración nuestros servicios, esperando que esta satisfaga sus expectativas, necesidades e intereses. Estamos atentos a las inquietudes que se generen a partir de esta propuesta.<br>
                Agradecemos su amable atención y estaremos atentos a sus comentarios.</p><br>
            <p>Asimismo, se verificó el tipo de medidor actual y el sistema de medición, lo cual se detalla en el informe anexo.</p>
            <p>Este documento resume los hallazgos y observaciones realizadas durante la visita, sirviendo como base para el diseño técnico y la propuesta económico-comercial que será enviada posteriormente.</p>
            <p>Estamos atentos a resolver cualquier inquietud o duda que pueda surgir de la información aquí registrada.</p>    
                <br>

        </div>
        <div id="footer">
            <img src="img/pie.png" alt="Imagen de pie de página">
        </div>
    </div>

</body>

</html>      
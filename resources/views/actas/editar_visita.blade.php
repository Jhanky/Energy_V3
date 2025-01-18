<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
    <link rel="shortcut icon" href="https://mlstplyh0ixw.i.optimole.com/w:1236/h:834/q:mauto/ig:avif/f:best/https://www.energy4cero.com/wp-content/uploads/2021/02/ENERGY4.0.png" type="image/x-icon">
    <title>
        Formulario
    </title>

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('css/material-dashboard.css') }}" rel="stylesheet" />
    <style>
        .img-thumbnail {
            width: 120px;
            height: 80px;
            object-fit: cover;
            margin: 5px;
        }

        .qq-upload-list {
            list-style-type: none;
            padding: 0;
        }

        .qq-upload-list li {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .qq-upload-img-container {
            margin-right: 10px;
        }

        .qq-upload-delete {
            margin-left: auto;
            cursor: pointer;
            color: red;
        }
    </style>
</head>

<body class="g-sidenav-show  bg-gray-200">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-white text-capitalize ps-3 mb-0">Formulario de recopilación de información</h6>
                            </div>
                        </div>
                        <div class="card">
                            <div class="container">
                                <form>
                                    <div class="row">
                                        <br>
                                        <span>Datos Basicos</span>
                                        <div class="col-md-6">
                                            <div class="input-group input-group-outline my-3">
                                                <label class="form-label">Nombre completo</label>
                                                <input type="email" class="form-control">
                                            </div>
                                            <div class="input-group input-group-outline my-3">
                                                <label class="form-label">NIC</label>
                                                <input type="number" class="form-control">
                                            </div>
                                            <div class="input-group input-group-outline my-3">
                                                <label class="form-label">Teléfono</label>
                                                <input type="number" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group input-group-outline my-3">
                                                <select id="selectDepartamentos" name="departamento" class="form-control" required onchange="filtrarCiudades()">
                                                    <option disabled selected>Departamento</option>
                                                    @foreach ($departamentos as $depa)
                                                    <option value="{{ $depa->departamento }}" data-departamento="{{$depa->departamento}}">
                                                        {{ $depa->departamento}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input-group input-group-outline my-3">
                                                <select id="selectCiudades" name="ciudad" class="form-control" required>
                                                    <option disabled selected>Ciudad</option>
                                                    @foreach ($ciudades as $ciudad)
                                                    <option value="{{ $ciudad->municipio }}" data-departamento="{{$ciudad->departamento}}">
                                                        {{ $ciudad->municipio}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input-group input-group-outline my-3">
                                                <label class="form-label">Direccion</label>
                                                <input type="email" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <span>Área disponible para instalación de paneles</span>
                                        <div class="col col-lg-6">
                                            <div class="input-group input-group-outline my-3">
                                                <label class="form-label">Ancho</label>
                                                <input type="number" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col col-lg-6">
                                            <div class="input-group input-group-outline my-3">
                                                <label class="form-label">Largo</label>
                                                <input type="number" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-outline my-3">
                                                <select class="form-control" id="exampleFormControlSelect1">
                                                    <option disabled selected>Tipo de superficie</option>
                                                    <option>Loza</option>
                                                    <option>Teja</option>
                                                    <option>Lamina</option>
                                                </select>
                                            </div>
                                            <div class="input-group input-group-outline my-3">
                                                <label class="form-label">Notas y Observaciones</label>
                                                <textarea class="form-control" rows="4"></textarea>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col text-center">
                                            <div class="input-group input-group-outline my-3 justify-content-center">
                                                <label class="btn btn-primary" for="formFile">Seleccionar fotos de dron</label>
                                                <input class="form-control d-none" type="file" id="formFile" multiple>
                                            </div>
                                            <p id="fileName"></p>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <ul id="imageList" class="qq-upload-list" aria-label="Uploaded files"></ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <span>Revision de soporte del tejado</span>
                                        <div class="col ">
                                            <div class="input-group input-group-outline my-3">
                                                <label class="form-label">Notas y Observaciones</label>
                                                <textarea class="form-control" rows="4"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-6">
                                                <div class="form-check mb-3">
                                                    <label for="customRadio1">¿Necesita refuerzo?</label> <br>
                                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="customRadio1">
                                                    <label class="custom-control-label" for="customRadio1">SI</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="customRadio2">
                                                    <label class="custom-control-label" for="customRadio2">NO</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-check mb-3">
                                                    <label for="customRadio1">¿Necesita sobre estructura?</label> <br>
                                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="customRadio1">
                                                    <label class="custom-control-label" for="customRadio1">SI</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="customRadio2">
                                                    <label class="custom-control-label" for="customRadio2">NO</label>
                                                </div>
                                                
                                            </div>
                                    </div>

                                    <div class="row">
                                        <div class="col text-center">
                                            <div class="input-group input-group-outline my-3 justify-content-center">
                                                <label class="btn btn-primary" for="formFile">Adjuntar fotos de soportes</label>
                                                <input class="form-control d-none" type="file" id="formFile" multiple>
                                            </div>
                                            <p id="fileName"></p>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <ul id="imageList" class="qq-upload-list" aria-label="Uploaded files"></ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <span>Puntos de bajantes y distancias al inversor</span>
                                        <div class="col col-lg-8">
                                            <div class="input-group input-group-outline my-3">
                                                <label class="form-label">Opción 1</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col col-lg-4">
                                            <div class="input-group input-group-outline my-3">
                                                <label class="form-label">Distancia</label>
                                                <input type="number" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col col-lg-8">
                                            <div class="input-group input-group-outline my-3">
                                                <label class="form-label">Opción 2</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col col-lg-4">
                                            <div class="input-group input-group-outline my-3">
                                                <label class="form-label">Distancia</label>
                                                <input type="number" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col col-lg-8">
                                            <div class="input-group input-group-outline my-3">
                                                <label class="form-label">Opción 3</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col col-lg-4">
                                            <div class="input-group input-group-outline my-3">
                                                <label class="form-label">Distancia</label>
                                                <input type="number" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col text-center">
                                            <div class="input-group input-group-outline my-3">
                                                <label class="form-label">Notas y Observaciones</label>
                                                <textarea class="form-control" rows="4"></textarea>
                                            </div>

                                            <div class="input-group input-group-outline my-3 justify-content-center">
                                                <label class="btn btn-primary" for="formFile">Ubicacion de bajantes</label>
                                                <input class="form-control d-none" type="file" id="formFile" multiple>
                                            </div>
                                            <p id="fileName"></p>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <ul id="imageList" class="qq-upload-list" aria-label="Uploaded files"></ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <span>Área disponible para la instalación del inversor</span>
                                        <p>El área debe de tener unos mínimos para poder instalar el inversor. La siguiente imagen muestra las distancias mínimas que deben de tener de separación y altura.</p>
                                        <div class="col d-flex justify-content-center">
                                            <img src="{{ asset('img/area-de-inversor.png') }}" class="img-fluid border-radius-lg" alt="Responsive image">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col text-center">
                                            <div class="input-group input-group-outline my-3">
                                                <label class="form-label">Distacia del TFV AC al tablero principal(mt)</label>
                                                <input type="number" class="form-control">
                                            </div>
                                            <div class="input-group input-group-outline my-3">
                                                <label class="form-label">Notas y Observaciones</label>
                                                <textarea class="form-control" rows="4"></textarea>
                                            </div>
                                            <div class="input-group input-group-outline my-3 justify-content-center">
                                                <label class="btn btn-primary" for="formFile">Ubicacion de bajantes</label>
                                                <input class="form-control d-none" type="file" id="formFile" multiple>
                                            </div>
                                            <p id="fileName"></p>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <ul id="imageList" class="qq-upload-list" aria-label="Uploaded files"></ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <span>Revición del tablero exixtente</span>
                                        <div class="col text-center">
                                            <div class="input-group input-group-outline my-3">
                                                <select class="form-control" id="exampleFormControlSelect1">
                                                    <option disabled selected>Tipo de red</option>
                                                    <option>Monofasica</option>
                                                    <option>Bifasica</option>
                                                    <option>Trifasica</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check mb-3">
                                                <label for="customRadio1">¿Tiene espacio para los breaker?</label> <br>
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="customRadio1">
                                                <label class="custom-control-label" for="customRadio1">SI</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="customRadio2">
                                                <label class="custom-control-label" for="customRadio2">NO</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check mb-3">
                                                <label for="customRadio1">¿Tiene espacio para los CT´s?</label> <br>
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="customRadio1">
                                                <label class="custom-control-label" for="customRadio1">SI</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="customRadio2">
                                                <label class="custom-control-label" for="customRadio2">NO</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-center">
                                            <div class="input-group input-group-outline my-3">
                                                <select class="form-control" id="exampleFormControlSelect1">
                                                    <option disabled selected>Calibre de cable</option>
                                                    <option>Calibre 8 AWG - 8.37 mm²</option>
                                                    <option>Calibre 6 AWG - 13.30 mm²</option>
                                                    <option>Calibre 4 AWG - 21.20 mm²</option>
                                                    <option>Calibre 2 AWG - 33.60 mm²</option>
                                                    <option>Calibre 1 AWG - 42.40 mm²</option>
                                                    <option>Calibre 1/0 AWG (0 AWG) - 53.50 mm²</option>
                                                    <option>Calibre 2/0 AWG - 67.40 mm²</option>
                                                    <option>Calibre 3/0 AWG - 85.00 mm²</option>
                                                    <option>Calibre 4/0 AWG - 107.20 mm²</option>
                                                    <option>250 kcmil - 127 mm²</option>
                                                    <option>300 kcmil - 152 mm²</option>
                                                    <option>350 kcmil - 177 mm²</option>
                                                    <option>400 kcmil - 203 mm²</option>
                                                    <option>500 kcmil - 253 mm²</option>
                                                    <option>600 kcmil - 304 mm²</option>
                                                    <option>700 kcmil - 355 mm²</option>
                                                    <option>750 kcmil - 380 mm²</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-center">
                                            <div class="input-group input-group-outline my-3">
                                            <label class="form-label">Totalizador(capasida amperio)</label>
                                            <input type="number" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <span>Revecion de medidor</span>
                                        <div class="col-6">
                                            <div class="input-group input-group-outline my-3">
                                                <select class="form-control" id="exampleFormControlSelect1">
                                                    <option disabled selected>Tipo de medidor</option>
                                                    <option>Medidor unidireccional</option>
                                                    <option>Medidor bidireccional</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-group input-group-outline my-3">
                                                <select class="form-control" id="exampleFormControlSelect1">
                                                    <option disabled selected>Tipo de medida</option>
                                                    <option>Directa</option>
                                                    <option>Semidirecta</option>
                                                    <option>Indirecta</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
    <!--   Core JS Files   -->
    <script src="{{ asset('/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/plugins/smooth-scrollbar.min.js') }}"></script>

    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('js/material-dashboard.min.js?v=3.1.0') }}"></script>

    <script>
        document.getElementById('formFile').addEventListener('change', function(event) {
            const imageList = document.getElementById('imageList');
            const fileNameDisplay = document.getElementById('fileName');

            const files = event.target.files;
            fileNameDisplay.textContent = Array.from(files).map(file => file.name).join(', ');
            for (let i = 0; i < files.length; i++) {
                const file = files[i];

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const li = document.createElement('li');
                        li.className = 'qq-upload-success';
                        li.setAttribute('tabindex', '-1');
                        li.setAttribute('actual-filename', file.name);

                        const imgContainer = document.createElement('div');
                        imgContainer.className = 'qq-upload-img-container';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = file.name;
                        img.className = 'img-thumbnail';

                        imgContainer.appendChild(img);

                        const extension = file.name.split('.').pop().toUpperCase();
                        const fileNameSpan = document.createElement('span');
                        fileNameSpan.className = 'qq-upload-file';
                        fileNameSpan.textContent = extension;

                        const fileSizeSpan = document.createElement('span');
                        fileSizeSpan.className = 'qq-upload-size';
                        fileSizeSpan.style.display = 'inline';
                        fileSizeSpan.textContent = (file.size / 1024 / 1024).toFixed(1) + 'MB';

                        const deleteSpan = document.createElement('span');
                        deleteSpan.className = 'qq-upload-delete';
                        deleteSpan.setAttribute('role', 'button');
                        deleteSpan.setAttribute('tabindex', '0');
                        deleteSpan.setAttribute('aria-label', 'Delete ' + file.name);
                        deleteSpan.textContent = 'X';
                        deleteSpan.onclick = function() {
                            li.remove();
                        };

                        li.appendChild(imgContainer);
                        li.appendChild(fileNameSpan);
                        li.appendChild(fileSizeSpan);
                        li.appendChild(deleteSpan);

                        imageList.appendChild(li);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
    </script>

    <script>
        function seleccionarDepartamento() {
            var ciudadSeleccionada2 = document.getElementById("selectCiudades").value;
            var departamentoSelect2 = document.getElementById("selectDepartamentos");

            // Buscar la opción correspondiente al departamento de la ciudad seleccionada
            var opcionesDepartamento = departamentoSelect2.options;
            for (var i = 0; i < opcionesDepartamento.length; i++) {
                var ciudadDepartamento = opcionesDepartamento[i].getAttribute('data-ciudades');
                if (ciudadDepartamento && ciudadDepartamento.includes(ciudadSeleccionada2)) {
                    departamentoSelect2.selectedIndex = i;
                    break;
                }
            }
        }

        function filtrarCiudades() {
            var departamentoSeleccionado = document.getElementById("selectDepartamentos").value;
            var ciudades = document.querySelectorAll("#selectCiudades option");

            ciudades.forEach(function(ciudad) {
                if (ciudad.dataset.departamento === departamentoSeleccionado || ciudad.dataset.departamento === undefined) {
                    ciudad.style.display = "block";
                } else {
                    ciudad.style.display = "none";
                }
            });

            // Habilitar la primera opción válida
            var primeraOpcionVisible = document.querySelector("#selectCiudades option[style='display: block;']");
            primeraOpcionVisible.selected = true;

            // Seleccionar automáticamente el departamento correspondiente a la ciudad seleccionada
            seleccionarDepartamento();
        }

        // Llamar a la función filtrarCiudades al cargar la página para establecer el estado inicial
        filtrarCiudades();
    </script>
</body>

</html>
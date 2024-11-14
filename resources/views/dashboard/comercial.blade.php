<div class="row">
  <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-header p-3 pt-2">
        <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
          <i class="material-icons opacity-10">group</i>
        </div>
        <div class="text-end pt-1">
          <p class="text-sm mb-0 text-capitalize">Clientes</p>
          <h4 class="mb-0">{{ $clientes }}</h4>
        </div>
      </div>
      <div class="card-footer">
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-header p-3 pt-2">
        <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
          <i class="material-icons opacity-10">folder_open</i>
        </div>
        <div class="text-end pt-1">
          <p class="text-sm mb-0 text-capitalize">Propuestas</p>
          <h4 class="mb-0">{{ $presupuestos }}</h4>
        </div>
      </div>
      <div class="card-footer">
      </div>
    </div>
  </div>

  <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-header p-3 pt-2">
        <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
          <i class="material-icons opacity-10">weekend</i>
        </div>
        <div class="text-end pt-1">
          <p class="text-sm mb-0 text-capitalize">Avance Comercial</p>
          <h4 class="mb-0">{{ number_format($porcentaje, 2,',', '.') }}%</h4>
        </div>
      </div>
      <div class="card-footer text-end pt-1">
        <p class="text-sm "><span class="font-weight-bolder">{{ number_format($avance, 0,',', '.') }}</span></p>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4">
  <div class="col-lg-4 mt-4 mb-3">
    <div class="card z-index-2">
      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
        <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
          <div class="chart">
            <div id="propuestas"></div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <h6 class="mb-0">Propuestas por mes</h6>
        <div class="text-center mt-3">
          <button class="btn btn-info" onclick="resetChart()">Mostrar datos Mensuales</button>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4 mt-4 mb-3">
    <div class="card z-index-2">
      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
        <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
          <div class="chart">
            <div id="tipo_cliente"></div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <h6 class="mb-0">kW por tipo de clientes</h6>
        <div class="row">
          <p>kWs presupuestados segun el tipo del cliente</p>
          <div class="col">
            <div class="text-center mt-3">
              <p style="color: black;">Residencial: <b>{{number_format($total_kW_residencial, 1, ',', '.') ?? '0'}}kW</b></p>
            </div>
          </div>
          <div class="col">
            <div class="text-center mt-3">
              <p style="color: black;">Comercial: <b>{{number_format($total_kW_Comercial, 1, ',', '.') ?? '0'}}kW</b></p>
            </div>
          </div>
          <div class="col">
            <div class="text-center mt-3">
              <p style="color: black;">Industrial: <b>{{number_format($total_kW_Industrial, 1, ',', '.') ?? '0'}}kW</b></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4 col-md-6 mt-4 mb-4">
    <div class="card z-index-2  ">
      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
        <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
          <div class="chart">
            <div id="clientes"></div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <h6 class="mb-0 ">Clientes</h6>
        <div class="text-center mt-3">
          <button class="btn btn-info" onclick="resetLineChart()">Mostrar datos Mensuales</button>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<div class="row mb-4">
  <div class="col-lg-4 col-md-6">
    <div class="card h-100">
      <div class="card-header pb-0">
        <h6>Porpuestas por estado</h6>
      </div>
      <div class="card-body p-3">
        <div class="timeline timeline-one-side">
          <div class="timeline-block mb-3">
            <span class="timeline-step">
              <i class="material-icons">pending_actions</i>
            </span>
            <div class="timeline-content">
              <h6 class="text-dark text-sm font-weight-bold mb-0">Pendientes</h6>
              <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ $pendientes }}</p>
            </div>
          </div>
          <div class="timeline-block mb-3">
            <span class="timeline-step">
              <i class="material-icons text-danger text-gradient">design_services</i>
            </span>
            <div class="timeline-content">
              <h6 class="text-dark text-sm font-weight-bold mb-0">Diseñadas</h6>
              <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ $disenadas }}</p>
            </div>
          </div>
          <div class="timeline-block mb-3">
            <span class="timeline-step">
              <i class="material-icons text-info text-gradient">send</i>
            </span>
            <div class="timeline-content">
              <h6 class="text-dark text-sm font-weight-bold mb-0">Enviadas</h6>
              <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ $enviadas }}</p>
            </div>
          </div>
          <div class="timeline-block mb-3">
            <span class="timeline-step">
              <i class="material-icons text-warning text-gradient">credit_card</i>
            </span>
            <div class="timeline-content">
              <h6 class="text-dark text-sm font-weight-bold mb-0">Negociaciones</h6>
              <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ $negociaciones}}</p>
            </div>
          </div>
          <div class="timeline-block mb-3">
            <span class="timeline-step">
              <i class="material-icons text-danger text-gradient">cancel</i>
            </span>
            <div class="timeline-content">
              <h6 class="text-dark text-sm font-weight-bold mb-0">Descartadas</h6>
              <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ $descargatas }}</p>
            </div>
          </div>
          <div class="timeline-block">
            <span class="timeline-step">
              <i class="material-icons text-success text-gradient">payments</i>
            </span>
            <div class="timeline-content">
              <h6 class="text-dark text-sm font-weight-bold mb-0">Contratadas</h6>
              <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ $contratadas }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php

namespace App\Exports;

use App\Models\Presupuesto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class PropuestaExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $presupuestos = DB::select('SELECT pre.codigo_propuesta, pre.nombre_proyecto, ((pre.numero_paneles * p.poder)/1000) AS kW, c.nombre AS nombre_cliente FROM presupuestos AS pre JOIN panel_solars AS p ON p.id = pre.id_panel JOIN clientes AS c ON c.NIC = pre.id_cliente WHERE pre.financiado = 1;');
        //DD($presupuestos);

        return $presupuestos;
    }
}

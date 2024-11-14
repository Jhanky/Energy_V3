<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Presupuesto;

class DataExport implements FromCollection, WithHeadings
{
    protected $selectedIds;

    public function __construct($selectedIds)
    {
        $this->selectedIds = $selectedIds;
    }

    public function collection()
    {
        return Presupuesto::whereIn('id', $this->selectedIds)
            ->select('nombre_proyecto', 'tipo_cliente', 'sugerida', 'TOTAL_PROYECTO', 'nombre_estado', 'updated_at')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nombre del Proyecto',
            'Tipo de Cliente',
            'kW Cotizados',
            'Presupuesto',
            'Estado',
            'Fecha de Actualización',
        ];
    }
}

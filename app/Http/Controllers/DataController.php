<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\DataExport;
use Maatwebsite\Excel\Facades\Excel;

class DataController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function exportSelected(Request $request)
    {
        $selectedIds = $request->input('selected_ids');

        if (empty($selectedIds)) {
            return redirect()->back()->with('error', 'Debe seleccionar al menos un proyecto para exportar.');
        }

        return Excel::download(new DataExport($selectedIds), 'Proyectos_Seleccionados.xlsx');
    }
}

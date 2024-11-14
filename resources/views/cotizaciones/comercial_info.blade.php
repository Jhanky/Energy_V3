<div class="card my-4">
    <div class="card-body">
        <div class="table-responsive" id="tabla">
            <table class="table table-bordered border-success" id="dataTable" width="100%" cellspacing="0">
                <tr>
                    <th style="color: black;"><b>Equipos</b></th>
                    <th style="color: black;"><b>Modelo</b></th>
                    <th style="color: black;"><b>Cantidad</b></th>
                    <th style="color: black;"><b>Potencia</b></th>
                </tr>
                </thead>
                <tbody>
                    <!-- Combina las celdas "Panel", "Batería" e "Inversor" en una sola fila -->
                    <tr>
                        <td class="table-success border-success" style="color: black;"><b>Panel</b></td>
                        <td>{{ $results->first()->solar_panel_marca }}</td>
                        <td style="text-align: right; color: black;">{{ number_format($results->first()->numero_paneles, 0,',', '.') }}</td>
                        <td style="text-align: right; color: black;">{{ number_format($results->first()->poder, 0,',', '.') }}W</td>
                    </tr>
                    @if($results->first()->id_bateria != 1)
                    <tr>
                        <td class="table-success border-success" style="color: black;"><b>Bateria</b></td>
                        <td>{{ $results->first()->batterie_marca ?? 'Sin bateria'}}</td>
                        <td style="text-align: right; color: black;">{{ number_format($results->first()->numero_baterias, 0, ',', '.' ?? '0') }}</td>
                        <td style="text-align: right; color: black;">{{ number_format($results->first()->amperios_hora, 0, ',', '.' ?? '0') }}Ah</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="table-success border-success" style="color: black;"><b>Inversor</b></td>
                        <td>
                            @if ($results->first()->investor_marca)
                            {{ $results->first()->investor_marca }}
                            @endif
                            <br>
                            @if ($results->first()->investor2_marca)
                            {{ $results->first()->investor2_marca }}
                            @endif
                        </td>
                        <td style="text-align: right; color: black;">
                            @if ($results->first()->numero_inversores)
                            {{ number_format($results->first()->numero_inversores, 0,',', '.') }}
                            @endif
                            <br>
                            @if ($results->first()->numero_inversores_2)
                            {{ number_format($results->first()->numero_inversores_2, 0,',', '.') }}
                            @endif
                        </td>
                        <td style="text-align: right; color: black;">
                            @if ($results->first()->poder_investor)
                            {{ number_format($results->first()->poder_investor, 0,',', '.') }}kW
                            @endif
                            <br>
                            @if ($results->first()->poder2_investor)
                            {{ number_format($results->first()->poder2_investor, 0,',', '.') }}kW
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <td class="table-danger border-success" style="color: black;"><b>Material electrico</b></td>
                        <td></td>
                        <td style="text-align: right; color: black;">{{ number_format($results->first()->numero_paneles, 0,',', '.') }}</td>
                        <td></td>
                    </tr>
                    @if($results->first()->valor_sobreestructura != 0)
                    <tr>
                        <td class="table-danger border-success" style="color: black;"><b>Sobreestructura</b></td>
                        <td></td>
                        <td style="text-align: right; color: black;">1</td>
                        <td></td>
                    </tr>
                    @endif
                    <tr>
                        <td class="table-danger border-success" style="color: black;"><b>Conductor fotovoltaico(mts)</b></td>
                        <td colspan="3"></td>

                    </tr>
                    <tr>
                        <td class="table-danger border-success" style="color: black;"><b>Mano de obra</b></td>
                        <td></td>
                        <td style="text-align: right; color: black;">{{ number_format($results->first()->numero_paneles, 0,',', '.') }}</td>
                        <td></td>



                    </tr>
                    <tr>
                        <td class="table-primary border-success" style="color: black;"><b>Tramites(certificados retie, medidor bidireccional, Estudio de conexion)</b></td>
                        <td></td>
                        <td style="text-align: right; color: black;">1</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="9"></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="negrita" colspan="3" style="text-align: right; color: black;"><b>VALOR TOTAL</b></td>
                        <td style="text-align: right; color: black;">
                            <h4>
                                {{ number_format($results->first()->TOTAL_PROYECTO, 0, ',', '.') }}
                            </h4>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
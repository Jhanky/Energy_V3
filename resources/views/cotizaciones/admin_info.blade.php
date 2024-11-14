<div class="card my-4">
            <div class="card-body">
                <div class="table-responsive" id="tabla">
                    <table class="table table-bordered border-success" id="dataTable" width="100%" cellspacing="0">
                        <tr>
                            <th style="color: black;"><b>Equipos</b></th>
                            <th style="color: black;"><b>Modelo</b></th>
                            <th style="color: black;"><b>Cantidad</b></th>
                            <th style="color: black;"><b>Potencia</b></th>
                            <th style="color: black;"><b>Precio Unitario</b></th>
                            <th style="color: black;"><b>Valor parcial</b></th>
                            <th style="color: black;"><b>% Gewinn</b></th>
                            <th style="color: black;"><b>Gewinn</b></th>
                            <th style="color: black;"><b>Valor + IVA</b></th>
                        </tr>
                        </thead>
                        <tbody>
                            <!-- Combina las celdas "Panel", "Batería" e "Inversor" en una sola fila -->
                            <tr>
                                <td class="table-success border-success" style="color: black;"><b>Panel</b></td>
                                <td>{{ $results->first()->solar_panel_marca }}</td>
                                <td style="text-align: right; color: black;">{{ number_format($results->first()->numero_paneles, 0,',', '.') }}</td>
                                <td style="text-align: right; color: black;">{{ number_format($results->first()->poder, 0,',', '.') }}W</td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->precio, 0, ',', '.') }}</td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->total_panel, 0,',', '.') }}</td>
                                <td style="text-align: right; color: black;">25%</td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->panel_gewinn, 0,',', '.') }}</td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->panel_total, 0,',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="table-success border-success" style="color: black;"><b>Bateria</b></td>
                                <td>{{ $results->first()->batterie_marca ?? 'Sin bateria'}}</td>
                                <td style="text-align: right; color: black;">{{ number_format($results->first()->numero_baterias, 0, ',', '.' ?? '0') }}</td>
                                <td style="text-align: right; color: black;">{{ number_format($results->first()->amperios_hora, 0, ',', '.' ?? '0') }}Ah</td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->precio_batterie, 0, ',', '.' ?? '0') }}</td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->total_bateria, 0,',', '.') }}</td>
                                <td style="text-align: right; color: black;">25%</td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->bateria_gewinn, 0,',', '.') }}</td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->bateria_total, 0,',', '.') }}</td>
                            </tr>
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

                                <td style="text-align: right; color: black;">
                                    @if ($results->first()->precio_investor)
                                    ${{ number_format($results->first()->precio_investor, 0, ',', '.') }}
                                    @endif
                                    <br>
                                    @if ($results->first()->precio2_investor)
                                    ${{ number_format($results->first()->precio2_investor, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td style="text-align: right; color: black;">
                                    @if ($results->first()->total_inversor)
                                    ${{ number_format($results->first()->total_inversor, 0,',', '.') }}
                                    @endif
                                    <br>
                                    @if ($results->first()->total_inversor2)
                                    ${{ number_format($results->first()->total_inversor2, 0,',', '.') }}
                                    @endif
                                </td>
                                <td style="text-align: right; color: black;">
                                    25%</td>
                                <td style="text-align: right; color: black;">
                                    @if ($results->first()->inversor_gewinn)
                                    ${{ number_format($results->first()->inversor_gewinn, 0,',', '.') }}
                                    @endif
                                    <br>
                                    @if ($results->first()->inversor_gewinn2)
                                    ${{ number_format($results->first()->inversor_gewinn2, 0,',', '.') }}
                                    @endif
                                </td>
                                <td style="text-align: right; color: black;">
                                    @if ($results->first()->inversor_total)
                                    ${{ number_format($results->first()->inversor_total, 0,',', '.') }}
                                    @endif
                                    <br>
                                    @if ($results->first()->inversor_total2)
                                    ${{ number_format($results->first()->inversor_total2, 0,',', '.') }}
                                    @endif
                                </td>

                            </tr>
                            <tr>
                                <td class="table-danger border-success" style="color: black;"><b>Material electrico</b></td>
                                <td></td>
                                <td style="text-align: right; color: black;">{{ number_format($results->first()->numero_paneles, 0,',', '.') }}</td>
                                <td></td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->material, 0,',', '.') }}</td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->material_p, 0, ',', '.') }}</td>
                                <td style="text-align: right; color: black;">25%</td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->material_gewinn, 0,',', '.') }}</td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->material_total, 0,',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="table-danger border-success" style="color: black;"><b>Estructura</b></td>
                                <td></td>
                                <td style="text-align: right; color: black;">{{ number_format($results->first()->numero_paneles, 0,',', '.') }}</td>
                                <td></td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->total_estructura, 0,',', '.') }}</td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->estructura_p, 0, ',', '.') }}</td>
                                <td style="text-align: right; color: black;">25%</td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->estructura_gewinn, 0,',', '.') }}</td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->estructura_total, 0,',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="table-danger border-success" style="color: black;"><b>Sobreestructura</b></td>
                                <td colspan="7"></td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->valor_sobreestructura, 0,',', '.' ?? 0) }}</td>
                            </tr>
                            <tr>
                                <td class="table-danger border-success" style="color: black;"><b>Conductor fotovoltaico(mts)</b></td>
                                @php
                                $mt = round($results->first()->cable_p / $valor_cable);
                                $precio_unitario = $mt * $valor_cable;
                                $gewinn = $precio_unitario * 0.25;
                                $total_cable = $precio_unitario + $gewinn;
                                @endphp
                                <td></td>
                                <td style="text-align: right; color: black;">{{ number_format($mt, 0,',', '.') }}</td>
                                <td></td>

                                <td style="text-align: right; color: black;">${{ number_format($valor_cable, 0,',', '.') }}</td>
                                <td style="text-align: right; color: black;">${{ number_format($precio_unitario, 0, ',', '.') }}</td>
                                <td style="text-align: right; color: black;">25%</td>
                                <td style="text-align: right; color: black;">${{ number_format($gewinn, 0,',', '.') }}</td>
                                <td style="text-align: right; color: black;">${{ number_format($total_cable, 0,',', '.') }}</td>

                            </tr>
                            <tr>
                                <td class="table-danger border-success" style="color: black;"><b>Mano de obra</b></td>
                                <td></td>
                                <td style="text-align: right; color: black;">{{ number_format($results->first()->numero_paneles, 0,',', '.') }}</td>
                                <td></td>

                                <td style="text-align: right; color: black;">${{ number_format($results->first()->mano, 0, ',', '.') }}</td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->mano_p, 0,',', '.') }}</td>
                                <td style="text-align: right; color: black;">25%</td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->mano_gewinn, 0,',', '.') }}</td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->mano_total, 0,',', '.') }}</td>

                            </tr>
                            <tr>
                                <td class="table-primary border-success" style="color: black;"><b>Tramites(certificados retie, medidor bidireccional, Estudio de conexion)</b></td>
                                <td></td>
                                <td style="text-align: right; color: black;">1</td>
                                <td></td>

                                <td style="text-align: right; color: black;">${{ number_format($results->first()->valor_tramites, 0, ',', '.') }}</td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->valor_tramites, 0,',', '.') }}</td>
                                <td style="text-align: right; color: black;">5%</td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->tramite_gewinn, 0,',', '.') }}</td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->tramite_total, 0,',', '.') }}</td>

                            </tr>
                            <tr>
                                <td colspan="9"></td>
                            </tr>
                        </tbody>
                        <tfoot>

                            <tr>
                                <td class="negrita" colspan="5" style="text-align: left;"><b>Subtotal</b></td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->subtotal_p, 0,',', '.') }}</td>
                                <td></td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->subtotal_gewinn, 0,',', '.') }}</td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->subtotal, 0,',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="table-danger border-success" colspan="8" style="color: black;"><b>Gestion comercial ({{$results->first()->comercial_poencentaje}}%)</b></td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->comercial, 0,',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="negrita" colspan="8" style="text-align: left;"><b>Subtotal 2</b></td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->subtotal_2, 0,',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="table-danger border-success" colspan="8" style="color: black;"><b>Administracion ({{ $results->first()->administracion_porcentaje }}%)</b></td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->administracion, 0,',', '.') }}</td>

                            </tr>
                            <tr>
                                <td class="table-danger border-success" colspan="8" style="color: black;"><b>Imprevistos ({{ $results->first()->imprevisto_porcentaje }}%)</b></td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->imprevisto, 0,',', '.') }}</td>

                            </tr>
                            <tr>
                                <td class="table-danger border-success" colspan="8" style="color: black;"><b>Utilidad ({{ $results->first()->utilidad_porcentaje }}%)</b></td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->utilidad, 0,',', '.') }}</td>

                            </tr>
                            <tr>
                                <td class="table-danger border-success" colspan="8" style="color: black;"><b>IVA sobre la utilidad (19%)</b></td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->Iva, 0,',', '.') }}</td>
                            </tr>

                            <tr>
                                <td class="negrita" colspan="8" style="text-align: left;"><b>Subtotal 3</b></td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->subtotal_3, 0,',', '.') }}</td>
                            </tr>

                            <tr>
                                <td class="negrita" colspan="8" style="text-align: left;"><b>Retenciones ({{ $results->first()->retencion_porcentaje }}%)</b></td>
                                <td style="text-align: right; color: black;">${{ number_format($results->first()->retencion, 0,',', '.') }}</td>
                            </tr>

                            <tr>
                                <td class="negrita" colspan="8" style="text-align: left;"><b>Cotización del proyecto</b></td>
                                <td style="text-align: right; color: black;"><b>${{ number_format($results->first()->TOTAL_PROYECTO_cotizado, 0, ',', '.') }}</b></td>
                            </tr>
                            <tr>
                                <td colspan="9"></td>
                            </tr>
                            <tr>
                                <td class="negrita" colspan="8" style="text-align: right; color: black;"><b>VALOR TOTAL</b></td>
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
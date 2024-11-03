<div class="modal fade" id="aprendicesModal{{ $ficha->id }}" tabindex="-1" aria-labelledby="aprendicesModalLabel{{ $ficha->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header text-white" style="background-color: #39A900;">
                <h5 class="modal-title" id="aprendicesModalLabel{{ $ficha->id }}">Aprendices de la Ficha {{ $ficha->codigo_ficha }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Documento</th>
                                <th>Nombre Completo</th>
                                <th>Correo Electrónico</th>
                                <th>Teléfono</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ficha->aprendices as $aprendiz)
                            <tr>
                                <td>{{ $aprendiz->documento }}</td>
                                <td>{{ $aprendiz->pnombre }} {{ $aprendiz->snombre }} {{ $aprendiz->papellido }} {{ $aprendiz->sapellido }}</td>
                                <td>{{ $aprendiz->correo }}</td>
                                <td>{{ $aprendiz->telefono }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <a href="{{ route('fichas.imprimir-aprendices', $ficha) }}" class="btn btn-success" target="_blank">Imprimir Listado</a>
            </div>
        </div>
    </div>
</div>
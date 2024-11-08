@extends('layouts.app')
@section('titulo', 'Fichas')

@section('content')
<div class="container-fluid">

                <a href="{{ route('fichas.create') }}" class="btn btn-success mb-3 boton-crear">
                    <i class="fas fa-plus"></i> Crear Ficha
                </a>


                <table id="fichasTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Programa</th>
                            <th>Instructor Líder</th>
                            <th>Aprendices</th>
                            <th>Fecha Inicio</th>
                            <th>Estado</th>
                            <th>Jornada</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fichas as $ficha)
                            <tr>
                                <td>{{ $ficha->codigo_ficha }}</td>
                                <td data-toggle="tooltip" title="{{ $ficha->programaFormacion->nombre }}">
                                    {{ Str::limit($ficha->programaFormacion->nombre, 40) }}
                                </td>
                                <td>{{ $ficha->instructor->pnombre }} {{ $ficha->instructor->papellido }}</td>
                                <td class="text-center">
                                    {{ $ficha->numero_aprendices }}
                                </td>
                                <td>{{ Carbon\Carbon::parse($ficha->fecha_inicio)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="estado-badge {{ Str::slug($ficha->estado_actual) }}">
                                        {{ $ficha->estado_actual }}
                                    </span>
                                </td>
                                <td>{{ $ficha->jornada->nombre }}</td>
                                <td>
                                        <a href="{{ route('fichas.show', $ficha) }}" 
                                           class="btn btn-success btn-sm" 
                                           title="Ver Detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('fichas.edit', $ficha) }}" 
                                           class="btn btn-success btn-sm"
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                      
                                        <button type="button" 
                                                class="btn btn-success btn-sm"
                                                title="Ver Lista de Aprendices"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#aprendicesModal{{ $ficha->id }}">
                                            <i class="bi bi-people"></i>
                                        </button>

                                    <form id="eliminar-ficha-{{ $ficha->id }}" 
                                          action="{{ route('fichas.destroy', $ficha) }}" 
                                          method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger mt-1"onclick="mensajeDeEliminacion(event, '{{ $ficha->id }}', '{{ $ficha->codigo }}', 'fichas')"><i class="bi bi-trash"></i></button>

                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
       
        </div>

</div>

<!-- Modales de Aprendices -->
@foreach($fichas as $ficha)
    <div class="modal fade" id="aprendicesModal{{ $ficha->id }}" tabindex="-1" 
         aria-labelledby="aprendicesModalLabel{{ $ficha->id }}" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="aprendicesModalLabel{{ $ficha->id }}">
                        Aprendices de la Ficha {{ $ficha->codigo_ficha }}
                    </h5>
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
                                @forelse($ficha->aprendices as $aprendiz)
                                    <tr>
                                        <td>{{ $aprendiz->documento }}</td>
                                        <td>{{ $aprendiz->pnombre }} {{ $aprendiz->snombre }} {{ $aprendiz->papellido }} {{ $aprendiz->sapellido }}</td>
                                        <td>{{ $aprendiz->correo }}</td>
                                        <td>{{ $aprendiz->telefono }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No hay aprendices registrados en esta ficha</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <a href="{{ route('fichas.imprimir-aprendices', $ficha) }}" 
                       class="btn btn-success" target="_blank">
                        <i class="fas fa-print"></i> Imprimir Listado
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script>
    $(document).ready(function() {
        $('#fichas-table').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'collection',
                    text: '<i class="fas fa-download"></i> Exportar',
                    buttons: [
                        {
                            extend: 'excel',
                            text: '<i class="far fa-file-excel"></i> Excel',
                            exportOptions: {
                                columns: [0,1,2,3,4,5,6]
                            }
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="far fa-file-pdf"></i> PDF',
                            exportOptions: {
                                columns: [0,1,2,3,4,5,6]
                            }
                        },
                        {
                            extend: 'print',
                            text: '<i class="fas fa-print"></i> Imprimir',
                            exportOptions: {
                                columns: [0,1,2,3,4,5,6]
                            }
                        }
                    ]
                }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
            },
            order: [[4, 'desc']], // Ordenar por fecha de inicio descendente
            pageLength: 25,
            columnDefs: [
                {
                    targets: -1,
                    orderable: false
                }
            ]
        });

        // Inicializar tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });

    function confirmarEliminacion(fichaId, codigoFicha) {
        Swal.fire({
            title: '¿Está seguro?',
            text: `Va a eliminar la ficha ${codigoFicha}. Esta acción no se puede deshacer.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('eliminar-ficha-' + fichaId).submit();
            }
        });
    }

    // Cerrar alertas automáticamente después de 5 segundos
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
</script>
@endpush
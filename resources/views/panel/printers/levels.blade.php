@extends('layouts.panel')

@section('title', 'Impressoras')
@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="/panel/js/plugins/datatables/dataTables.bootstrap4.css">
@endsection
@section('content')
<div class="card">
    <!-- /.card-header -->
    <div class="card-header">
        <a href="{{ route('panel.printers.create') }}" class="btn btn-primary float-left" role="button">Adicionar
            Impressora</a> 
    </div>
    <div class="card-body">
        <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
                <div class="col-sm-12">
                    <table id="datatable" class="table table-bordered table-hover dataTable" role="grid">
                        <thead>
                            <tr role="row">
                                <th>Serial</th>
                                <th>Modelo</th>
                                <th>Nome</th>
                                <th>Toner Preto</th>
                                <th style="width:175px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($printers as $item)
                            <tr>
                                <td>{{$item->serial_number}}</td>
                                <td>{{$item->model}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->toner_black}}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="http://{{$item->ipaddress}}" target="_blank">
                                        <i class="fa fa-pencil-alt white"></i> Acessar
                                    </a>                                   
                                </td>
                            </tr>
                            <div class=" modal fade" id="deleteRatificationModal-{{$item->toner_black}}" role="dialog"
                                aria-labelledby="ratificationMsg" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="ratificationMsg">
                                                Confirmar exclusão
                                            </h4>
                                        </div>
                                        <div class="modal-body">
                                            Quer mesmo deletar este registro?
                                        </div>
                                        <div class="modal-footer">
                                            <form method="POST" action="{{ route('panel.user.destroy', $item->toner_black ) }}">
                                                @method('DELETE') @csrf
                                                <button type="button" class="btn btn-primary"
                                                    data-dismiss="modal">Cancelar</button>
                                                <input type="submit" name="submit" value="Delete"
                                                    class='btn btn-danger'>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>
@stop

@section('js')
<!-- DataTables -->
<script src="/panel/js/plugins/datatables/jquery.dataTables.js"></script>
<script src="/panel/js/plugins/datatables/dataTables.bootstrap4.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.21/dataRender/percentageBars.js"></script>

<script>
    $(function () {
        $("#datatable").DataTable({
            "ordering": false,
            "columnDefs": [ {
            targets: 3,
            render: $.fn.dataTable.render.percentBar( 'round','#fff', '#000000', '#000000', '#696969', 1, 'solid' )
            } ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
            }
        });
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "columnDefs": [ {
            targets: 3,
            render: $.fn.dataTable.render.percentBar( 'round','#000000', '#696969', '#808080', '#A9A9A9', 1, 'black' )
            } ]
        });
    });
</script>
@stop

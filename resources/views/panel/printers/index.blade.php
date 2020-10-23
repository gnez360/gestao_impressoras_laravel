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
        <a href="{{ route('panel.printers.create') }}" class="row btn btn-primary float-left" role="button" id="addPrinter" name="addPrinter">Adicionar
            Impressora</a> 
            @foreach ($locations_atual as $location)
            <h1 class="row justify-content-center"> Impressoras {{$location->name}} </h1>
            <?php $atual = $location->id ?>
            @endforeach
    </div>
    <div class="card-body">
        <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
                <div class="col-sm-12">
                    <label>
                        Selecione a Unidade: 
                    </label>
                  
                    <select id ="location" name="location" class="form-group col-sm-auto">
                        @foreach ($locations as $location)
                        @if($location->id == $atual)}}
                            <option value="{{$location->id}}" selected>{{$location->name}}</option>
                        @else  
                        <option value="{{$location->id}}">{{$location->name}}</option>  
                        @endif  
                        @endforeach
                    </select>
               
                    <table id="datatable" class="table table-bordered table-hover dataTable" role="grid">
                        <thead>
                            <tr role="row">
                                <th>Serial</th>
                                <th>Modelo</th>
                                <th>Nome</th>
                                <th>IP</th>
                                <th>Status</th>
                                <th style="width:175px">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($printers as $item)
                            <tr>
                                <td>{{$item->serial_number}}</td>
                                <td>{{$item->model}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->ipaddress}}</td>
                                <td>{{$item->status}}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="{{route('panel.user.edit', $item->id)}}">
                                        <i class="fa fa-pencil-alt white"></i> Editar
                                    </a>
                                    /
                                    <a class="btn btn-danger btn-sm" href="#" data-toggle="modal"
                                        data-target="#deleteRatificationModal-{{$item->id}}">
                                        <i class="fa fa-trash white"></i> Apagar
                                    </a>
                                </td>
                            </tr>
                            <div class=" modal fade" id="deleteRatificationModal-{{$item->id}}" role="dialog"
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
                                            <form method="POST" action="{{ route('panel.user.destroy', $item->id ) }}">
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
<script>

    $(document).ready(function() {
    /**
    * for showing edit item popup
    */

    $(document).on('click', "#edit-addPrinter", function() {       
        $('#edit-modal').modal(options)
    })
    $(function () {
       $("#datatable").DataTable({
            "ordering": true,
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
        });
    });

    $("#location").change(function() {
        var e = document.getElementById("location");      
        var option = e.value;
        window.location.href = window.location.url="/panel/printers/"+option;
    });
})
</script>
@stop

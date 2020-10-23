<div class="card-body">
    <div class="form-group">
        <fieldset> 
            <div class="form-group" >
                {!! Form::label('serial_number', 'Numero de Serial:', ['class' => 'col-lg control-label']) !!}
                <div class="col-lg">
                    {!! Form::text('serial_number', $value = null, ['class' => 'form-control', 'placeholder' => 'Numero de Serial']) !!}
                </div>
            </div>   
            <div class="form-group">
                {!! Form::label('name', 'Nome:', ['class' => 'col-lg control-label']) !!}
                <div class="col-lg">
                    {!! Form::text('name', $value = null, ['class' => 'form-control input-lg', 'placeholder' => 'Nome']) !!}
                </div>
            </div> 
            <div class="form-group">
                {!! Form::label('model', 'Modelo:', ['class' => 'col-lg control-label']) !!}
                <div class="col-lg-auto">                            
                    {!! Form::text('model', $value = null, ['class' => 'form-control input-lg', 'placeholder' => 'Modelo']) !!}
                </div>
            </div>  
             
            <div class="form-group">
                {!! Form::label('ipaddress', 'IP:', ['class' => 'col-lg control-label']) !!}
                <div class="col-lg">
                    {!! Form::text('ipaddress', $value = null, ['class' => 'form-control input-lg', 'placeholder' => 'Endereço IP']) !!}
                </div>
            </div> 
            <div class="form-group">
                {!! Form::label('location_id', 'Localização:', ['class' => 'col-lg control-label']) !!}
                <div class="col-lg">
                    {!! Form::select('location_id', $locations, $selectedID, ['class' => 'form-control form-control-xs']) !!}
                </div>
            </div>   
            <div class="form-group">
                {!! Form::label('type', 'Tipo:', ['class' => 'col-lg control-label']) !!}
                <div class="col-lg">
                    {!! Form::select('type',array(["Preto/Branco"=>"Preto/Branco","Colorido"=>"Colorido"]),"Preto/Branco", ['class' => 'form-control form-control-xs']) !!}
                </div>
            </div>     
     
        </fieldset>
        
    </div>

</div>

<div class="card-footer">
    <div class="box-footer">
        <a class="btn btn-danger pull-left"
            href="{{ (auth()->user()->can('index', [App\User::class, auth()->user()])) ? route('panel.printers.index') : route('panel.index') }}">Voltar</a> {!!
        Form::submit('Salvar',['class'
        => 'btn btn-primary float-right']) !!}
    </div>
</div>
@section('css')
<link rel="stylesheet" href="/panel/js/plugins/jquery-ui/jquery-ui.min.css">
@endsection
@section('js_form')
<script type="text/javascript" src="/panel/js/via-cep.js"></script>
<script type="text/javascript" src="/panel/js/plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
            // $("#form_id").validate();
            $('.datepicker').datepicker({
                dateFormat: 'dd/mm/yy',
                dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
                dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
                dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
                monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
                nextText: 'Próximo',
                prevText: 'Anterior'
            });
        });
</script>
@stop
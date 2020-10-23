@extends('layouts.panel')

@section('title', 'Cadastro de Impressoras')

@section('content')
@include('includes.alert')
<div class="card card-info" style="width: 50%;">
    <div class="card-header">
        <h3 class="card-title">Cadastro de Impressoras</h3>
    </div>
    {!! Form::open([
    'route' => 'panel.printers.store',
    'files' => true,
    'class' => 'form-horizontal',
    'id' => 'form_id'
    ]) !!}
    @include('panel.printers._form')
    {!! Form::close() !!}
</div>
@stop

@section('js')
    <script type="text/javascript" src="/vendor/jsvalidation/js/jsvalidation.js"></script>
    {!! JsValidator::formRequest('App\Http\Requests\Printer\StoreRequest', '#form_id'); !!}
@yield('js_form')
@endsection

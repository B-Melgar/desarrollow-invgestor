@extends ('layouts.admin')
@section ('contenido') 
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		@if (count($errors)>0)
		<div class="alert alert-danger">
			<ul>
			@foreach ($errors->all() as $error)
				<li>{{$error}}</li>
			@endforeach
			</ul>
		</div>
		@endif
	</div>
</div>

	{!! Form::open(array('url' => 'seguridad/segrol', 'method' => 'POST', 'autocomplete'=>'off')) !!}
	{{Form::token()}}
	@csrf

<div class="form-row">			
	<div class="form-group col-md-6">
		<div class="page-header">
			<h3>Nuevo</h3>
		</div>
		<div class="box-body">
			<div class="form-group col-md-6">
				<label for="nombre">Descripci&oacute;n</label>
				<input type="text" name="descripcionrol" class="form-control" value="{{old('descripcionrol')}}" placeholder="Descripción" required>
			</div>
			<div class="form-group col-md-12">
				<a href="{{url ('seguridad/segrol')}}" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
				<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar</button>
			</div>
		</div>
	</div>
</div>
{!!Form::close()!!}
@endsection
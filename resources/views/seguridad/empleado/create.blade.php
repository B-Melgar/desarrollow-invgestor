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

	{!! Form::open(array('url' => 'seguridad/empleado', 'method' => 'POST', 'autocomplete'=>'off')) !!}
	{{Form::token()}}
	@csrf

<div class="form-row">			
	<div class="form-group col-md-6">
		<div class="page-header">
			<h3>Nuevo</h3>
		</div>
		<div class="box-body">
			<div class="form-group col-md-6">
				<label for="nombre">Nombres</label>
				<input type="text" name="nombres" class="form-control" value="{{old('nombres')}}" placeholder="" required>
			</div>
            <div class="form-group col-md-6">
				<label for="nombre">Apellidos</label>
				<input type="text" name="apellidos" class="form-control" value="{{old('apellidos')}}" placeholder="" required>
			</div>
            <div class="form-group col-md-6">
				<label for="nombre">Direcci&oacute;n</label>
                <textarea type="text" name="direccion" class="form-control" value="{{old('direccion')}}" placeholder="" rows="2" cols="50" required></textarea>
			</div>
            <div class="form-group col-md-6">
				<label for="nombre">Tel&eacute;fono</label>
				<input type="text" name="telefono" class="form-control" value="{{old('telefono')}}" placeholder="" required>
			</div>
            <div class="form-group col-md-6">
				<label for="nombre">Correo</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="correo" value="{{ old('correo') }}" autocomplete="email" required>
			</div>
			<div class="form-group col-md-12">
				<a href="{{url ('seguridad/empleado')}}" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
				<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar</button>
			</div>
		</div>
	</div>
</div>
{!!Form::close()!!}
@endsection
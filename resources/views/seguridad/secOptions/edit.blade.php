@extends ('layouts.admin')
@section ('contenido') 
@inject('menus', 'App\Services\secMenuService')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">


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

<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function() {
		//document.getElementById('idrol').disabled = true;
		//document.getElementById('users_id').disabled = true;
	});
</script>


	{!! Form::model ($secOptions, ['method'=>'PATCH','route'=>['secOptions.update',$secOptions->idOption]])!!}
	{{Form::token()}}
	@csrf
<div class="form-row">			
	<div class="form-group col-md-6">
		<div class="page-header">
			<h3>Modificar Opci&oacute;n</h3> 
</div>
		<div class="box-body">
        <div class="form-group col-md-6">
        		<label for="idMenu">Menu</label>
                	<div>
                    	<select id="idMenu" name="idMenu" class="form-control{{ $errors->has('idMenu') ? ' is-invalid' : '' }}" required>
                        @foreach($menus->get() as $indexMenu => $menu)
                        <option value="{{  $indexMenu }}" {{ $secOptions->idMenu == $indexMenu  ? 'selected' : '' }}>
                        {{ $menu }}
                        </option>
                        @endforeach
                    	</select>

                    	@if ($errors->has('idMenu'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('idMenu') }}</strong>
                        </span>
                   		@endif
                	</div>
        	</div>
			<div class="form-group col-md-6">
				<label for="DescriptionOption">Descripci&oacute;n</label>
				<input type="text" name="DescriptionOption" class="form-control" value="{{ $secOptions->DescriptionOption }}" placeholder="Descripción" required>
			</div>
			<div class="form-group col-md-6">
				<label for="RouteOption">Ruta</label>
				<input type="text" name="RouteOption" class="form-control" value="{{ $secOptions->RouteOption }}" placeholder="Ruta">
			</div>
			<div class="form-group col-md-6">
				<label for="IconOption">Icono</label>
				<input type="text" name="IconOption" class="form-control" value="{{ $secOptions->IconOption }}" placeholder="Icono">
			</div>
			<div  class="form-group col-md-12">
				<a href="{{url ('security/secOptions')}}" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
				<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar</button>
			</div>
		</div>
	</div>
</div>
{!!Form::close()!!}
@endsection
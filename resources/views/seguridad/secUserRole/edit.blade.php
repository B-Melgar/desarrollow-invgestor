@extends ('layouts.admin')
@section ('contenido') 
@inject('roles', 'App\Services\segrolService')
@inject('usuarios', 'App\Services\segusuarioService')

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


	{!! Form::model ($segusuariorol, ['method'=>'PATCH','route'=>['segusuariorol.update',$segusuariorol->idUserRole]])!!}
	{{Form::token()}}
	@csrf
<div class="form-row">			
	<div class="form-group col-md-6">
		<div class="page-header">
			<h3>Modificar Rol - Usuario</h3> 
</div>
		<div class="box-body">
        <div class="form-group col-md-6">
        		<label for="idrol">Rol</label>
                	<div>
                    	<select id="idrol" name="idrol" class="form-control{{ $errors->has('idrol') ? ' is-invalid' : '' }}" readonly  required>
                        @foreach($roles->get() as $indexRol => $rol)
                        <option value="{{  $indexRol }}" {{ $segusuariorol->idrol == $indexRol  ? 'selected' : '' }}>
                        {{ $rol }}
                        </option>
                        @endforeach
                    	</select>

                    	@if ($errors->has('idrol'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('idrol') }}</strong>
                        </span>
                   		@endif
                	</div>
        	</div>

			<div class="form-group col-md-6">
        	<label for="users_id">Usuario</label>
                <div>
                    <select id="users_id" name="users_id" class="form-control{{ $errors->has('users_id') ? ' is-invalid' : '' }}" readonly required>
                         @foreach($usuarios->get() as $indexUsuario => $usuario)
						 <option value="{{  $indexUsuario }}" {{ $segusuariorol->users_id = $indexUsuario ? 'selected' : '' }}>
                                {{ $usuario }}
                            </option>
                        @endforeach
                    </select>

                    @if ($errors->has('users_id'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('users_id') }}</strong>
                        </span>
                    @endif
                </div>
        	</div>

			<div class="form-group col-md-6">
				<label for="startDate">Fecha Inicio</label>
				<input type="date" name="startDate" class="form-control" value="{{ $segusuariorol->startDate }}" placeholder="Año-Mes-Día" readonly required>
			</div>
			<div class="form-group col-md-6">
				<label for="endDate">Fecha Fin</label>
				<input type="date" name="endDate" class="form-control" value="{{ $segusuariorol->endDate }}" placeholder="Año-Mes-Día">
			</div>
			<div class="form-group col-md-6">
				<label for="Active">Activo</label>
				<input type="checkbox" name="Active" class="" @if(old('Active', $segusuariorol->Active)) checked @endif>
			</div>
			<div  class="form-group col-md-12">
				<a href="{{url ('security/segusuariorol')}}" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
				<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar</button>
			</div>
		</div>
	</div>
</div>
{!!Form::close()!!}
@endsection
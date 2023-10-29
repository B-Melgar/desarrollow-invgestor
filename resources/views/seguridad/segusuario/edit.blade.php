@extends ('layouts.admin')
@section ('contenido') 
@inject('empleados', 'App\Services\empleadoservicio')
@inject('roles', 'App\Services\segrolservicio')
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<h3>Modificar Usuario: {{$segusuario->email}}</h3> 

		@if (count($errors)>0)
		<div class="alert alert-danger">
			<ul>
			@foreach ($errors->all() as $error)
				<li>{{$error}}</li>
			@endforeach
			</ul>
		</div>
		@endif

		

		{!! Form::model ($segusuario, ['method'=>'PATCH','route'=>['segusuario.update',$segusuario->id]])!!}
		{{Form::token()}}
		@csrf

		<div class="form-group col-md-6">
        			<label for="categoria">Rol</label>
					<div>
                    	<select id="categoria" name="idrol" class="form-control{{ $errors->has('idrol') ? ' is-invalid' : '' }}" required>
                         	@foreach($roles->get() as $index => $role)
                            <option value="{{  $index }}" {{ $segusuario->idrol == $index ? 'selected' : '' }}>
                                {{ $role }}
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
			<label for="password">{{ __('Contraseña') }}</label>
			<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{$segusuario->password}}" required autocomplete="new-password" required>

				@error('password')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
		</div>
		<div class="form-group col-md-6">
			<label for="password-confirm">{{ __('Confirmar contraseña') }}</label>
			<input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{$segusuario->password}}" required autocomplete="new-password" required>
		</div>

		<div>
			<a href="{{url ('security/segusuario')}}" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
			<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar </button>
		</div>

		{!!Form::close()!!}

	</div>
</div>
@endsection
@extends ('layouts.admin')
@section ('contenido') 
@inject('empleados', 'App\Services\empleadoservicio')
@inject('roles', 'App\Services\segrolservicio')
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<h3>Nuevo Usuario</h3>

		@if (count($errors)>0)
		<div class="alert alert-danger">
			<ul>
			@foreach ($errors->all() as $error)
				<li>{{$error}}</li>
			@endforeach
			</ul>
		</div>
		@endif

		{!! Form::open(array('url'=>'seguridad/segusuario', 'method'=> 'POST', 'autocomplete'=>'off'))!!}
		{{Form::token()}}
		@csrf
		<div class="form-group col-md-6">
        	<label for="categoria">Empleado</label>
                <div>
                    <select id="categoria" name="idempleado" class="form-control{{ $errors->has('idempleado') ? ' is-invalid' : '' }}" required>
                         @foreach($empleados->get() as $index => $empleado)
                            <option value="{{ $index }}" {{ old('idempleado') == $index ? 'selected' : '' }}>
                                {{ $empleado }}
                            </option>
                        @endforeach
                    </select>

                    @if ($errors->has('idempleado'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('idempleado') }}</strong>
                        </span>
                    @endif
                </div>
        </div>
		<div class="form-group col-md-6">
        	<label for="role">Rol</label>
                <div>
                    <select id="role" name="idrol" class="form-control{{ $errors->has('idrol') ? ' is-invalid' : '' }}" required>
                         @foreach($roles->get() as $index => $role)
                            <option value="{{ $index }}" {{ old('idrol') == $index ? 'selected' : '' }}>
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
			<label for="email">{{ __('Correo electronico') }}</label>
			<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" required>

				@error('email')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
		</div>

		<div class="form-group col-md-6">
			<label for="password">{{ __('Contraseña') }}</label>
			<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" required>

				@error('password')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
		</div>

		<div class="form-group col-md-6">
			<label for="password-confirm">{{ __('Confirmar contraseña') }}</label>
				<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" required>
		</div>

		<div>
			<a href="{{url ('security/segusuario')}}" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
			<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar </button>
		</div>

		{!!Form::close()!!}

	</div>
</div>
@endsection
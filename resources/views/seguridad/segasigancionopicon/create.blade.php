@extends ('layouts.admin')
@section ('contenido') 
@inject('roles', 'App\Services\segrolService')
@inject('options', 'App\Services\secOptionsService')
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
<script type="text/javascript">
	// document.addEventListener('DOMContentLoaded', function() {
	// 	$(this).find('input[type="checkbox"]').prop('checked', true);
	// });
</script>

	{!! Form::open(array('url' => 'security/secAssignmentOption', 'method' => 'POST', 'autocomplete'=>'off')) !!}
	{{Form::token()}}
	@csrf

<div class="form-row">			
	<div class="form-group col-md-6">
		<div class="page-header">
			<h3>Asignación Rol - Opci&oacute;n</h3>
		</div>
		<div class="box-body">
			<div class="form-group col-md-6">
        		<label for="idrol">Rol</label>
                	<div>
                    	<select id="idrol" name="idrol" class="form-control{{ $errors->has('idrol') ? ' is-invalid' : '' }}" required>
                        @foreach($roles->get() as $indexRol => $rol)
                        <option value="{{ $indexRol }}" {{ old('idrol') == $indexRol ? 'selected' : '' }}>
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
        	<label for="idOption">Opci&oacute;n</label>
                <div>
                    <select id="idOption" name="idOption" class="form-control{{ $errors->has('idOption') ? ' is-invalid' : '' }}" required>
                         @foreach($options->get() as $index => $option)
                            <option value="{{ $index }}" {{ old('idOption') == $index ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>

                    @if ($errors->has('idOption'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('idOption') }}</strong>
                        </span>
                    @endif
                </div>
        	</div>
			<div class="form-group col-md-12">
				<a href="{{url ('security/secAssignmentOption')}}" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
				<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar</button>
			</div>
		</div>
	</div>
</div>
{!!Form::close()!!}
@endsection
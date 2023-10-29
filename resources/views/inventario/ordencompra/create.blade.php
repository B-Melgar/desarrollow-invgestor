@extends ('layouts.admin')
@section ('contenido') 
@inject('empleados', 'App\Services\empleadoservicio')
@inject('proveedores', 'App\Services\proveedorservicio')
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
	document.addEventListener('DOMContentLoaded', function(){
	});
</script>

	{!! Form::open(array('url' => 'inventario/ordencompra', 'method' => 'POST', 'autocomplete'=>'off', 'files'=>'true')) !!}
	{{Form::token()}}
	@csrf

	<!-- <input class="getinfo"></input>
    <div class="writeinfo"></div>    -->
<div class="">			
	<div class="form-group col-md-12">
		<div class="page-header">
			<h3>Orden Compra</h3>
		</div>
		<div class="">
		<table>
			<tr>
				<td><div>DATOS GENERALES</div></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>
					<div class="form-group col-md-12">
        				<label for="categoria">Proveedor</label>
						<div>
                    	<select id="_proveedor" name="idproveedor" class="form-control{{ $errors->has('idproveedor') ? ' is-invalid' : '' }}" required>
                         	@foreach($proveedores->get() as $index => $proveedor)
                            <option value="{{  $index }}" {{ old('idproveedor') == $index  ? 'selected' : '' }}>
                                {{ $proveedor }}
                            </option>
                        	@endforeach
                    	</select>

                    	@if ($errors->has('idproveedor'))
                        	<span class="invalid-feedback" role="alert">
                        	<strong>{{ $errors->first('idproveedor') }}</strong>
                        	</span>
                   		 @endif
                		</div>
        			</div>
				</td>
				<td>
					<div class="form-group col-md-12">
        				<label for="categoria">Empleado</label>
						<div>
                    	<select id="_empleado" name="idempleado" class="form-control{{ $errors->has('idempleado') ? ' is-invalid' : '' }}" required>
                         	@foreach($empleados->get() as $index => $empleado)
                            <option value="{{  $index }}" {{ old('idempleado') == $index  ? 'selected' : '' }}>
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
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Total</label>
						<input type="number" name="total" class="form-control" value="{{old('total')}}" placeholder="0.00" disabled>
					</div>
				</td>
			</tr>
		</table>
		</div>
	</div>
	<div class="form-group col-md-12">
		<a href="{{url ('inventario/ordencompra')}}" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
		<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar</button>
	</div>
</div>
{!!Form::close()!!}
@endsection

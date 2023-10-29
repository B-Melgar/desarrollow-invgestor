@extends ('layouts.admin')
@section ('contenido') 
@inject('tipostransaccion', 'App\Services\tipotransaccionservicio')
@inject('empleados', 'App\Services\empleadoservicio')
@inject('proveedores', 'App\Services\proveedorservicio')
@inject('clientes', 'App\Services\clienteservicio')
@inject('estadostransaccion', 'App\Services\estadotransaccionservicio')

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
	window.addEventListener("load", function(){

	});

	document.addEventListener('DOMContentLoaded', function(){
	});

</script>

	{!! Form::model ($transaccion, ['method'=>'PATCH','route'=>['transaccioncompra.update',$transaccion->idtransaccion], 'files'=>'true'])!!}
	{{Form::token()}}
	@csrf

	<div class="writeinfo"></div>
<div class="form-row">			
	<div class="form-group col-md-12">
		<div class="page-header">
			<h3>Modificar</h3> 
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
        				<label for="categoria">Categoria</label>
						<div>
                    	<select id="_proveedor" name="idproveedor" class="form-control{{ $errors->has('idproveedor') ? ' is-invalid' : '' }}" required disabled>
                         	@foreach($proveedores->get() as $indexProveedor => $proveedor)
                            <option value="{{  $indexProveedor }}" {{ $transaccion->idproveedor == $indexProveedor ? 'selected' : '' }}>
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
        			</div>
				</td>
				<td>
					<div class="form-group col-md-12">
        				<label for="Empleado">Empleado</label>
						<div>
                    	<select id="_empleado" name="idempleado" class="form-control{{ $errors->has('idempleado') ? ' is-invalid' : '' }}" required disabled>
                         	@foreach($empleados->get() as $indexEmpleado => $empleado)
                            <option value="{{  $indexEmpleado }}" {{ $transaccion->idempleado == $indexEmpleado ? 'selected' : '' }}>
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
        			</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Total</label>
						<input type="number" name="total" class="form-control" value="{{$transaccion->total}}" placeholder="" requerid disabled>
					</div>
				</td>
				<td>
				<td>
					<div class="form-group col-md-12">
        				<label for="Estado">Estado</label>
						<div>
                    	<select id="_estadotransaccion" name="idestadotransaccion" class="form-control{{ $errors->has('idestadotransaccion') ? ' is-invalid' : '' }}" required>
                         	@foreach($estadostransaccion->get() as $indexEstadoT => $estadotransaccion)
                            <option value="{{  $indexEstadoT }}" {{ $transaccion->idestadotransaccion == $indexEstadoT ? 'selected' : '' }}>
                                {{ $estadotransaccion }}
                            </option>
                        	@endforeach
                    	</select>

                    	@if ($errors->has('idestadotransaccion'))
                        	<span class="invalid-feedback" role="alert">
                        	<strong>{{ $errors->first('idestadotransaccion') }}</strong>
                        	</span>
                   		 @endif
                		</div>
        				</div>
        			</div>
				</td>
				</td>
			</tr>
			<tr>
		
		</table>
		</div>
	</div>
	<div  class="form-group col-md-12">
		<a href="{{url ('inventario/transaccioncompra')}}" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
		<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar</button>
	</div>
</div>
{!!Form::close()!!}
@endsection
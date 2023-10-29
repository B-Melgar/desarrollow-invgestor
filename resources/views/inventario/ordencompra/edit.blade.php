@extends ('layouts.admin')
@section ('contenido') 
@inject('empleados', 'App\Services\empleadoservicio')
@inject('proveedores', 'App\Services\proveedorservicio')
@inject('clientes', 'App\Services\clienteservicio')

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

	{!! Form::model ($ordencompra, ['method'=>'PATCH','route'=>['ordencompra.update',$ordencompra->idordencompra], 'files'=>'true'])!!}
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
        				<label for="categoria">Proveedor</label>
						<div>
                    	<select id="idempleado" name="idproveedor" class="form-control{{ $errors->has('idproveedor') ? ' is-invalid' : '' }}" required >
                         	@foreach($proveedores->get() as $indexPro => $proveedor)
                            <option value="{{  $indexPro }}" {{ $ordencompra->idproveedor == $indexPro ? 'selected' : '' }}>
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
                    	<select id="idempleado" name="idempleado" class="form-control{{ $errors->has('idempleado') ? ' is-invalid' : '' }}" required >
                         	@foreach($empleados->get() as $indexEmpleado => $empleado)
                            <option value="{{  $indexEmpleado }}" {{ $ordencompra->idempleado == $indexEmpleado ? 'selected' : '' }}>
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
						<input type="number" name="total" class="form-control" value="{{$ordencompra->total}}" placeholder="" requerid disabled>
					</div>
				</td>
				<td>
				<td>
					
				</td>
				</td>
			</tr>
			<tr>
		
		</table>
		</div>
	</div>
	<div  class="form-group col-md-12">
		<a href="{{url ('inventario/ordencompra')}}" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
		<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar</button>
	</div>
</div>
{!!Form::close()!!}
@endsection
@extends ('layouts.admin')
@section ('contenido') 
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
		$("#txtdiascredito").attr("disabled", "disabled"); 
  		$('#ckCredito').change(function() {
			if ($('#ckCredito').is(":checked")) {
        		$("#txtdiascredito").removeAttr("disabled"); 
				$("#txtdiascredito").focus();
    		} else {
				$("#txtdiascredito").attr("disabled", "disabled"); 
				$("#txtdiascredito").val('');

    		}  
		});
	});
</script>

	{!! Form::model ($proveedor, ['method'=>'PATCH','route'=>['proveedor.update',$proveedor->idproveedor]])!!}
	{{Form::token()}}
	@csrf
<div class="form-row">			
	<div class="form-group col-md-12">
		<div class="page-header">
			<h3>Modificar Proveedor</h3> 
		</div>	

		<div class="">
			
		<table>
			<tr>
				<td>
					<div class="labelDetalles">DATOS GENERALES</div>
				</td>
				<td>
				</td>
				<td>
				</td>
			<td>
			<tr>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">NIT</label>
						<input type="text" id="nit" name="nit" class="form-control" value="{{$proveedor->nit}}" placeholder="NIT" required>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Nombre</label>
						<textarea type="text" name="nombreproveedor" class="form-control" value="{{$proveedor->nombreproveedor}}" placeholder="Nombre" rows="2" cols="35" required>{{$proveedor->nombreproveedor}}</textarea>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Direcci&oacute;n</label>
						<textarea  type="text" name="direccion" class="form-control" value="{{$proveedor->direccion}}" placeholder="Dirección" rows="2" cols="35" required>{{$proveedor->direccion}}</textarea>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Tel&eacute;fono</label>
						<input type="text" name="telefono" class="form-control" value="{{$proveedor->telefono}}" placeholder="Teléfono" required>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Correo</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="correo" value="{{ $proveedor->correo }}" autocomplete="email" required>
					</div>
				
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Cr&eacute;dito</label>
						<table>
							<tr>
								<td>
									<input type="checkbox" id="ckCredito" name="credito" class="" @if(old('credito', $proveedor->credito)) checked @endif>
								</td>
								<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td>
									<input type="text" id="txtdiascredito" name="diascredito" class="form-control" value="{{$proveedor->diascredito}}" placeholder="No. Días Crédito">
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>

			<div  class="form-group col-md-12">
				<a href="{{url ('inventario/proveedor')}}" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>	
				<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar</button>
				
			</div>
		</div>
	</div>
</div>
{!!Form::close()!!}
@endsection
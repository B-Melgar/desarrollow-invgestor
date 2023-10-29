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

	{!! Form::model ($cliente, ['method'=>'PATCH','route'=>['cliente.update',$cliente->idcliente]])!!}
	{{Form::token()}}
	@csrf
<div class="form-row">			
	<div class="form-group col-md-12">
		<div class="page-header">
			<h3>Modificar cliente</h3> 
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
						<input type="text" id="nit" name="nit" class="form-control" value="{{$cliente->nit}}" placeholder="NIT" required>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Nombre</label>
						<textarea type="text" name="nombrecliente" class="form-control" value="{{$cliente->nombrecliente}}" placeholder="Nombre" rows="2" cols="35" required>{{$cliente->nombrecliente}}</textarea>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Direcci&oacute;n</label>
						<textarea  type="text" name="direccion" class="form-control" value="{{$cliente->direccion}}" placeholder="Dirección" rows="2" cols="35" required>{{$cliente->direccion}}</textarea>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Tel&eacute;fono</label>
						<input type="text" name="telefono" class="form-control" value="{{$cliente->telefono}}" placeholder="Teléfono" required>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Correo</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="correo" value="{{ $cliente->correo }}" autocomplete="email" required>
					</div>
				
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Cr&eacute;dito</label>
						<table>
							<tr>
								<td>
									<input type="checkbox" id="ckCredito" name="credito" class="" @if(old('credito', $cliente->credito)) checked @endif>
								</td>
								<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td>
									<input type="text" id="txtdiascredito" name="diascredito" class="form-control" value="{{$cliente->diascredito}}" placeholder="No. Días Crédito">
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>

			<div  class="form-group col-md-12">
				<a href="{{url ('inventario/cliente')}}" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>	
				<button class="btn btn-secondary" type="submit"><i class="fa fa-save"></i> Guardar</button>
				
			</div>
		</div>
	</div>
</div>
{!!Form::close()!!}
@endsection
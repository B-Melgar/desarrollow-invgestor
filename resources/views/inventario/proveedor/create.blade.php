@extends ('layouts.admin')
@section ('contenido') 
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
	document.addEventListener('DOMContentLoaded', function() {
		$("#txtdiascredito").attr("disabled", "disabled"); 
  		$('#ckCredito').change(function() {
			//var val = $('#credito').data('value');
			//alert("Hola");
     		//var val = $(this).data('value');
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

	{!! Form::open(array('url' => 'inventario/proveedor', 'method' => 'POST', 'autocomplete'=>'off')) !!}
	{{Form::token()}}
	@csrf

<div class="">			
	<div class="form-group col-md-12">
		<div class="page-header">
			<h3>Nuevo Proveedor</h3>
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
						<input type="text" id="nit" name="nit" class="form-control" value="{{old('nit')}}" placeholder="" required>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Nombre</label>
						<textarea type="text" name="nombreproveedor" class="form-control" value="{{old('nombreproveedor')}}" placeholder="" rows="2" cols="35" required></textarea>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Direcci&oacute;n</label>
						<textarea  type="text" name="direccion" class="form-control" value="{{old('direccion')}}" placeholder="" rows="2" cols="35" required></textarea>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Tel&eacute;fono</label>
						<input type="text" name="telefono" class="form-control" value="{{old('telefono')}}" placeholder="" required>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Correo</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="correo" value="{{ old('email') }}" autocomplete="email" required>
					</div>
					<!-- <div class="form-group col-md-6">
						<label for="nombre">Cr&eacute;dito</label>
						<input type="checkbox" name="credit" class="" value="{{old('credit')}}">
					</div> -->
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Cr&eacute;dito</label>
						<table>
							<tr>
								<td>
									<input type="checkbox" id="ckCredito" name="credito" class="" value="{{old('credito')}}">		
								</td>
								<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td>
									<input type="text" id="txtdiascredito" name="diascredito" class="form-control" value="{{old('diascredito')}} " placeholder="No. Días Crédito" >
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
			<div class="form-group col-md-12">
				<a href="{{url ('inventario/proveedor')}}" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
				<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar</button>
			</div>
		</div>
	</div>
</div>
{!!Form::close()!!}
@endsection
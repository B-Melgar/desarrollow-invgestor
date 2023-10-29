@extends ('layouts.admin')
@section ('contenido') 
@inject('categorias', 'App\Services\categoriaservicio')
@inject('subcategorias', 'App\Services\subcategoriaservicio')

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
	
 document.addEventListener("onload", function(){
	var str,
	element = document.getElementById('subcategoria');
	if (element != null) {
    	str = element.value;
	}else{
    	str = null;
	}
	//alert("str: " + str);
});

window.addEventListener("load", function(){
	//document.getElementById("compras").value = 25;	
	var str,
	element = document.getElementById('subcategoria');
	if (element != null) {
    	str = element.value;
	}else{
    	str = null;
	}
	//alert("str: " + str);
	//var valsubcat = document.getElementById("subcategoria").value
	//alert("sub categoria:" + vasubcat);
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	var idcategoria = document.getElementById("_categoria").value;
				var valor = $(".getinfo").val();
                $.ajax({
                    url: '/postajax',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN, message:idcategoria},
                    dataType: 'JSON',
                    success: function (data) { 
						console.log(data);
							var opciones = "<option value=''>Seleccionar</option>";
							for (let i in data.lista){
								opciones += '<option value="'+ data.lista[i].idsubcategoria +'">'+ data.lista[i].descripcionsubcategoria +'</option>'
							}
							document.getElementById("_subcategoria").innerHTML = opciones;
							
							//document.getElementById("_subcategoria").value = valsubcat;
							if (data.lista.length > 0) {
								$("#_subcategoria").show();; 
								$("#_subcategoria").focus();
							} else {
								$("#_subcategoria").hide(); 
								$("#estado").focus();
    						} 
                    }
                }); 
});

function cambiarFile(){
    const input = document.getElementById('photo');
    	if(input.files && input.files[0])
		var tmppath = URL.createObjectURL(input.files[0]);
		var myPhoto = document.getElementById("photoproducto").src= tmppath; 
		var height = document.getElementById("photoproducto").clientHeight;
		var width = document.getElementById("photoproducto").clientWidth;
	}


	document.addEventListener('DOMContentLoaded', function(){
		var str,
	element = document.getElementById('subcategoria');
	if (element != null) {
    	str = element.value;
	}else{
    	str = null;
	}
	//alert("str: DOMLoaded " + str);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			$("#_subcategoria").hide(); 
			$('#_categoria').change(function() {
				var idcategoria = $(this).val();
				var valor = $(".getinfo").val();
                $.ajax({
                    url: '/postajax',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN, message:idcategoria},
                    dataType: 'JSON',
                    success: function (data) { 
						console.log(data);
							var opciones = "<option value=''>Seleccionar</option>";
							for (let i in data.lista){
								opciones += '<option value="'+ data.lista[i].idsubcategoria +'">'+ data.lista[i].descripcion +'</option>'
							}
							document.getElementById("_subcategoria").innerHTML = opciones;
							if (data.lista.length > 0) {
								$("#_subcategoria").show();; 
								$("#_subcategoria").focus();
							} else {
								$("#_subcategoria").hide(); 
								$("#estado").focus();
    						} 
                    }
                }); 
            });
		});
</script>

	{!! Form::model ($producto, ['method'=>'PATCH','route'=>['producto.update',$producto->idproducto], 'files'=>'true'])!!}
	{{Form::token()}}
	@csrf

	<div class="writeinfo"></div>
<div class="form-row">			
	<div class="form-group col-md-12">
		<div class="page-header">
			<h3>Modificar Producto</h3> 
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
						<label for="nombre">C&oacute;digo</label>
						<input type="text" name="codigoproducto" class="form-control" value="{{$producto->codigoproducto}}" placeholder="" required>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Descripci&oacute;n</label>
						<textarea  type="text" name="descripcionproducto" class="form-control" value="{{$producto->descripcionproducto}}" placeholder="" rows="2" cols="35" required>{{$producto->descripcionproducto}}</textarea>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Precio Costo</label>
						<input type="text" name="preciocosto" class="form-control" value="{{$producto->preciocosto}}" placeholder="" required>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Precio Venta</label>
						<input type="text" name="precioventa" class="form-control" value="{{$producto->precioventa}}" placeholder="" required>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Compras</label>
						<input type="number" name="compras" class="form-control" value="{{$producto->compras}}" placeholder="" required>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Ventas</label>
						<input type="number" name="ventas" class="form-control" value="{{$producto->ventas}}" placeholder="" required>
					</div>
				</td>
				<td>
					<div class="form-group col-md-12">
						<label for="nombre">Existencia</label>
						<input type="number" name="existencia" class="form-control" value="{{$producto->existencia}}" placeholder="" required>
					</div>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>
					<div class="form-group col-md-12">
        				<label for="categoria">Categoria</label>
						<div>
                    	<select id="_categoria" name="idcategoria" class="form-control{{ $errors->has('idcategoria') ? ' is-invalid' : '' }}" required>
                         	@foreach($categorias->get() as $indexCategory => $categoria)
                            <option value="{{  $indexCategory }}" {{ $producto->idcategoria == $indexCategory ? 'selected' : '' }}>
                                {{ $categoria }}
                            </option>
                        	@endforeach
                    	</select>

                    	@if ($errors->has('idcategoria'))
                        	<span class="invalid-feedback" role="alert">
                        	<strong>{{ $errors->first('idcategoria') }}</strong>
                        	</span>
                   		 @endif
                		</div>
        			</div>
        	</div>
				</td>
				<td>
					<div class="form-group col-md-12">
        				<label for="_subcategoria">Sub Categoria</label>
                		<div>
                    		<select id="_subcategoria" name="idsubcategoria" class="form-control{{ $errors->has('idsubcategoria') ? ' is-invalid' : '' }}"></select>
                    		@if ($errors->has('idsubcategoria'))
                        	<span class="invalid-feedback" role="alert">
                        	<strong>{{ $errors->first('idsubcategoria') }}</strong>
                        	</span>
                    		@endif
                		</div>
        			</div>
				</td>
				
				<td>
					
				</td>
			</tr>
			<tr>
			<td>
					<div class="form-group col-md-12">
						<label for="photo">Foto</label>
						@if (($producto->photo) !="")
						<input type="file" id="photo" name="photo" class="" value="{{$producto->photo}}" accept="image/*" onchange="return cambiarFile();">
						@else
						<input type="file" id="photo" name="photo" class="" >
						@endif
					</div>
				</td>
				
				<td><input id="subcaterogia" class="getinfo" style="visibility:hidden;" value="{{$producto->idsubcategoria}}"></td>
				<td></td>
				<td>
					<div class="form-group col-md-1">
							@if (($producto->photo) !="")
								<img id="photoproducto" src="{{$producto->photo}}" width="200px"> 
							@endif
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
		</div>
	</div>
	<div  class="form-group col-md-12">
		<a href="{{url ('inventario/producto')}}" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
		<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar</button>
	</div>
</div>
{!!Form::close()!!}
@endsection
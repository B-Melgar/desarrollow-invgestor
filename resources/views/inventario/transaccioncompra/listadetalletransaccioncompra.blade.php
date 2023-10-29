@extends ('layouts.admin')
@section ('contenido') 
@inject('productos', 'App\Services\productoservicio')
<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function(){
		var label = document.getElementById('resultado');
		label.textContent = '';
		document.getElementById('resultado').style.visibility='hide';

		$("#btnAgregarProducto").click(function(){
			var label = document.getElementById('resultado');
			label.textContent = '';
			document.getElementById('resultado').style.visibility='hide';
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

			var strtransaccion;
			idtransaccion = document.getElementById('idtransaccion');
			if (idproducto != null) {
    			strtransaccion = idtransaccion.value;
			}else{
    			strtransaccion = 0;
			}
			var strproducto;
			idproducto = document.getElementById('idproducto');
			if (idproducto != null) {
    			strproducto = idproducto.value;
			}else{
    			strproducto = 0;
			}
			var strcantidad;
			cantidad = document.getElementById('cantidad');
			if (cantidad != null) {
    			strcantidad = cantidad.value;
			}else{
    			strcantidad = 0;
			}
			var strprecio;
			precio = document.getElementById('precio');
			if (precio != null) {
    			strprecio = precio.value;
			}else{
    			strprecio = 0;
			}
		
			if(strproducto > 0 && strcantidad > 0 && strprecio > 0){
				var subtotal = strcantidad * strprecio;
                $.ajax({
                    url: '/postdetallecompra',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN, idtransaccion:strtransaccion, idproducto:strproducto, cantidad:strcantidad, precio:strprecio, subtotal:subtotal},
                    dataType: 'JSON',
                    success: function (data) { 
						console.log(data);
						console.log("hola");
						for (let i in data.lista){
                            alert(data.fechatransaccion);
				        }
                    }
                }); //FIN AJAX
				var url = "../listadetalletransaccioncompra/" + strtransaccion;
                window.location.href = url;
				var label = document.getElementById('resultado');
				label.textContent = 'Se agrego correctamente el producto!!!!';
				document.getElementById('resultado').style.visibility='visible';
				document.getElementById('resultado').style.color ='green';
            }else{
				alert("Falta un dato para agregar producto");
			};
            
        }); //FIN BOTON AGREGAR PRODUCTO          
		
		$("#btnQuitarProducto").click(function(){
			var label = document.getElementById('resultado');
			label.textContent = '';
			document.getElementById('resultado').style.visibility='hide';
			var strtransaccion;
			idtransaccion = document.getElementById('idtransaccion');
			if (idproducto != null) {
    			strtransaccion = idtransaccion.value;
			}else{
    			strtransaccion = 0;
			}
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			$(".table tbody tr").each(function(){
				var isCkecked = $(this).find('input[type="checkbox"]').is(':checked');
				var tableSize = $(".table tbody tr").length;
				var iddetalletransaccion = 0;
				if(isCkecked){
					var iddetalletransaccion = $(this).find('input[type="checkbox"]').val();
					//alert("id seleccionado: " + iddetalletransaccion);
					$.ajax({
                    	url: '/postquitardetallecompra',
                    	type: 'POST',
                    	data: {_token: CSRF_TOKEN, iddetalletransaccion:iddetalletransaccion},
                    	dataType: 'JSON',
                    	success: function (data) { 
							console.log(data);
							console.log("hola");
							for (let i in data.lista){
                            	alert(data.fechatransaccion);
				        	}
                    	}
                	}); //FIN AJAX
					var url = "../listadetalletransaccioncompra/" + strtransaccion;
                	window.location.href = url;
					var label = document.getElementById('resultado');
					label.textContent = 'Se quitaron correctamente los productos seleccionados!!!!';
					document.getElementById('resultado').style.visibility='visible';
					document.getElementById('resultado').style.color ='green';
				}
			});
		}); //FIN BOTON QUITAR PRODUCTO      
		
		$("#btnAplicar").click(function(){
			var label = document.getElementById('resultado');
			label.textContent = '';
			document.getElementById('resultado').style.visibility='hide';
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

			var strtransaccion;
			idtransaccion = document.getElementById('idtransaccion');
			if (idproducto != null) {
    			strtransaccion = idtransaccion.value;
			}else{
    			strtransaccion = 0;
			}
                $.ajax({
                    url: '/postaplicardetallecompra',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN, idtransaccion:strtransaccion},
                    dataType: 'JSON',
                    success: function (data) { 
						console.log(data);
						console.log("hola");
						for (let i in data.lista){
                            alert(data.fechatransaccion);
				        }
                    }
                }); //FIN AJAX
				var url = "../listadetalletransaccioncompra/" + strtransaccion;
                window.location.href = url;
				var label = document.getElementById('resultado');
				label.textContent = 'Compra cargada correctamente!!!!';
				document.getElementById('resultado').style.visibility='visible';
				document.getElementById('resultado').style.color ='green';
            
        }); //FIN BOTON APLICAR PRODUCTO  
		
		$("#btnAnular").click(function(){
			var label = document.getElementById('resultado');
			label.textContent = '';
			document.getElementById('resultado').style.visibility='hide';
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

			var strtransaccion;
			idtransaccion = document.getElementById('idtransaccion');
			if (idproducto != null) {
    			strtransaccion = idtransaccion.value;
			}else{
    			strtransaccion = 0;
			}
                $.ajax({
                    url: '/postanulardetallecompra',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN, idtransaccion:strtransaccion},
                    dataType: 'JSON',
                    success: function (data) { 
						console.log(data);
						console.log("hola");
						for (let i in data.lista){
                            alert(data.fechatransaccion);
				        }
                    }
                }); //FIN AJAX
				var url = "../listadetalletransaccioncompra/" + strtransaccion;
                window.location.href = url;
				var label = document.getElementById('resultado');
				label.textContent = 'Compra anulada correctamente!!!!';
				document.getElementById('resultado').style.visibility='visible';
				document.getElementById('resultado').style.color ='green';
            
        }); //FIN BOTON anular PRODUCTO  

	}); //FIN DOM
</script>

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

        @if(\Session::has('Success'))
		<div class="alert alert-danger">
			<p>{{ $msgbox }}</p>
		</div>
		@endif
        
	</div>
</div>
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<label id="resultado" name="resultado" class="alert alert-danger">
	</div>
</div>

<div>
    <table class="tituloDetalle">
	<tr>
            <td><h2>Proveedor: </h2></td>
            <td><h2>{{$nombreproveedor}}</h2></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><h2></h4></td>
            <td><h2></h2></td>
            <td><h2></h2></td>
        </tr>
        <tr>
			<td><h2>Fecha: </h4></td>
            <td><h2>{{$fechatransaccion}}</h2></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><h2></h4></td>
            <td><h2></h2></td>
            <td><h2></h2></td>
        </tr>
    </table>
	<br>
	<table class="row">
		<tr>
            <td>
				<div class="form-group col-md-12">
        			<label for="producto">Producto</label>
        		</div>
			</td>
            <td>
				<div class="form-group col-md-12">
					<label for="nombre">Cantidad</label>
				</div>
			</td>
            <td>
				<div class="form-group col-md-12">
					<label for="nombre">Precio</label>
				</div>
			</td>
        </tr>
        <tr>
            <td>
				<div class="form-group col-md-12">
					<div>
                    	<select id="idproducto" name="idproducto" class="form-control{{ $errors->has('idproducto') ? ' is-invalid' : '' }}" required>
                         	@foreach($productos->get() as $index => $producto)
                            <option value="{{  $index }}" {{ old('idproducto') == $index  ? 'selected' : '' }}>
                                {{ $producto }}
                            </option>
                        	@endforeach
                    	</select>

                    	@if ($errors->has('idproducto'))
                        	<span class="invalid-feedback" role="alert">
                        	<strong>{{ $errors->first('idproducto') }}</strong>
                        	</span>
                   		 @endif
                	</div>
        		</div>
			</td>
            <td>
				<div class="form-group col-md-12">
					<input type="number" id="cantidad" name="cantidad" class="form-control" value="{{old('cantidad')}}" placeholder="" required>
				</div>
			</td>
            <td>
				<div class="form-group col-md-12">
					<input type="number" id="precio" name="precio" class="form-control" value="{{old('precio')}}" placeholder="" required>
				</div>
			</td>
			<td>
				@if(($idestadotransaccion) == 1)
					<button id="btnAgregarProducto" class= "btn btn-success text-light" title="Regresar">Agregar</button>
				@endif
			</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td>
				@if(($idestadotransaccion) == 1)
					<button id="btnQuitarProducto" class= "btn btn-danger text-light" title="Regresar">Quitar</button>	
				@endif
			</td>
			<td>
				<div class="form-group col-md-12">
					<input type="number" style="visibility:hidden;" id="idtransaccion" name="idtransaccion" class="form-control" value="{{$idtransaccion}}" placeholder="" required>
				</div>
			</td>
        </tr>
    </table>
</div>
<br>
<div class="row">
	<div class = "col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h2>Detalle de Compra  </h2>
	</div>
</div>
<div class="row">
	<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="">	
			<table class ="table table-striped table-bordered table-condensed table-hover">
				<thead class="thead-dark">
					<th class="fondoGrid">Producto</th>
                    <th class="fondoGrid">Cantidad</th>
                    <th class="fondoGrid">Precio</th>
					<th class="fondoGrid">subtotal</th>
					<th class="fondoGrid">Quitar</th>
				</thead>
		
				@foreach ($transacciondetalle as $detalle)
				<tr>
					<td class="table-active">{{$detalle->descripcionproducto}}</td>
					<td class="table-active">{{$detalle->cantidad}}</td>
                    <td class="table-active">{{$detalle->precio}}</td>
					<td class="table-active" style="text-align:right">{{$detalle->subtotal}}</td>
                    <div id="buttonArray" class="">
					<td class="table-active alignButtonGrid">
						<input type="checkbox" id="ckDetalle" class="" value="{{$detalle->iddetalletransaccion}}">
					</td>
                </div>
				</tr>
				@endforeach
			</table>
			Total: {{$transacciondetalle->total()}}
		</div>
		{{$transacciondetalle->render()}}
	</div>
</div>
<br>
<div class="" style="text-align: lefth; width=300">
	<table>
		<tr>
			<td>
				<a href="../inventario/transaccioncompra"><button id="regresarTransaccion" class= "btn btn-secondary text-light" title="Regresar">Regresar</button></a>
			</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td>
				@if(($idestadotransaccion) == 1)
					<button id="btnAplicar" class= "btn btn-success text-light" title="Regresar">Aplicar</button>
				@endif		
			</td>
			<td>
				@if ($idestadotransaccion== 1 || $idestadotransaccion == 2)
					<button id="btnAnular" class= "btn btn-success text-light" title="Regresar">Anular</button>		
				@endif	
			</td>
		</tr>
	</table>
</div>
@endsection
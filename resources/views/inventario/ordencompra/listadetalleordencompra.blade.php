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

			var strordencompra;
			idordencompra = document.getElementById('idordencompra');
			if (idproducto != null) {
    			strordencompra = idordencompra.value;
			}else{
    			strordencompra = 0;
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
                    url: '/postdetalleordencompra',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN, idordencompra:strordencompra, idproducto:strproducto, cantidad:strcantidad, precio:strprecio, subtotal:subtotal},
                    dataType: 'JSON',
                    success: function (data) { 
						console.log(data);
						console.log("hola");
						for (let i in data.lista){
                            alert(data.fechatransaccion);
				        }
                    }
                }); //FIN AJAX
				var url = "../listadetalleordencompra/" + strordencompra;
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
			var strordencompra;
			idordencompra = document.getElementById('idordencompra');
			if (idordencompra != null) {
    			strordencompra = idordencompra.value;
			}else{
    			strordencompra = 0;
			}
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			$(".table tbody tr").each(function(){
				var isCkecked = $(this).find('input[type="checkbox"]').is(':checked');
				var tableSize = $(".table tbody tr").length;
				var iddetalleordencompra = 0;
				if(isCkecked){
					var iddetalleordencompra = $(this).find('input[type="checkbox"]').val();
					$.ajax({
                    	url: '/postquitardetalleordencompra',
                    	type: 'POST',
                    	data: {_token: CSRF_TOKEN, iddetalleordencompra:iddetalleordencompra},
                    	dataType: 'JSON',
                    	success: function (data) { 
							console.log(data);
							console.log("hola");
							for (let i in data.lista){
                            	alert(data.fechaordencompra);
				        	}
                    	}
                	}); //FIN AJAX
					var url = "../listadetalleordencompra/" + strordencompra;
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
                    url: '/aplicarordencompra',
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
				var url = "../listadetalleordencompra/" + strtransaccion;
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
                    url: '/postanulardetalleordencompra',
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
				var url = "../listadetalleordencompra/" + strtransaccion;
                window.location.href = url;
				var label = document.getElementById('resultado');
				label.textContent = 'Compra anulada correctamente!!!!';
				document.getElementById('resultado').style.visibility='visible';
				document.getElementById('resultado').style.color ='green';
            
        }); //FIN BOTON anular PRODUCTO  

		$("#btnImprimirOrden").click(function(){
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			var idordencompra = document.getElementById("idordencompra").value;
			
			if(idordencompra > 0){
			$.ajax({
				type: 'POST',
				url: '/postimprimirordencompra',
				data: {_token: CSRF_TOKEN,idordencompra:idordencompra},
				xhrFields: {
					responseType: 'blob'
				},
				success: function(data){
					console.log(data);
					var blob = new Blob([data]);
					var link = document.createElement('a');
					link.href = window.URL.createObjectURL(blob);
					var tiempo = new Date();
					link.download = "Orden_Compra_" + idordencompra + '_' + tiempo.getTime() + ".pdf";
					link.click();
				},
				error: function(blob){
					var label = document.getElementById('resultado');
						label.textContent = 'No se puede imprimir!!!';
						label.style.visibility='visible';
				}
			});
			}else{
				var label = document.getElementById('resultado');
				label.textContent = 'No se encontro el código de la orden de compra';
				label.style.visibility='visible';
			}
		}); //FIN IMPRIMIR


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
            <td><h2>{{$fechaordencompra}}</h2></td>
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
				<button id="btnAgregarProducto" class= "btn btn-success text-light" title="Regresar">Agregar</button>
			</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td>
					<button id="btnQuitarProducto" class= "btn btn-danger text-light" title="Regresar">Quitar</button>	
			</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td>
				<button id="btnImprimirOrden" class="btn btn-primary"><i class="fa fa-print"></i> Imprimir</button>			
			</td>
			<td>
				<div class="form-group col-md-12">
					<input type="number" style="visibility:hidden;" id="idordencompra" name="idordencompra" class="form-control" value="{{$idordencompra}}" placeholder="" required>
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
		
				@foreach ($ordencompradetalle as $detalle)
				<tr>
					<td class="table-active">{{$detalle->descripcionproducto}}</td>
					<td class="table-active">{{$detalle->cantidad}}</td>
                    <td class="table-active">{{$detalle->precio}}</td>
					<td class="table-active" style="text-align:right">{{$detalle->subtotal}}</td>
                    <div id="buttonArray" class="">
					<td class="table-active alignButtonGrid">
						<input type="checkbox" id="ckDetalle" class="" value="{{$detalle->iddetalleordencompra}}">
					</td>
                </div>
				</tr>
				@endforeach
			</table>
			Total: {{$ordencompradetalle->total()}}
		</div>
		{{$ordencompradetalle->render()}}
	</div>
</div>
<br>
<div class="" style="text-align: lefth; width=300">
	<table>
		<tr>
			<td>
				<a href="../inventario/ordencompra"><button id="regresarTransaccion" class= "btn btn-secondary text-light" title="Regresar">Regresar</button></a>
			</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
	</table>
</div>
@endsection
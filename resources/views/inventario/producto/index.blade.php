@extends ('layouts.admin')
@section ('contenido') 
@inject('categorias', 'App\Services\categoriaservicio')

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
	//Poner invisible botones y caja de texto
	$("#_subcategoria").hide(); 
	
	//Permite seleccionar las subcategorias a partir de la categoria -- Inicia
	$('#_categoria').change(function() {
				//alert("Hola");
				var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
				var idcategoria = $(this).val();
				var valor = $(".getinfo").val();
				$("#idProd").hide(); 
                $.ajax({
                    /* the route pointing to the post function */
                    url: '/postajax',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN, message:idcategoria},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
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
    					} 
                    }
                }); 
            });
	//Permite seleccionar las subcategorias a partir de la categoria -- Finaliza
	});//cierre del DOM
</script>
<div class="row">
	<div class = "col-lg-8 col-md-8 col-sm-8 col-xs-12 titlecatalogos">
		<h2>Productos: </h2> <a href="producto/create"><button class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</button> </a> <h4></h4>
		@include ('inventario.producto.search')
	</div>
</div>

<div class="row">
	<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="">	
			<table class ="table table-striped table-bordered table-condensed table-hover">
				<thead class="thead-dark">
					<th class="fondoGrid">C&oacute;digo</th>
					<th class="fondoGrid">Descripci&oacute;n</th>
					<th class="fondoGrid">Categoria</th>
					<th class="fondoGrid">Sub Categoria</th>
					<th class="fondoGrid">Costo</th>
					<th class="fondoGrid">Precio Venta</th>
					<th class="fondoGrid">Compras</th>
					<th class="fondoGrid">Ventas</th>
					<th class="fondoGrid">Existencia</th>
					<th class="alignButtonGrid">Opciones</th>
				</thead>
		
				@foreach ($producto as $product)
				<tr>
					<td class="table-active">{{$product->codigoproducto}}</td>
					<td class="table-active">{{$product->descripcionproducto}}</td>
					<td class="table-active">{{$product->descripcion}}</td>
					<td class="table-active">{{$product->descripcionsubcategoria}}</td>
					<td class="table-active" style="text-align: right;">{{$product->preciocosto}}</td>
					<td class="table-active" style="text-align: right;">{{$product->precioventa}}</td>
					<td class="table-active" style="text-align: right;">{{$product->compras}}</td>
					<td class="table-active" style="text-align: right;">{{$product->ventas}}</td>
					<td class="table-active" style="text-align: right;">{{$product->existencia}}</td>
					<td class="table-active alignButtonGrid">
						<a href="{{URL::action('productoController@edit', $product->idproducto)}}"><button class="btn btn-outline-primary"><i class="fa fa-pencil"></i></button></a>
						<a href="" data-target="#modal-delete-{{$product->idproducto}}" data-toggle="modal"><button class= "btn btn-outline-danger"><i class="fa fa-close"></i></button></a>
					</td>
				</tr>
				@include('inventario.producto.modal')
				@endforeach
			</table>
			Total: {{$producto->total()}}
		</div>
		{{$producto->render()}}
	</div>
</div>
@endsection
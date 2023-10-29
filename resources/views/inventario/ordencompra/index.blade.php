@extends ('layouts.admin')
@section ('contenido') 
@inject('empleados', 'App\Services\empleadoservicio')
@inject('proveedores', 'App\Services\proveedorservicio')
@inject('clientes', 'App\Services\clienteservicio')
@inject('estadoordencompra', 'App\Services\estadoordencompraservicio')

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
	
	});//cierre del DOM
</script>
<div class="row">
	<div class = "col-lg-8 col-md-8 col-sm-8 col-xs-12 titlecatalogos">
		<h2>Compras: </h2> <a href="ordencompra/create"><button class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</button> </a> <h4></h4>
		@include ('inventario.ordencompra.search')
	</div>
</div>

<div class="row">
	<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="">	
			<table class ="table table-striped table-bordered table-condensed table-hover">
				<thead class="thead-dark">
					<th class="fondoGrid">Fecha</th>
					<th class="fondoGrid">Proveedor</th>
					<th class="fondoGrid">Total</th>
					<th class="fondoGrid">Estado</th>
					<th class="alignButtonGrid">Opciones</th>
					<th class="alignButtonGrid">Detalle</th>
				</thead>
		
				@foreach ($ordencompra as $ordcompra)
				<tr>
					<td class="table-active">{{$ordcompra->fecha}}</td>
					<td class="table-active">{{$ordcompra->nombreproveedor}}</td>
					<td class="table-active" style="text-align: right;">{{$ordcompra->total}}</td>
					<td class="table-active">{{$ordcompra->descripcionordencompra}}</td>
					<td class="table-active alignButtonGrid">
						<a href="{{URL::action('ordencompraController@edit', $ordcompra->idordencompra)}}"><button class="btn btn-outline-primary"><i class="fa fa-pencil"></i></button></a>
						<a href="" data-target="#modal-delete-{{$ordcompra->idordencompra}}" data-toggle="modal"><button class= "btn btn-outline-danger"><i class="fa fa-close"></i></button></a>
					</td>
					<td>
						<a href="../listadetalleordencompra/{{$ordcompra->idordencompra}}"><button class="btn btn-outline-primary"><i class="fa fa-eye"></i></button></a>
					</td>
				</tr>
				@include('inventario.ordencompra.modal')
				@endforeach
			</table>
			Total: {{$ordencompra->total()}}
		</div>
		{{$ordencompra->render()}}
	</div>
</div>
@endsection
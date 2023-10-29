@extends ('layouts.admin')
@section ('contenido') 
@inject('tipostransaccion', 'App\Services\tipotransaccionservicio')
@inject('empleados', 'App\Services\empleadoservicio')
@inject('proveedores', 'App\Services\proveedorservicio')
@inject('clientes', 'App\Services\clienteservicio')
@inject('estadostransaccion', 'App\Services\estadotransaccionservicio')

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
	
	});//cierre del DOM
</script>
<div class="row">
	<div class = "col-lg-8 col-md-8 col-sm-8 col-xs-12 titlecatalogos">
		<h2>Ventas: </h2> <a href="transaccionventa/create"><button class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</button> </a> <h4></h4>
		@include ('inventario.transaccionventa.search')
	</div>
</div>

<div class="row">
	<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="">	
			<table class ="table table-striped table-bordered table-condensed table-hover">
				<thead class="thead-dark">
					<th class="fondoGrid">Fecha</th>
					<th class="fondoGrid">Cliente</th>
					<th class="fondoGrid">Total</th>
					<th class="fondoGrid">Estado</th>
					<th class="alignButtonGrid">Opciones</th>
					<th class="alignButtonGrid">Detalle</th>
				</thead>
		
				@foreach ($transaccion as $tran)
				<tr>
					<td class="table-active">{{$tran->fecha}}</td>
					<td class="table-active">{{$tran->nombrecliente}}</td>
					<td class="table-active" style="text-align: right;">{{$tran->total}}</td>
					<td class="table-active">{{$tran->descripcionestadotransaccion}}</td>
					<td class="table-active alignButtonGrid">
						<!-- <a href="{{URL::action('transaccionventaController@edit', $tran->idtransaccion)}}"><button class="btn btn-outline-primary"><i class="fa fa-pencil"></i></button></a> -->
						<a href="" data-target="#modal-delete-{{$tran->idtransaccion}}" data-toggle="modal"><button class= "btn btn-outline-danger"><i class="fa fa-close"></i></button></a>
					</td>
					<td>
						<a href="../listadetalletransaccionventa/{{$tran->idtransaccion}}"><button class="btn btn-outline-primary"><i class="fa fa-eye"></i></button></a>
					</td>
				</tr>
				@include('inventario.transaccioncompra.modal')
				@endforeach
			</table>
			Total: {{$transaccion->total()}}
		</div>
		{{$transaccion->render()}}
	</div>
</div>
@endsection
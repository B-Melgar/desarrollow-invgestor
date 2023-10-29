@extends ('layouts.admin')
@section ('contenido') 
<div class="row">

	<div class = "col-lg-8 col-md-8 col-sm-8 col-xs-12 titleCatalogs">
		<h2>Proveedores: </h2> <a href="proveedor/create"><button class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</button> </a> <h4></h4>
		@include ('inventario.proveedor.search')
	</div>
</div>

<div class="row">
	<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="">	
			<table class ="table table-striped table-bordered table-condensed table-hover">
				<thead class="thead-dark">
					<th class="fondoGrid">NIT</th>
					<th class="fondoGrid">Nombre</th>
					<th class="fondoGrid">Tel&eacute;fono</th>
					<th class="fondoGrid">Correo</th>
					<th class="fondoGrid">Cr&eacute;dito</th>
					<th class="fondoGrid">D&iacute;as</th>
					<th class="alignButtonGrid">Opciones</th>
				</thead>
		
				@foreach ($proveedor as $provee)
				<tr>
					<td class="table-active">{{$provee->nit}}</td>
					<td class="table-active">{{$provee->nombreproveedor}}</td>
					<td class="table-active">{{$provee->telefono}}</td>
					<td class="table-active">{{$provee->correo}}</td>
					<td class="table-active">{{$provee->credito}}</td>
					<td class="table-active">{{$provee->diascredito}}</td>
					<td class="table-active alignButtonGrid">
						<a href="{{URL::action('proveedorController@edit', $provee->idproveedor)}}"><button class="btn btn-outline-primary"><i class="fa fa-pencil"></i></button></a>
						<a href="" data-target="#modal-delete-{{$provee->idproveedor}}" data-toggle="modal"><button class= "btn btn-outline-danger"><i class="fa fa-close"></i></button></a>
					</td>
				</tr>
				@include('inventario.proveedor.modal')
				@endforeach
			</table>
			Total: {{$proveedor->total()}}
		</div>
		{{$proveedor->render()}}
	</div>
</div>
@endsection
@extends ('layouts.admin')
@section ('contenido') 
<div class="row">

<div class = "col-lg-8 col-md-8 col-sm-8 col-xs-12 titlecatalogos">
		<h2>Empleados: </h2> <a href="empleado/create"><button class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</button> </a> <h4></h4>
		@include ('seguridad.empleado.search')
</div>
</div>

<div class="row">
	<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="">	
			<table class ="table table-striped table-bordered table-condensed table-hover">
				<thead class="thead-dark">
					<th class="fondoGrid">Nombres</th>
					<th class="fondoGrid">Apellidos</th>
					<th class="fondoGrid">Direcci&oacute;n</th>
					<th class="fondoGrid">Tel&eacute;fono</th>
					<th class="fondoGrid">Correo</th>
					<th class="alignButtonGrid">Opciones</th>
				</thead>
		
				@foreach ($empleado as $emple)
				<tr>
					<td class="table-active">{{$emple->nombres}}</td>
					<td class="table-active">{{$emple->apellidos}}</td>
					<td class="table-active">{{$emple->direccion}}</td>
					<td class="table-active">{{$emple->telefono}}</td>
					<td class="table-active">{{$emple->correo}}</td>
					<td class="table-active alignButtonGrid">
						<a href="{{URL::action('empleadoController@edit', $emple->idempleado)}}"><button class="btn btn-outline-primary"><i class="fa fa-pencil"></i></button></a>
						<a href="" data-target="#modal-delete-{{$emple->idempleado}}" data-toggle="modal"><button class= "btn btn-outline-danger"><i class="fa fa-close"></i></button></a>
					</td>
				</tr>
				@include('seguridad.empleado.modal')
				@endforeach
			</table>
			Total: {{$empleado->total()}}
		</div>
		{{$empleado->render()}}
	</div>
</div>
@endsection
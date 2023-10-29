@extends ('layouts.admin')
@section ('contenido') 
<div class="row">

	<div class = "col-lg-8 col-md-8 col-sm-8 col-xs-12 titlecatalogos">
		<h2>Asigaci&oacute;n Rol Usuario: </h2> <a href="segusuariorol/create"><button class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</button> </a> <h4></h4>
		@include ('security.segusuariorol.search')
	</div>
</div>

<div class="row">
	<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">	
			<table class ="table table-striped table-bordered table-condensed table-hover">
				<thead class="thead-dark">
					<th class="fondoGrid">Usuario</th>
                    <th class="fondoGrid"></th>
					<th class="fondoGrid">Rol</th>
					<th class="fondoGrid">Fecha Inicio</th>
					<th class="fondoGrid">Fecha Fin</th>
					<th class="fondoGrid">Activo</th>
					<th class="alignButtonGrid">Opciones</th>
				</thead>
		
				@foreach ($segusuariorol as $usuarioRol)
				<tr>
					<td class="table-active">{{$usuarioRol->names}}</td>
                    <td class="table-active">{{$usuarioRol->apellidos}}</td>
					<td class="table-active">{{$usuarioRol->descripcionrol}}</td>
					<td class="table-active">{{$usuarioRol->startDate}}</td>
					<td class="table-active">{{$usuarioRol->endDate}}</td>
					<td class="table-active">{{$usuarioRol->Active}}</td>
					<td class="table-active alignButtonGrid">
						<a href="{{URL::action('segusuariorolController@edit', $usuarioRol->idUserRole)}}"><button class="btn btn-outline-primary"><i class="fa fa-pencil"></i></button></a>
						<a href="" data-target="#modal-delete-{{$usuarioRol->idUserRole}}" data-toggle="modal"><button class= "btn btn-outline-danger"><i class="fa fa-close"></i></button></a>
					</td>
				</tr>
				@include('security.segusuariorol.modal')
				@endforeach
			</table>
			Total: {{$segusuariorol->total()}}
		</div>
		{{$segusuariorol->render()}}
	</div>
</div>
@endsection
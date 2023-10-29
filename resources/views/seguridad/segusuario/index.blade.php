@extends ('layouts.admin')
@section ('contenido') 
<div class="row">

<div class = "col-lg-8 col-md-8 col-sm-8 col-xs-12 titlecatalogos">
		<h2>Usuarios: </h2> <a href="segusuario/create"><button class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</button> </a> <h4></h4>
		@include ('seguridad.segusuario.search')
</div>
</div>

<div class="row">
	<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="">	
			<table class ="table table-striped table-bordered table-condensed table-hover">
				<thead class="thead-dark">
					<th class="fondoGrid">Usuario</th>
					<th class="fondoGrid">Contraseña</th>
					<th class="fondoGrid">Empleado</th>
					<th class="fondoGrid">Rol</th>
					<th class="alignButtonGrid">Opciones</th>
				</thead>
		
				@foreach ($segusuario as $user)
				<tr>
					<td class="table-active">{{$user->email}}</td>
					<td class="table-active">{{$user->password}}</td>
					<td class="table-active">{{$user->nombres}} {{$user->apellidos}}</td>
					<td class="table-active">{{$user->descripcionrol}}</td>
					<td class="table-active alignButtonGrid">
						<a href="{{URL::action('segusuarioController@edit', $user->id)}}"><button class="btn btn-outline-primary"><i class="fa fa-pencil"></i></button></a>
						<a href="" data-target="#modal-delete-{{$user->id}}" data-toggle="modal"><button class= "btn btn-outline-danger"><i class="fa fa-close"></i></button></a>
					</td>
				</tr>
				@include('seguridad.segusuario.modal')
				@endforeach
			</table>
			Total: {{$segusuario->total()}}
		</div>
		{{$segusuario->render()}}
	</div>
</div>
@endsection
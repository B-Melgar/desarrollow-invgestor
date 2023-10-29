@extends ('layouts.admin')
@section ('contenido') 
<div class="row">

	<div class = "col-lg-8 col-md-8 col-sm-8 col-xs-12 titlecatalogos">
		<h2>Roles: </h2> <a href="secMenu/create"><button class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</button> </a> <h4></h4>
		@include ('security.secMenu.search')
	</div>
</div>

<div class="row">
	<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class="table-responsive">	
			<table class ="table table-striped table-bordered table-condensed table-hover">
				<thead class="thead-dark">
					<th class="fondoGrid">Descripci&oacute;n</th>
                    <th class="fondoGrid">Icono</th>
					<th class="fondoGrid">Orden</th>
					<th class="alignButtonGrid">Opciones</th>
				</thead>
		
				@foreach ($secMenu as $menu)
				<tr>
					<td class="table-active">{{$menu->DescriptionMenu}}</td>
                    <td class="table-active">{{$menu->IconMenu}}</td>
					<td class="table-active">{{$menu->orden}}</td>
					<td class="table-active alignButtonGrid">
						<a href="{{URL::action('secMenuController@edit', $menu->idMenu)}}"><button class="btn btn-outline-primary"><i class="fa fa-pencil"></i></button></a>
						<!-- <a href="" data-target="#modal-delete-{{$menu->idMenu}}" data-toggle="modal"><button class= "btn btn-outline-danger"><i class="fa fa-close"></i></button></a> -->
					</td>
				</tr>
				@include('security.secMenu.modal')
				@endforeach
			</table>
			Total: {{$secMenu->total()}}
		</div>
		{{$secMenu->render()}}
	</div>
</div>
@endsection
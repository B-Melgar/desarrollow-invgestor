@extends ('layouts.admin')
@section ('contenido') 
<div class="row">

	<div class = "col-lg-8 col-md-8 col-sm-8 col-xs-12 titlecatalogos">
		<h2>Opciones de Menu: </h2> <a href="secOptions/create"><button class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</button> </a> <h4></h4>
		@include ('security.secOptions.search')
	</div>
</div>

<div class="row">
	<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">	
			<table class ="table table-striped table-bordered table-condensed table-hover">
				<thead class="thead-dark">
					<th class="fondoGrid">Menu</th>
					<th class="fondoGrid">Opci&oacute;n</th>
					<th class="fondoGrid">Ruta</th>
					<th class="fondoGrid">Icono</th>
					<th class="alignButtonGrid">Opciones</th>
				</thead>
		
				@foreach ($secOptions as $option)
				<tr>
					<td class="table-active">{{$option->DescriptionMenu}}</td>
                    <td class="table-active">{{$option->DescriptionOption}}</td>
					<td class="table-active">{{$option->RouteOption}}</td>
					<td class="table-active">{{$option->IconOption}}</td>
					<td class="table-active alignButtonGrid">
						<a href="{{URL::action('secOptionsController@edit', $option->idOption)}}"><button class="btn btn-outline-primary"><i class="fa fa-pencil"></i></button></a>
						<a href="" data-target="#modal-delete-{{$option->idOption}}" data-toggle="modal"><button class= "btn btn-outline-danger"><i class="fa fa-close"></i></button></a>
					</td>
				</tr>
				@include('security.secOptions.modal')
				@endforeach
			</table>
			Total: {{$secOptions->total()}}
		</div>
		{{$secOptions->render()}}
	</div>
</div>
@endsection
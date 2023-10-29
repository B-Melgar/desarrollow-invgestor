@extends ('layouts.admin')
@section ('contenido') 
<div class="row">

	<div class = "col-lg-8 col-md-8 col-sm-8 col-xs-12 titlecatalogos">
		<h2>Asigaci&oacute;n Rol Opciones: </h2> <a href="secAssignmentOption/create"><button class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</button> </a> <h4></h4>
		@include ('security.secAssignmentOption.search')
	</div>
</div>

<div class="row">
	<div class= "col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">	
			<table class ="table table-striped table-bordered table-condensed table-hover">
				<thead class="thead-dark">
					<th class="fondoGrid">Rol</th>
					<th class="fondoGrid">Opci&oacute;n</th>
					<th class="alignButtonGrid">Opciones</th>
				</thead>
		
				@foreach ($secAssignmentOption as $assigmentOption)
				<tr>
					<td class="table-active">{{$assigmentOption->descripcionrol}}</td>
                    <td class="table-active">{{$assigmentOption->DescriptionOption}}</td>
					<td class="table-active alignButtonGrid">
						<a href="{{URL::action('secAssignmentOptionController@edit', $assigmentOption->idAssignmentOption)}}"><button class="btn btn-outline-primary"><i class="fa fa-pencil"></i></button></a>
						<a href="" data-target="#modal-delete-{{$assigmentOption->idAssignmentOption}}" data-toggle="modal"><button class= "btn btn-outline-danger"><i class="fa fa-close"></i></button></a>
					</td>
				</tr>
				@include('security.secAssignmentOption.modal')
				@endforeach
			</table>
			Total: {{$secAssignmentOption->total()}}
		</div>
		{{$secAssignmentOption->render()}}
	</div>
</div>
@endsection
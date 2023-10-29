@extends ('layouts.admin')
@section ('contenido') 
<div class="row">

	<div class = "col-lg-8 col-md-8 col-sm-8 col-xs-12 titlecatalogos">
		<h2>Sub Categorias Producto: </h2> <a href="subcategoria/create"><button class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</button> </a> <h4></h4>
		@include ('catalogos.subcategoria.search')
	</div>
</div>

<div class="row">
	<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class="table-responsive">	
			<table class ="table table-striped table-bordered table-condensed table-hover">
				<thead class="thead-dark">
					<th class="fondoGrid">Categoria</th>
					<th class="fondoGrid">Sub Categoria</th>
					<th class="alignButtonGrid">Opciones</th>
				</thead>
		
				@foreach ($subcategoria as $subcategorias)
				<tr>
					<td class="table-active">{{$subcategorias->descripcion}}</td>
					<td class="table-active">{{$subcategorias->descripcionsubcategoria}}</td>
					<td class="table-active alignButtonGrid">
					<a href="{{URL::action('subcategoriaController@edit', $subcategorias->idsubcategoria)}}"><button class="btn btn-outline-primary"><i class="fa fa-pencil"></i></button></a>
						<a href="" data-target="#modal-delete-{{$subcategorias->idsubcategoria}}" data-toggle="modal"><button class= "btn btn-outline-danger"><i class="fa fa-close"></i></button></a>
					</td>
				</tr>
				@include('catalogos.subcategoria.modal')
				@endforeach
			</table>
			Total: {{$subcategoria->total()}}
		</div>
		{{$subcategoria->render()}}
	</div>
</div>
@endsection
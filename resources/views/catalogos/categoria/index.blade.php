@extends ('layouts.admin')
@section ('contenido') 
<div class="row">
	<div class = "col-lg-8 col-md-8 col-sm-8 col-xs-12 titlecatalogos">
		<h2>Categoria Producto: </h2> <a href="categoria/create"><button class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</button> </a> <h4></h4>
		@include ('catalogos.categoria.search')
	</div>
</div>

<div class="row">
	<div class= "col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class="table-responsive">	
			<table class ="table table-striped table-bordered table-condensed table-hover">
				<thead class="thead-dark">
					<th class="fondoGrid">Descripci&oacute;n</th>
					<th class="alignButtonGrid">Opciones</th>
				</thead>
		
				@foreach ($categoria as $categorias)
				<tr>
					<td class="table-active">{{$categorias->descripcion}}</td>
					<td class="table-active alignButtonGrid">
						<a href="{{URL::action('categoriaController@edit', $categorias->idcategoria)}}"><button class="btn btn-outline-primary"><i class="fa fa-pencil"></i></button></a>
						<a href="" data-target="#modal-delete-{{$categorias->idcategoria}}" data-toggle="modal"><button class= "btn btn-outline-danger"><i class="fa fa-close"></i></button></a>
					</td>
				</tr>
				@include('catalogos.categoria.modal')
				@endforeach
			</table>
			Total: {{$categoria->total()}}
		</div>
		{{$categoria->render()}}
	</div>
</div>
@endsection
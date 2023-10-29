@extends ('layouts.admin')
@section ('contenido') 
<div class="row">
	<div class = "col-lg-8 col-md-8 col-sm-8 col-xs-12 titlecatalogos">
		<h2>Estados Orden Compra: </h2> <a href="comEstatePurchaseOrder/create"><button class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</button> </a><h4></h4>
		@include ('catalogos.comEstatePurchaseOrder.search')
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
		
				@foreach ($comEstatePurchaseOrder as $ordencompra)
				<tr>
					<td class="table-active">{{$ordencompra->descriptionPurchaseOrder}}</td>
					<td class="table-active alignButtonGrid">
						<a href="{{URL::action('comEstatePurchaseOrderController@edit', $ordencompra->idEstatePurchaseOrder)}}"><button class="btn btn-outline-primary"><i class="fa fa-pencil"></i></button></a>
						<a href="" data-target="#modal-delete-{{$ordencompra->idEstatePurchaseOrder}}" data-toggle="modal"><button class= "btn btn-outline-danger"><i class="fa fa-close"></i></button></a>
					</td>
				</tr>
				@include('catalogos.comEstatePurchaseOrder.modal')
				@endforeach
			</table>
			Total: {{$comEstatePurchaseOrder->total()}}
		</div>
		{{$comEstatePurchaseOrder->render()}}
	</div>
</div>
@endsection
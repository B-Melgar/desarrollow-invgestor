<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modal-delete-{{$ordencompra->idEstatePurchaseOrder}}">
		{{Form::Open(array('action'=>array('comEstatePurchaseOrderController@destroy',$ordencompra->idEstatePurchaseOrder), 'method'=>'delete'))}}	
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="alert alert-danger">
					<h4 class="modal-title"><strong>Eliminar</strong></h4>
				</div>
				<div class="modal-body">
					<p>¿Desea eliminar?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-ban"></i> Cerrar</button>
					<button type="submit" class="btn btn-danger"><i class="fa fa-check"></i> Confirmar</button>
				</div>
			</div>	
		</div>
		{{Form::Close()}}
</div>
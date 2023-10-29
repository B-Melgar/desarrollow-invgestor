@extends ('layouts.admin')
@section ('contenido') 
@inject('branchs', 'App\Services\gralBranchService')

<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function() {
		document.getElementById('resultado').style.visibility='hidden';

	$("#btnPrintProductBranchList").click(function(){
		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		var idBranch = document.getElementById("idBranch").value;
		
		if(idBranch !=''){
		$.ajax({
		type: 'POST',
		url: '/postprintproductbranchlist',
		data: {_token: CSRF_TOKEN,idBranch:idBranch},
		xhrFields: {
			responseType: 'blob'
		},
		//dataType: 'JSON',
		success: function(data){
			console.log(data);
			var blob = new Blob([data]);
			var link = document.createElement('a');
			link.href = window.URL.createObjectURL(blob);
			var tiempo = new Date();
			link.download = "Inventario_Sucursal_No._" + idBranch + '_' + tiempo.getTime() + ".pdf";
			link.click();
			var label = document.getElementById('resultado');
			label.textContent = 'Inventario generado exitosamente!!!';
			label.style.visibility='visible';
		},
		error: function(blob){
				var label = document.getElementById('resultado');
				label.textContent = 'No se puede imprimir!!!';
				label.style.visibility='visible';
		}
	});
	}else{
		var label = document.getElementById('resultado');
		label.textContent = 'No se encontro el código de la sucursal';
		label.style.visibility='visible';
	}
	});


	});
</script>
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		@if (count($errors)>0)
		<div class="alert alert-danger">
			<ul>
			@foreach ($errors->all() as $error)
				<li>{{$error}}</li>
			@endforeach
			</ul>
		</div>
		@endif
	</div>
</div>
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		@if (!empty($msg))
		<div class="alert alert-danger">
			
			<ul>
				<li>{{$msg}}</li>
			</ul>
		</div>
		@endif
	</div>
</div>
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<label id="resultado" name="resultado" class="alert alert-danger">
	</div>
</div>
<div class="form-row">			
	<div class="form-group col-md-6">
		<div class="page-header">
			<h3>Panel de reportes</h3>
		</div>
		<div class="box-body">
        <div class="form-group col-md-12">
        	<label for="idBranch">Inventario por Sucursal</label>
                <div>
                    <select id="idBranch" name="idBranch" class="form-control{{ $errors->has('idBranch') ? ' is-invalid' : '' }}" required>
                    @foreach($branchs->get() as $indexBranch => $branch)
                    <option value="{{ $indexBranch }}" {{ old('idBranch') == $indexBranch ? 'selected' : '' }}>
                    {{ $branch }}
                    </option>
                    @endforeach
                    </select>

                    @if ($errors->has('idBranch'))
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('idBranch') }}</strong>
                    </span>
                    @endif
            </div>
        </div>
           
			<div class="form-group col-md-12">
				<button id="btnPrintProductBranchList" class="btn btn-primary"><i class="fa fa-print"></i> Imprimir</button>			
			</div>
		</div>
	</div>
</div>
{!!Form::close()!!}
@endsection
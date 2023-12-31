@extends ('layouts.admin')
@section ('contenido') 
@inject('categorias', 'App\Services\categoriaservicio')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">


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

		{!! Form::model ($subcategoria, ['method'=>'PATCH','route'=>['subcategoria.update',$subcategoria->idsubcategoria]])!!}
		{{Form::token()}}
		@csrf
<div class="form-row">			
	<div class="form-group col-md-6">
		<div class="page-header">
			<h3>Modificar Sub Categoria Producto</h3> 
		</div>

		<div class="box-body">
			<div class="form-group col-md-6">
        			<label for="categoria">Categoria</label>
					<div>
                    	<select id="categoria" name="idcategoria" class="form-control{{ $errors->has('idcategoria') ? ' is-invalid' : '' }}" required>
                         	@foreach($categorias->get() as $index => $categoria)
                            <option value="{{  $index }}" {{ $subcategoria->idcategoria == $index ? 'selected' : '' }}>
                                {{ $categoria }}
                            </option>
                        	@endforeach
                    	</select>

                    @if ($errors->has('idcategoria'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('idcategoria') }}</strong>
                        </span>
                    @endif
                </div>
        	</div>
			<div class="form-group col-md-6">
				<label for="descripcion">Descripci&oacute;n</label>
				<input type="text" name="descripcionsubcategoria" class="form-control" value="{{$subcategoria->descripcionsubcategoria}}" required>
			</div>
			<div  class="form-group col-md-12">
				<a href="{{url ('catalogos/subcategoria')}}" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>
				<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Guardar</button>
			</div>
		</div>
	</div>
</div>
{!!Form::close()!!}
@endsection
{!! Form::open(array('url'=>'inventario/producto', 'method'=>'GET', 'autocomplete'=>'off','role'=>'search')) !!}
<div class="form-group">
	<div class="input-group">
	<table>
		<tr>
			<td>
			<label for="categoria">Categoria</label>
			</td>
				<td>
					<div class="form-group col-md-12">	
						<div>
                    	<select id="_categoria" name="_categoria" class="form-control{{ $errors->has('idcategoria') ? ' is-invalid' : '' }}" >
                         	@foreach($categorias->get() as $index => $categoria)
                            <option value="{{  $index }}" {{ old('idcategoria') == $index  ? 'selected' : '' }}>
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
					</td>
					<td>
					&nbsp;&nbsp;&nbsp;
					</td>
				</tr>
				<tr>
				<td>
					<label for="categoria">Sub Categoria</label>
				</td>
				<td>
					<div class="form-group col-md-12">	
                		<select id="_subcategoria" name="_subcategoria" class="form-control{{ $errors->has('idsubcategoria') ? ' is-invalid' : '' }}"></select>
                    	@if ($errors->has('idsubcategoria'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('idsubcategoria') }}</strong>
                        </span>
                    	@endif
                	</div>
				</td>
				<td>
					&nbsp;&nbsp;&nbsp;
				</td>
			</tr>
			<tr>
				<td>
				<label for="categoria">Descripci&oacute;n</label>
				</td>
				<td>
				<div class="form-group col-md-12">
					<input type="text" class="form-control" aria-label="Small" name="searchText" placeholder="Buscar" values="{{$searchText}}"> &nbsp;&nbsp;
					</div>
				</td>
				<td>
					&nbsp;&nbsp;&nbsp;
				</td>
				<td>
				<span class="input-group-btn">
					<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>	
				</span>
				</td>
			</tr>
		</table>
	</div>
</div>
{{Form::close()}}
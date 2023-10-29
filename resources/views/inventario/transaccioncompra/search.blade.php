{!! Form::open(array('url'=>'inventario/transaccioncompra', 'method'=>'GET', 'autocomplete'=>'off','role'=>'search')) !!}
<div class="form-group">
	<div class="input-group">
	<table>
		<tr>
			<td>
			<label for="categoria">Proveedor</label>
			</td>
				<td>
					<div class="form-group col-md-12">	
						<div>
                    	<select id="_proveedor" name="_proveedor" class="form-control{{ $errors->has('idproveedor') ? ' is-invalid' : '' }}" >
                         	@foreach($proveedores->get() as $index => $proveedor)
                            <option value="{{  $index }}" {{ old('idproveedor') == $index  ? 'selected' : '' }}>
                                {{ $proveedor }}
                            </option>
                        	@endforeach
                    	</select>

                   		@if ($errors->has('idproveedor'))
                        	<span class="invalid-feedback" role="alert">
                        	<strong>{{ $errors->first('idproveedor') }}</strong>
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
					<label for="categoria">Estado</label>
				</td>
				<td>
				<div class="form-group col-md-12">	
						<div>
                    	<select id="_estadotransaccion" name="_estadotransaccion" class="form-control{{ $errors->has('idestadotransaccion') ? ' is-invalid' : '' }}" >
                         	@foreach($estadostransaccion->get() as $index => $estadotransaccion)
                            <option value="{{  $index }}" {{ old('idestadotransaccion') == $index  ? 'selected' : '' }}>
                                {{ $estadotransaccion }}
                            </option>
                        	@endforeach
                    	</select>

                   		@if ($errors->has('idestadotransaccion'))
                        	<span class="invalid-feedback" role="alert">
                        	<strong>{{ $errors->first('idestadotransaccion') }}</strong>
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
				<td></td>
				<td></td>
				<td>
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
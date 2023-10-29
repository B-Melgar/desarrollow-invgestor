{!! Form::open(array('url'=>'inventario/ordencompra', 'method'=>'GET', 'autocomplete'=>'off','role'=>'search')) !!}
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
                    	<select id="estadoordencompra" name="estadoordencompra" class="form-control{{ $errors->has('idestadoordencompra') ? ' is-invalid' : '' }}" >
                         	@foreach($estadoordencompra->get() as $index => $estadoordcompra)
                            <option value="{{  $index }}" {{ old('idestadoordencompra') == $index  ? 'selected' : '' }}>
                                {{ $estadoordcompra }}
                            </option>
                        	@endforeach
                    	</select>

                   		@if ($errors->has('idestadoordencompra'))
                        	<span class="invalid-feedback" role="alert">
                        	<strong>{{ $errors->first('idestadoordencompra') }}</strong>
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
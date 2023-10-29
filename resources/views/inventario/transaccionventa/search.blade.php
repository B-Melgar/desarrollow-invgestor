{!! Form::open(array('url'=>'inventario/transaccionventa', 'method'=>'GET', 'autocomplete'=>'off','role'=>'search')) !!}
<div class="form-group">
	<div class="input-group">
	<table>
		<tr>
			<td>
			<label for="categoria">Cliente</label>
			</td>
				<td>
					<div class="form-group col-md-12">	
						<div>
                    	<select id="_cliente" name="_cliente" class="form-control{{ $errors->has('idcliente') ? ' is-invalid' : '' }}" >
                         	@foreach($clientes->get() as $index => $cliente)
                            <option value="{{  $index }}" {{ old('idcliente') == $index  ? 'selected' : '' }}>
                                {{ $cliente }}
                            </option>
                        	@endforeach
                    	</select>

                   		@if ($errors->has('idcliente'))
                        	<span class="invalid-feedback" role="alert">
                        	<strong>{{ $errors->first('idcliente') }}</strong>
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
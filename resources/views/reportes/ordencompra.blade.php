<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Orden de Compra</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        /*!
         * Bootstrap v3.3.5 (http://getbootstrap.com)
         * Copyright 2011-2015 Twitter, Inc.
         * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
         *//*! normalize.css v3.0.3 | MIT License | github.com/necolas/normalize.css */
        .title { 
            text-align: center;
            color: black;
            font-size: 14px;
        }
        .datePrint { 
            text-align: right;
            color: black;
            font-size: 10px;
        }
        .header { 
            text-align: left;
            color: black;
            font-size: 14px;
        }
        .header { 
            text-align: left;
            color: black;
            font-size: 14px;
        }
        .textBold{
            font-weight: bold;
        }
        .tableWidth{
            width: 100%;
        }
        .footer { 
            text-align: right;
            color: black;
            font-size: 16px;
        }
        .centerText { 
            text-align: center;
        }
        .leftText { 
            text-align: left;
        }
        .rightText { 
            text-align: right;
        }
        * {
    font-size: x-small;
}

th {
    background-color: #f7f7f7;
    border-color: #959594;
    border-style: solid;
    border-width: 1px;
    text-align: center;
}

.bordered td {
    border-color: #959594;
    border-style: solid;
    border-width: 1px;
}

table {
    border-collapse: collapse;
}

/* Para sobrescribir lo que está en div-table.css */
.divTableCell,
.divTableHead {
    padding: 0px !important;
    border: 0px !important;
}
</style>
    <script type="text/javascript">
    $(document).ready(function () {
        $('#price').inputmask({
            alias: 'numeric', 
            allowMinus: false,  
            digits: 2, 
            max: 999999.99
        });
    });
    </script>
  </head>
  <body>
    <div class="datePrint">
        Fecha Impresion: {{$fechaimpresion}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
    <div class="title">
        <h2>ORDEN DE COMPRA</h2>
    </div>
    <br>
    <table class="header">
        <tr>
            <td><h4>No. Orden: </h4></td>
            <td><h4>{{$idordencompra}}</h4></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
            <td class="textBold">Proveedor: </td>
            <td>{{$nombreproveedor}}</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
            <td class="textBold">Fecha: </td>
            <td>{{$fechaordencompra}}</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
    <br>
    <br>
    <div class="divTable">
    <div class="divTableBody">
    <div class="divTableRow">
    <div class="divTableCell">
    <table style="table-layout:fixed; width: 100%;"  class ="table table-bordered">
		<thead class="">
        <tr>
            <th style="width:45%;">Producto</th>
            <th style="width:10%;">Cantidad</th>
			<th style="width:10%;">Precio</th>
			<th style="width:10%;">Sub Total</th>    
        </tr>    
		</thead>
        <tbody>
		@foreach ($ordencompradetalle as $detalle)
		<tr>
			<td class="">{{$detalle->descripcionproducto}}</td>
			<td class="centerText">{{$detalle->cantidad}}</td>
			<td class="rightText">{{$detalle->precio}}</td>
			<td class="rightText">{{$detalle->subtotal}}</td>
		</tr>
        </tbody>
		@endforeach
       
	</table>
    </div>
    </div>
    </div>
    </div>
    <div class="footer textBold">
        Total: Q {{$totalOrden}}
    </div>
  </body>
</html>
@extends('base')

@section('title')
{{ $otherArray['nombre'] }} - {{ $otherArray['tiker'] }}
@endsection

@section('container')
	
	<div class="row">
		<div class="col-md-4">
			<h2>{{ $otherArray['nombre'] }} <small>({{ $otherArray['tiker'] }}):</small></h2>
			<br>
			<table class="table table-condensed">
				<tr>
					<td><b>Cierre Anterior</b></td>
					<td>{{ $otherArray['cierreAnterior'] }}</td>
				</tr>
				<tr>
					<td><b>Abrir</b></td>
					<td>{{ $otherArray['abrir'] }}</td>
				</tr>
				<tr>
					<td><b>Oferta</b></td>
					<td>{{ $otherArray['oferta'] }}</td>
				</tr>
				<tr>
					<td><b>Precio de Compra</b></td>
					<td>{{ $otherArray['demanda'] }}</td>
				</tr>
				<tr>
					<td><b>Rango Diario</b></td>
					<td>{{ $otherArray['rangoDiario'] }}</td>
				</tr>
				<tr>
					<td><b>Intervalo de 52 Semanas</b></td>
					<td>{{ $otherArray['rango52Semanas'] }}</td>
				</tr>
				<tr>
					<td><b>Volumen</b></td>
					<td>{{ $otherArray['volumen'] }}</td>
				</tr>
				<tr>
					<td><b>Media Volumen</b></td>
					<td>{{ $otherArray['mediaVolumen'] }}</td>
				</tr>
				<tr>
					<td><b>Ratio precio/beneficio (TMTM)</b></td>
					<td>{{ $otherArray['tmtm'] }}</td>
				</tr>
				<tr>
					<td><b>BPA (TTM)</b></td>
					<td>{{ $otherArray['ttm'] }}</td>
				</tr>
				<tr>
					<td><b>Fecha de beneficios</b></td>
					<td>{{ $otherArray['fechaBeneficios'] }}</td>
				</tr>
				<tr>
					<td><b>Previsión de rentabilidad y dividendo</b></td>
					<td>{{ $otherArray['prevision'] }}</td>
				</tr>
			</table>

			<a href="{{ url('/generar/excel') }}/{{ $otherArray['tiker'] }}" class="btn btn-success">Generar</a>
		</div>

		<div class="col-md-8">
			<div class="row">
				<div class="col-md-6">
					<h3>Datos Históricos</h3>
				</div>
				<div class="col-md-6" style="padding-top: 1em">
					<a href="{{ url('company') }}/{{ $otherArray['tiker'] }}/financieros" class="btn btn-link btn-md">Financieros</a>
					<a href="{{ url('company') }}/{{ $otherArray['tiker'] }}/estadisticos" class="btn btn-link btn-md">Estadisticos</a>
				</div>
			</div>
			
			<table class="table table-hover table-condensed" id="history">
		    	<thead>
		    		<tr>
		    			<th>Fecha</th>
		    			<th>Abrir</th>
		    			<th>Alto</th>
		    			<th>Bajo</th>
		    			<th>Cierre</th>
		    			<th>Cierre Ajustado</th>
		    			<th>Volumen</th>
		    		</tr>
		    	</thead>
		    	<tbody>
		    		@foreach($arrayFormatHistory as $item)
		    		<tr>
		    			<td>{{ $item['date']['date'] }}</td>
		    			<td>{{ $item['open'] }}</td>
		    			<td>{{ $item['high'] }}</td>
		    			<td>{{ $item['low'] }}</td>
		    			<td>{{ $item['close'] }}</td>
		    			<td>{{ $item['adjClose'] }}</td>
		    			<td>{{ $item['volume'] }}</td>
		    		</tr>
		    		@endforeach
		    	</tbody>
		    </table>

		    <table class="table table-hover table-condensed" id="history-false" style="display: none">
		    	<thead>
		    		<tr>
		    			<th>Fecha</th>
		    			<th>Abrir</th>
		    			<th>Alto</th>
		    			<th>Bajo</th>
		    			<th>Cierre</th>
		    			<th>Cierre Ajustado</th>
		    			<th>Volumen</th>
		    		</tr>
		    	</thead>
		    	<tbody>
		    		@foreach($arrayFormatHistory as $item)
		    		<tr>
		    			<td>{{ $item['date']['date'] }}</td>
		    			<td>{{ $item['open'] }}</td>
		    			<td>{{ $item['high'] }}</td>
		    			<td>{{ $item['low'] }}</td>
		    			<td>{{ $item['close'] }}</td>
		    			<td>{{ $item['adjClose'] }}</td>
		    			<td>{{ $item['volume'] }}</td>
		    		</tr>
		    		@endforeach
		    	</tbody>
		    </table>
		</div>
	</div>
@endsection

@section('scripts-vue')
	
<script>
	$('#history').DataTable({
		"order": [[ 0, "desc" ]],
		"pageLength": 20, 
	});
</script>

@endsection
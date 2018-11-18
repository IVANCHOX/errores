@extends('base')

@section('container')

	<div class="row">
		<div class="col-md-12">

			<div class="row">
				<div class="col-md-8">
					<h2>{{ $arrayFormatQuote['shortName'] }} <small>({{ $arrayFormatQuote['symbol'] }})</small></h2>
				</div>

				<div class="col-md-4 text-right" style="padding-top: 1.5em">
					<a href="{{ url('company') }}/{{ $arrayFormatQuote['symbol'] }}" class="btn btn-primary btn-sm">Actualizar</a>
				</div>
			</div>
			

			<br>
			<table class="table table-condensed">
				<thead>
					<tr>
						<th class="text-center">Cierre Anterior</th>
						<th class="text-center">Abrir</th>
						<th class="text-center">Oferta</th>
						<th class="text-center">Demanda</th>
						<th class="text-center">Rango Diario</th>
						<th class="text-center">Rango 52 Semanas</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="text-center">
							{{ $arrayFormatQuote['regularMarketPreviousClose'] }}
						</td>
						<td class="text-center">
							{{ $arrayFormatQuote['regularMarketOpen'] }}
						</td>
						<td class="text-center">
							{{ $arrayFormatQuote['bid'] }} x {{ $arrayFormatQuote['bidSize']*100 }}
						</td>
						<td class="text-center">
							{{ $arrayFormatQuote['ask'] }} x {{ $arrayFormatQuote['askSize']*100 }}
						</td>
						<td class="text-center">
							{{ $arrayFormatQuote['regularMarketDayLow'] }} - {{ $arrayFormatQuote['regularMarketDayHigh']}}
						</td>
						<td class="text-center">
							{{ $arrayFormatQuote['fiftyTwoWeekLow'] }} - {{ $arrayFormatQuote['fiftyTwoWeekHigh'] }}
						</td>
					</tr>
				</tbody>
			</table>

		
			<h3>Datos Históricos</h3>
			<br>
			<table class="table table-hover table-condensed" id="history">
		    	<thead>
		    		<tr>
		    			<th>Fecha</th>
		    			<th>Abrir</th>
		    			<th>Alto</th>
		    			<th>Bajo</th>
		    			<th>Cierre</th>
		    			<th>PMS(Prueba)</th>
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
		    			<td>{{ $item['pms'] }}</td>
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
	});
</script>

@endsection
@extends('base')

@section('title')
{{ $company['company'] }}
@endsection

@section('search')
	@include('search')
@endsection

@section('container')
	<div>
		<h2>{{ $company['company'] }}</h2>
		<hr>
	</div>
	
	<div class="row">
		<div class="col-md-4">
			<div class="alert alert-success" role="alert" style="color: #707070;background-color: #ecf0f1;border-color: #ebe2e2;">
				<b>Símbolo:</b> {{ $company['tiker'] }} <br>
				<b>Industria:</b> {{ $company['industry'] }} <br>
				<b>Sector:</b> {{ $company['sector'] }} <br>
				<b>País:</b> {{ $company['country'] }}
			</div>
			<hr>
			<div>
				<div class="row">
					<div class="col-md-4">
						<h4><b>Resumen</b></h4>
					</div>
					<div class="col-md-8 text-right" style="padding-top: .5em">
						<a  class="btn btn-xs btn-success">Descargar en Excel</a>

						@if($bool==true)

						@else
							<button class="btn btn-xs btn-danger" onclick="guardarResumen()" id="btnGuardarBD">Guardar en BD</button>

						@endif
						
					</div>
				</div>
				
				<table class="table table-condensed table-bordered">
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
						<td><b>Rango Diario (MINIMO)</b></td>
						<td>{{ $otherArray['rangoDiarioLow'] }}</td>
					</tr>
					<tr>
						<td><b>Rango Diario (MAXIMO)</b></td>
						<td>{{ $otherArray['rangoDiarioHigh'] }}</td>
					</tr>
					<tr>
						<td><b>Intervalo de 52 Semanas (MINIMO)</b></td>
						<td>{{ $otherArray['rango52SemanasLow'] }}</td>
					</tr>
					<tr>
						<td><b>Intervalo de 52 Semanas (MAXIMO)</b></td>
						<td>{{ $otherArray['rango52SemanasHigh'] }}</td>
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
			</div>
		</div>
		<div class="col-md-8" id="app-tab-panel">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist" >
			    <li role="presentation" class="active"><a href="#" aria-controls="datos" role="tab" data-toggle="tab" onclick="clickTab('datos')">Datos Históricos</a></li>
			    <li role="presentation"><a href="#" aria-controls="estadisticos" role="tab" data-toggle="tab" onclick="clickTab('estadisticos')">Estadísticos</a></li>
			    <li role="presentation"><a href="#" aria-controls="financieros" role="tab" data-toggle="tab" onclick="clickTab('financieros')">Financieros</a></li>
			    
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="datos">
			    	<br>
			    	<div class="row">
						<div class="col-md-6">
							Datos Históricos de <b>{{ $company['company'] }}</b>
						</div>
						<div class="col-md-6 text-right" >
							<a href="{{ url('/generar/excel/historicos') }}/{{ $company['tiker'] }}" class="btn btn-xs btn-success">Descargar en Excel</a>

							@if($bool2==true)

							@else
								<button class="btn btn-xs btn-danger" onclick="guardarHistory()" id="btnGuardarBDHistory">Guardar en BD</button>

							@endif
							
						</div>
					</div>
			    	<br>
			    	<table class="table table-hover table-condensed table-bordered" id="history">
				    	<thead>
				    		<tr style="background: #ecf0f1">
				    			<th>Fecha</th>
				    			<th>Abrir</th>
				    			<th>Alto</th>
				    			<th>Bajo</th>
				    			<th>Cierre</th>
				    			<th>PMS (55)</th>
				    			<th>PMS (200)</th>
				    			<th>Cierre Ajustado</th>
				    			<th>Volumen</th>
				    		</tr>
				    	</thead>
				    	<tbody>
				    		@foreach($arrayFormatHistory as $item)
				    		<tr>
				    			<td>@if($bool2==true) {{ $item['date'] }} @else {{ $item['date']['date'] }} @endif</td>
				    			<td>{{ $item['open'] }}</td>
				    			<td>{{ $item['high'] }}</td>
				    			<td>{{ $item['low'] }}</td>
				    			<td>{{ $item['close'] }}</td>
				    			<td>{{ $item['pms55'] }}</td>
				    			<td>{{ $item['pms200'] }}</td>
				    			<td>{{ $item['adjClose'] }}</td>
				    			<td>{{ $item['volume'] }}</td>
				    		</tr>
				    		@endforeach
				    	</tbody>
				    </table>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="estadisticos">
			    	<br>
			    	<div class="row">
			    		<div id="html" style="display: none">
							{!! $htmlEstadisticos !!}
						</div>
						<div class="col-md-6">
							Datos Estadísticos de <b>{{ $company['company'] }}</b>
						</div>
						<div class="col-md-6 text-right" >
							<button class="btn btn-xs btn-success">Descargar en Excel</button>

							@if($bool2==true)

							@else
								<button class="btn btn-xs btn-danger" onclick="guardarHistory()" id="btnGuardarBDHistory">Guardar en BD</button>

							@endif
							
						</div>
						
						
					</div>
					<br>
					<div class="row">
						<div class="col-md-12">
							<div >
								<div class="row ct">
									
								</div>
							</div>
						</div>
					</div>
			    	
			    </div>
			    <div role="tabpanel" class="tab-pane" id="financieros">
			    	<br>
			    	<div class="row">
			    		<div id="html-financieros" style="display: none">
							{!! $htmlFinancieros !!}
						</div>
						<div class="col-md-6">
							Datos Financieros de <b>{{ $company['company'] }}</b>
						</div>
						<div class="col-md-6 text-right" >
							<button class="btn btn-xs btn-success">Descargar en Excel</button>

							{{-- @if($bool2==true)

							@else
								<button class="btn btn-xs btn-danger" onclick="guardarHistory()" id="btnGuardarBDHistory">Guardar en BD</button>

							@endif --}}
							
						</div>
						
						
					</div>
					<br>

					<div class="row">
						<div class="col-md-12">
							<table class="table table-hover table-condensed table-bordered" id="table-financieros">
								<tbody></tbody>
								
							</table>
						</div>
					</div>
			    </div>
			    
			</div>
		</div>
		
	</div>
@endsection

@section('scripts-vue')
	{{-- <script src="{{ asset('js/vue-files/index.js') }}"></script> --}}

	<script>
		$('#history').DataTable({
			"order": [[ 0, "desc" ]],
			"pageLength": 15, 
		});

		function guardarResumen(){
			$.ajax({
				url:'{{ url('ajax/save/resumen') }}/{{ $company['tiker'] }}',
				type: 'get',
				dataType: 'json',
				success: function(data){
					if(data==1){
						$('#btnGuardarBD').hide();
					}
				}
			})
		}

		function guardarHistory(){
			$.ajax({
				url:'{{ url('ajax/save/history') }}/{{ $company['tiker'] }}',
				type: 'get',
				dataType: 'json',
				success: function(data){
					if(data==1){
						$('#btnGuardarBDHistory').hide();
					}
				}
			})
		}

		function clickTab(element){
			$('.tab-pane').hide();
			$('[role="presentation"]').removeClass('active');
			$('[aria-controls="'+element+'"]').parent().addClass('active');
			$('#'+element).show();
		}

	</script>

	<script>

		function isBillon(cadena){
			lastPosition = cadena.length - 1; //ultima posicion
			if(cadena[lastPosition]==="B"){
				return true; 
			}else{
				return false;
			}
		}

		function isMillon(cadena){
			lastPosition = cadena.length - 1; //ultima posicion
			if(cadena[lastPosition]==="M"){
				return true; 
			}else{
				return false;
			}
		}

		//Parses of HTML string
		var cadHTML = $.parseHTML( $('#html').text() );
		var appHTML;

		var groups = [];
		var rows = [];
		var childrenRows = [];
		var k=0;
		var j=0;
		var i=0;
		var html = '';
		var htmlRow='';

		var tableHTML;
		
		if(document.location.origin=='http://206.81.6.193'){
			appHTML = $.parseHTML( cadHTML['55'].innerHTML );

			tableHTML = $('table', appHTML);
			tableHTML.splice(0,1); 



		
			tableHTML.each( function(){

				
					var element = $('tr', this);
					j=0;
					rows=[];
					element.each( function(){
						var children = $('td', this);
						k=0;
						childrenRows = [];
						children.each(function(){
							childrenRows[k] = this.innerText;
							k=k+1;
						});

						rows[j] = childrenRows;
						j=j+1;
					});

					groups[i] = rows;
					i=i+1;

				
			});			
		}else{	
			appHTML = $.parseHTML( cadHTML['53'].innerHTML );

			tableHTML = $('table', appHTML);

		
			tableHTML.each( function(){
				var element = $('tr', this);
				j=0;
				rows=[];
				element.each( function(){
					var children = $('td', this);
					k=0;
					childrenRows = [];
					children.each(function(){
						childrenRows[k] = this.innerText;
						k=k+1;
					});

					rows[j] = childrenRows;
					j=j+1;
				});

				groups[i] = rows;
				i=i+1;
			});
				
		}	

		

		
		for (var i = 0; i < groups.length; i++) {
			htmlRow = "";
			titulo = "";
			subtitulo = "";
			for (var j = 0; j < groups[i].length; j++) {
				htmlChildren = "";
				for (var k = 0; k < groups[i][j].length; k++) {
					cad = "";
					for (var l = 0; l < groups[i][j][k].length; l++) {
						if(isBillon(groups[i][j][k])==true){
							groups[i][j][k] = parseFloat(groups[i][j][k])*1000000000;
						}else{
							if(isMillon(groups[i][j][k])==true){
								groups[i][j][k] = parseFloat(groups[i][j][k])*1000000;
							}
						}

						
						cad = '<td>'+groups[i][j][k]+'</td>';
					}
					htmlChildren = htmlChildren+cad;
				}
				htmlRow = htmlRow+'<tr>'+htmlChildren+'</tr>';

			}

			if(i==0){ titulo = "Medidas de Valoración" }
			if(i==1){ titulo = "Actividad Financiera Destacada"; subtitulo = "Año Fiscal" }
			if(i==2){ subtitulo = "Rentabilidad" }
			if(i==3){ subtitulo = "Eficacia de la administración" }
			if(i==4){ subtitulo = "Estado de ingresos" }
			if(i==5){ subtitulo = "Balance" }
			if(i==5){ subtitulo = "Estado de Flujo de Caja" }
			if(i==7){ titulo = "Información de Operaciones"; subtitulo = "Historial de precios de acciones"}
			if(i==8){ subtitulo = "Estadisticas de acciones"}
			if(i==8){ subtitulo = "Dividendos y Divisiones"}
			
			
			$('.ct').append('<div class="col-md-12"><h4><b>'+titulo+'</b></h4><h5><b>'+subtitulo+'</b></h5><table class="table table-condensed">'+htmlRow+'</table></div>');

		}

			
		


	</script>

	<script>

		//scripts para datos financieros
		var cadHTMLFinancieros = $.parseHTML( $('#html-financieros').text() );
		var appHTMLFinancieros;
		var tableHTMLFinancieros;

		if(document.location.origin=='http://206.81.6.193'){
			appHTMLFinancieros = $.parseHTML( cadHTMLFinancieros['55'].innerHTML );
			tableHTMLFinancieros = $('table', appHTMLFinancieros);
			tableHTMLFinancieros.splice(0,1);
		}else{
			appHTMLFinancieros = $.parseHTML( cadHTMLFinancieros['53'].innerHTML );
			tableHTMLFinancieros = $('table', appHTMLFinancieros);
		}	
		
		
		var rowsFinancieros = tableHTMLFinancieros.children().children().children();
		console.log(rowsFinancieros);

		//array with dates
		var datesFi = [rowsFinancieros[1].innerText, rowsFinancieros[2].innerText, rowsFinancieros[3].innerText, rowsFinancieros[4].innerText ];

		// //array with titles of financial data
		var titlesFi = [ "Ingreso", "Gastos operativos", "Ingreso de operaciones continuas", "Eventos no recurrentes", "Ingresos netos" ];

 		//array for help
		var arrayFi = [];
		var arrayResultFi = [];
		
		//put data text in array for help
		for (var i = 0; i < rowsFinancieros.length; i++) {
			arrayFi[i] = rowsFinancieros[i].innerText;
		}

		//extract array clear titles and dates

		var banderaFi = 0;
		for (var i = 0; i < arrayFi.length; i++) {
			for (var j = 0; j < titlesFi.length; j++) {
				if(titlesFi[j]==arrayFi[i]){
					if(arrayFi[i]=="Ingresos netos"&&banderaFi==0){
						banderaFi=1;
						arrayFi[i]="*";
					}

					if(banderaFi==0){
						arrayFi[i]="*";
					}
					
				}
			}
			for (var k = 0; k < datesFi.length; k++) {
				if(datesFi[k]==arrayFi[i]){
					arrayFi[i] = "*";
				}
			}
			
		}

		// for (var i = 0; i < titles.length; i++) {
		// 	arrayResult[i] = { title:titles[i], dates: [] };
		// 	for (var j = 0; j < dates.length; j++) {
		// 		arrayResult[i].dates[j] = {date: dates[j]}
		// 	}
			 
		// }

		var array2Fi = [];
		var array3Fi = [];
		var m = 0;

		for (var i = 0; i < arrayFi.length; i++) {

			if(arrayFi[i]=="*"){
				
			}else{
				array2Fi[m] = arrayFi[i];
				m=m+1;
			}
			
			if(m==5){
				array3Fi.push(array2Fi);
				m=0;
				array2Fi=[];
			}

			
		}


		var arreglo1Fi = [];
		

		for (var i = 0; i < array3Fi.length; i++) {
			
				$('#table-financieros>tbody').append('<tr><td><b>'+array3Fi[i][0]+'</b></td><td>'+array3Fi[i][1]+'</td><td>'+array3Fi[i][2]+'</td><td>'+array3Fi[i][3]+'</td><td>'+array3Fi[i][4]+'</td></tr>');
			
		}

		console.log(datesFi);

	</script>
	
@endsection
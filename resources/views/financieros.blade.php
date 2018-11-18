@extends('base')

@section('container')
	<div id="html" style="display: none">
		{!! $html !!}
	</div>
	<h2>
		{{ $arrayFormatQuote['longName'] }} <small>({{ $arrayFormatQuote['symbol'] }})</small>
	</h2>
	<br>
	<button class="btn btn-default" id="gen">Generar Excel Financieros</button>
	<button onclick="exportTableToExcel('table', '{{ $arrayFormatQuote['symbol'] }}')">Export Table Data To Excel File</button>
	<br>
	<input type="hidden" name="_token" value="{!! csrf_token() !!}" id="token_data">
	<table id="table" class="table table-condensed">
		<tr>
			<td>{{ $arrayFormatQuote['longName'] }} ({{ $arrayFormatQuote['symbol'] }})</td>
		</tr>
		
	</table>
@endsection

@section('scripts-vue')
	<script src="{{ asset('js/filesaver.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/TableExport/3.3.13/js/tableexport.min.js"></script>
	<script>

		//Parses of HTML string
		var cadHTML = $.parseHTML( $('#html').text() );
		var appHTML = $.parseHTML( cadHTML['53'].innerHTML );
		var tableHTML = $('table', appHTML);
		var rows = tableHTML.children().children().children();

		//array with dates
		var dates = [rows[1].innerText, rows[2].innerText, rows[3].innerText, rows[4].innerText ];

		//array with titles of financial data
		var titles = [ "Revenue", "Operating Expenses", "Income from Continuing Operations", "Non-recurring Events", "Net Income" ];

 		//array for help
		var array = [];
		var arrayResult = [];
		
		//put data text in array for help
		for (var i = 0; i < rows.length; i++) {
			array[i] = rows[i].innerText;
		}

		//extract array clear titles and dates

		var bandera = 0;
		for (var i = 0; i < array.length; i++) {
			for (var j = 0; j < titles.length; j++) {
				if(titles[j]==array[i]){
					if(array[i]=="Net Income"&&bandera==0){
						bandera=1;
						array[i]="*";
					}

					if(bandera==0){
						array[i]="*";
					}
					
				}
			}
			for (var k = 0; k < dates.length; k++) {
				if(dates[k]==array[i]){
					array[i] = "*";
				}
			}
			
		}

		// for (var i = 0; i < titles.length; i++) {
		// 	arrayResult[i] = { title:titles[i], dates: [] };
		// 	for (var j = 0; j < dates.length; j++) {
		// 		arrayResult[i].dates[j] = {date: dates[j]}
		// 	}
			 
		// }

		var array2 = [];
		var array3 = [];
		var m = 0;

		for (var i = 0; i < array.length; i++) {

			if(array[i]=="*"){
				
			}else{
				array2[m] = array[i];
				m=m+1;
			}
			
			if(m==5){
				array3.push(array2);
				m=0;
				array2=[];
			}

			
		}


		var arreglo1 = [];
		

		for (var i = 0; i < array3.length; i++) {
			
				$('#table').append('<tr><td>'+array3[i][0]+'</td><td>'+array3[i][1]+'</td><td>'+array3[i][2]+'</td><td>'+array3[i][3]+'</td><td>'+array3[i][4]+'</td></tr>');
			
		}

		console.log(array3);

	</script>

	<script>
		

		 

		function exportTableToExcel(tableID, filename = ''){
		    var downloadLink;
		    var dataType = 'application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
		    var tableSelect = document.getElementById(tableID);
		    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
		    
		    // Specify file name
		    filename = filename?filename+'.xls':'excel_data.xls';
		    
		    // Create download link element
		    downloadLink = document.createElement("a");
		    
		    document.body.appendChild(downloadLink);
		    
		    if(navigator.msSaveOrOpenBlob){
		        var blob = new Blob(['\ufeff', tableHTML], {
		            type: dataType
		        });
		        navigator.msSaveOrOpenBlob( blob, filename);
		    }else{
		        // Create a link to the file
		        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
		    
		        // Setting the file name
		        downloadLink.download = filename;
		        
		        //triggering the function
		        downloadLink.click();
		    }
		}
	</script>
@endsection
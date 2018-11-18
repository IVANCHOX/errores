@extends('base')

@section('container')
	<div id="html" style="display: none">
		{!! $html !!}
	</div>
	<h2>
		Estadísticos: <b>{{ $arrayFormatQuote['longName'] }} <small>({{ $arrayFormatQuote['symbol'] }})</small></b>
	</h2>
	
	<br>
	<input type="hidden" name="_token" value="{!! csrf_token() !!}" id="token_data">
	

	<div >
		<div class="row ct">
			
		</div>
	</div>
@endsection

@section('scripts-vue')
	<script src="{{ asset('js/filesaver.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/TableExport/3.3.13/js/tableexport.min.js"></script>

	<script>

		//Parses of HTML string
		var cadHTML = $.parseHTML( $('#html').text() );
		var appHTML = $.parseHTML( cadHTML['53'].innerHTML );
		var tableHTML = $('table', appHTML);

		var groups = [];
		var rows = [];
		var childrenRows = [];
		var k=0;
		var j=0;
		var i=0;
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

		
		for (var i = 0; i < groups.length; i++) {
			htmlRow = "";
			for (var j = 0; j < groups[i].length; j++) {
				htmlChildren = "";
				for (var k = 0; k < groups[i][j].length; k++) {
					cad = "";
					for (var l = 0; l < groups[i][j][k].length; l++) {
						cad = '<td>'+groups[i][j][k]+'</td>';
					}
					htmlChildren = htmlChildren+cad;
				}
				htmlRow = htmlRow+'<tr>'+htmlChildren+'</tr>';
			}
			
			$('.ct').append('<div class="col-md-12"><table class="table table-condensed">'+htmlRow+'</table></div>');
		}
			
		


	</script>
@endsection
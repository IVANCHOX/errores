@extends('base')

@section('title')
Companies
@endsection

@section('container')
	<div class="html-content" style="display: none" >
		{{ $cadHTML }}
	</div>

	<div class="row">
		<div class="col-md-8">
			<nav aria-label="Page navigation">
			  <ul class="pagination">
			    <li >
			      <a href="#" aria-label="Previous">
			        <span aria-hidden="true">&laquo;</span>
			      </a>
			    </li>
			    {{-- <li><a href="#">1</a></li>
			    <li><a href="#">2</a></li>
			    <li><a href="#">3</a></li>
			    <li><a href="#">4</a></li>
			    <li><a href="#">5</a></li> --}}
			    <li>
			      <a aria-label="Next" id="a-href">
			        <span aria-hidden="true">&raquo;</span>
			      </a>
			    </li>
			  </ul>
			</nav>
		</div>
		<div class="col-md-4" style="padding-top: 1.7em">
			<div class="text-right">
				<small><b>Get Tiker on <a href="https://finviz.com/">https://finviz.com/</a></b></small>
			</div>
		</div>
	</div>
	
	<button onclick="guardarCompanies()">guardar</button>
	<table class="table table-condensed table-hover table-striped table-bordered" id="tikers">
		<thead>
			<tr>
				<th class="text-center">N°</th>
				<th class="text-center">TIKER/SYMBOL</th>
				<th class="text-center">NAME COMPANY</th>
				<th class="text-center">COUNTRY</th>
				<th class="text-center">INDUSTRY</th>
			</tr>
		</thead>
		<tbody class="tbod">
			
		</tbody>
	</table>

	<input type="hidden" name="_token" value="{!! csrf_token() !!}" id="token">
@endsection

@section('scripts-vue')
	<script>
		var arreglo = [];
		var arregloTodo = [];

		
		var cadHTML = $.parseHTML( $('.html-content').text() );
		var secondCadHTML = $.parseHTML(cadHTML[47].innerHTML);
		var threeCadHTML = $.parseHTML(secondCadHTML[1].innerHTML);
		var fourCadHTML = $.parseHTML(threeCadHTML[0].innerHTML);
		var fiveCadHTML = $.parseHTML(fourCadHTML[6].innerHTML);
		var sixCadHTML = $.parseHTML(fiveCadHTML[1].innerHTML);
		var sevenCadHTML = $.parseHTML(sixCadHTML[1].innerHTML);
		var eightCadHTML = $.parseHTML(sevenCadHTML[1].innerHTML);
		
		for (var i = 0; i < eightCadHTML.length; i++) {
			var tiker = $.parseHTML(eightCadHTML[i].innerHTML);
			arreglo[i] = [tiker[2].innerText, tiker[3].innerText, tiker[6].innerText, tiker[5].innerText, tiker[1].innerText,  tiker[4].innerText];
		}

		arregloTodo.push(arreglo);

		var cont = 0;
		
		for (var i = 0; i < arregloTodo.length; i++) {
			for (var j = 0; j <21; j++) {
				if(j!=0){
					cont = cont + 1;
					$('.tbod').append('<tr><td>'+arregloTodo[i][j][4]+'</td><td><a href="/company/'+arregloTodo[i][j][0]+'">'+arregloTodo[i][j][0]+'</a></td><td><a href="/company/'+arregloTodo[i][j][0]+'">'+arregloTodo[i][j][1]+'</a></td><td>'+arregloTodo[i][j][2]+'</td><td>'+arregloTodo[i][j][3]+'</td></tr>');
				}
				
			}
			
		}

		$('#a-href').attr('href','/companies/'+(parseInt(arregloTodo[0][20][4])+1));

		function guardarCompanies(){
			//provisional para guardar en la bd
			var token = $('#token').val();

			$.ajax({
	            headers: {'X-CSRF-Token':token},
	            url:"{{ url('/ajax/save/companies') }}",
	            data: {arreglo:arregloTodo},
	            type:'POST',
	            dataType:'json',
	            success: function(data){
	            	console.log(data);
	            }
	        });
		}
	</script>
@endsection

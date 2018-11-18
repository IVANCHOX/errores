@extends('base')

@section('search')
	@include('search')
@endsection

@section('container')

	<div id="index-app">
		
		{{-- <div v-show="showWrap==true">
			<div class="list-group">
			  <a v-for="item in allCompanies" v-bind:href="'/company/'+item.symbol" class="list-group-item" ><b>@{{ item.symbol }}</b> | @{{ item.name }}</a>
			  
			</div>
		</div> --}}
		{{-- <div v-show="showWrap==false" class="text-center">
			Loading ...
		</div> --}}

		<h3>Todas las Compañias</h3>


		<table class="table table-condensed table-bordered table-striped" id="companies">

			<thead>
				<tr>
					<th>N°</th>
					<th>Símbolo</th>
					<th>Compañía</th>
					<th>Industria</th>
					<th>Sector</th>
					<th>País</th>
				</tr>
			</thead>
			<tbody>
				@foreach($companies as $company)
				<tr>
					<td><span class="label label-default">{{ $company->nro }}</span></td>
					<td><a href="{{ url('/empresa') }}/{{ $company->tiker }}/resumen">{{ $company->tiker }}</a></td>
					<td><a href="{{ url('/empresa') }}/{{ $company->tiker }}/resumen">{{ $company->company }}</a></td>
					<td>{{ $company->industry }}</td>
					<td>{{ $company->sector }}</td>
					<td>{{ $company->country }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>

		
		
	</div>

@endsection

@section('scripts-vue')
	<script src="{{ asset('js/vue-files/index.js') }}"></script>

	<script>
		$('#companies').DataTable({
			"pageLength": 50, 
		});
	</script>
	
@endsection
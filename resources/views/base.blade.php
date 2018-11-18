<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GS of F | @yield('title') </title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.min.css') }}">
    

    <!-- Owner styles -->
    <link rel="stylesheet" href="{{ asset('css/own-styles.css') }}">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<style>
		body{
			font-family: 'Open Sans', sans-serif;
		}
	</style>



</head>
<body>
	<header id="header-app">
		<div class="container">
			<h1 class="text-center">GetSomething of Finances</h1>
			
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<p class="text-center">
						Obtener información muy importante de Yahoo Finanzas.
					</p>
					{{-- @yield('search') --}}
				</div>
			</div>
		</div>

	</header>
    <div style="height: 154px">
    	
    </div>

	<div class="container">
		@yield('container')
	</div>

	<br>
	<footer class="container">
		<div class="row">
			<div class="col-md-12 text-center" style="padding: 1em">
				Desarrollado por @jhonazsh
			</div>
		</div>
	</footer>
	<script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
	<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>
	<!-- Vue.js Library -->
	<script src="https://cdn.jsdelivr.net/npm/vue"></script>

	<!-- Files js use Vue.js -->
	{{-- <script src="{{ asset('js/vue-files/header.js') }}"></script> --}}
	@yield('scripts-vue')
    
</body>
</html>



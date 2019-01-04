<!DOCTYPE html>
<html lang="ru" class="position-relative h-100">
<head>
	<meta charset="UTF-8">
	<title>@yield('title')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	{{--<meta name="csrf-token" content="{{ csrf_token() }}">--}}
	<link type="text/css" rel="stylesheet" href="css/app.css">
	<script src="js/vue.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.15.2/axios.js"></script>
</head>
<body>
@includeWhen(isset($msg),'parts.msg')
@includeWhen(isset($errors),'parts.errors')
@include('parts.acc-grid-template')
<div id="app">
	<h6 class="bread-crumbs">@{{ breadCrumbs }}</h6>
	<h1 class="page-head">@{{ pageHead }}</h1>
	<div class="add-new-channel">
		<button v-if="isVisibleAddBtn" @click="addNewChannel">Add new channel</button>
	</div>
	@section('app')@show
</div>
<footer>
	@stack('scripts')
</footer>
</body>
</html>
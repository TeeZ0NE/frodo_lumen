@extends('layout')
@section('title', 'app')
@section('app')
	<div class="data-table">
		<user-message class="msg" v-bind:class="[ hasError ? errorMsg : '' ]">@{{ message }}</user-message>

		@{{ channels }}<br>
		<acc-grid
				:channels="channels"
				:columns="columnHeaders"
				:url="url">
		</acc-grid>
	</div>




@endsection
@push('scripts')
	<script src="js/app.js"></script>
	{{--<script>vm.channels = @json($users);</script>--}}
@endpush
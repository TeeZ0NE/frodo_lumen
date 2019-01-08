@extends('layout')
@section('title', 'app')
@section('app')
<div class="data-table">
    <user-message class="msg" v-bind:class="[ hasError ? 'errorMsg' : '' ]">@{{ message }}</user-message>

    <acc-grid :channels="channels" :columns="columnHeaders" :url="url" v-show="!isPosts">
    </acc-grid>
    <posts-grid v-if="isPosts" :columns="columnPostsHeaders" :posts="posts"></posts-grid>
</div>

@endsection
@push('scripts')
<script src="js/app.js"></script>
@endpush
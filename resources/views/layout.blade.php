<!DOCTYPE html>
<html lang="ru" class="position-relative h-100">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="css/app.css">
    <script src="js/vue.js"></script>
</head>

<body>
    @includeWhen(isset($msg),'parts.msg')
    @includeWhen(isset($errors),'parts.errors')
    @include('parts.acc-grid-template')
    @include('parts.posts')
    <div id="app">
    
    <ul class="nav">
            <li v-for="(navItem, index) in navItems">
                <span :class="{'nav-active': isNavActive(index)}" @click="toHome">@{{navItem.title}}</span>
                <span v-if="isNavActive(index)">@{{navSpacer}}</span>
            </li>
        </ul>
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
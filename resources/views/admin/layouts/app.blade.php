<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>{{config('app.name')}}</title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	@include('admin.layouts.partials.styles')
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
	<header class="app-header navbar">
		<button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand" href="#">
			<img src="{{ asset('img/logo/logo.png') }}" width="65" alt="{{ env('APP_NAME') }}">
		</a>
		<button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
			<span class="navbar-toggler-icon"></span>
		</button>

		<ul class="nav navbar-nav ml-auto">
			<li class="nav-item d-md-down-none">
				<a class="nav-link" href="#">
					<i class="icon-bell"></i>
					<span class="badge badge-pill badge-danger">5</span>
				</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link" style="margin-right: 10px" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
					{{ Auth::user()->name }}
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<div class="dropdown-header text-center">
						<strong>Account</strong>
					</div>
					<a class="dropdown-item" href="#">
						<i class="fa fa-envelope-o"></i> Messages
						<span class="badge badge-success">42</span>
					</a>
					<div class="dropdown-header text-center">
						<strong>Settings</strong>
					</div>
					<a class="dropdown-item" href="#">
						<i class="fa fa-user"></i> Profile</a>
					<a class="dropdown-item" href="#">
						<i class="fa fa-wrench"></i> Settings</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#">
						<i class="fa fa-shield"></i> Lock Account</a>
					<a href="{{ url('/logout') }}" class="dropdown-item btn btn-default btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
						<i class="fa fa-lock"></i>Logout
					</a>
					<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
						@csrf
					</form>
				</div>
			</li>
		</ul>
	</header>

	<div class="app-body">
		@include('admin.layouts.sidebar')
		<main class="main">
			@include('coreui-templates::common.errors')
			<div class="clearfix"></div>
			@include('flash::message')
			<div class="clearfix"></div>
			@yield('content')
		</main>
	</div>
	<footer class="app-footer">
		<div>
			<strong>Copyright © {{ date('Y') }} <a href="{{ env('APP_URL') }}">{{ env('APP_NAME') }}</a>.</strong>
			All rights reserved.
		</div>
		<div class="ml-auto">
			<b>Version</b> v0.0.1
		</div>
	</footer>
</body>

@include('admin.layouts.partials.scripts')

</html>

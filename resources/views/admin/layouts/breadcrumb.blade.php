<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="{{ env('APP_URL') }}">
			@lang('general.home')
		</a>
	</li>
	@if(Request::is('admin*'))
	<li class="breadcrumb-item">
		<a href="{{Request::url()}}">
			Admin
		</a>
	</li>
	@endif
	@if(!Request::is('*home'))
	<li class="breadcrumb-item active">{{$title}}</li>
	@endif

	<!-- Breadcrumb Menu right-->
	<li class="breadcrumb-menu d-md-down-none">
		<div class="btn-group" role="group" aria-label="Button group">
			<a class="btn" href="#">
				<i class="icon-settings"></i> @lang('general.settings')
			</a>
		</div>
	</li>
</ol>
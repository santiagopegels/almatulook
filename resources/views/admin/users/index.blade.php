@extends('admin.layouts.app')

@section('content')

<!-- Breadcrumb-->
@include('admin.layouts.breadcrumb', ['title'=>__('model.users'), 'link_to'=>'admin.users.index'])

<div class="container-fluid">
	<div class="animated fadeIn">

		@role(['super-administrador',' administrador'])
		<div class="clearfix">
			<users-index title="{!! __('model.users') !!}" />
		</div>
		@endrole

	</div>
</div>
@endsection

@push('scripts')
@include('admin.layouts.partials.validators', ['empty_options'=>true])
@endpush

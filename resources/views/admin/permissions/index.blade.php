@extends('admin.layouts.app')

@section('content')

<!-- Breadcrumb-->
@include('admin.layouts.breadcrumb', ['title'=>__('model.permissions'), 'link_to'=>'admin.permissions.index'])

<div class="container-fluid">
	<div class="animated fadeIn">
        <div id="app">
            <router-view></router-view>
        </div>
	</div>
</div>
@endsection

@push('scripts')
@include('admin.layouts.partials.validators', ['empty_options'=>true])
@endpush

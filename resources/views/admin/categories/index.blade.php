@extends('admin.layouts.app')

@section('content')

    <!-- Breadcrumb-->
    @include('admin.layouts.breadcrumb', ['title'=>__('model.categories'), 'link_to'=>'admin.categories.index'])

    <div class="container-fluid">
        <div class="animated fadeIn">
            <categories-index title="{!! __('model.categories') !!}" />
        </div>
    </div>
@endsection

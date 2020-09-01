@extends('admin.layouts.app')

@section('content')

    <!-- Breadcrumb-->
    @include('admin.layouts.breadcrumb', ['title'=>__('model.attributes'), 'link_to'=>'admin.attributes.index'])

    <div class="container-fluid">
        <div class="animated fadeIn">
            <attributes-index title="{!! __('model.attributes') !!}" />
        </div>
    </div>
@endsection

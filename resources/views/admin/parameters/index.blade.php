@extends('admin.layouts.app')

@section('content')

    <!-- Breadcrumb-->
    @include('admin.layouts.breadcrumb', ['title'=>__('model.parameters'), 'link_to'=>'admin.parameters.index'])

    <div class="container-fluid">
        <div class="animated fadeIn">
            <parameters-index title="{!! __('model.parameters') !!}" />
        </div>
    </div>
@endsection

@push('scripts')
    @include('admin.layouts.partials.validators', ['empty_options'=>true])
@endpush

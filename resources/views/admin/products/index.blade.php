@extends('admin.layouts.app')

@section('content')

    <!-- Breadcrumb-->
    @include('admin.layouts.breadcrumb', ['title'=>__('model.products'), 'link_to'=>'admin.products.index'])

    <div class="container-fluid">
        <div class="animated fadeIn">
            <products-index title="{!! __('model.products') !!}" />
        </div>
    </div>
@endsection

@push('scripts')
    @include('admin.layouts.partials.validators', ['empty_options'=>true])
@endpush

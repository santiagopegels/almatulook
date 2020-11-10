@role(['admin',' administrador'])
<li class="nav-title">AlmaTuLook</li>
<li class="nav-item {{ Request::is('store*') ? 'active' : '' }}">
    <a class="nav-link {{ Request::is('store*') ? 'active' : '' }}" href=" {!! route('admin.purchases.index') !!}">
        <i class="nav-icon icon-cursor"></i>
        <span>@lang('model.store')</span>
    </a>
</li>
<li class="nav-item {{ Request::is('products*') ? 'active' : '' }}">
    <a class="nav-link {{ Request::is('products*') ? 'active' : '' }}" href=" {!! route('admin.products.index') !!}">
        <i class="nav-icon icon-cursor"></i>
        <span>@lang('model.products')</span>
    </a>
</li>
<li class="nav-title">Configuración</li>
<li class="nav-item {{ Request::is('categories*') ? 'active' : '' }}">
    <a class="nav-link {{ Request::is('categories*') ? 'active' : '' }}" href=" {!! route('admin.categories.index') !!}">
        <i class="nav-icon icon-cursor"></i>
        <span>@lang('model.categories')</span>
    </a>
</li>
<li class="nav-item {{ Request::is('attributes*') ? 'active' : '' }}">
    <a class="nav-link {{ Request::is('attributes*') ? 'active' : '' }}" href=" {!! route('admin.attributes.index') !!}">
        <i class="nav-icon icon-cursor"></i>
        <span>@lang('model.attributes')</span>
    </a>
</li>
<li class="nav-item {{ Request::is('parameters*') ? 'active' : '' }}">
    <a class="nav-link {{ Request::is('parameters*') ? 'active' : '' }}" href=" {!! route('admin.parameters.index') !!}">
        <i class="nav-icon icon-cursor"></i>
        <span>@lang('model.parameters')</span>
    </a>
</li>
<li class="nav-title">Administrador</li>
<li class="nav-item {{ Request::is('users*') ? 'active' : '' }}">
    <a class="nav-link {{ Request::is('users*') ? 'active' : '' }}" href=" {!! route('admin.users.index') !!}">
        <i class="nav-icon icon-cursor"></i>
        <span>@lang('model.users')</span>
    </a>
</li>
<li class="nav-item {{ Request::is('roles*') ? 'active' : '' }}">
    <a class="nav-link {{ Request::is('roles*') ? 'active' : '' }}" href=" {!! route('admin.roles.index') !!}">
        <i class="nav-icon icon-cursor"></i>
        <span>@lang('model.roles')</span>
    </a>
</li>
<li class="nav-item {{ Request::is('permissions*') ? 'active' : '' }}">
    <a class="nav-link {{ Request::is('permissions*') ? 'active' : '' }}" href=" {!! route('admin.permissions.index') !!}">
        <i class="nav-icon icon-cursor"></i>
        <span>@lang('model.permissions')</span>
    </a>
</li>
@endrole

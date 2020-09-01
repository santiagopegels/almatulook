@role(['super-administrador',' administrador'])
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

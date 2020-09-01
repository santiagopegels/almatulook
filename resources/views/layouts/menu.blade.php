<li class="nav-item {{ Request::is('admin/attributes*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.attributes.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Attributes</span>
    </a>
</li>

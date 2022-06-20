<li class=" {{ Route::is('admin.support.*') ? 'active active-menu' : '' }}">

    <a href="#support_menu" class="iq-waves-effect collapsed" data-toggle="collapse"
        aria-expanded="{{ Route::is('admin.support.*') ? 'true' : 'false' }}">
        <i class="las la-headset"></i><span>Support</span><i class="ri-arrow-right-s-line iq-arrow-right"></i>
    </a>
    <ul id="support_menu" class="iq-submenu collapse  {{ Route::is('admin.support.*') ? 'show' : '' }}"
        data-parent="#iq-sidebar-toggle">
        <li class="{{ Route::is('admin.support.template') ? 'active' : '' }}"><a href="{{ route('admin.support.template') }}"><i
                    class="lar la-circle"></i> All Ticket</a></li>
    </ul>
</li>
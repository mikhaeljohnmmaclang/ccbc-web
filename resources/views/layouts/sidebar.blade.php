<!-- Dashboard -->
<li class="menu-item @yield('dashboard')">
  <a href="{{ route('dashboard') }}" class="menu-link">
    <i class="menu-icon tf-icons bx bx-home-circle"></i>
    <div data-i18n="Analytics">Dashboard </div>
  </a>
</li>

<li class="menu-header small text-uppercase">
  <span class="menu-header-text">MENUS</span>
</li>


<li class="menu-item @yield('members')">
  <a href="{{ route('members') }}" class="menu-link">
    <i class="menu-icon tf-icons bx bx-user"></i>
    <div data-i18n="Basic">Members</div>
  </a>
</li>

<li class="menu-item @yield('transactions')">
  <a href="{{ route('transactions') }}" class="menu-link">
    <i class="menu-icon tf-icons bx bx-detail"></i>
    <div data-i18n="Basic">Transactions</div>
  </a>
</li>


<li class="menu-item @yield('expenses')">
  <a href="{{ route('expenses') }}" class="menu-link">
    <i class="menu-icon tf-icons bx bx-collection"></i>
    <div data-i18n="Basic">Expenses</div>
  </a>
</li>

<li class="menu-item @yield('ministries')">
  <a href="{{ route('ministries') }}" class="menu-link">
    <i class="menu-icon tf-icons bx bx-heart"></i>
    <div data-i18n="Basic">Ministries</div>
  </a>
</li>




<li class="menu-header small text-uppercase">
  <span class="menu-header-text">Admin</span>
</li>

<li class="menu-item open @yield('maintenance')">
  <a href="javascript:void(0);" class="menu-link menu-toggle">
    <i class="menu-icon tf-icons bx bx-dock-top"></i>
    <div data-i18n="Menu">Menu</div>
  </a>
  <ul class="menu-sub">
  <li class="menu-item @yield('services')">
      <a href="{{ route('services') }}" class="menu-link">
        <div data-i18n="Services">Services</div>
      </a>
    </li>
  @if(Auth::user()->role == 'Admin')
    <li class="menu-item @yield('users')">
      <a href="{{ route('users') }}" class="menu-link">
        <div data-i18n="Users">Users</div>
      </a>
    </li>
    @endif

    <li class="menu-item @yield('settings')">
      <a href="{{ route('settings') }}" class="menu-link">
        <div data-i18n="Settings">Settings</div>
      </a>
    </li>
  </ul>
</li>


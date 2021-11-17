<li class="nav-item">
    <a href="{{ route('seafoodrestos.index') }}"
       class="nav-link {{ Request::is('seafoodrestos*') ? 'active' : '' }}">
        <p>Seafoodrestos</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('logs.index') }}"
       class="nav-link {{ Request::is('logs*') ? 'active' : '' }}">
        <p>Logs</p>
    </a>
</li>



<nav class="main-header navbar navbar-expand navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="javascript:;">
                <i class="fa fa-bars"></i>
            </a>
        </li>
    </ul>

    {% if auth.guard('admin').user() is not empty %}
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="javascript:;">
                <i class="fa fa-user"></i>
                {{ auth.guard('admin').user().name | e }}
                <span class="fa fa-angle-down"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ url('logout') }}" class="dropdown-item">
                    Logout
                    <i class="fa fa-sign-out float-right"></i>
                </a>
            </div>
        </li>
    </ul>
    {% endif %}
</nav>

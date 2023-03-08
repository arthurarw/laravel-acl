<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link @if(request()->is('manager/roles*')) active @endif"
                   href="{{route('users.index')}}">
                    <span data-feather="home"></span>
                    Home <span class="sr-only">(current)</span>
                </a>
            </li>

            @foreach($modules as $module)
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>{{$module['name']}}</span>
                </h6>
                @foreach($module['resources'] as $resource)
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{route($resource['resource'])}}">
                            <span data-feather="file"></span>
                            {{ $resource['name'] }}
                        </a>
                    </li>
                @endforeach
            @endforeach
        </ul>
    </div>
</nav>

 <!-- Sidebar On Left Menu -->
 <ul class="navbar-nav sidebar sidebar-dark accordion" style="background-color: #24396f" id="accordionSidebar">
     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
         <div class="sidebar-brand-text mx-3">QRUN WEBSITE</div>
     </a>
     <!-- Divider -->
     <hr class="sidebar-divider my-0">
     <!-- Nav Item - Dashboard -->
     <li class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
         <a class="nav-link" href="{{ route('dashboard') }}">
             <i class="fas fa-fw fa-tachometer-alt"></i>
             <span>Dashboard</span></a>
     </li>
     <!-- Divider -->
     <hr class="sidebar-divider">
     <!-- Heading -->
     <div class="sidebar-heading">
         MORE MENU
     </div>
     <!-- Nav Item - Charts -->
     @if (Auth::user()->hasRole('superadmin'))
         <li
             class="nav-item {{ Route::is('users') || Route::is('users.blocked') || Route::is('users.pending') ? 'active' : '' }}">
             <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                 aria-controls="collapseTwo">
                 <i class="fas fa-fw fa-users"></i>
                 <span>Manage Users</span>
             </a>
             <div id="collapseTwo"
                 class="collapse {{ Route::is('users') || Route::is('users.blocked') || Route::is('users.pending') || Route::is('users-limit.index') ? 'show' : '' }}"
                 aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <a class="collapse-item {{ Route::is('users') ? 'active' : '' }}" href="{{ route('users') }}">All
                         Users</a>
                     <a class="collapse-item {{ Route::is('users.blocked') ? 'active' : '' }}"
                         href="{{ route('users.blocked') }}">Blocked/Deleted Users</a>
                     <a class="collapse-item {{ Route::is('users.pending') ? 'active' : '' }}"
                         href="{{ route('users.pending') }}">Pending Approved</a>
                     <a class="collapse-item {{ Route::is('users-limit.index') ? 'active' : '' }}"
                         href="{{route('users-limit.index')}}">Users Limit</a>
                 </div>
             </div>
         </li>
         <li
             class="nav-item {{ Route::is('place') || Route::is('place.getDeleted') || Route::is('place.create') ? 'active' : '' }}">
             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                 aria-expanded="true" aria-controls="collapseUtilities">
                 <i class="fas fa-fw fa-map"></i>
                 <span>Manage Place</span>
             </a>
             <div id="collapseUtilities"
                 class="collapse {{ Route::is('place') || Route::is('place.getDeleted') || Route::is('place.create') ? 'show' : '' }}"
                 aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <a class="collapse-item {{ Route::is('place') ? 'active' : '' }}"
                         href="{{ route('place') }}">Manage
                         Place</a>
                     <a class="collapse-item {{ Route::is('place.getDeleted') ? 'active' : '' }}"
                         href="{{ route('place.getDeleted') }}">Deleted Place</a>
                     <a class="collapse-item {{ Route::is('place.create') ? 'active' : '' }}"
                         href="{{ route('place.create') }}">Create Place</a>
                 </div>
             </div>
         </li>
         <li class="nav-item {{ Route::is('event') ? 'active' : '' }}">
             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                 aria-expanded="true" aria-controls="collapsePages">
                 <i class="fas fa-fw fa-folder"></i>
                 <span>Manage Event</span>
             </a>
             <div id="collapsePages" class="collapse {{ Route::is('event') ? 'show' : '' }}"
                 aria-labelledby="headingPages" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <a class="collapse-item {{ Route::is('event') ? 'active' : '' }}" href="{{ route('event') }}">Manage Event</a>
                 </div>
             </div>
         </li>
         {{-- Manage Comment --}}
         <li class="nav-item {{ Route::is('comments.admin') ? 'show' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages3"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-envelope fa-fw"></i>
                <span>Manage Comments</span>
            </a>
            <div id="collapsePages3" class="collapse {{ Route::is('comments.admin') ? 'show' : '' }}"
                aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ Route::is('comments.admin') ? 'active' : '' }}" href="{{route('comments.admin')}}">Manage Comments</a>
                </div>
            </div>
        </li>
     @else
         <li class="nav-item {{ Route::is('place.myplace') ? 'active' : '' }}">
             <a class="nav-link" href="{{ route('place.myplace') }}">
                 <i class="fas fa-fw fa-map"></i>
                 <span>My Place</span></a>
         </li>
         <li class="nav-item">
             <a class="nav-link collapsed {{ Route::is('myevent.users') ? 'active' : '' }}" href="#"
                 data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                 <i class="fas fa-fw fa-folder"></i>
                 <span>Manage Event</span>
             </a>
             <div id="collapsePages" class="collapse {{ Route::is('myevent.users') ? 'show' : '' }}"
                 aria-labelledby="headingPages" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <a class="collapse-item {{ Route::is('myevent.users') ? 'active' : '' }}" href="{{ route('myevent.users') }}">Manage Event</a>
                 </div>
             </div>
         </li>
     @endif
     <hr class="sidebar-divider">
     <!-- Heading -->
     <div class="sidebar-heading">
         SETTINGS
     </div>
     <li class="nav-item">
        <a class="nav-link collapsed" href="#"
            data-toggle="collapse" data-target="#collapsePages2" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-cog"></i>
            <span>Settings</span>
        </a>
        <div id="collapsePages2" class="collapse {{ Route::is('settings.general') || Route::is('place-limit.index') ? 'show' : '' }}"
            aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item  {{ Route::is('settings.general') ? 'active' : '' }}" href="{{route('settings.general')}}">General</a>
                {{-- <a class="collapse-item">Roles</a> --}}
                <a class="collapse-item {{ Route::is('place-limit.index') ? 'active' : '' }}" href="{{route('place-limit.index')}}">Place Limit</a>
                {{-- <a class="collapse-item {{ Route::is('place-limit.index') ? 'active' : '' }}" href="{{route('place-limit.index')}}">Place Limit</a> --}}
            </div>
        </div>
    </li>

     <!-- Divider -->
     <hr class="sidebar-divider">
     <li class="nav-item {{Route::is('profile') ? 'active' : ''}}">
         <a class="nav-link" href="{{route('profile')}}">
             {{-- <i class="fas fa-fw fa-door"></i> --}}
             <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
             <span>My Profile</span></a>
     </li>
     <!-- Nav Item - Dashboard -->
     <li class="nav-item">
         <a class="nav-link" href="{{ route('logout') }}">
             {{-- <i class="fas fa-fw fa-door"></i> --}}
             <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
             <span>Logout</span></a>
     </li>
     <!-- Sidebar Toggler (Sidebar) -->
     <div class="text-center d-none d-md-inline">
         <button class="rounded-circle border-0" id="sidebarToggle"></button>
     </div>

 </ul>
 <!-- End of Sidebar -->

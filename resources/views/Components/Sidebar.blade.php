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
             class="nav-item {{ Route::is('users') || Route::is('users.blocked') || Route::is('users.pending') || Route::is('users-limit.index') || Route::is('pending-verify.index') ? 'active' : '' }}">
             <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                 aria-controls="collapseTwo">
                 <i class="fas fa-fw fa-users"></i>
                 <span>@lang('messages.navigation_admin.manage_users.index')</span>
             </a>
             @php
                 $pendingUser = \App\Helpers\SidebarHelper::getPendingUser();
             @endphp
             <div id="collapseTwo"
                 class="collapse {{ Route::is('users') || Route::is('users.blocked') || Route::is('users.pending') || Route::is('users-limit.index') || Route::is('pending-verify.index') ? 'show' : '' }}"
                 aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <a class="collapse-item {{ Route::is('users') ? 'active' : '' }}"
                         href="{{ route('users') }}">@lang('messages.navigation_admin.manage_users.all_users')</a>
                     <a class="collapse-item {{ Route::is('users.blocked') ? 'active' : '' }}"
                         href="{{ route('users.blocked') }}">@lang('messages.navigation_admin.manage_users.deleted_users')</a>
                     <a class="collapse-item {{ Route::is('users.pending') ? 'active' : '' }}"
                         href="{{ route('users.pending') }}">@lang('messages.navigation_admin.manage_users.pending_approved') <b
                             style="background-color: #4e73df; padding:4px; color:white; border-radius:5px">{{ $pendingUser }}</b></a>
                     <a class="collapse-item {{ Route::is('users-limit.index') ? 'active' : '' }}"
                         href="{{ route('users-limit.index') }}">@lang('messages.navigation_admin.manage_users.users_limit')</a>
                     <a class="collapse-item {{ Route::is('pending-verify.index') ? 'active' : '' }}"
                         href="{{ route('pending-verify.index') }}">@lang('messages.navigation_admin.manage_users.pending_verify')</a>
                 </div>
             </div>
         </li>
         <li
             class="nav-item {{ Route::is('place') || Route::is('place.getDeleted') || Route::is('place.create') ? 'active' : '' }}">
             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                 aria-expanded="true" aria-controls="collapseUtilities">
                 <i class="fas fa-fw fa-map"></i>
                 <span>@lang('messages.navigation_admin.manage_place.manage_place')</span>
             </a>
             <div id="collapseUtilities"
                 class="collapse {{ Route::is('place') || Route::is('place.getDeleted') || Route::is('place.create') ? 'show' : '' }}"
                 aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <a class="collapse-item {{ Route::is('place') ? 'active' : '' }}"
                         href="{{ route('place') }}">@lang('messages.navigation_admin.manage_place.manage_place')</a>
                     <a class="collapse-item {{ Route::is('place.getDeleted') ? 'active' : '' }}"
                         href="{{ route('place.getDeleted') }}">@lang('messages.navigation_admin.manage_place.deleted_place')</a>
                     {{-- <a class="collapse-item {{ Route::is('place.create') ? 'active' : '' }}"
                         href="{{ route('place.create') }}">@lang('messages.navigation_admin.manage_place.create_place')</a> --}}
                 </div>
             </div>
         </li>
         <li class="nav-item {{ Route::is('event') ? 'active' : '' }}">
             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                 aria-expanded="true" aria-controls="collapsePages">
                 <i class="fas fa-fw fa-folder"></i>
                 <span>@lang('messages.navigation_admin.manage_event.manage_event')</span>
             </a>
             <div id="collapsePages" class="collapse {{ Route::is('event') ? 'show' : '' }}"
                 aria-labelledby="headingPages" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <a class="collapse-item {{ Route::is('event') ? 'active' : '' }}"
                         href="{{ route('event') }}">@lang('messages.navigation_admin.manage_event.manage_event')</a>
                 </div>
             </div>
         </li>
         {{-- Manage Comment --}}
         <li class="nav-item {{ Route::is('comments.admin') ? 'active' : '' }} ">
             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages3"
                 aria-expanded="true" aria-controls="collapsePages">
                 <i class="fas  fa-comment fa-fw"></i>
                 <span>@lang('messages.navigation_admin.manage_comments.manage_comments')</span>
             </a>
             <div id="collapsePages3" class="collapse {{ Route::is('comments.admin') ? 'show' : '' }}"
                 aria-labelledby="headingPages" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <a class="collapse-item {{ Route::is('comments.admin') ? 'active' : '' }}"
                         href="{{ route('comments.admin') }}">@lang('messages.navigation_admin.manage_comments.manage_comments')</a>
                 </div>
             </div>
         </li>
        {{-- Manage Gallery --}}

        <li class="nav-item {{Route::is('gallery.index') ? 'active' : ''}} ">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePagesgallery"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-images"></i>
                <span>@lang('messages.navigation_admin.manage_gallery.manage_gallery')</span>
            </a>
            <div id="collapsePagesgallery" class="collapse {{ Route::is('gallery.index') ? 'show' : '' }}"
                aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ Route::is('gallery.index') ? 'active' : '' }}"
                        href="{{ route('gallery.index') }}">@lang('messages.navigation_admin.manage_gallery.manage_gallery')</a>
                </div>
            </div>
        </li>
        {{-- Manage Blog --}}

        <li class="nav-item {{Route::is('blog.index') ? 'active' : ''}} ">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePagesblog"
                aria-expanded="true" aria-controls="collapsePages">
              <i class="fas fa-newspaper"></i>
                <span>@lang('messages.navigation_admin.manage_blog.manage_blog')</span>
            </a>
            <div id="collapsePagesblog" class="collapse {{ Route::is('blog.index') ? 'show' : '' }}"
                aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ Route::is('blog.index') ? 'active' : '' }}"
                        href="{{ route('blog.index') }}">@lang('messages.navigation_admin.manage_blog.manage_blog')</a>
                </div>
            </div>
        </li>

         {{-- Manage Advertise --}}

         <li class="nav-item {{Route::is('advertise.index') ? 'active' : ''}} ">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages4"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-list-alt fa-fw"></i>
                <span>@lang('messages.navigation_admin.manage_advertise.manage_advertise')</span>
            </a>
            <div id="collapsePages4" class="collapse {{ Route::is('advertise.index') ? 'show' : '' }}"
                aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ Route::is('advertise.index') ? 'active' : '' }}"
                        href="{{ route('advertise.index') }}">@lang('messages.navigation_admin.manage_advertise.manage_advertise')</a>
                </div>
            </div>
        </li>

         <hr class="sidebar-divider">
         <!-- Heading -->
         <div class="sidebar-heading">
             @lang('messages.navigation_admin.report.message')
         </div>

          <li class="nav-item {{Route::is('report.index') ? 'active' : ''}} ">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePagesreport"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-table fa-fw"></i>
                <span>@lang('messages.navigation_admin.report.message')</span>
            </a>
            <div id="collapsePagesreport" class="collapse {{ Route::is('report.index') ? 'show' : '' }}"
                aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ Route::is('report.index') ? 'active' : '' }}"
                        href="{{ route('report.index') }}">@lang('messages.navigation_admin.report.message')</a>
                </div>
            </div>
        </li>


         <hr class="sidebar-divider">
         <!-- Heading -->
         <div class="sidebar-heading">
             @lang('messages.navigation_admin.settings.index')
         </div>
         <li class="nav-item {{ Route::is('settings.general') || Route::is('place-limit.index') || Route::is('settings.log-activity') ? 'active' : '' }} ">
             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages2"
                 aria-expanded="true" aria-controls="collapsePages">
                 <i class="fas fa-fw fa-cog"></i>
                 <span>
                     @lang('messages.navigation_admin.settings.index')
                 </span>
             </a>
             <div id="collapsePages2"
                 class="collapse {{ Route::is('settings.general') || Route::is('place-limit.index') || Route::is('settings.log-activity') ? 'show' : '' }}"
                 aria-labelledby="headingPages" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <a class="collapse-item  {{ Route::is('settings.general') ? 'active' : '' }}"
                         href="{{ route('settings.general') }}"> @lang('messages.navigation_admin.settings.general')
                     </a>
                     {{-- <a class="collapse-item">Roles</a> --}}
                     <a class="collapse-item {{ Route::is('place-limit.index') ? 'active' : '' }}"
                         href="{{ route('place-limit.index') }}">
                         @lang('messages.navigation_admin.settings.place_limit')
                     </a>
                     <a class="collapse-item {{ Route::is('settings.log-activity') ? 'active' : '' }}"
                     href="{{route('settings.log-activity')}}">
                     @lang('messages.navigation_admin.settings.log_activity')
                 </a>
                     {{-- <a class="collapse-item {{ Route::is('place-limit.index') ? 'active' : '' }}" href="{{route('place-limit.index')}}">Place Limit</a> --}}
                 </div>
             </div>
         </li>
     @else
         @php
             $limitUser = \App\Helpers\SidebarHelper::getAmountOfLimitUser();
         @endphp

         @if ($limitUser > 1)
             <li
                 class="nav-item {{ Route::is('place') || Route::is('place.getDeleted') || Route::is('place.create') ? 'active' : '' }}">
                 <a class="nav-link collapsed" href="#" data-toggle="collapse"
                     data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                     <i class="fas fa-fw fa-map"></i>
                     <span>Manage Place</span>
                 </a>
                 <div id="collapseUtilities"
                     class="collapse {{ Route::is('place') || Route::is('place.getDeleted') || Route::is('place.create') ? 'show' : '' }}"
                     aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                     <div class="bg-white py-2 collapse-inner rounded ">
                         <a class="collapse-item {{ Route::is('place') ? 'active' : '' }}"
                             href="{{ route('place') }}">Manage
                             Place</a>
                         <a class="collapse-item {{ Route::is('place.getDeleted') ? 'active' : '' }}"
                             href="{{ route('place.getDeleted') }}">Deleted Place</a>
                         {{-- <a class="collapse-item {{ Route::is('place.create') ? 'active' : '' }}"
                             href="{{ route('place.create') }}">Create Place</a> --}}
                     </div>
                 </div>
             </li>
             <li class="nav-item {{ Route::is('event') ? 'active' : '' }}">
                 <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                     aria-expanded="true" aria-controls="collapsePages">
                     <i class="fas fa-fw fa-folder"></i>
                     <span>@lang('messages.navigation_admin.manage_event.manage_event')</span>
                 </a>
                 <div id="collapsePages" class="collapse {{ Route::is('event') ? 'show' : '' }}"
                     aria-labelledby="headingPages" data-parent="#accordionSidebar">
                     <div class="bg-white py-2 collapse-inner rounded">
                         <a class="collapse-item {{ Route::is('event') ? 'active' : '' }}"
                             href="{{ route('event') }}">@lang('messages.navigation_admin.manage_event.manage_event')</a>
                     </div>
                 </div>
             </li>
             <li class="nav-item {{ Route::is('comments.admin') ? 'show' : '' }}">
                 <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages3"
                     aria-expanded="true" aria-controls="collapsePages">
                     <i class="fas  fa-comment fa-fw"></i>
                     <span>Manage Comments</span>
                 </a>
                 <div id="collapsePages3" class="collapse {{ Route::is('comments.admin') ? 'show' : '' }}"
                     aria-labelledby="headingPages" data-parent="#accordionSidebar">
                     <div class="bg-white py-2 collapse-inner rounded">
                         <a class="collapse-item {{ Route::is('comments.admin') ? 'active' : '' }}"
                             href="{{ route('comments.admin') }}">Manage Comments</a>
                     </div>
                 </div>
             </li>
         @else
             <li class="nav-item {{ Route::is('place.myplace') ? 'active' : '' }}">
                 <a class="nav-link" href="{{ route('place.myplace') }}">
                     <i class="fas fa-fw fa-map"></i>
                     <span>@lang('messages.navigation_admin.my_place')</span></a>
             </li>
             <li class="nav-item">
                 <a class="nav-link collapsed {{ Route::is('myevent.users') ? 'active' : '' }}" href="#"
                     data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
                     aria-controls="collapsePages">
                     <i class="fas fa-fw fa-folder"></i>
                     <span>@lang('messages.navigation_admin.manage_event.manage_event')</span>
                 </a>
                 <div id="collapsePages" class="collapse {{ Route::is('myevent.users') ? 'show' : '' }}"
                     aria-labelledby="headingPages" data-parent="#accordionSidebar">
                     <div class="bg-white py-2 collapse-inner rounded">
                         <a class="collapse-item {{ Route::is('myevent.users') ? 'active' : '' }}"
                             href="{{ route('myevent.users') }}">@lang('messages.navigation_admin.manage_event.manage_event')</a>
                     </div>
                 </div>
             </li>
             <li class="nav-item {{ Route::is('comments.admin') ? 'show' : '' }}">
                 <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages3"
                     aria-expanded="true" aria-controls="collapsePages">
                     <i class="fas  fa-comment fa-fw"></i>
                     <span>@lang('messages.navigation_admin.manage_comments.manage_comments')</span>
                 </a>
                 <div id="collapsePages3" class="collapse {{ Route::is('comments.admin') ? 'show' : '' }}"
                     aria-labelledby="headingPages" data-parent="#accordionSidebar">
                     <div class="bg-white py-2 collapse-inner rounded">
                         <a class="collapse-item {{ Route::is('comments.admin') ? 'active' : '' }}"
                             href="{{ route('comments.admin') }}">@lang('messages.navigation_admin.manage_comments.manage_comments')</a>
                     </div>
                 </div>
             </li>
         @endif

     @endif


     <!-- Divider -->
     <hr class="sidebar-divider">
     <li class="nav-item {{ Route::is('profile') ? 'active' : '' }}">
         <a class="nav-link" href="{{ route('profile') }}">
             {{-- <i class="fas fa-fw fa-door"></i> --}}
             <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
             <span>@lang('messages.navigation_admin.my_profile')</span></a>
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

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    {{-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
    <div class="input-group">
        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
            aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button class="btn btn-primary" type="button">
                <i class="fas fa-search fa-sm"></i>
            </button>
        </div>
    </div>
</form> --}}

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto ">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            {{-- <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
            aria-labelledby="searchDropdown">
            <form class="form-inline mr-auto w-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                        aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div> --}}
        </li>

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">3+</span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December12,
                            2019</div>
                        <span class="font-weight-bold"> A new monthly
                            report is ready to
                            download!</span>
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-success">
                            <i class="fas fa-donate text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 7, 2019</div>
                        $290.29 has been deposited into your account!
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-warning">
                            <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 2, 2019</div>
                        Spending Alert: We've noticed unusually high spending for your account.
                    </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
            </div>
        </li>

        <!-- Nav Item - Messages -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter" id="total-unread-msgs-count"></span>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown" style="max-height:200px; overflow-y:auto;">
                <h6 class="dropdown-header">
                    Message Center
                </h6>
                <div id="unread-msgs-droplist">
                </div>

                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
            </div>
        </li>
        {{-- <li>
            <ul class="za-nav-list"> --}}
        <li class="za-nav-list py-2">
            <div id="google_translate_element1" style="padding: 1em; display: none !important">
            </div>
            <img class="selected-flag" data-src="{{ asset('flags/us-flag.png') }}" alt="" id="selected-flag"
                data-lang="English" data-lang-code="en" loading="lazy" /><i class="ml-2 fas fa-chevron-down"></i>
            <ul class="za-nav-dropdown">
                <li>
                    <img class="flags default" src="{{ asset('flags/us-flag.png') }}" alt="" data-lang-code="en"
                        data-lang="English" />
                </li>
                <li>
                    <img class="flags" src="{{ asset('flags/china-flag.png') }}" alt="" data-lang-code="cn"
                        data-lang="Chinese" />
                </li>
                <li>
                    <img class="flags" src="{{ asset('flags/ger-flag.png') }}" alt="" data-lang-code="de"
                        data-lang="German" />
                </li>
                <li>
                    <img class="flags" src="{{ asset('flags/ita-flag.png') }}" alt="" data-lang-code="it"
                        data-lang="Italian" />
                </li>
                <li>
                    <img class="flags" src="{{ asset('flags/nl-flag.png') }}" alt="" data-lang-code="nl"
                        data-lang="Dutch" />
                </li>
                <li>
                    <img class="flags" src="{{ asset('flags/in.svg') }}" alt="" data-lang-code="hi"
                        data-lang="Hindi" />
                </li>
                <li>
                    <img class="flags" src="{{ asset('flags/in.svg') }}" alt="" data-lang-code="in"
                        data-lang="Tamil" />
                </li>
                <li>
                    <img class="flags" src="{{ asset('flags/jp.svg') }}" alt="" data-lang-code="jp"
                        data-lang="Japanese" />
                </li>
                <li>
                    <img class="flags" src="{{ asset('flags/sp.svg') }}" alt="" data-lang-code="es"
                        data-lang="Spanish" />
                </li>
                <li>
                    <img class="flags" src="{{ asset('flags/id.svg') }}" alt="" data-lang-code="id"
                        data-lang="Indonesian" />
                </li>
                <li>
                    <img class="flags" src="{{ asset('flags/ar.svg') }}" alt="" data-lang-code="ar"
                        data-lang="Arabic" />
                </li>
                <li>
                    <img class="flags" src="{{ asset('flags/phil.svg') }}" alt="" data-lang-code="tl"
                        data-lang="Filipino" />
                </li>
            </ul>
        </li>
        {{-- </ul>
        </li> --}}
        {{-- <li>
            <a class="nav-link dropdown-toggle" href="#" id="langDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ session()->get('locale') }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="langDropdown">

                @if (session()->get('locale') == 'en')
                    <a class="dropdown-item" href="{{ route('changeLang', ['lang' => 'ar']) }}">
                        {{ trans('Arabic') }}
                    </a>
                @else
                    <a class="dropdown-item" href="{{ route('changeLang', ['lang' => 'en']) }}">
                        {{ trans('English') }}
                    </a>
                @endif


            </div>
        </li> --}}

        <div class="topbar-divider d-none d-sm-block">

        </div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                <img class="img-profile rounded-circle w-"
                    src="{{ asset('new_template/assets/img/undraw_profile.svg') }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('admin.user.view_profile', Auth::user()) }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>


                <a class="dropdown-item" href="{{ route('admin.settings.index') }}">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Super Admin Settings
                </a>
                @can('view activity logs')
                    <a class="dropdown-item" href="{{ route('activity_log.index') }}">
                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                        Activity Logs
                    </a>
                @endcan
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>


    </ul>
</nav>
<!-- End of Topbar -->

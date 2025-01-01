<!-- ========== Left Sidebar Start ========== -->
<div class="app-menu">

    <div class="logo-box">
        <a href="#" class="logo-light">
            <img src="/images/logo-light.png" alt="logo" class="logo-lg">
            <img src="/images/logo-sm.png" alt="small logo" class="logo-sm">
        </a>
        <a href="#" class="logo-dark">
            <img src="/images/logo-dark.png" alt="dark logo" class="logo-lg">
            <img src="/images/logo-sm.png" alt="small logo" class="logo-sm">
        </a>
    </div>

    <div class="scrollbar h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">
            <img src="/images/users/user-1.jpg" alt="user-img" title="Mat Helme" class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="dropdown-toggle h5 mb-1 d-block" data-bs-toggle="dropdown">Geneva
                    Kennedy</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user me-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings me-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock me-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out me-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted mb-0">Admin Head</p>
        </div>

        <!--- Sidemenu -->

        <ul id="side-menu" class="menu">

            <li class="menu-title">Navigation</li>

            <li class="menu-item ">
                <a href="#sidebarDashboards" data-bs-toggle="collapse" class="menu-link">
                    <span class="menu-icon">
                        <i data-feather="airplay"></i>
                    </span>
                    <span class="menu-text"> Dashboards </span>
                    <span class="badge bg-success rounded-pill ms-auto">4</span>
                </a>
                <div class="collapse" id="sidebarDashboards">
                    <ul class="sub-menu">
                        <li class="menu-item ">
                            <a href="#" class="menu-link"><span class="menu-text">Dashboard 1</span></a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link"><span class="menu-text">Dashboard 2</span></a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link"><span class="menu-text">Dashboard 3</span></a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link"><span class="menu-text">Dashboard 4</span></a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="menu-title">Apps</li>

            <li class="menu-item">
                <a href="#" class="menu-link">
                    <span class="menu-icon"><i data-feather="calendar"></i></span>
                    <span class="menu-text"> Calendar </span>
                </a>
            </li>

            <li class="menu-item">
                <a href="#" class="menu-link">
                    <span class="menu-icon"><i data-feather="message-square"></i></span>
                    <span class="menu-text"> Chat </span>
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#sidebarCrm" data-bs-toggle="collapse">
                    <span class="menu-icon"><i data-feather="users"></i></span>
                    <span class="menu-text"> 客戶管理 </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarCrm">
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('customers') }}"
                                class="{{ request()->is('customers') ? 'active' : '' }}"><span
                                    class="menu-text">客戶列表</span></a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('user.create') }}"
                                class="{{ request()->is('user.create') ? 'active' : '' }}"><span
                                    class="menu-text">新增客戶</span></a>
                        </li>
                    </ul>
                </div>
            </li>


            <li class="menu-item">
                <a class="menu-link" href="#project" data-bs-toggle="collapse">
                    <span class="menu-icon"><i data-feather="users"></i></span>
                    <span class="menu-text"> 專案管理 </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="project">
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a class="menu-link" href="#"><span class="menu-text">提案未過案</span></a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="#"><span class="menu-text">提案階段</span></a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="#"><span class="menu-text">簽約階段</span></a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="#"><span class="menu-text">期中</span></a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="#"><span class="menu-text">期末</span></a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#plan" data-bs-toggle="collapse">
                    <span class="menu-icon"><i data-feather="users"></i></span>
                    <span class="menu-text"> 方案管理 </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="plan">
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a class="menu-link" href="#"><span class="menu-text">方案列表</span></a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#task" data-bs-toggle="collapse">
                    <span class="menu-icon"><i data-feather="users"></i></span>
                    <span class="menu-text"> 排程管理 </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="task">
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a class="menu-link" href="#"><span class="menu-text">排程列表</span></a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#work" data-bs-toggle="collapse">
                    <span class="menu-icon"><i data-feather="users"></i></span>
                    <span class="menu-text"> 派工管理 </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="work">
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a class="menu-link" href="#"><span class="menu-text">派工列表</span></a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#setting" data-bs-toggle="collapse">
                    <span class="menu-icon"><i data-feather="users"></i></span>
                    <span class="menu-text"> 其他設定 </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="setting">
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('contractStatus') }}"
                                class="{{ request()->is('contractStatus') ? 'active' : '' }}"><span
                                    class="menu-text">簽約類別設定</span></a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('checkStatus') }}"
                                class="{{ request()->is('checkStatus') ? 'active' : '' }}"><span
                                    class="menu-text">計畫狀態類別設定</span></a>
                        </li>
                    </ul>
                </div>
                <div class="collapse" id="setting">
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a class="menu-link" href="#"><span class="menu-text">繳資料列表</span></a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#rpg" data-bs-toggle="collapse">
                    <span class="menu-icon"><i data-feather="users"></i></span>
                    <span class="menu-text"> 報表管理 </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="rpg">
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a class="menu-link" href="#"><span class="menu-text">待更新</span></a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#sidebarCrm" data-bs-toggle="collapse">
                    <span class="menu-icon"><i data-feather="users"></i></span>
                    <span class="menu-text"> 用戶管理 </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarCrm">
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('users') }}"
                                class="{{ request()->is('users') ? 'active' : '' }}"><span
                                    class="menu-text">用戶列表</span></a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('user.create') }}"
                                class="{{ request()->is('user.create') ? 'active' : '' }}"><span
                                    class="menu-text">新增用戶</span></a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>

        {{-- </div> --}}
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->

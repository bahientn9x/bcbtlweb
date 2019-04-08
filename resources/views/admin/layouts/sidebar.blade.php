<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                    <img alt="image" class="img-circle" src="admin/img/profile_small.jpg" />
                </span>
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::guard('users')->user()->name }}</strong>
                    </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route('admin.logout') }}">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li>
                <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span> {{-- <span class="fa arrow"></span> --}}</a>
                {{-- <ul class="nav nav-second-level collapse">
                    <li><a href="index.html">Dashboard v.1</a></li>
                    <li><a href="dashboard_2.html">Dashboard v.2</a></li>
                    <li><a href="dashboard_3.html">Dashboard v.3</a></li>
                    <li><a href="dashboard_4_1.html">Dashboard v.4</a></li>
                    <li><a href="dashboard_5.html">Dashboard v.5 </a></li>
                </ul> --}}
            </li>

            <li>
                <a href="admin/members"><i class="fa fa-user"></i> <span class="nav-label">Thành viên</span></a>
            </li>
            <li>
                <a href="admin/orders"><i class="fa fa-money"></i> <span class="nav-label">Đơn hàng</span></a>
            </li>
            <li>
                <a href="adminrecharge"><i class="fa fa-key"></i><span class="nav-label">Yêu cầu nạp tiền</span></a>
            </li>
            <li>
                <a href="adminwithdrawal"><i class="fa fa-dollar"></i> <span class="nav-label">Yêu cầu rút tiền</span></a>
            </li>
            <li>
                <a href="adminmanagertrade"><i class="fa fa-refresh"></i> <span class="nav-label">Quản lý giao dịch</span></a>
            </li>
            <li>
                <a href="bank"><i class="fa fa-bank"></i> <span class="nav-label">Ngân hàng</span></a>
            </li>
            <li>
                <a href="bankadmin"><i class="fa fa-user-secret"></i> <span class="nav-label">Tài khoản ngân hàng</span></a>
            </li>
        </ul>

    </div>
</nav>
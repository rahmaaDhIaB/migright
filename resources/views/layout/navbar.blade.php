<div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
        {{-- <div class="input-group">
            <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
            <input type="text" class="form-control" placeholder="Type here...">
        </div> --}}
    </div>
    <ul class="navbar-nav  justify-content-end">
        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner mx-2">
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                </div>
            </a>
        </li>

        <li class="nav-item dropdown pe-2 d-flex align-items-center">
            <a href="javascript:;" class="nav-link  p-0" id="dropdownMenuButton" data-bs-toggle="dropdown"
               aria-expanded="false">
                <i class="fa fa-user me-sm-1"></i>


            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                <li class="">
                    <a class="dropdown-item border-radius-md" href="#">
                        <div class="d-flex gap-2">
                            <div class="">
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal">
                                    <span class="font-weight-bold">Profile</span>
                                </h6>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="">
                    <form action="{{route('logout')}}" method="post" id="logout-form">
                        @method('post')
                        @csrf
                        <a class="dropdown-item border-radius-md"
                           onclick="document.getElementById('logout-form').submit()">
                            <div class="d-flex gap-2">
                                <div class="">
                                    <i class="fa fa-sign-out "></i>
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="text-sm font-weight-normal">
                                        <span class="font-weight-bold">{{__('logout')}}</span>
                                    </h6>
                                </div>
                            </div>
                        </a>
                    </form>
                </li>




            </ul>
        </li>

    </ul>
</div>

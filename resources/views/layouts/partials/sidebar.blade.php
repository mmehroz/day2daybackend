
<div class="sidebar" data-color="rose" data-background-color="black" >


    <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->


    <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
            <img src="{!! url('public/assets/img/logo.png') !!}" alt="logo" height="20" class="logo-normal">
        </a>
        <a href="{!! url('') !!}" class="simple-text logo-normal">
            Day 2 Day
        </a></div>
    <div class="sidebar-wrapper">
           

        <div class="user">


            <div class="photo">
                <img src="{{asset('public/assets/img/'. Auth::user()->photo)}}" />
            </div>
            <div class="user-info">
                <a href="{{route('profile.view')}}" class="username">
              <span>
                Welcome, {{Auth::user()->name}}
              </span>
                </a>
            </div>
        </div>
        <ul class="nav">
            
               
            
            <li class="nav-item {{ $activePage == 'dashboard' ? ' active' : '' }} ">
                <a class="nav-link" href="{{route('dashboard')}}">
                    <i class="material-icons">dashboard</i>
                    <p> Dashboard </p>
                </a>

            </li>
            
              <li class="nav-item ">
                <a class="nav-link " data-toggle="collapse" href="#product">
                    <i class="material-icons">business</i>
                    <p> Product
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ $activePage == 'product' ? ' show' : '' }}" id="product">
                    <ul class="nav">
                        <li class="nav-item  {{ $activeSub == 'brand' ? ' active' : '' }}">
                            <a class="nav-link" href="{{route('brands.index')}}">
                                <i class="material-icons">store</i>
                                <span class="sidebar-normal"> Brands </span>
                            </a>
                        </li>
                        <li class="nav-item  {{ $activeSub == 'cat' ? ' active' : '' }}">
                            <a class="nav-link" href="{{route('category.index')}}">
                                <i class="material-icons">category</i>
                                <span class="sidebar-normal"> Category </span>
                            </a>
                        </li>
                        <li class="nav-item {{ $activeSub == 'sub_cat' ? ' active' : '' }}">
                            <a class="nav-link " href="{{route('sub_category.index')}}">
                                <i class="material-icons">subscriptions</i>
                                <span class="sidebar-normal"> Sub Categories </span>
                            </a>
                        </li>
                        <li class="nav-item {{ $activeSub == 'sub_sub_cat' ? ' active' : '' }}">
                            <a class="nav-link " href="{{route('sub_sub_category.index')}}">
                                <i class="material-icons">subtitles</i>
                                <span class="sidebar-normal"> Sub Sub Categories </span>
                            </a>
                        </li>
                        <li class="nav-item {{ $activeSub == 'product' ? ' active' : '' }}">
                            <a class="nav-link " href="{{route('products.index')}}">
                                <i class="material-icons">local_convenience_store</i>
                                <span class="sidebar-normal"> Products </span>
                            </a>
                        </li>
                        <li class="nav-item {{ $activeSub == 'lookup' ? ' active' : '' }}">
                            <a class="nav-link " href="{{route('products.lookup')}}">
                                <i class="material-icons">local_convenience_store</i>
                                <span class="sidebar-normal"> Product Lookup </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
               <li class="nav-item {{ $activePage == 'slider' ? ' active' : '' }} ">
                <a class="nav-link" href="{{route('slider.index')}}">
                    <i class="material-icons">crop_original</i>
                    <p> Slider </p>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link " data-toggle="collapse" href="#user">
                    <i class="material-icons">people</i>
                    <p> User
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ $activePage == 'user' ? ' show' : '' }}" id="user">
                    <ul class="nav">
                        <li class="nav-item  {{ $activeSub == 'user' ? ' active' : '' }}">
                            <a class="nav-link" href="{{route('users.index')}}">
                                <i class="material-icons">people_outline</i>
                                <span class="sidebar-normal"> View All Users </span>
                            </a>
                        </li>
                        <li class="nav-item  {{ $activeSub == 'add_user' ? ' active' : '' }}">
                            <a class="nav-link" href="{{route('users.create')}}">
                                <i class="material-icons">person_add_alt</i>
                                <span class="sidebar-normal"> Add Users </span>
                            </a>
                        </li>
                        <li class="nav-item {{ $activeSub == 'roles' ? ' active' : '' }}">
                            <a class="nav-link " href="{{route('roles.index')}}">
                                <i class="material-icons">lock_open</i>
                                <span class="sidebar-normal"> Roles </span>
                            </a>
                        </li>
                        <li class="nav-item {{ $activeSub == 'permission' ? ' active' : '' }}">
                            <a class="nav-link " href="{{route('permissions.index')}}">
                                <i class="material-icons">check_circle_outline</i>
                                <span class="sidebar-normal"> Permissions </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item {{ $activePage == 'orders' ? ' active' : '' }} ">
                <a class="nav-link" href="{{route('orders.index')}}">
                    <i class="material-icons">card_giftcard</i>
                    <p> Orders </p>
                </a>
            </li>
        </ul>
    </div>
</div>

<nav class="navbar-default navbar-side" role="navigation">
 <div class="sidebar-collapse">
  <ul class="nav" id="main-menu">
   <li class="text-center">
    <img src={{ asset("assets/img/find_user.png") }} class="user-image img-responsive"/>
   </li>
   <li>


{{--
{{{$page}}}
   @if (  === 1)
    I have one record!
@elseif (count($records) > 1)
    I have multiple records!
@else
    I don't have any records!
@endif --}}

    <a @if ( $page === 'dashboard')class="active-menu"@endif  
    href="{{ URL::to('admin') }}"><i class="fa fa-dashboard fa-3x"></i> Dashboard</a>
   </li>
    <li>
     <a  @if ( $page === 'user_mgmt')class="active-menu"@endif 
     href="{{ URL::to('admin/users') }}"><i class="fa fa-user fa-3x"></i> User Management</a>
   </li>
   <li>
     <a  @if ( $page === 'category')class="active-menu"@endif 
     href="{{ URL::to('admin/category') }}"><i class="fa fa-list-ol fa-3x"></i> Dynamic Categoies</a>
   </li>
   <!-- <li>
     <a  href="ui.html"><i class="fa fa-desktop fa-3x"></i> UI Elements</a>
   </li>
   <li>
     <a  href="tab-panel.html"><i class="fa fa-qrcode fa-3x"></i> Tabs &amp; Panels</a>
    </li>
    <li  >
    <a   href="chart.html"><i class="fa fa-bar-chart-o fa-3x"></i> Morris Charts</a>
    </li> 
    <li  >
    <a  href="table.html"><i class="fa fa-table fa-3x"></i> Table Examples</a>
    </li>
    <li  >
    <a  href="form.html"><i class="fa fa-edit fa-3x"></i> Forms </a>
    </li>       
    <li  >
    <a   href="login.html"><i class="fa fa-bolt fa-3x"></i> Login</a>
    </li> 
    <li  >
    <a   href="registeration.html"><i class="fa fa-laptop fa-3x"></i> Registeration</a>
    </li>  -->

    <!-- <li>
    <a href="#"><i class="fa fa-sitemap fa-3x"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">
    <li>
    <a href="#">Second Level Link</a>
    </li>
    <li>
    <a href="#">Second Level Link</a>
    </li>
    <li>
    <a href="#">Second Level Link<span class="fa arrow"></span></a>
    <ul class="nav nav-third-level">
    <li>
        <a href="#">Third Level Link</a>
    </li>
    <li>
        <a href="#">Third Level Link</a>
    </li>
    <li>
        <a href="#">Third Level Link</a>
    </li>

    </ul>
       
    </li>
    </ul>
    </li>  
    <li  >
    <a  href="blank.html"><i class="fa fa-square-o fa-3x"></i> Blank Page</a>
    </li>  -->
    </ul>
               
  </div>
</nav>  
<!-- /. NAV SIDE  -->
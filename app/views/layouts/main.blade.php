<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 @include('layouts.common-css')
 @yield('head')
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">DC</a> 
            </div>
  <div style="color: white;
padding: 15px 50px 5px 50px;
float: right;
font-size: 16px;"> {{Auth::user()->username }} &nbsp; <a style="border-radius:5px;" href="/admin/logout" class="btn btn-danger square-btn-adjust">Logout</a>
 </div>
        </nav>   
           <!-- /. NAV TOP  -->
 @yield('sidebar')
 
<div id="page-wrapper" >
<div id="page-inner">

    @yield('content')
      
</div>
 <!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->

<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    @include('layouts.common-js')
    @yield('script')
    
   
</body>
</html>

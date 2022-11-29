<?php $userAuth = Auth::user(); if( Auth::check() ) { } use App\Models\Categories as catt;use App\main_categorys as mainn; ?>

<div class="navbar">
   <div class="nav navbar-nav floatleft">

      <a href="/">
      <img id="ilogo" class="logo ilogo" src="/public/svg/logo_o.svg" height="45" width="45" style="display: none;">

         <svg id="noilogo" class="logo" height="45" width="45" viewBox="0 0 512 512">
            <g id="dd-loading">
               <circle class="svgRing"/>
            </g>
            <g id="dd-loading1" class="svgc">
               <path class="svgDots"/>
               <circle class="svgCircle"/>
               <path class="svgDot"/>
            </g>
         </svg>
      </a>

      @if(!Request::is('/') && !Request::is('search/*'))
      <form role="search" class="suggest" autocomplete="off" action="{{config('app.appurl')}}/search" method="get">
         <input type="text" class="form-control" name="q" value="" placeholder="Search..." aria-label="search">
         <button onclick="vibrateSimple();" class="search icsearch" aria-label="Justify" title="Search" type="submit">
         </button>
      </form>
      @endif
            @if(Request::is('/'))
            <div class="voidd"></div>
            @endif

      <label class="theme-switch" for="checkbox">
         <input onclick="vibrateSimple()" type="checkbox" id="checkbox" />
         <div role="switch" class="slider round">
            <div role="switch" class="scenary">
               <span class="moon icmoon">
               </span>
               <span class="sun icsun">
               </span>
            </div>
         </div>
      </label>

      <button type="button" onclick="vibrateSimple();" class="navbar-toggle icmenu" aria-label="Right Align">
      </button>
   </div>
   <div class="nc collapse fixed-position">
      <div id="nvbrcls" style="display:none;overflow: auto;">
         <a onclick="vibrateSimple();" id="ncc" class="icclose">
         </a>
      </div>
      <ul class="nav navbar-nav floatright">
         @foreach(mainn::orderBy('id')->take(6)->get(); as $main_category )
         <?php 
         $menus = catt::where('main_cat_id',$main_category->id)->orderBy('main_cat_id')->take(9)->get(); 
         
         ?>
         <li class="dropdown">
            <button onclick="vibrateSimple();" class="nvbtn" data-toggle="dropdown">{{ $main_category->name }}
            <span class="iccaret-down floatright"></span>
            </button>
            <ul itemscope itemtype="http://www.schema.org/SiteNavigationElement" class="dropdown-menu" role="menu" aria-label="dropdownMenu">

               
               @foreach(catt::where('mode','on')->where('main_cat_id',$main_category->id)->orderBy('name')->take(9)->get() as $category )
               <?php $images = App\Models\Query::categoryImages($category->slug); ?>
               @if( $images['total'] != 0 )
               <li itemprop="name" class="dropdown">
                  <a itemprop="url" href="{{config('app.appurl')}}/c/{{$category->slug}}" class="nv-d text-overflow"> {{ $category->name }} </a>
               </li>
               @endif
               @endforeach
               

               @if(catt::count() > 9 )
               <li >
                  <a class="nv-d" href="{{config('app.appurl')}}/type/{{$main_category->slug}}">{{ trans('misc.view_all') }}</a>
               </li>
               @endif
            </ul>
         </li>
         @endforeach
         @if( Auth::check() )
         <li class="dropdown">
            <a href="javascript:void(0);" class="nvbtn u" data-toggle="dropdown">
            <img alt="User" class="img-circle u" src="/public/avatar/{{$userAuth->avatar}}">
            </a>
            <ul class="dropdown-menu dd-close" role="menu" aria-label="dropdownMenu4">
               @if ( $userAuth->role == 'admin' || $userAuth->role == 'editor' )
               <li>
                  <a href="{{config('app.appurl')}}/panel/admin" class="text-overflow">{{ trans('admin.admin') }}</a>
               </li>
               @endif
               <li>
                  <a href="{{config('app.appurl')}}/user/{{$userAuth->username}}" class="myprofile text-overflow">
                  {{ trans('users.my_profile') }}</a>
               </li>
               <li>
                  <a href="{{config('app.appurl')}}/account" class="text-overflow">
                  {{ trans('users.account_settings') }}
                  </a>
               </li>
               <li>
                  <a href="{{config('app.appurl')}}/logout" class="logout text-overflow">
                  {{trans('users.logout')}}
                  </a>
               </li>
            </ul>
         </li>
            @if( Auth::user()->authorized_to_upload == 'yes' )
            <li>
               <a class="nvbtn" href="{{config('app.appurl')}}/upload">
               Upload
               </a>
            </li>
            @endif
         @else

         @if( $settings->registration_active == '1' )
         <li>
            <a class="nvbtn" href="{{config('app.appurl')}}/register">
            {{ trans('auth.sign_up') }}
            </a>
         </li>
         <li>
            <a class="nvbtn" href="{{config('app.appurl')}}/login">{{ trans('auth.login') }}</a>
         </li>
             @endif
      @endif
   </ul>
</div>
</div>
<script>const btn=document.querySelector('.theme-switch input[type="checkbox"]'),prefersDarkScheme=window.matchMedia("(prefers-color-scheme: dark)"),currentTheme=localStorage.getItem("theme");"dark"==currentTheme?(document.body.classList.toggle("dark-theme"),btn.checked=!1):"light"==currentTheme&&(document.body.classList.toggle("light-theme"),btn.checked=!0),btn.addEventListener("click",(function(){if(prefersDarkScheme.matches){document.body.classList.toggle("light-theme");var e=document.body.classList.contains("light-theme")?"light":"dark"}else document.body.classList.toggle("dark-theme"),e=document.body.classList.contains("dark-theme")?"dark":"light";localStorage.setItem("theme",e)}));

if(navigator.vendor.match(/apple/i)) {
   document.getElementById("ilogo").style.display = "block"; 
   document.getElementById("noilogo").style.display = "none"; 
  }
</script>

 <!-- partial:partials/_horizontal-navbar.html -->
 <div class="horizontal-menu">
     @if (!Request::is('full'))
         <nav class="navbar top-navbar col-lg-12 col-12 p-0">
             <div class="container">
                 <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                     <a class="navbar-brand brand-logo" href="{{ url('/') }}">
                         {{-- <img src="{{ asset('assets/images/logo-msi.png') }}" alt="logo" />
                         <span class="font-12 d-block font-weight-light">
                             PT DIC Astra Chemicals
                         </span> --}}
                         <h4>PT. Multi Sarana Indotani</h4>
                     </a>
                     <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}"><img
                             src="{{ asset('assets/images/logo-dic-md.webp') }}" alt="logo" /></a>
                 </div>
                 <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">

                     <ul class="navbar-nav navbar-nav-right">
                         <li class="nav-item nav-profile dropdown">
                             <a class="nav-link" id="profileDropdown" href="javascript:void(0)"
                                 data-bs-toggle="dropdown" aria-expanded="false">
                                 <div class="nav-profile-img">
                                     <img src="{{ asset('assets/images/user-default.png') }}" alt="image" />
                                 </div>
                                 <div class="nav-profile-text">
                                     <p class="text-black font-weight-semibold m-0">
                                         {{ auth()->user()->fullname }}
                                     </p>
                                     <span class="font-13 online-color">{{ auth()->user()->username }} <i
                                             class="mdi mdi-chevron-down"></i></span>
                                 </div>
                             </a>
                             <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                                 <form role="form" method="post" action="{{ route('logout') }}">
                                     @csrf
                                     <button type="submit" class="dropdown-item" class="nav-link px-0">
                                         <i class="mdi mdi-logout text-primary"></i> Logout
                                     </button>
                                 </form>

                             </div>
                         </li>
                     </ul>
                     <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                         data-toggle="horizontal-menu-toggle">
                         <span class="mdi mdi-menu"></span>
                     </button>
                 </div>
             </div>
         </nav>

         <nav class="bottom-navbar">
             <div class="container">
                 <ul class="nav page-navigation">
                     <li class="nav-item">
                         <a class="nav-link" href="{{ route('paraquat.index') }}">
                             <i class="mdi mdi-calendar-clock menu-icon"></i>
                             <span class="menu-title">Paraquat</span>
                         </a>
                     </li>

                     <li class="nav-item">
                         <a class="nav-link" href="{{ route('glyposate.index') }}">
                             <i class="mdi mdi-calendar-clock menu-icon"></i>
                             <span class="menu-title">Glyposate</span>
                         </a>
                     </li>

                     <li class="nav-item">
                         <a href="javascript:void(0)" class="nav-link">
                             <i class="mdi mdi-file-document menu-icon"></i>
                             <span class="menu-title">Data List</span>
                             <i class="menu-arrow"></i>
                         </a>
                         <div class="submenu">
                             <ul class="submenu-item">
                                 <li class="nav-item">
                                     <a class="nav-link" href="{{ route('upload_po.index') }}">PO List</a>
                                 </li>
                                 <li class="nav-item">
                                     <a class="nav-link" href="{{ route('log_goodissue.index') }}">Good Issue</a>
                                 </li>
                                 <li class="nav-item">
                                     <a class="nav-link" href="{{ route('log_confirmation.index') }}">Confirmation</a>
                                 </li>
                                 <li class="nav-item">
                                     <a class="nav-link" href="{{ route('log_recipient.index') }}">Good Receipt</a>
                                 </li>

                             </ul>
                         </div>
                     </li>

                     <li class="nav-item">
                         <a href="javascript:void(0)" class="nav-link">
                             <i class="mdi mdi-cogs menu-icon"></i>
                             <span class="menu-title">Log & Report</span>
                             <i class="menu-arrow"></i>
                         </a>
                         <div class="submenu">
                             <ul class="submenu-item">
                                 <li class="nav-item">
                                     <a class="nav-link" href="{{ route('report.index') }}">Report</a>
                                 </li>
                                 <li class="nav-item">
                                     <a class="nav-link" href="javascript:void(0)">Log SAP</a>
                                 </li>
                                 <li class="nav-item">
                                     <a class="nav-link" href="{{ route('log_mesin.index') }}">Log Machine</a>
                                 </li>
                                 <li class="nav-item">
                                     <a class="nav-link" href="{{ route('log_goodissue.index') }}">Log Good Issue</a>
                                 </li>
                                 <li class="nav-item">
                                     <a class="nav-link" href="{{ route('log_confirmation.index') }}">Log
                                         Confirmation</a>
                                 </li>
                                 <li class="nav-item">
                                     <a class="nav-link" href="{{ route('log_recipient.index') }}">Log Recipients</a>
                                 </li>
                             </ul>
                         </div>
                     </li>

                     <li class="nav-item">
                         <a href="javascript:void(0)" class="nav-link">
                             <i class="mdi mdi-cogs menu-icon"></i>
                             <span class="menu-title">Settings</span>
                             <i class="menu-arrow"></i>
                         </a>
                         <div class="submenu">
                             <ul class="submenu-item">
                                 <li class="nav-item">
                                     <a class="nav-link" href="{{ route('users.index') }}">User Setting</a>
                                 </li>
                             </ul>
                         </div>
                     </li>
                 </ul>
             </div>
         </nav>
     @else
         <nav class="navbar top-navbar col-lg-12 col-12 p-0">
             <div class="container">
                 <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                     <a class="navbar-brand brand-logo" href="{{ url('/') }}">
                         <img src="{{ asset('assets/images/logo-dic.webp') }}" alt="logo" />
                         <span class="font-12 d-block font-weight-light">
                             PT DIC Astra Chemicals
                         </span>
                     </a>
                 </div>
                 <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-end">
                     <h4 class="font-12 d-block">
                         Dashboard
                     </h4>
                 </div>
             </div>
         </nav>
     @endif
 </div>
 <!-- partial -->

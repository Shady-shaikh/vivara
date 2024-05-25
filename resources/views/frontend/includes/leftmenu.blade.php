<!-- BEGIN: Main Menu-->
{{-- <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item">
                <a href="{{ route('user.dashboard') }}">
                    <i class="feather icon-home"></i>
                    <span class="menu-title" data-i18n="Dashboard">Dashboard</span>
                </a>
            </li>
            <li lass=" nav-item">
                <a href="{{ route('user.ideaManagement') }}">
                    <i class="fa fa-list-ul" aria-hidden="true"></i>
                    @if(Auth::user()->role == 'User')
                    <span class="menu-title" data-i18n="Idea_Management">My Ideas</span>
                    @elseif(Auth::user()->role == 'Assessment Team' || Auth::user()->role == 'Approving Authority')
                    <span class="menu-title" data-i18n="Idea_Management">Idea Management</span>
                    @endif
                </a>
            </li>
        </ul>
    </div>
</div> --}}
<!-- END: Main Menu-->

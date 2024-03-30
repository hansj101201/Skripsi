<style>
    .user-panel .info span {
        color: white; /* Ubah warna teks menjadi putih */
    }
</style>


<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if(config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <nav class="pt-2">

            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <!-- You can include user avatar here if available -->
                </div>
                <div class="info">
                    <span class="d-block">USER : {{ auth()->user()->name }}</span>
                    <!-- You can include additional user details here -->
                    <span class="d-block">ROLE : {{ auth()->user()->rolenya }}</span>
                    <span class="d-block">DEPO : {{ getNamaDepo() }}</span>
                </div>
            </div>

            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if(config('adminlte.sidebar_nav_animation_speed') != 300)
                    data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}"
                @endif
                @if(!config('adminlte.sidebar_nav_accordion'))
                    data-accordion="false"
                @endif>
                {{-- Configured sidebar links --}}
                @each('adminlte::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item')
            </ul>
        </nav>
    </div>

</aside>

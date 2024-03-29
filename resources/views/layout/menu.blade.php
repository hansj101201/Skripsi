<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>
        <li class="nav-item has-treeview {{ (request()->is('setup*')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Setup
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('barang.index') }}" class="nav-link {{ (request()->is('setup/barang*')) ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                        Barang
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('depo.index') }}" class="nav-link {{ (request()->is('setup/depo*')) ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Depo</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('gudang.index') }}" class="nav-link {{ (request()->is('setup/gudang*')) ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                        Gudang
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('salesman.index') }}" class="nav-link {{ (request()->is('setup/salesman*')) ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Salesman</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('driver.index') }}" class="nav-link {{ (request()->is('setup/driver*')) ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Driver</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('harga.index') }}" class="nav-link {{ (request()->is('setup/harga*')) ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Harga</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('satuan.index') }}" class="nav-link {{ (request()->is('setup/satuan*')) ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Satuan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('supplier.index') }}" class="nav-link {{ (request()->is('setup/supplier*')) ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Supplier</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('customer.index') }}" class="nav-link {{ (request()->is('setup/customer*')) ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Customer</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link {{ (request()->is('setup/user*')) ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>User</p>
                    </a>
                </li>
                <!-- Tambahkan submenu lainnya di sini -->
            </ul>
        </li>
        <li class="nav-item has-treeview {{ (request()->is('transaksi*')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Transaksi
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('gudang.terimaPO') }}" class="nav-link {{ (request()->is('transaksi/gudang*')) ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                            Penerimaan Barang
                        </p>
                    </a>
                </li>
                <!-- Tambahkan submenu transaksi lainnya di sini -->
            </ul>
        </li>
    </ul>
</nav>

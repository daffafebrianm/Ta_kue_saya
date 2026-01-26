<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    {{-- Bisa tambahkan search bar atau menu lain di sini --}}
                </div>

                <ul class="navbar-nav header-right">
                    <!-- Notifikasi -->
                    <li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                            <i class="mdi mdi-bell-outline"></i>
                            @if ($notifikasiOrders->count() > 0)
                                <span class="badge badge-danger">{{ $notifikasiOrders->count() }}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
                            <h6 class="dropdown-header text-uppercase font-weight-bold">
                                Notifikasi
                            </h6>

                            <div class="notification-list" style="max-height: 300px; overflow-y: auto;">
                                @forelse($notifikasiOrders as $order)
                                    <a class="dropdown-item d-flex align-items-center"
                                        href="{{ route('orders.show', $order->id) }}">
                                        <div class="notification-icon mr-3">
                                            <i class="mdi mdi-cart-outline text-primary"></i>
                                        </div>
                                        <div class="notification-text">
                                            <strong>{{ $order->order_code }}</strong> {{-- Menampilkan order_code --}}
                                            <div class="text-muted small">{{ $order->customer_name }} - Pesanan sedang
                                                diproses</div>
                                        </div>
                                    </a>
                                @empty
                                    <span class="dropdown-item text-center text-muted">Tidak ada notifikasi</span>
                                @endforelse
                            </div>
                             <div class="dropdown-divider"></div>
        <a class="dropdown-item text-center text-primary font-weight-bold" href="{{ route('orders.index') }}">
            Lihat semua Pesanan
        </a>
                    </li>


                    <!-- Profil -->
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                            <i class="mdi mdi-account"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="/logout" class="dropdown-item">
                                <i class="icon-key"></i>
                                <span class="ml-2">Logout</span>
                            </a>
                        </div>
                    </li>
                </ul>

            </div>
        </nav>
    </div>
</div>
<style>
    .notification-list::-webkit-scrollbar {
        width: 6px;
    }

    .notification-list::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 3px;
    }

    .dropdown-item:hover {
        background-color: #f1f1f1;
    }

    .notification-icon {
        font-size: 1.3rem;
    }

    .notification-text strong {
        display: block;
        font-weight: 500;
    }
</style>

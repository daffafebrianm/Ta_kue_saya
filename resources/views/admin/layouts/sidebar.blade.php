 <div class="quixnav">
     <div class="quixnav-scroll">
         <ul class="metismenu" id="menu">


             <li>

                 <a href="/dashboard">
                     <i class="bi bi-speedometer2"></i>
                     <span class="nav-text">Dashboard</span>
                 </a>
             </li>
             <li>

             <li class="{{ Request::is('produk*') ? 'mm-active' : '' }}">
                 <a href="/produk">
                     <i class="bi bi-box-seam"></i>
                     <span class="nav-text">Produk</span>
                 </a>
             </li>

             <li class="{{ Request::is('kategori*') ? 'mm-active' : '' }}">
                 <a href="/kategori">
                     <i class="bi bi-tags"></i>
                     <span class="nav-text">Kategori</span>
                 </a>
             </li>

             <li class="{{ Request::is('users*') ? 'mm-active' : '' }}">
                 <a href="/users">
                     <i class="bi bi-people"></i>
                     <span class="nav-text">User</span>
                 </a>
             </li>

             <li class="{{ Request::is('orders*') ? 'mm-active' : '' }}">
                 <a href="/orders">
                     <i class="bi bi-cart-check"></i>
                     <span class="nav-text">Order</span>
                 </a>
             </li>

             <li class="{{ Request::is('keuangan*') ? 'mm-active' : '' }}">

                 <a href="/mana">
                     <i class="bi bi-cash-stack"></i>
                     <span class="nav-text">Keuangan</span>
                 </a>
             </li>
         </ul>
     </div>
 </div>

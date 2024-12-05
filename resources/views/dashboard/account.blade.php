
<ul class="account-nav">
    <li><a href="#" class="menu-link menu-link_us-s ">Dashboard</a></li>
    <li><a href="#" class="menu-link menu-link_us-s ">Orders</a></li>
    <li><a href="#" class="menu-link menu-link_us-s">Addresses</a></li>
    <li><a href="#" class="menu-link menu-link_us-s">Account Details</a></li>
    <li><a href="#" class="menu-link menu-link_us-s ">Wishlist</a></li>
    <li>
        <form method="POST" action="{{route('logout')}}" id="logout-form-1">
            @csrf
            <a href="{{route('logout')}}" class="menu-link menu-link_us-s" onclick="event.preventDefault(); document.getElementById('logout-form-1').submit();">Logout</a>
        </form>
    
</ul>

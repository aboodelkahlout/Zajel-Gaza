<ul class="sidebar-nav">
            <li><a href="{{route('user.home')}}" class="{{request()->routeIs('user.home')? 'active':''}}"><i class="fas fa-home"></i> <span>الرئيسية</span></a></li>
            <li><a href="{{route('user.fav.hotel')}}" class="{{request()->routeIs('user.fav.hotel')? 'active':''}}"><i class="fas fa-heart"></i> <span>المفضلة</span></a></li>
            <li><a href="{{route('user.settings.page')}}" class="{{request()->routeIs('user.settings.page')? 'active':''}}"><i class="fas fa-cog"></i> <span>الإعدادات</span></a></li>
        </ul>
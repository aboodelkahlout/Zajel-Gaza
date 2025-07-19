<div class="sidebar-nav">
                <a href="{{ route('owner.dashboard')}}" class="nav-item  {{request()->routeIs('owner.dashboard')? 'active':''}}">
                    <i class="fas fa-home"></i>
                    <span>نظرة عامة</span>
                </a>
                <a href="{{route('hotel.comments')}}" class="nav-item {{request()->routeIs('hotel.comments')? 'active':''}}">
                    <i class="fas fa-comments"></i>
                    <span>التعليقات والتقييمات</span>
                </a>
                <a href="{{route('hotelowner.settings')}}" class="nav-item {{request()->routeIs('hotelowner.settings')? 'active':''}}">
                    <i class="fas fa-cog"></i>
                    <span>الإعدادات</span>
                </a>
            </div>
<div class="sidebar-menu">
                <ul>
                    <li>
                        <a href="{{route('admin.dashboard')}}" class="{{request()->routeIs('admin.dashboard')? 'active':''}}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>الرئيسية</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.hotel.requests')}}" class="{{request()->routeIs('admin.hotel.requests')? 'active':''}}">
                            <i class="fas fa-hotel"></i>
                            <span>طلبات الفنادق</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.hotel_owners')}}" class="{{request()->routeIs('admin.hotel_owners')? 'active':''}}">
                            <i class="fas fa-user-tie"></i>
                            <span>إدارة أصحاب الفنادق</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('showalluser')}}" class="{{request()->routeIs('showalluser')? 'active':''}}">
                            <i class="fas fa-users"></i>
                            <span>إدارة المستخدمين</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.statistics')}}" class="{{request()->routeIs('admin.statistics')? 'active':''}}">
                            <i class="fas fa-calendar-check"></i>
                            <span>الاحصائيات</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.ratingandcomment')}}" class="{{request()->routeIs('admin.ratingandcomment')? 'active':''}}">
                            <i class="fas fa-star"></i>
                            <span>التقييمات والتعليقات</span>
                            @if ($allcomment > 0)
                            <span class="badge">{{$allcomment}}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.settings')}}" class="{{request()->routeIs('admin.settings')? 'active':''}}">
                            <i class="fas fa-cog"></i>
                            <span>إعدادات النظام</span>
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                      @csrf
                    <button type="submit" class="me-2 text-white btn btn-outline-none border-0 bg-transparent text-dark">
                    <i class="fas fa-sign-out-alt ms-2"></i> تسجيل الخروج
                </button>
                </form>
                    </li>
                </ul>
            </div>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم العميل - احجز فندق</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset ('bootstrap-5.3.7-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/mainbook.css')}}">

</head>
<body>
    <!-- زر القائمة -->
    <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- الشريط الجانبي -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2>zajel gaza</h2>
        </div>

       @include('user.layout')
    </div>

    <!-- المحتوى الرئيسي -->
    <div class="main-content" id="mainContent">
        <div class="header">
            <div class="user-greeting">
                <h2>احجز فندق</h2>
                <p>ابحث عن أفضل الفنادق والعروض</p>
            </div>

            <form action="{{route('user.home')}}" method="get">
                @csrf
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="q" class="search-bar" value="{{ request('q') }}" placeholder="ابحث عن فنادق،...">
            </div>
        </div>
    </form>

        <!-- محتوى الفنادق الرئيسي -->
        <div class="hotel-content">
            <div class="hotel-header">
                <h3>الفنادق المتاحة</h3>
                <a href="{{route('user.show.allhotel')}}" class="view-all">عرض الكل <i class="fas fa-chevron-left"></i></a>
            </div>

            <div class="hotel-grid">
            @forelse ($hotels as $hotel)
            <div class="hotel-card">
                <form class="favorite-form" action="{{route('user.add.fav.hotel',$hotel->id)}}" method="post">
                    @csrf
                <button type="submit" class="favorite-btn">
                @php
                  $isFavorited = $hotel->favorites->where('user_id', auth()->id())->count() > 0;
                @endphp
               <i class="{{ $isFavorited ? 'fas' : 'far' }} fa-heart text-danger"></i>
                </button>
                </form>
                    <div class="hotel-image" style="background-image: url('{{ asset('img/' . ($hotel->cover_image ?? 'default.jpg')) }}')"></div>
                    <div class="hotel-details">
                        <h4 class="hotel-name"></h4>
                        <p class="hotel-location"><i class="fas fa-map-marker-alt"></i> {{$hotel->name}}</p>
                        <p class="hotel-location">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $hotel->adress }}
                        </p>
                        @php
                            $average = $hotel->ratings->avg('rating');
                            $average = round($average, 1);
                        @endphp
                        <p class="hotel-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= floor($average))
                                    <i class="fas fa-star text-warning"></i>
                                @elseif ($i - $average < 1)
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                @else
                                    <i class="far fa-star text-warning"></i>
                                @endif
                            @endfor
                            ({{ $average }})
                        </p>

                        <p class="hotel-price">{{ $hotel->price_per_night }} دولار / ليلة</p>
                        <div class="hotel-actions">
                        <a href="{{route('user.detiles.hotel', $hotel->id)}}" class="btn btn-outline-primary">عرض التفاصيل</a>
                     </div>
                 </div>
            </div>
            @empty
            <div class="container">
                <table>
                    <tr>
                    <th>
                    <div class="hotel-card">
                        لا يوجد فندق بهذا الاسم
                    </div>
                </th>
                    </tr>
                </table>
            </div>
            @endforelse
        </div>

    </div>

        <!-- قسم أكثر الفنادق زيارة -->
        <div class="popular-box">
            <h3>أعلا الفنادق تقييما</h3>
            <p>قائمة بأعلا الفنادق تقييما وحجزاً في العالم</p>
            <a  href="{{route('user.most.hotel.rating')}}" class="popular-link">عرض القائمة الكاملة</a>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const favoriteBtns = document.querySelectorAll('.favorite-btn');

            // نظام سحب الشريط الجانبي
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('expanded');
                document.body.classList.toggle('sidebar-expanded');

                // تغيير الأيقونة بين القائمة والإغلاق
                const icon = menuToggle.querySelector('i');
                if (sidebar.classList.contains('expanded')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });

            // نظام المفضلة
            favoriteBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    this.classList.toggle('active');

                    const icon = this.querySelector('i');
                    if (this.classList.contains('active')) {
                        icon.style.animation = 'heartBeat 0.5s';
                        setTimeout(() => {
                            icon.style.animation = '';
                        }, 500);
                    }
                });
            });
        });
    </script>
</body>
</html>
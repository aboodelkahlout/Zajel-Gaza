<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم العميل - المفضلة</title>
    <link rel="stylesheet" href="css/fav.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset ('bootstrap-5.3.7-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/fav.css')}}">
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
        <div class="favorites-container">
            <h1 class="favorites-title">المفضلة</h1>

            <div class="favorites-grid">
                @foreach ($favhotels as $hotel)
                @php
                    $favhotel= $hotel->hotel;
                @endphp
                <div class="favorite-card">
                    <form action="{{route('user.remove.fav.hotel', $hotel->id )}}" method="post">
                        @csrf
                        @method('DELETE')
                    <button type="submit" class="remove-favorite"><i class="fas fa-times"></i></button>
                    </form>
                <div class="favorite-image" style="background-image: url('{{asset('img/'. $favhotel->cover_image)}}')"></div>
                    <div class="favorite-details">
                        <h3 class="favorite-hotel-name">{{ $favhotel->name }}</h3>
                        <p class="favorite-hotel-location"><i class="fas fa-map-marker-alt"></i>{{$favhotel->adress}}</p>
                        @php
                            $average = $favhotel->ratings->avg('rating');
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
                        <p class="favorite-price">{{ $favhotel->price_per_night }} ر.س / ليلة</p>
                    </div>
                </div>
                @endforeach
            </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');

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

            // إزالة من المفضلة
            const removeButtons = document.querySelectorAll('.remove-favorite');
            removeButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const card = this.closest('.favorite-card');
                    card.style.transform = 'scale(0)';
                    setTimeout(() => {
                        card.remove();
                    }, 300);
                });
            });
        });
    </script>
</body>
</html>
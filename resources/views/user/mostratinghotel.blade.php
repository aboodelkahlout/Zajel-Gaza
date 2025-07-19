<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أعلا الفنادق تقييما - احجز فندق</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset ('bootstrap-5.3.7-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('css/mosthotelratings.css')}}">
</head>
<body>
    <div class="container">
        <div class="section-header">
            <h1 class="section-title">أعلا الفنادق تقييما</h1>
        </div>

        <button onclick="window.history.back()" class="back-button">
          رجوع <i class="fa fa-arrow-left"></i>
         </button>
        <div class="hotels-grid">
              <!-- الفندق الثالث -->
               @foreach ( $sortedHotels as $hotel )
            <div class="hotel-card">
                <div class="hotel-image" style="background-image: url('{{asset('img/'.$hotel->cover_image)}}');"></div>
                <form class="favorite-form" action="{{route('user.add.fav.hotel',$hotel->id)}}" method="post">
                    @csrf
                <button type="submit" class="favorite-btn">
                @php
                  $isFavorited = $hotel->favorites->where('user_id', auth()->id())->count() > 0;
                @endphp
               <i class="{{ $isFavorited ? 'fas' : 'far' }} fa-heart text-danger"></i>
                </button>
                </form>
                <div class="hotel-content">
                    <h3 class="hotel-name">{{$hotel->name}}</h3>
                    <div class="hotel-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{$hotel->adress}}</span>
                    </div>
                    <p class="hotel-description">
                        {{ $hotel->description }}
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
                    <div class="hotel-actions">
                    <a href="{{route('user.detiles.hotel', $hotel->id)}}" class="btn btn-outline-primary">عرض التفاصيل</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script>
        // وظيفة تبديل حالة المفضلة
        function toggleFavorite(btn) {
            btn.classList.toggle('active');
            const icon = btn.querySelector('i');

            if (btn.classList.contains('active')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                // هنا يمكنك إضافة كود لحفظ الفندق في المفضلة
                console.log('تمت إضافة الفندق إلى المفضلة');
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                // هنا يمكنك إضافة كود لإزالة الفندق من المفضلة
                console.log('تمت إزالة الفندق من المفضلة');
            }
        }
    </script>
</body>
</html>
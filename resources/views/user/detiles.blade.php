<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فندق القصر الذهبي - احجز فندق</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset ('bootstrap-5.3.7-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/detileshotel.css')}}">
</head>
<body>
<button onclick="window.history.back()" class="back-button">
    رجوع <i class="fa fa-arrow-left"></i>
  </button>
    <div class="container">
        <div class="hotel-header">
            <div>
                <h1 class="hotel-title">{{ $hotel->name }}</h1>
                <div style="display: flex; align-items: center; margin-top: 10px;">
                    <span class="hotel-price">{{ $hotel->price_per_night }} دولار/ليلة</span>
                </div>
            </div>
        </div>

        <h1 class="text-center my-4">معرض الصور</h1>

            <div class="container">
            <div class="row">
                @foreach ($hotel->images as $image)
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card image-card shadow-sm border-0">
                    <div class="image-container" style="background-image: url('{{ asset($image->image_path ?? 'default.jpg') }}');"></div>
                    </div>
                </div>
                @endforeach
            </div>
            </div>


        <div class="details-section">
            <div class="description-box">
                <h3 class="section-title">الوصف</h3>
                <p class="hotel-description">
                    {{ $hotel->description }}
            </p>
            </div>

            <div class="reservation-box">
                <h3 class="section-title">احجز إقامتك</h3>
                <p style="color: #666; margin-bottom: 30px; line-height: 1.6;">للحجز والأستفسار يرجى التواصل على الرقم التالي:{{ $hotel->phone_number }}
                    التواصل على مواقع التواصل الاجتماعي :
                    {{ $hotel->instagram }} على الانستجرام
                    <br>
                    {{ $hotel->whatsapp }} على الواتس اب
                    <br>
                    {{ $hotel->facebook }} على الفيس بوك
            </p>
            </div>
        </div>

        <div class="reviews-section">
            <h3 class="section-title">تقييمات النزلاء</h3>

            <div class="review-summary">
                <div class="overall-rating">{{ $averageRating }}</div>

                <div class="rating-stats">
                @foreach ($hotel->comments as $comment)
    <div class="comment">
        <div class="comment-header">
            @foreach ($hotel->ratings as $rating)
            <span class="comment-rating">
                {{ str_repeat('★', $rating->rating) . str_repeat('☆', 5 - $rating->rating) }}
            </span>
           @endforeach
            <span class="comment-author">{{ $comment->user->name ?? 'ضيف' }}</span>
            <span class="comment-date">{{ $comment->created_at->format('d M Y') }}</span>
        </div>
        <p class="comment-text">{{ $comment->comment }}</p>

        <div class="comment-reply" style="margin-top: 10px; padding-left: 20px; border-left: 2px solid #ccc;">
        @if ($comment->reply)
        @foreach ($comment->reply as $reply)
    @if ($reply->replied_by === 'admin')
        <strong>رد الإدارة:</strong>
    @elseif ($reply->replied_by === 'hotel_owner')
        <strong>رد صاحب الفندق:</strong>
    @else
        <strong>رد:</strong>
    @endif
    <p>{{ $reply->reply_text }}</p>
    @endforeach
@endif
      </div>
    </div>
@endforeach
            </div>
        </div>

        <div class="add-review-section">
            <h3 class="section-title">أضف تقييمك</h3>

            <form action="{{ route('user.rating.hotel' , $hotel->id) }}" method="POST">
                @csrf
            <div class="rating-input">
                    <span class="rating-title">تقييمك:</span>
                    <div class="stars-rating">
                        <input type="radio" id="star5" name="rating" value="5">
                        <label for="star5">★</label>
                        <input type="radio" id="star4" name="rating" value="4">
                        <label for="star4">★</label>
                        <input type="radio" id="star3" name="rating" value="3">
                        <label for="star3">★</label>
                        <input type="radio" id="star2" name="rating" value="2">
                        <label for="star2">★</label>
                        <input type="radio" id="star1" name="rating" value="1">
                        <label for="star1">★</label>
                    </div>
                </div>
                <button type="submit" class="submit-review">إرسال التقييم</button>
            </form>
            <form action="{{route('user.comment.hotel',$hotel->id)}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="comment">تعليقك (اختياري)</label>
                    <textarea id="comment" name="comment" placeholder="اكتب تعليقك هنا..." required></textarea>
                </div>
                <button type="submit" class="submit-review">إرسال تعليقك</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>    <script>
</body>
</html>
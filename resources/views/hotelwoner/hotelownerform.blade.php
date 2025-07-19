<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>تسجيل صاحب فندق</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset('bootstrap-5.3.7-dist/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('css/hotelwonerform.css')}}">
</head>
<body>


<div class="login-container">

  <!-- زر الرجوع -->
  <button onclick="window.history.back()" class="back-button">
    رجوع <i class="fa fa-arrow-left"></i>
  </button>

  <h1>تسجيل صاحب الفندق</h1>
  <p class="subtitle">يرجى تعبئة البيانات التالية بدقة</p>

  <form id="ownerForm" enctype="multipart/form-data" action="{{ route('hotel.add.hotel.op', ['id'=> $owner_id]) }}" method="post">
    @csrf

    <div class="form-group">
        <label for="name">اسم الفندق</label>
        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}"  placeholder="أدخل اسم الفندق">
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">وصف الفندق</label>
        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" value="{{old('description')}}"  placeholder="أدخل وصفاً للفندق"></textarea>
        @error('description')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group">
        <label for="room_types">أنواع الغرف</label>
        <input type="text" id="room_types" name="room_types" class="form-control @error('room_types') is-invalid @enderror" value="{{old('room_types')}}" placeholder="مثلاً: فردية، مزدوجة، جناح...">
        @error('room_types')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group">
        <label for="phone_number">رقم الهاتف</label>
        <input type="tel" id="phone_number" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{old('phone_number')}}" placeholder="أدخل رقم الهاتف">
        @error('phone_number')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group">
        <label for="adress">العنوان</label>
        <input type="text" id="adress" name="adress" class="form-control @error('adress') is-invalid @enderror" value="{{old('adress')}}" placeholder="اسم المدينة - اسم الدولة">
        @error('adress')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group">
        <label for="room_count">عدد الغرف</label>
        <input type="number" id="room_count" name="room_count" class="form-control @error('room_count') is-invalid @enderror" value="{{old('room_count')}}" placeholder="أدخل عدد الغرف">
        @error('room_count')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group">
        <label for="price_per_night">السعر لليلة</label>
        <input type="number" id="price_per_night" name="price_per_night" class="form-control @error('price_per_night') is-invalid @enderror"  value="{{old('price_per_night')}}"  placeholder="أدخل السعر لليلة">
        @error('price_per_night')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group">
        <label for="whatsapp"> واتساب (اختياري)</label>
        <input type="text" id="whatsapp" name="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror" value="{{old('whatsapp')}}" placeholder="+972059*******">
        @error('whatsapp')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group">
        <label for="instagram">رابط إنستغرام (اختياري)</label>
        <input type="url" id="instagram" name="instagram" class="form-control @error('instagram') is-invalid @enderror" value="{{old('instagram')}}"  placeholder="مثلاً: https://instagram.com/yourpage">
        @error('instagram')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group">
        <label for="facebook">رابط فيسبوك (اختياري)</label>
        <input type="url" id="facebook" name="facebook" class="form-control @error('facebook') is-invalid @enderror" value="{{old('facebook')}}" placeholder="مثلاً: https://facebook.com/yourpage">
        @error('facebook')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group">
    <label for="cover_image">صورة الغلاف</label>
    <input type="file" name="cover_image" class="form-control" accept="image/*">
    </div>

    <button type="submit" class="next-button">إرسال</button>
</form>


</div>


  <script>
//    document.getElementById("ownerForm").addEventListener("submit", function(e) {
//   e.preventDefault(); // اختياري: يمنع التحويل إذا فيه تحقق

//   const username = document.getElementById("username").value.trim();
//   const email = document.getElementById("email").value.trim();
//   const password = document.getElementById("password").value.trim();
//   const phone = document.getElementById("phone").value.trim();
//   const hotelName = document.getElementById("hotelName").value.trim();
//   const hotelLocation = document.getElementById("hotelLocation").value.trim();

//   if (!username || !email || !password || !phone || !hotelName || !hotelLocation) {
//     alert("يرجى تعبئة جميع الحقول المطلوبة.");
//     return;
//   }

//   // ✅ تحويل المستخدم إلى صفحة شكرًا بعد الإرسال
//   window.location.href = "تسجيل الدخول صاحب الفندق.html";
// });

  </script>
</body>
</html>

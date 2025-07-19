<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>احجز فندق - الواجهة الرئيسية</title>
    <!-- Font Awesome Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset ('bootstrap-5.3.7-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
</head>
<body>
    <!-- شريط التنقل -->
    <nav class="navbar">
        <div class="logo">zajel gaza</div>
        <ul class="nav-links">
            <li><a href="#services">الخدمات</a></li>
             <li><a href="#text">من نحن</a></li>
            <li><a href="#contact">اتصل بنا</a></li>
            <li class="dropdown">
                <a href="{{ route('showloginpage')}}" class="sign-in-btn" id="loginUserBtn">تسجيل الدخول</a>
        </li>
        </ul>
    </nav>

    @if(session('success'))
                    <div class="alert alert-success mt-2">{{ session('success') }}</div>
        @endif
    <!-- قسم البانر -->
    <section class="banner-section" style="background-image: url('{{asset('img/banner-image.jpeg')}}');">
        <h1 class="banner-title">احجز فندقك المثالي بكل سهولة</h1>
    </section>

    <!--  الخدمات -->
    <section class="services-section" id="services">
        <div class="section-header">
            <h2 class="section-title">خدماتنا</h2>
        </div>

        <div class="services-grid">
            <div class="service-card">
                <div class="card-image" style="background-image: url('{{asset('img/hotel-service.jpg')}}');"></div>
                <div class="card-content">
                    <h3 class="card-title">فنادق فاخرة</h3>
                    <p class="card-description">اختر من بين مجموعة واسعة من الفنادق الفاخرة في أفضل الوجهات السياحية حول العالم</p>
                    <div class="card-footer">
                        <span class="rating">4.7 ★★★★☆</span>
                        <a href="{{route('login')}}" class="read-more">المزيد</a>
                    </div>
                </div>
            </div>

            <div class="service-card">
                <div class="card-image" style="background-image: url('{{asset('img/discounts.jpg')}}');"></div>
                <div class="card-content">
                    <h3 class="card-title">عروض حصرية</h3>
                    <p class="card-description">استفد من أفضل العروض والخصومات على حجوزات الفنادق طوال العام</p>
                    <div class="card-footer">
                        <span class="rating">4.9 ★★★★☆</span>
                        <a href="{{route('login')}}" class="read-more">المزيد</a>
                    </div>
                </div>
            </div>

            <div class="service-card">
                <div class="card-image" style="background-image: url('{{asset('img/reservation.jpg')}}');"></div>
                <div class="card-content">
                    <h3 class="card-title">حجوزات فورية</h3>
                    <p class="card-description">احجز فندقك المفضل بضغطة زر واحصل على تأكيد فوري</p>
                    <div class="card-footer">
                        <a href="#" class="read-more">احجز الآن</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

   <!-- من نحن -->
<section class="featured-section" id="text">
    <div class="featured-container">
      <h2 class="featured-title">لماذا تختار موقعنا لحجز الفنادق؟</h2>
      <p class="featured-description">
        نقدم لك أفضل تجربة حجز فنادق عبر الإنترنت مع ضمان أفضل الأسعار وخدمة العملاء على مدار الساعة.
        اكتشف آلاف الفنادق في جميع أنحاء العالم واحجز بثقة مع خيارات دفع آمنة ومتعددة.
      </p>

      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-check"></i></div>
          <h3 class="feature-title">أسعار تنافسية</h3>
          <p class="feature-text">نضمن لك أفضل الأسعار مع خصومات تصل إلى 40%</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-check"></i></div>
          <h3 class="feature-title">خيارات متنوعة</h3>
          <p class="feature-text">أكثر من 500,000 فندق وشقة فندقية حول العالم</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-check"></i></div>
          <h3 class="feature-title">دعم فوري</h3>
          <p class="feature-text">خدمة عملاء متاحة 24/7 لمساعدتك في أي استفسار</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-check"></i></div>
          <h3 class="feature-title">تقييمات حقيقية</h3>
          <p class="feature-text">آراء نزلاء حقيقيين لمساعدتك في اتخاذ قرارك</p>
        </div>
      </div>
    </div>
  </section>

     <!-- قسم اتصل بنا -->
          <section class="services-section" id="contact">

      <div class="section-header">
            <h2 class="section-title">اتصل بنا</h2>
        </div>
        <form class="contact-form" action="{{ route('contact.send') }}" method="post">
            @csrf
            <label for="name">الاسم الكامل</label>
            <input type="text" id="name" name="name" class="@error('name') is-invalid @enderror" placeholder="اكتب اسمك">
            @error('name')
             <small class="text-danger">
                {{ $message }}
             </small>
            @enderror
            <br>
            <br>
            <label for="email">البريد الإلكتروني</label>
            <input type="email" id="email" name="email" class="@error('email') is-invalid @enderror" placeholder="example@email.com">
            @error('message')
             <small class="text-danger">
                {{ $message }}
             </small>
            @enderror
            <br>
            <br>
            <label for="message">رسالتك</label>
            <textarea id="message" name="message" class="@error('message') is-invalid @enderror" rows="6" placeholder="اكتب رسالتك هنا..."></textarea>
            @error('message')
             <small class="text-danger">
                {{ $message }}
             </small>
            @enderror
            <br>
            <br>
            <button type="submit">إرسال</button>
        </form>
    </section>
    <!-- التذييل -->
    <footer class="footer">
        <p>© 2025 احجز فندق. جميع الحقوق محفوظة.</p>
    </footer>

    <!-- جافا سكريبت للقائمة -->
    <script>
        const loginBtn = document.getElementById('loginBtn');
        const dropdownMenu = document.getElementById('dropdownMenu');

        loginBtn.addEventListener('click', function(e) {
            e.preventDefault();
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown')) {
                dropdownMenu.style.display = 'none';
            }
        });
    </script>
</body>
</html>
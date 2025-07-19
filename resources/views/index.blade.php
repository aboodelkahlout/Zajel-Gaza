<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم العميل - احجز فندق</title>
    <link rel="stylesheet" href="css/mainbook.css">

    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

        <ul class="sidebar-nav">
            <li><a href="./احجز فندق الرئيسية.html" class="active"><i class="fas fa-home"></i> <span>الرئيسية</span></a></li>
            <li><a href="./المفضلة.html"><i class="fas fa-heart"></i> <span>المفضلة</span></a></li>
            <li><a href="./الاعدادات.html"><i class="fas fa-cog"></i> <span>الإعدادات</span></a></li>
        </ul>
    </div>

    <!-- المحتوى الرئيسي -->
    <div class="main-content" id="mainContent">
        <div class="header">
            <div class="user-greeting">
                <h2>احجز فندق</h2>
                <p>ابحث عن أفضل الفنادق والعروض</p>
            </div>

            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-bar" placeholder="ابحث عن فنادق، وجهات، عروض...">
            </div>
        </div>

        <!-- محتوى الفنادق الرئيسي -->
        <div class="hotel-content">
            <div class="hotel-header">
                <h3>الفنادق المتاحة</h3>
                <a href="./كل الفنادق.html" class="view-all">عرض الكل <i class="fas fa-chevron-left"></i></a>
            </div>

            <div class="hotel-grid">
                <div class="hotel-card">
                    <button class="favorite-btn"><i class="fas fa-heart"></i></button>
                    <div class="hotel-image" style="background-image: url('img/فندق\ الشرق\ الأوسط.jpg')"></div>
                    <div class="hotel-details">
                        <h4 class="hotel-name">فندق الشرق الأوسط</h4>
                        <p class="hotel-location"><i class="fas fa-map-marker-alt"></i> الرياض، السعودية</p>
                        <p class="hotel-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            (4.5)
                        </p>
                        <p class="hotel-price">450 ر.س / ليلة</p>
                    </div>
                </div>

                <div class="hotel-card">
                    <button class="favorite-btn"><i class="fas fa-heart"></i></button>
                    <div class="hotel-image" style="background-image: url('img/فندق\ البحر\ الأحمر.jpg')"></div>
                    <div class="hotel-details">
                        <h4 class="hotel-name">فندق البحر الأحمر</h4>
                        <p class="hotel-location"><i class="fas fa-map-marker-alt"></i> جدة، السعودية</p>
                        <p class="hotel-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            (4.0)
                        </p>
                        <p class="hotel-price">380 ر.س / ليلة</p>
                    </div>
                </div>

                <div class="hotel-card">
                    <button class="favorite-btn"><i class="fas fa-heart"></i></button>
                    <div class="hotel-image" style="background-image: url('./فندق\ القصر\ الذهبي.jpg')"></div>
                    <div class="hotel-details">
                        <h4 class="hotel-name">فندق القصر الذهبي</h4>
                        <p class="hotel-location"><i class="fas fa-map-marker-alt"></i> دبي، الإمارات</p>
                        <p class="hotel-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            (5.0)
                        </p>
                        <p class="hotel-price">520 ر.س / ليلة</p>
                    </div>
                </div>

                <div class="hotel-card">
                    <button class="favorite-btn"><i class="fas fa-heart"></i></button>
                    <div class="hotel-image" style="background-image: url('./فندق\ الواحة.jpg')"></div>
                    <div class="hotel-details">
                        <h4 class="hotel-name">فندق الواحة</h4>
                        <p class="hotel-location"><i class="fas fa-map-marker-alt"></i> أبوظبي، الإمارات</p>
                        <p class="hotel-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            (5.0)
                        </p>
                        <p class="hotel-price">490 ر.س / ليلة</p>
                    </div>
                </div>

                 <div class="hotel-card">
                    <button class="favorite-btn"><i class="fas fa-heart"></i></button>
                    <div class="hotel-image" style="background-image: url('./فندق\ السحاب.jpg')"></div>
                    <div class="hotel-details">
                        <h4 class="hotel-name">فندق السحاب</h4>
                        <p class="hotel-location"><i class="fas fa-map-marker-alt"></i> أبوظبي، الإمارات</p>
                        <p class="hotel-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            (4.0)
                        </p>
                        <p class="hotel-price">350 ر.س / ليلة</p>
                    </div>
                </div>

                <div class="hotel-card">
                    <button class="favorite-btn"><i class="fas fa-heart"></i></button>
                    <div class="hotel-image" style="background-image: url('./فندق\ اللؤلؤة.jpg')"></div>
                    <div class="hotel-details">
                        <h4 class="hotel-name">فندق اللؤلؤة</h4>
                        <p class="hotel-location"><i class="fas fa-map-marker-alt"></i> أبوظبي، الإمارات</p>
                        <p class="hotel-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            (4.0)
                        </p>
                        <p class="hotel-price">320 ر.س / ليلة</p>
                    </div>
                </div>

                <div class="hotel-card">
                    <button class="favorite-btn"><i class="fas fa-heart"></i></button>
                    <div class="hotel-image" style="background-image: url('./فندق\ الأفق.jpg')"></div>
                    <div class="hotel-details">
                        <h4 class="hotel-name">فندق الأفق</h4>
                        <p class="hotel-location"><i class="fas fa-map-marker-alt"></i>البحرين</p>
                        <p class="hotel-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            (4.0)
                        </p>
                        <p class="hotel-price">480 ر.س / ليلة</p>
                    </div>
                </div>

                <div class="hotel-card">
                    <button class="favorite-btn"><i class="fas fa-heart"></i></button>
                    <div class="hotel-image" style="background-image: url('./فندق\ الكوثر.jpg')"></div>
                    <div class="hotel-details">
                        <h4 class="hotel-name">فندق الكوثر</h4>
                        <p class="hotel-location"><i class="fas fa-map-marker-alt"></i> مسقط، عمان</p>
                        <p class="hotel-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            (4.0)
                        </p>
                        <p class="hotel-price">410 ر.س / ليلة</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- قسم أكثر الفنادق زيارة -->
        <div class="popular-box">
            <h3>أعلا الفنادق تقييما</h3>
            <p>قائمة بأعلا الفنادق تقييما وحجزاً في العالم</p>
            <a  href="./اكثر الفنادق زيارة.html" class="popular-link">عرض القائمة الكاملة</a>
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
                    e.preventDefault();
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
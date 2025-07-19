<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الفندق - الإحصائيات</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset ('bootstrap-5.3.7-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/hotelwonerstatistics.css')}}">

</head>
<body>
    <div class="dashboard">
        <!-- الشريط الجانبي -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h3>لوحة تحكم الفندق</h3>
            </div>
            @include('hotelwoner.layout')
        </div>

        <!-- المحتوى الرئيسي -->
        <div class="main-content">
            <div class="header">
                <h1>الإحصائيات</h1>
            </div>

            <!-- قسم الإحصائيات السريعة -->
            <div class="stats-section">
                <h2 class="section-title">الإحصائيات الرئيسية</h2>
                <div class="stats-grid">
                    <!-- بطاقة عدد التعليقات -->
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-comments"></i>
                            </div>

                        </div>
                        <div class="stat-title">التعليقات</div>
                        <div class="stat-value">{{$statistic['commentsCount']}}</div>
                        <div class="stat-subtext">تعليق هذا الشهر</div>
                    </div>

                    <!-- بطاقة متوسط التقييم -->
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-star"></i>
                            </div>

                        </div>
                        <div class="stat-title">متوسط التقييم</div>
                        <div class="stat-value">{{$statistic['averageRating']}}</div>
                        <div class="stat-subtext">من 5 نجوم</div>
                    </div>

                    <!-- بطاقة عدد مرات الإضافة للمفضلة -->
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-heart"></i>
                            </div>

                        </div>
                        <div class="stat-title">الإضافات للمفضلة</div>
                        <div class="stat-value">{{$statistic['favoritesCount']}}</div>
                        <div class="stat-subtext">إضافة هذا الشهر</div>
                    </div>

                    <!-- بطاقة إضافية -->
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-bed"></i>
                            </div>

                        </div>
                        <div class="stat-title">عدد التقيمات</div>
                        <div class="stat-value">{{$statistic['ratingsCount']}}</div>
                        <div class="stat-subtext"></div>
                    </div>
                </div>
            </div>



            <!-- قسم إضافي -->
            <div class="stats-section">
                <h2 class="section-title">تحليل التقييمات</h2>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-thumbs-up"></i>
                            </div>
                        </div>
                        <div class="stat-title">تقييمات إيجابية</div>
                        <div class="stat-value">{{$statistic['positiveRatings']}}</div>
                        <div class="stat-subtext">(4-5 نجوم)</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-thumbs-down"></i>
                            </div>
                        </div>
                        <div class="stat-title">تقييمات سلبية</div>
                        <div class="stat-value">{{$statistic['negativeRatings']}}</div>
                        <div class="stat-subtext">(1-2 نجوم)</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-meh"></i>
                            </div>
                        </div>
                        <div class="stat-title">تقييمات متوسطة</div>
                        <div class="stat-value">{{$statistic['neutralRatings']}}</div>
                        <div class="stat-subtext">(3 نجوم)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // عرض تاريخ اليوم
        function updateCurrentDate() {
            const now = new Date();
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('current-date').textContent = now.toLocaleDateString('ar-SA', options);
        }

        // عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            updateCurrentDate();

            // هنا يمكنك جلب البيانات الحقيقية من API
            // fetchHotelStats();

            // إضافة تأثير النقر لعناصر القائمة الجانبية
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                item.addEventListener('click', function() {
                    navItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');

                    // هنا يمكنك تغيير المحتوى حسب العنصر المختار
                    // loadContent(this.dataset.page);
                });
            });
        });

        // دالة لجلب البيانات من API (مثال)
        function fetchHotelStats() {
            /*
            fetch('/api/hotel-stats')
                .then(response => response.json())
                .then(data => {
                    // تحديث البيانات في الصفحة
                    document.querySelectorAll('.stat-value')[0].textContent = data.comments_count;
                    document.querySelectorAll('.stat-value')[1].textContent = data.average_rating;
                    document.querySelectorAll('.stat-value')[2].textContent = data.favorites_count;
                    // ... إلخ
                })
                .catch(error => {
                    console.error('Error fetching stats:', error);
                });
            */
        }
    </script>
</body>
</html>
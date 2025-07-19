<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>لوحة التحكم - الرئيسية</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset('bootstrap-5.3.7-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/homeforadmin.css')}}">
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>لوحة التحكم</h3>
                <button class="toggle-sidebar" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            @include('admin.layout')
        </div>

        <!-- Main Content -->
        <div class="main-content">
           <!-- Content Header: Title and Search -->
<div class="page-header">
    <div>
        <h2>لوحة التحكم</h2>
        <ul class="breadcrumb">
            <li>لوحة التحكم</li>
            <li>الرئيسية</li>
        </ul>
    </div>
</div>

            <!-- Cards -->
            <div class="cards">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">عدد الفنادق</span>
                        <div class="card-icon hotels"><i class="fas fa-hotel"></i></div>
                    </div>
                    <div class="card-body">
                        <h3>{{ $hotelsCount }}</h3>
                        <span>فندق</span>
                    </div>
                    <div class="card-footer">+3% منذ الشهر الماضي</div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">أصحاب الفنادق</span>
                        <div class="card-icon owners"><i class="fas fa-user-tie"></i></div>
                    </div>
                    <div class="card-body">
                        <h3>{{ $ownersCount }}</h3>
                        <span>صاحب فندق</span>
                    </div>
                    <div class="card-footer danger">-5% منذ الشهر الماضي</div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">المستخدمين</span>
                        <div class="card-icon users"><i class="fas fa-users"></i></div>
                    </div>
                    <div class="card-body">
                        <h3>{{ $usersCount }}</h3>
                        <span>مستخدم</span>
                    </div>
                    <div class="card-footer">+12% منذ الشهر الماضي</div>
                </div>
            </div>

            <!-- Table -->
            <h4 class="mt-5">أعلى الفنادق تقييمًا:</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>اسم الفندق</th>
                <th>متوسط التقييم</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topHotels as $hotel)
                <tr>
                    <td>{{ $hotel->name }}</td>
                    <td>{{ number_format($hotel->ratings_avg_rating, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">لا توجد تقييمات بعد.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
        </div>
    </div>

    <script>
        // Sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const toggleSidebarBtn = document.getElementById('toggleSidebar');

        toggleSidebarBtn.addEventListener('click', () => {
            sidebar.classList.toggle('sidebar-collapsed');
        });
    </script>
</body>
</html>

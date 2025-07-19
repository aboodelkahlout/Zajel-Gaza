<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - الإحصائيات العامة</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset('bootstrap-5.3.7-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/adminstatistics.css')}}">
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
                <div class="sidebar-menu">
                @include('admin.layout')
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Content Header: Title and Search -->
 <div class="page-header">
     <div>
         <h2>الإحصائيات العامة</h2>
         <ul class="breadcrumb">
             <li>لوحة التحكم</li>
             <li>الإحصائيات العامة</li>
         </ul>
     </div>
     <div class="search-box">
         <input type="text" placeholder="بحث..." />
         <i class="fas fa-search"></i>
     </div>
 </div>

                <!-- Stats Cards -->
                <div class="stats-container">
                    <div class="stat-card primary">
                        <div class="stat-title">إجمالي الفنادق</div>
                        <div class="stat-value">{{$hotelsCount}}</div>
                        <div class="stat-change up">
                            <i class="fas fa-arrow-up"></i>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-hotel"></i>
                        </div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-title">إجمالي المستخدمين</div>
                        <div class="stat-value">{{$usersCount}}</div>
                        <div class="stat-change up">
                            <i class="fas fa-arrow-up"></i>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>

                    <div class="stat-card warning">
                        <div class="stat-title">إجمالي اصحاب الفنادق</div>
                        <div class="stat-value">{{$ownersCount}}</div>
                        <div class="stat-change down">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>

                </div>

                <!-- Charts Section -->
                <div class="charts-container">
                    <div class="chart-card">
                        <div class="chart-header">
                            <div class="chart-title">إحصائيات التعليقات خلال الاشهر</div>
                            <div class="chart-actions">
                                <select>
                                    <option>2023</option>
                                    <option>2022</option>
                                    <option>2021</option>
                                </select>
                            </div>
                        </div>
                        <canvas id="bookingsChart" width="400" height="300"></canvas>
                    </div>

                    <div class="chart-card">
                        <div class="chart-header">
                            <div class="chart-title">توزيع الفنادق حسب المدينة</div>
                            <div class="chart-actions">
                                <select>
                                    <option>السنة الحالية</option>
                                    <option>العام الماضي</option>
                                </select>
                            </div>
                        </div>
                        <canvas id="citiesChart" width="400" height="300"></canvas>
                    </div>
                </div>

                <!-- Recent Activity -->
            <!-- أحدث النشاطات -->
            <div class="container mt-4">
    <h3 class="mb-4">أحدث النشاطات</h3>

    <div class="row">
        @forelse ($recentActivities as $activity)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-2">{{ $activity['user'] }}</h5>
                        <p class="card-text mb-1">{{ $activity['text'] }}</p>
                        <small class="text-muted">{{ $activity['time'] }}</small>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">لا يوجد نشاطات حتى الآن.</div>
            </div>
        @endforelse
    </div>
</div>



            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const bookingsChart = new Chart(document.getElementById('bookingsChart'), {
        type: 'bar',
        data: {
            labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
            datasets: [{
                label: 'عدد التعليقات',
                data: @json($commentsPerMonth),
                backgroundColor: '#007bff',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    const citiesChart = new Chart(document.getElementById('citiesChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($hotelsByadress->keys()) !!},
            datasets: [{
                data: {!! json_encode($hotelsByadress->values()) !!},
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1', '#20c997'],
            }]
        },
        options: {
            responsive: true,
        }
    });
</script>
<script>
    // JavaScript for toggling sidebar
    document.addEventListener('DOMContentLoaded', function () {
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');

        toggleSidebar.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
        });

        initCharts(); // استدعاء الرسوم البيانية بعد تحميل الصفحة
    });

    // إعداد الرسوم البيانية باستخدام Chart.js
    function initCharts() {
        const bookingsChart = new Chart(document.getElementById('bookingsChart'), {
            type: 'line',
            data: {
                labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
                datasets: [{
                    label: 'عدد الحجوزات',
                    data: [120, 190, 170, 220, 250, 280, 310, 290, 330, 350, 370, 400],
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    tension: 0.1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        const citiesChart = new Chart(document.getElementById('citiesChart'), {
            type: 'doughnut',
            data: {
                labels: ['الرياض', 'جدة', 'الدمام', 'مكة', 'المدينة'],
                datasets: [{
                    data: [35, 25, 20, 15, 5],
                    backgroundColor: [
                        '#3498db',
                        '#2ecc71',
                        '#f39c12',
                        '#e74c3c',
                        '#9b59b6'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });
    }
</script>
</body>
</html>
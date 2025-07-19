<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الفندق - نظرة عامة</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset ('bootstrap-5.3.7-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset ('css/viewforhotelwoner.css')}}">

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
                <h1>نظرة عامة</h1>
                <a href="{{route('hotel.add.hotel', $owner_id)}}" class="btn btn-outline-primary ms-2" style="border:1px blue solid;"><i class="fa-solid fa-plus"></i> add hotel </a>
            </div>

            @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @foreach ($hotels as $hotel)

            <!-- بطاقة نظرة عامة -->
            <div class="overview-card">
                <div class="hotel-header">
                    <div class="hotel-name">{{$hotel['name']}}</div>
                    <div class="hotel-status {{$hotel['status'] == 'approved' ?'text-success': 'text-danger'}} ">{{ $hotel['status'] == 'pending' ? 'قيد المراجعة' : ($hotel['status'] == 'approved' ? 'مفعل' : 'مرفوض') }}
                    </div>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">السعر الافتراضي لليلة</div>
                        <div class="info-value">{{$hotel['pricepernight']}}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">عدد الصور المرفوعة</div>
                        <div class="info-value">{{$hotel['imagescount']}}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">عدد الغرف</div>
                        <div class="info-value">{{$hotel['roomcount']}}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">معدل التقييم</div>
                        <div class="info-value">{{$hotel['averagerating'] ? number_format($hotel['averagerating'],$hotel['allrating']).'/5' : 'لا يوجد تقيمات'}}</div>
                    </div>
                </div>

                <div class="action-buttons">
                <a href="{{ route('show.info.hotel', $hotel['id']) }}" class="btn btn-primary text-center no-underline ">
                        <i class="fas fa-edit"></i> تعديل معلومات الفندق
                     </a>
                     <a href="{{route('hotel.add.hotel' , $hotel['hotel_owner_id'])}}" class="btn btn-secondary text-center no-underline">
                         تسجيل فندق جديد
                     </a>
                     <a href="{{route('hotel.statistics', $hotel['id'] )}}" class="btn btn-secondary text-center no-underline">
                        احصائيات عامة
                    </a>
                </div>

            </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        // عرض تاريخ اليوم
        const today = new Date();
        const dateString = today.toLocaleDateString('ar-SA');
        // تأكد من وجود العنصر قبل التعديل عليه
        const dateElement = document.getElementById('current-date');
        if (dateElement) {
            dateElement.textContent = dateString;
        }

        // أحداث الأزرار - تأكد من وجود الأزرار قبل استخدامهم
        const editBtn = document.getElementById('edit-info-btn');
        if (editBtn) {
            editBtn.addEventListener('click', function () {
                alert('سيتم توجيهك إلى صفحة تعديل معلومات الفندق');
                // window.location.href = 'edit-hotel.html';
            });
        }

        const changePasswordBtn = document.getElementById('change-password-btn');
        if (changePasswordBtn) {
            changePasswordBtn.addEventListener('click', function () {
                alert('سيتم فتح نموذج تغيير كلمة المرور');
                // openPasswordModal();
            });
        }

        // تغيير حالة الفندق حسب البيانات الفعلية
        function updateHotelStatus(status) {
            const statusElement = document.querySelector('.hotel-status');
            if (!statusElement) return;

            statusElement.className = 'hotel-status';

            if (status === 'approved') {
                statusElement.classList.add('status-approved');
                statusElement.textContent = 'مقبول';
            } else if (status === 'pending') {
                statusElement.classList.add('status-pending');
                statusElement.textContent = 'قيد المراجعة';
            } else {
                statusElement.classList.add('status-rejected');
                statusElement.textContent = 'مرفوض';
            }
        }

    </script>
</body>
</html>
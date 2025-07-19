<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الفندق - الإعدادات</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset('bootstrap-5.3.7-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/hotelwonersettings.css')}}">
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
                <h1>الإعدادات</h1>
            </div>
            @if(session('success'))
            <div class="alert alert-success mt-2">{{ session('success') }}</div>
           @endif
            <!-- معلومات الحساب -->
            <div class="content-section">
                <h2 class="section-title">
                    <i class="fas fa-user" style="margin-left: 10px;"></i>
                    معلومات الحساب
                </h2>
                <div class="account-info-grid">
                    <div>
                        <div class="info-item">
                            <div class="info-label">الاسم</div>
                            <div class="info-value">{{ $owner['name'] }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">البريد الإلكتروني</div>
                            <div class="info-value">{{ $owner['email'] }}</div>
                        </div>
                    </div>
                    <div>
                        <div class="info-item">
                            <div class="info-label">الدور</div>
                            <div class="info-value">{{ $owner['role'] == "hotel_owner" ? 'مالك الفندق': ' ' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">رقم التواصل</div>
                            <div class="info-value">{{ $owner['phone'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- تعديل البريد الإلكتروني -->
            <div class="content-section">
                <h2 class="section-title">
                    <i class="fas fa-envelope" style="margin-left: 10px;"></i>
                    تعديل البريد الإلكتروني
                </h2>
                <form action="{{route('hotelowner.update.settings',$owner['id'])}}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label>البريد الإلكتروني الحالي</label>
                        <input type="email" class="form-control" value="{{$owner['email']}}" readonly>
                    </div>
                    <div class="form-group">
                        <label>البريد الإلكتروني الجديد</label>
                        <input type="email" name="email" class="form-control" placeholder="أدخل البريد الإلكتروني الجديد">
                    </div>
                    <button type="submit" class="btn btn-primary">تحديث البريد الإلكتروني</button>
                </form>
            </div>

            <!-- تعديل كلمة المرور -->
            <div class="content-section">
                <h2 class="section-title">
                    <i class="fas fa-lock" style="margin-left: 10px;"></i>
                    تغيير كلمة المرور
                </h2>
                <form action="{{route('hotelowner.update.password',$owner['id'])}}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label>كلمة المرور الحالية</label>
                        <input type="password" name="current_password" class="form-control @error('current_password')
                            is-invalid
                        @enderror" placeholder="أدخل كلمة المرور الحالية">
                        @error('current_password')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>كلمة المرور الجديدة</label>
                        <input type="password" name="new_password" class="form-control @error('new_password')
                        is-invalid
                        @enderror" placeholder="أدخل كلمة المرور الجديدة">
                        @error('new_password')
                        <small class="text-danger">
                        {{ $message }}
                    </small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>تأكيد كلمة المرور الجديدة</label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="أعد إدخال كلمة المرور الجديدة">
                        @error('new_password')
                        <small class="text-danger">
                        {{ $message }}
                    </small>
                        @enderror
                    </div>
                    <button  class="btn btn-primary">تغيير كلمة المرور</button>
                </form>
            </div>

            <!-- إجراءات الحساب -->
            <div class="content-section">
                <h2 class="section-title">
                    <i class="fas fa-exclamation-triangle" style="margin-left: 10px;"></i>
                    إجراءات الحساب
                </h2>
               <form action="{{route('hotelowner.logout')}}" method="post">
                @csrf
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <button class="btn btn-logout">
                        <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                    </button>
                </div>
               </form>
            </div>
        </div>
    </div>

    <script>


        // عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            updateCurrentDate();

            // حدث تسجيل الخروج
            document.querySelector('.btn-logout').addEventListener('click', function() {
                if (confirm('هل أنت متأكد من تسجيل الخروج؟')) {
                    alert('سيتم تسجيل خروجك من النظام');
                    // هنا يمكنك إضافة كود تسجيل الخروج الفعلي
                }
            });

            // حدث حذف الحساب
            document.querySelector('.btn-danger').addEventListener('click', function() {
                if (confirm('هل أنت متأكد من حذف الحساب؟ هذا الإجراء لا يمكن التراجع عنه.')) {
                    const confirmDelete = prompt('يرجى كتابة "حذف" للتأكيد:');
                    if (confirmDelete === 'حذف') {
                        alert('سيتم حذف حسابك نهائياً');
                        // هنا يمكنك إضافة كود حذف الحساب الفعلي
                    } else {
                        alert('تم إلغاء عملية حذف الحساب');
                    }
                }
            });
        });
    </script>
<script src="{{ asset('bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
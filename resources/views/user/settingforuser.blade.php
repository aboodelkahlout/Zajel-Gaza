<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>لوحة تحكم العميل - الإعدادات</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset ('bootstrap-5.3.7-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/settingsforuser.css')}}">
</head>
<body>
    <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2>zajel gaza</h2>
        </div>
       @include('user.layout')
    </div>

     <div class="main-content" id="mainContent">
       <div class="container">
        @if(session('success'))
                    <div class="alert alert-success mt-2">{{ session('success') }}</div>
        @endif
        </div>
    <div class="settings-container">
            <div class="settings-header">
                <h2>الإعدادات</h2>
                <p>قم بإدارة معلومات حسابك وتفضيلاتك الشخصية</p>
            </div>
            <div class="settings-section">
                <div class="settings-section-content">
                    <form  action="{{route('user.update.settings')}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">الاسم الكامل</label>
                        <input type="text" name="name" id="name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror "/>
                        @error('name')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">رقم الجوال</label>
                        <input type="tel" id="phone" name="phone" value="{{old('phone')}}" class="form-control @error('phone') is-invalid @enderror "/>
                        @error('phone')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                    </div>
                    </div>
                    <div class="form-group p-4">
                        <label for="password"> كلمة المرور الحالية</label>
                        <input type="password" name="current_password" value="{{old('current_password')}}" id="password" class="form-control @error('current_password') is-invalid @enderror"/>
                    @error('current_password')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                    </div>
                    <div class="form-group p-4">
                        <label for="password">كلمة المرور الجديدة</label>
                        <input type="password" name="new_password" id="password" value="{{old('new_password')}}" class="form-control  @error('current_password') is-invalid @enderror"/>
                    @error('new_password')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                    </div>
                    <div class="form-group p-4">
                        <label for="password">تأكيد كلمة المرور</label>
                        <input type="password" name="confirm_password" value="{{old('confirm_password')}}" id="password" class="form-control @error('new_password_confirmation') is-invalid @enderror"/>
                    @error('confirm_password')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                    </div>
                    <button type="submit" class="btn">تحديث المعلومات</button>
                    </form>
                </div>
            </div>
            <div class="settings-container">
            <div class="settings-section">
                <div class="settings-section-content">
                    <form action="{{route('user.update.email')}}" method="post">
                        @csrf
                        @method('PUT')
                    <div class="form-group">
                        <label for="email">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror"/>
                        @error('email')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <button type="submit" class="btn">تحديث البريد الالكتروني</button>
                    </form>
                    <form action="{{route('user.logout')}}" class="mt-4" method="post">
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
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');

            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('expanded');
                document.body.classList.toggle('sidebar-expanded');

                const icon = menuToggle.querySelector('i');
                if (sidebar.classList.contains('expanded')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
        });
    </script>
</body>
</html>

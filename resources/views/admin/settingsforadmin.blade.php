<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - إعدادات النظام</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset('bootstrap-5.3.7-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/adminsystemsettings.css')}}">
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
            <div class="container">
            @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

        </div>
            <!-- Content Header: Title and Search -->
                <div class="page-header">
                    <div>
                        <h2>إعدادات النظام</h2>
                        <ul class="breadcrumb">
                            <li>لوحة التحكم</li>
                            <li>إعدادات النظام</li>
                        </ul>
                    </div>
                </div>
                <div class="settings-panel">
                    <div class="settings-tabs">
                        <div class="settings-tab active" onclick="openTab('general-settings')">
                            الإعدادات العامة
                        </div>
                        <div class="settings-tab" onclick="openTab('admin-settings')">
                            إعدادات المسؤول
                        </div>
                        <div class="settings-tab" onclick="openTab('contact-settings')">
                            معلومات التواصل
                        </div>
                    </div>

                    <!-- General Settings Tab -->
                    <div id="general-settings" class="settings-content active">
                    <form id="generalSettingsForm" action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                   <label for="sitename">اسم الموقع</label>
                   <br>
                   <input type="text" id="sitename" name="site_name" class="form-control" value="{{ old('site_name', $settings->site_name) }}">
                   <br>
                   <label for="site_description">وصف الموقع </label>
                   <input type="text" id="site_description" name="site_description" class="form-control" value="{{ old('site_description', $settings->site_description) }}">
                   <br>
                   <label for="site_language">لغة الموقع</label>
                   <br>
                   <input type="text" id="site_language" name="site_language" class="form-control" value="{{ old('site_language', $settings->site_language) }}">
                   <br>
                   <label for="site_timezone">المنطقة الزمنية</label>
                   <br>
                  <input type="text" id="site_timezone" name="site_timezone" class="form-control" value="{{ old('site_timezone', $settings->site_timezone) }}">
               <button type="submit" class="btn btn-primary mt-3"><i class="fa fa-save"></i> save</button>
            </form>
         </div>

                    <div id="admin-settings" class="settings-content">
                        <form id="adminSettingsForm" action="{{ route ('admin.settings.update') }}" method="POST">
                         @csrf
                           @method('PUT')
                            <div class="form-group">
                                <label for="admin_username">اسم المستخدم</label>
                                <input type="text" id="admin_username" class="form-control" value="{{old('admin_username',$settings->admin_username)}}">
                            </div>

                            <div class="form-group">
                                <label for="admin_email">البريد الإلكتروني</label>
                                <input type="email" id="admin_email" class="form-control" value="{{old('admin_email',$settings->admin_email)}}">
                            </div>
                            <div class="form-group">
                                <label for="current-password">كلمة المرور الحالية</label>
                                <div class="password-toggle">
                                    <input type="password" name="current_password" id="current-password" class="form-control">
                                    <i class="fas fa-eye" onclick="togglePassword('current-password', this)"></i>
                                @error('current_password')
                                <small class="text-danger">
                                   {{ $message }}
                                 </small>
                                @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="new-password">كلمة المرور الجديدة</label>
                                <div class="password-toggle">
                                    <input type="password" id="new-password" name="new_password" class="form-control">
                                    <i class="fas fa-eye" onclick="togglePassword('new-password', this)"></i>
                                    @error('new_password')
                                <small class="text-danger">
                                   {{ $message }}
                                 </small>
                                @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="confirm-password">تأكيد كلمة المرور</label>
                                <div class="password-toggle">
                                    <input type="password" id="confirm-password" name="confirm_password" class="form-control">
                                    <i class="fas fa-eye" onclick="togglePassword('confirm-password', this)"></i>
                                    @error('confrim_password')
                                <small class="text-danger">
                                   {{ $message }}
                                 </small>
                                @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> حفظ التغييرات
                                </button>
                            </div>
                        </form>
                    </div>


                    <!-- Contact Settings Tab -->
                    <div id="contact-settings" class="settings-content">
                        <form id="contactSettingsForm">
                            <div class="form-group">
                                <label for="contact-email">البريد الإلكتروني للتواصل</label>
                                <input type="email" id="contact-email" name="contact_email" class="form-control" value=" {{old('contact_email' ,$settings-> contact_email )}}">
                            </div>

                            <div class="form-group">
                                <label for="contact-phone">رقم الهاتف</label>
                                <input type="tel" id="contact-phone" name="contact_phone" class="form-control" value=" {{old('contact_phone', $settings->contact_phone)}}">
                            </div>

                            <div class="form-group">
                                <label for="contact-address">العنوان</label>
                                <textarea id="contact-address" name="contact_address" class="form-control" rows="2">الرياض، المملكة العربية السعودية</textarea>
                            </div>

                            <div class="form-group">
                                <label for="contact-facebook">فيسبوك</label>
                                <input type="url" id="contact-facebook" name="contact_facebook" class="form-control" value=" {{old('contact_facebook', $settings->contact_facebook)}}">
                            </div>

                            <div class="form-group">
                                <label for="contact-twitter">تويتر</label>
                                <input type="url" id="contact-twitter" name="contact_twitter" class="form-control" value=" {{old('contact_twitter' , $settings-> contact_twitter)}}">
                            </div>

                            <div class="form-group">
                                <label for="contact-instagram">إنستغرام</label>
                                <input type="url" id="contact-instagram" name="contact_instagram" class="form-control" value=" {{old('contact_instagram', $settings->contact_instagram)}}">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> حفظ التغييرات
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        // JavaScript for toggling sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const toggleSidebar = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');

            toggleSidebar.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('sidebar-collapsed');
            });
        });

        // Settings Tabs Functionality
        function openTab(tabId) {
            // Hide all tabs
            document.querySelectorAll('.settings-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Deactivate all tab buttons
            document.querySelectorAll('.settings-tab').forEach(tab => {
                tab.classList.remove('active');
            });

            // Activate the selected tab
            document.getElementById(tabId).classList.add('active');

            // Activate the clicked tab button
            event.currentTarget.classList.add('active');
        }

        // Password Toggle Functionality
        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Form Submission Handlers
        // document.getElementById('generalSettingsForm').addEventListener('submit', function(e) {
        //     e.preventDefault();
        //     alert('تم حفظ الإعدادات العامة بنجاح');
        //     // هنا يمكنك إضافة كود AJAX لإرسال البيانات إلى الخادم
        // });

        // document.getElementById('adminSettingsForm').addEventListener('submit', function(e) {
        //     e.preventDefault();
        //     alert('تم تحديث إعدادات المسؤول بنجاح');
        //     // هنا يمكنك إضافة كود AJAX لإرسال البيانات إلى الخادم
        // });

        // document.getElementById('contactSettingsForm').addEventListener('submit', function(e) {
        //     e.preventDefault();
        //     alert('تم تحديث معلومات التواصل بنجاح');
        //     // هنا يمكنك إضافة كود AJAX لإرسال البيانات إلى الخادم
        // });

        // Reset Admin Settings
        function resetAdminSettings() {
            if (confirm('هل أنت متأكد من رغبتك في إعادة تعيين إعدادات المسؤول؟')) {
                document.getElementById('admin-username').value = 'admin';
                document.getElementById('admin-email').value = 'admin@example.com';
                document.getElementById('current-password').value = '';
                document.getElementById('new-password').value = '';
                document.getElementById('confirm-password').value = '';
                alert('تم إعادة تعيين الإعدادات');
            }
        }
    </script>
</body>
</html>
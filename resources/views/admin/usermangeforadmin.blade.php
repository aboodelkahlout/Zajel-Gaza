<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - إدارة أصحاب الفنادق</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset('bootstrap-5.3.7-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/customermangeforadmin.css')}}">
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

        @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('erorr') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
            <!-- Content Header: Title and Search -->
 <div class="page-header">
     <div>
         <h2>إدارة المستخدمين</h2>
         <ul class="breadcrumb">
             <li>لوحة التحكم</li>
             <li>إدارة المستخدمين</li>
         </ul>

     </div>
     <form class="d-flex" method="GET" action="{{ route('showalluser') }}">
        <input class="form-control" type="text" name="search" placeholder="ابحث عن اسم اليوزر" value="{{ request('search') }}">
        <button class="btn btn-outline-primary" type="submit"><i class="fa fa-search"></i></button>
    </form>
 </div>

                <!-- Hotel Owners Table -->
                <div class="table-container">
                    <div class="table-header">
                        <h3 class="table-title">قائمة أصحاب الفنادق</h3>
                        <div class="table-actions">
                            <form action="{{ route ('admin.hotel_owners.delete.all')}}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="selected_ids" value="">
                                <button class="btn btn-outline-danger btn-delete d-none" style="border:1px red solid;" onsubmit="return confirm('هل أنت متأكد من حذف ')"> <i class="fa fa-trash"></i> حذف كل المحدد </button>
                            </form>
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="check_all" /></th>
                                <th>id</th>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>الهاتف</th>
                                <th>تاريخ التسجيل</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse ($allusers as $user)
                           <tr>
                           <tr id="row_{{ $user->id }}">
                           <td><input type="checkbox" value="{{ $user->id }}"></td>
                           <td>{{ $loop->iteration }}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->phone}}</td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            <td>{{ $user->status === 'active' ? 'active' : 'not active ' }}</td>
                            <td>
                {{-- زر تعطيل --}}
                <form method="POST" action="{{ route('admin.user.toggle_status', $user->id) }}" style="display:inline;">
                    @csrf @method('PUT')
                    <button type="submit" class="btn btn-warning btn-sm">
                        {{ $user->status === 'active' ? 'تعطيل' : 'تفعيل' }}
                    </button>
                </form>

                {{-- زر حذف --}}
                <form method="POST" action="{{ route('deluser', $user->id) }}" style="display:inline;" onsubmit="return confirm('هل أنت متأكد؟')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                </form>
            </td>
                           </tr>
                           @empty
                           <tr>
                            <td colspan="9" class="text-center">
                                لا يوجد بيانات مستخدمين
                            </td>
                        </tr>
                           @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Owner Details Modal -->
    <div class="modal" id="ownerDetailsModal">
        <div class="modal-content" style="width: 800px;">
            <div class="modal-header">
                <h3 class="modal-title">تفاصيل صاحب الفندق</h3>
                <button class="close-modal" onclick="closeModal('ownerDetailsModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="owner-details">
                    <div>
                        <div class="form-group">
                            <label>الاسم الكامل:</label>
                            <p>محمد أحمد</p>
                        </div>
                        <div class="form-group">
                            <label>البريد الإلكتروني:</label>
                            <p>mohammed@example.com</p>
                        </div>
                        <div class="form-group">
                            <label>الهاتف:</label>
                            <p>+966501234567</p>
                        </div>
                        <div class="form-group">
                            <label>تاريخ التسجيل:</label>
                            <p>2023-01-15</p>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label>الحالة:</label>
                            <p><span class="status status-active">مفعل</span></p>
                        </div>
                        <div class="form-group">
                            <label>عدد الفنادق:</label>
                            <p>3</p>
                        </div>
                        <div class="form-group">
                            <label>آخر نشاط:</label>
                            <p>2023-06-10 14:30</p>
                        </div>
                        <div class="form-group">
                            <label>عنوان السكن:</label>
                            <p>الرياض، حي الصحافة، شارع الملك فهد</p>
                        </div>
                    </div>
                </div>

                <div class="owner-hotels">
                    <h4>الفنادق التابعة له:</h4>

                    <div class="hotel-card">
                        <img src="https://via.placeholder.com/300x200" alt="صورة الفندق" class="hotel-image">
                        <div class="hotel-info">
                            <h4>فندق الشيراتون</h4>
                            <p>الرياض، المملكة العربية السعودية</p>
                        </div>
                        <span class="hotel-status active">مفعل</span>
                        <div class="hotel-actions">
                            <button class="action-btn btn-primary" style="padding: 5px 8px;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="hotel-card">
                        <img src="https://via.placeholder.com/300x200" alt="صورة الفندق" class="hotel-image">
                        <div class="hotel-info">
                            <h4>فندق الرياض</h4>
                            <p>الرياض، المملكة العربية السعودية</p>
                        </div>
                        <span class="hotel-status active">مفعل</span>
                        <div class="hotel-actions">
                            <button class="action-btn btn-primary" style="padding: 5px 8px;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="hotel-card">
                        <img src="https://via.placeholder.com/300x200" alt="صورة الفندق" class="hotel-image">
                        <div class="hotel-info">
                            <h4>فندق النخيل</h4>
                            <p>جدة، المملكة العربية السعودية</p>
                        </div>
                        <span class="hotel-status inactive">معطل</span>
                        <div class="hotel-actions">
                            <button class="action-btn btn-primary" style="padding: 5px 8px;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" onclick="closeModal('ownerDetailsModal')">إغلاق</button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal" id="deleteModal">
        <div class="modal-content" style="width: 500px;">
            <div class="modal-header">
                <h3 class="modal-title">تأكيد الحذف</h3>
                <button class="close-modal" onclick="closeModal('deleteModal')">&times;</button>
            </div>
            <div class="modal-body">
                <p>هل أنت متأكد من رغبتك في حذف هذا الحساب؟ سيتم حذف جميع البيانات المرتبطة به بما في ذلك الفنادق التابعة له.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" onclick="deleteOwner()">نعم، احذف</button>
                <button class="btn" onclick="closeModal('deleteModal')">إلغاء</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>

        document.querySelector('#check_all').onchange=()=>{

            let checkboxes=Array.from(document.querySelectorAll('td input[type=checkbox]'));

            checked = document.querySelector('#check_all').checked;

            checkboxes.forEach(ch => {
                ch.checked = checked;
            });

            if (checked) {
                document.querySelector('.btn-delete').classList.remove('d-none');
            }else{
                 document.querySelector('.btn-delete').classList.add('d-none');
            }
        }

        let checkboxes = document.querySelectorAll('td input[type="checkbox"]');
      checkboxes.forEach(cb=>{
        cb.onchange=()=>{
            let check = false;
            let selected = [];

            checkboxes.forEach(ch => {
                if (ch.checked) {
                    check = true;
                    selected.push(ch.value);
                }
            });

            if (check) {
                document.querySelector('.btn-delete').classList.remove('d-none');
            }else{
                document.querySelector('.btn-delete').classList.add('d-none');

            }

            document.querySelector('input[name=selected_ids]').value = selected.join(',');
        }
    });




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

        // Owner Management Functions
        let currentOwnerId = null;

        function toggleOwnerStatus(id, activate) {
            currentOwnerId = id;
            const action = activate ? 'تفعيل' : 'تعطيل';
            if(confirm(`هل أنت متأكد من رغبتك في ${action} هذا الحساب؟`)) {
                // Here you would typically send an AJAX request to the server
                alert(`تم ${action} الحساب بنجاح`);
                updateOwnerStatus(id, activate);
            }
        }

        function viewOwnerDetails(id) {
            currentOwnerId = id;
            // Here you would typically fetch the details from the server
            document.getElementById('ownerDetailsModal').style.display = 'flex';
        }

        function confirmDeleteOwner(id) {
            currentOwnerId = id;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function deleteOwner() {
            // Here you would typically send an AJAX request to the server
            alert('تم حذف الحساب بنجاح');
            closeModal('deleteModal');
            // Remove the row from the table
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                if(row.cells[1].textContent == currentOwnerId) {
                    row.remove();
                }
            });
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function updateOwnerStatus(id, activate) {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                if(row.cells[1].textContent == id) {
                    const statusCell = row.cells[7];
                    const actionsCell = row.cells[8];

                    if(activate) {
                        statusCell.innerHTML = '<span class="status status-active">مفعل</span>';
                        actionsCell.innerHTML = `
                            <div class="action-buttons">
                                <button class="action-btn btn-warning" onclick="toggleOwnerStatus(${id}, false)">
                                    <i class="fas fa-ban"></i> تعطيل
                                </button>
                                <button class="action-btn btn-primary" onclick="viewOwnerDetails(${id})">
                                    <i class="fas fa-eye"></i> عرض
                                </button>
                                <button class="action-btn btn-danger" onclick="confirmDeleteOwner(${id})">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        `;
                    } else {
                        statusCell.innerHTML = '<span class="status status-inactive">معطل</span>';
                        actionsCell.innerHTML = `
                            <div class="action-buttons">
                                <button class="action-btn btn-success" onclick="toggleOwnerStatus(${id}, true)">
                                    <i class="fas fa-check"></i> تفعيل
                                </button>
                                <button class="action-btn btn-primary" onclick="viewOwnerDetails(${id})">
                                    <i class="fas fa-eye"></i> عرض
                                </button>
                                <button class="action-btn btn-danger" onclick="confirmDeleteOwner(${id})">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        `;
                    }
                }
            });
        }
    </script>
</body>
</html>
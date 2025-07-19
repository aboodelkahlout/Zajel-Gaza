<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - إدارة أصحاب الفنادق</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset('bootstrap-5.3.7-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/hotelwonermangeforadmin.css')}}">
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
                        <h2>إدارة أصحاب الفنادق</h2>
                        <ul class="breadcrumb">
                            <li>لوحة التحكم</li>
                            <li>إدارة أصحاب الفنادق</li>
                        </ul>
                    </div>

                    <form class="d-flex" method="GET" action="{{ route('admin.hotel_owners') }}">
                    <input class="form-control" type="text" name="search" placeholder="ابحث عن اسم صاحب الفندق" value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit"><i class="fa fa-search"></i></button>
                </form>
                </div>



                <!-- Hotel Owners Table -->
                <div class="table-container">
                    <div class="table-header">
                        <h3 class="table-title">قائمة أصحاب الفنادق</h3>
                        <div class="table-actions">
                            <form class="d-inline" action="{{route('admin.hotel_owners.delete.all')}}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="selected_ids">
                                <button class="btn btn-outline-danger btn-delete d-none" style="border:1px red solid;" onsubmit="return confirm('هل أنت متأكد من حذف ')"> <i class="fa fa-trash"></i> حذف كل المحدد </button>
                            </form>
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                            <th><input type="checkbox" id="check_all"></th>
                                <th>id</th>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>الهاتف</th>
                                <th>عدد الفنادق</th>
                                <th>تاريخ التسجيل</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
            @foreach($owners as $owner)
            <tr id="row_{{ $owner->id }}">
            <td><input type="checkbox" value="{{ $owner->id }}"></td>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $owner->name }}</td>
            <td>{{ $owner->email }}</td>
            <td>{{ $owner->phone}}</td>
            <td>{{ $owner->hotels_count }}</td>
            <td>{{ $owner->created_at->format('Y-m-d') }}</td>
            <td>{{ $owner->status === 'active' ? 'مفعل' : 'غير مفعل' }}</td>
            <td style="white-space: nowrap;">
            <form method="POST" action="{{ route('admin.hotel_owners.toggle_status', $owner->id) }}" style="display:inline;">
                    @csrf @method('PUT')
                    <button type="submit" class="btn btn-warning btn-sm">
                        {{ $owner->status === 'active' ? 'تعطيل' : 'تفعيل' }}
                    </button>
                </form>

                {{-- زر حذف --}}
                <form method="POST" action="{{ route('admin.hotel_owners.delete', $owner->id) }}" style="display:inline;" onsubmit="return confirm('هل أنت متأكد؟')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                </form>
                {{-- زر عرض --}}
                <div class="action-buttons" style="display:inline;">
        <button class="action-btn btn-primary" style="padding:10px;" onclick="openModal('ownerModal-{{ $owner->id }}')">
            <i class="fas fa-eye"></i> عرض
        </button>
    </div>
     @foreach($owners as $owner)
    <!-- Modal خاص بصاحب الفندق -->
    <div class="modal" id="ownerModal-{{ $owner->id }}" style="display:none;">
        <div class="modal-content" style="width: 800px;">
            <div class="modal-header">
                <h3 class="modal-title">تفاصيل صاحب الفندق</h3>
                <button class="close-modal" onclick="closeModal('ownerModal-{{ $owner->id }}')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="owner-details">
                    <div>
                        <div class="form-group">
                            <label>الاسم الكامل:</label>
                            <p>{{ $owner->name }}</p>
                        </div>
                        <div class="form-group">
                            <label>البريد الإلكتروني:</label>
                            <p>{{ $owner->email }}</p>
                        </div>
                        <div class="form-group">
                            <label>الهاتف:</label>
                            <p>{{ $owner->phone }}</p>
                        </div>
                        <div class="form-group">
                            <label>تاريخ التسجيل:</label>
                            <p>{{ $owner->created_at->format('Y-m-d') }}</p>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label>الحالة:</label>
                            <p><span class="status {{ $owner->status === 'active' ? 'status-active' : 'status-inactive' }}">
                                {{ $owner->status === 'active' ? 'مفعل' : 'غير مفعل' }}</span></p>
                        </div>
                        <div class="form-group">
                            <label>عدد الفنادق:</label>
                            <p>{{ $owner->hotels_count }}</p>
                        </div>
                    </div>
                </div>

                <div class="owner-hotels">
                    <h4>الفنادق التابعة له:</h4>
                    @foreach ($owner->hotels as $hotel)
                        <div class="hotel-card">

                    <img src="{{ asset('img/' . ($hotel->cover_image ?? 'default.jpg')) }}" width="80" height="60" style="margin: 5px;">
                            <div class="hotel-info">
                                <h4>{{ $hotel->name }}</h4>
                                <p>{{ $hotel->city }}، {{ $hotel->country }}</p>
                            </div>
                            <span class="hotel-status {{ $hotel->status == 'approved' ? 'active' : 'inactive' }}">
                                {{ $hotel->status == 'approved' ? 'مفعل' : 'معطل' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" onclick="closeModal('ownerModal-{{ $owner->id }}')">إغلاق</button>
            </div>
        </div>
    </div>
@endforeach
            </td>
        </tr>
        @endforeach
    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

      <script>
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




        document.querySelector('#check_all').onchange =()=>{
            const checkboxes=Array.from(document.querySelectorAll('td input[type="checkbox"]'));
            let check = document.querySelector('#check_all').checked;
            checkboxes.forEach((cb)=> cb.checked = check);

            if (check) {
                document.querySelector('.btn-delete').classList.remove('d-none');
            }else{
                document.querySelector('.btn-delete').classList.add('d-none');

            }
        }
    </script>
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



        function openModal(id) {
    document.getElementById(id).style.display = 'flex';
}
function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

    </script>
</body>
</html>
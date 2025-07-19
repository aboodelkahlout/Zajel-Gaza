<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - إدارة الفنادق</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset('bootstrap-5.3.7-dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/hotelmangeforadmin.css')}}">
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
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('error') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
            <!-- Content Header: Title and Search -->
 <div class="page-header">
     <div>
         <h2>إدارة الفنادق</h2>
         <ul class="breadcrumb">
             <li>لوحة التحكم</li>
             <li>إدارة الفنادق</li>
         </ul>
     </div>
     <form class="d-flex" method="GET" action="{{ route('admin.hotel.requests') }}">
    <input class="form-control" type="text" name="search" placeholder="ابحث عن اسم الفندق" value="{{ request('search') }}">
    <button class="btn btn-outline-primary" type="submit"><i class="fa fa-search"></i></button>
</form>

 </div>

                <!-- Hotels Table -->
                <div class="table-container">
                    <div class="table-header">
                        <h3 class="table-title">قائمة الفنادق</h3>
                        <form action="{{route('admin.hotel.delete.allhotel')}}" method="post">
                            @csrf
                            <input type="hidden" value="" name="selected_ids">
                            <button class="btn btn-outline-danger btn-delete d-none" style="border:1px red solid;"> <i class="fa fa-trash ms-2"></i>حذف كل المحدد</button>
                        </form>
                    </div>
                    <table>
                        <thead>
                            <tr>
                            <th><input type="checkbox" id="select_all"></th>
                                <th>id</th>
                                <th>اسم الفندق</th>
                                <th>المدينة</th>
                                <th>صاحب الفندق</th>
                                <th>رقم الفندق</th>
                                <th>الوصف</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
        @forelse ($requests as $hotel)
        <tr class="row_{{$hotel->id}}">
            <td><input type="checkbox" value="{{ $hotel->id }}"></td>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $hotel->name }}</td>
            <td>{{$hotel->adress}}</td>
            <td>{{ $hotel->owner->name }}</td>
            <td>{{ $hotel->phone_number }}</td>
            <td>{{ $hotel->description }}</td>
            <td>{{$hotel->status}}</td>
            <td style="white-space: nowrap;">
            <form method="POST" action="{{ route('admin.hotel.requests.approve', $hotel->id) }}" style="display:inline-block">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">موافقة</button>
                </form>

                <form method="POST" action="{{ route('admin.hotel.requests.reject', $hotel->id) }}" style="display:inline-block">
                    @csrf
                    <button type="submit" class="btn btn-warning btn-sm" onclick=" return confirm('هل انت متأكد من رفض هذا الفندق ')">رفض</button>
                </form>
                <form method="POST" action="{{route('admin.hotel.requests.delete', $hotel->id )}}" onsubmit="return confirm('هل انت متأكد من حذف العنصر !')" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="sumbit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                </form>
            <div class="action-buttons" style="display:inline;">
               <button class="action-btn btn-primary" style="padding:10px;" onclick="openModal('hotelModal-{{ $hotel->id }}')"><i class="fas fa-eye"></i> عرض </button>
               @foreach($requests as $hotel)
    <!-- Modal خاص بصاحب الفندق -->
    <div class="modal" id="hotelModal-{{ $hotel->id }}" style="display:none;">
        <div class="modal-content" style="width: 800px;">
            <div class="modal-header">
                <h3 class="modal-title">تفاصيل صاحب الفندق</h3>
                <button class="close-modal" onclick="closeModal('hotelModal-{{ $hotel->id }}')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="hotel-details">
                    <div>
                        <div class="form-group">
                            <label>الاسم الكامل:</label>
                            <p>{{ $hotel->name }}</p>
                        </div>
                        <div class="form-group">
                            <label> اسم صاحب الفندق</label>
                            <p>{{ $hotel->owner->name }}</p>
                        </div>
                        <div class="form-group">
                            <label>البريد الالكتروني</label>
                            <p>{{ $hotel->owner->email }}</p>
                        </div>
                        <div class="form-group">
                            <label>رقم هاتف الفندق</label>
                            <p>{{ $hotel->phone_number }}</p>
                        </div>
                        <div class="form-group">
                            <label>رقم هاتف صاحب الفندق</label>
                            <p>{{ $hotel->owner->phone }}</p>
                        </div>
                        <div class="form-group">
                    <label>الوصف:</label>
                    <p>{{ $hotel->description }}</p>
                </div>
                  <div class="form-group">
                            <label>موقع الفندق</label>
                            <p> {{$hotel->adress}}</p>
                        </div>

                        <div class="form-group">
                            <label>تاريخ التسجيل:</label>
                            <p>{{ $hotel->created_at->format('Y-m-d') }}</p>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label>الحالة:</label>
                            <p><span class="status {{ $hotel->status === 'approved' ? 'status-active' : 'status-inactive' }}">
                                {{ $hotel->status === 'approved' ? 'مفعل' : 'غير مفعل' }}</span></p>
                        </div>
                        <div class="form-group">
                            <label>متوسط التقيمات</label>
                            <p>{{ $hotel->ratings->avg('rating') ?? 'لا يوجد تقييمات' }}</p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>صور الفندق:</label>
                    <div class="hotel-gallery">
                    @foreach ($hotel->images as $image)
                    <img src="{{ asset($image->image_path) }}" width="80" height="60" style="margin: 5px;">
                   @endforeach
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn" onclick="closeModal('hotelModal-{{ $hotel->id }}')">إغلاق</button>
            </div>
        </div>
    </div>
@endforeach
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center">لا يوجد طلبات حالياً</td>
        </tr>
        @endforelse
    </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Hotel Details Modal -->
    <div class="modal" id="hotelDetailsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">تفاصيل الفندق</h3>
                <button class="close-modal" onclick="closeModal('hotelDetailsModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="hotel-details">
                    <div>
                        <div class="form-group">
                            <label>اسم الفندق:</label>
                            <p>فندق الشيراتون</p>
                        </div>
                        <div class="form-group">
                            <label>صاحب الفندق:</label>
                            <p>أحمد محمد</p>
                        </div>
                        <div class="form-group">
                            <label>البريد الإلكتروني:</label>
                            <p>ahmed@example.com</p>
                        </div>
                        <div class="form-group">
                            <label>الهاتف:</label>
                            <p>+966501234567</p>
                        </div>
                        <div class="form-group">
                            <label>العنوان:</label>
                            <p>الرياض، حي الصحافة، شارع الملك فهد</p>
                        </div>
                        <div class="form-group">
                            <label>المدينة:</label>
                            <p>الرياض</p>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label>سعر الليلة:</label>
                            <p>500 ر.س</p>
                        </div>
                        <div class="form-group">
                            <label>التقييم:</label>
                            <p>
                                <i class="fas fa-star" style="color: #f39c12;"></i> 4.5 (120 تقييم)
                            </p>
                        </div>
                        <div class="form-group">
                            <label>الحالة:</label>
                            <p><span class="status status-active">نشط</span></p>
                        </div>
                        <div class="form-group">
                            <label>تاريخ الإضافة:</label>
                            <p>2023-05-15</p>
                        </div>
                        <div class="form-group">
                            <label>آخر تحديث:</label>
                            <p>2023-06-10</p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>الوصف:</label>
                    <p>فندق 5 نجوم يقدم خدمات فاخرة مع إطلالة رائعة على المدينة، يحتوي على مسبح داخلي وخارجي ومركز لياقة بدنية. الغرف مجهزة بأحدث التقنيات وتوفر إطلالات بانورامية على المدينة. يقدم الفندق خدمة الواي فاي المجانية في جميع أنحاء الفندق، كما يضم عدة مطاعم تقدم أشهى المأكولات المحلية والعالمية.</p>
                </div>

                <div class="form-group">
                    <label>المرافق:</label>
                    <p>واي فاي مجاني، موقف سيارات، مطعم، مسبح، صالة رياضية، مركز سبا، غرف لغير المدخنين، خدمة الغرف على مدار 24 ساعة، صراف آلي، مكتب استقبال على مدار 24 ساعة</p>
                </div>

                <div class="form-group">
                    <label>صور الفندق:</label>
                    <div class="hotel-gallery">
                        <img src="https://via.placeholder.com/300x200" alt="صورة الفندق">
                        <img src="https://via.placeholder.com/300x200" alt="صورة الفندق">
                        <img src="https://via.placeholder.com/300x200" alt="صورة الفندق">
                        <img src="https://via.placeholder.com/300x200" alt="صورة الفندق">
                        <img src="https://via.placeholder.com/300x200" alt="صورة الفندق">
                        <img src="https://via.placeholder.com/300x200" alt="صورة الفندق">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" onclick="closeModal('hotelDetailsModal')">إغلاق</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>    <script>
        document.querySelector('#select_all').onchange =()=>
        {
             const checkboxes =Array.from(document.querySelectorAll('td input[type=checkbox]'));
             let check =document.querySelector('#select_all').checked;
             checkboxes.forEach( (cb) => cb.checked = check);
             if (check) {
                document.querySelector('.btn-delete').classList.remove('d-none')
             }else{
                document.querySelector('.btn-delete').classList.add('d-none')
             }
        }

        let checkboxes = document.querySelectorAll('td input[type="checkbox"]');
        checkboxes.forEach(cb => {
            cb.onchange=()=>{

                let check = false ;
                let selected=[];

                checkboxes.forEach(ch => {
                    if (ch.checked) {
                        check = true ;
                        selected.push(ch.value);
                    }
                });
                if (check) {
                document.querySelector('.btn-delete').classList.remove('d-none')
             }else{
                document.querySelector('.btn-delete').classList.add('d-none')
             }

             let selectedids= document.querySelector('input[name=selected_ids]').value=selected.join(',');

            }
        });

    </script>

    <script>
        // JavaScript for toggling sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const toggleSidebar = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');

            toggleSidebar.addEventListener('click', function() {
                sidebar.classList.toggle('sidebar-collapsed');
            });
        });

        // Hotel Management Functions
        function viewHotelDetails(id) {
            // Here you would typically fetch the details from the server
            document.getElementById('hotelDetailsModal').style.display = 'flex';
        }

        function suspendHotel(id) {
            if(confirm('هل أنت متأكد من تعطيل هذا الفندق؟')) {
                // Here you would typically send an AJAX request to the server
                alert('تم تعطيل الفندق بنجاح');
                updateHotelStatus(id, 'suspended');
            }
        }

        function activateHotel(id) {
            if(confirm('هل أنت متأكد من تفعيل هذا الفندق؟')) {
                // Here you would typically send an AJAX request to the server
                alert('تم تفعيل الفندق بنجاح');
                updateHotelStatus(id, 'active');
            }
        }

        function deleteHotel(id) {
            if(confirm('هل أنت متأكد من حذف هذا الفندق؟ لا يمكن التراجع عن هذه العملية.')) {
                // Here you would typically send an AJAX request to the server
                alert('تم حذف الفندق بنجاح');
                // Remove the row from the table
                const rows = document.querySelectorAll('tbody tr');
                rows.forEach(row => {
                    if(row.cells[1].textContent == id) {
                        row.remove();
                    }
                });
            }
        }

        function updateHotelStatus(id, status) {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                if(row.cells[1].textContent == id) {
                    const statusCell = row.cells[8];
                    const actionsCell = row.cells[9];

                    if(status === 'active') {
                        statusCell.innerHTML = '<span class="status status-active">نشط</span>';
                        actionsCell.innerHTML = `
                            <div class="action-buttons">
                                <button class="action-btn btn-primary" onclick="viewHotelDetails(${id})">
                                    <i class="fas fa-eye"></i> عرض
                                </button>
                                <button class="action-btn btn-warning" onclick="suspendHotel(${id})">
                                    <i class="fas fa-ban"></i> تعطيل
                                </button>
                                <button class="action-btn btn-danger" onclick="deleteHotel(${id})">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        `;
                    } else if(status === 'suspended') {
                        statusCell.innerHTML = '<span class="status status-suspended">موقوف</span>';
                        actionsCell.innerHTML = `
                            <div class="action-buttons">
                                <button class="action-btn btn-primary" onclick="viewHotelDetails(${id})">
                                    <i class="fas fa-eye"></i> عرض
                                </button>
                                <button class="action-btn btn-success" onclick="activateHotel(${id})">
                                    <i class="fas fa-check"></i> تفعيل
                                </button>
                                <button class="action-btn btn-danger" onclick="deleteHotel(${id})">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        `;
                    } else if(status === 'inactive') {
                        statusCell.innerHTML = '<span class="status status-inactive">غير نشط</span>';
                        actionsCell.innerHTML = `
                            <div class="action-buttons">
                                <button class="action-btn btn-primary" onclick="viewHotelDetails(${id})">
                                    <i class="fas fa-eye"></i> عرض
                                </button>
                                <button class="action-btn btn-success" onclick="activateHotel(${id})">
                                    <i class="fas fa-check"></i> تفعيل
                                </button>
                                <button class="action-btn btn-danger" onclick="deleteHotel(${id})">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        `;
                    }
                }
            });
        }


        function openModal(id) {
    document.getElementById(id).style.display = 'flex';
}
function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}
    </script>
</body>
</html>
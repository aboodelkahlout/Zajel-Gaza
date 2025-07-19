<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Rating;
use App\Models\comment;
use App\Models\AdminSetting;
use App\Models\CommentReply;
use App\Models\HotelRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    function admindashbord(){
        $usersCount = User::where('role', 'user')->count();
        $ownersCount = User::where('role', 'hotel_owner')->count();
        $hotelsCount = Hotel::count();

        $topHotels = Hotel::withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->take(5)
            ->get();

        return view('admin.admindashbord', compact('usersCount', 'ownersCount', 'hotelsCount', 'topHotels'));
    }

    public function hotelRequests(Request $request)
{
    $query = Hotel::with(['owner', 'images','ratings']);

    if ($request->has('search') && $request->search !== null) {
        $query->where('name', 'LIKE', '%' . $request->search . '%');
    }

    $requests = $query->orderBy('created_at', 'desc')->get();

    return view('admin.controlhotel', compact('requests'));
}

public function deletehotel($id){

    $hotel =Hotel::findOrFail($id);
    $hotel->delete();
    return redirect()->back()->with('success', 'تم الحذف بنجاح');

}

public function approveHotelRequest($id)
{
    $hotel = Hotel::findOrFail($id);
    $hotel->status = 'approved';
    $hotel->save();

    return redirect()->back()->with('success', 'تمت الموافقة على الفندق.');
}

public function rejectHotelRequest($id)
{
    $request = Hotel::findOrFail($id);
    $request->status = 'rejected';
    $request->save();

    return back()->with('success', 'تم رفض الطلب.');
}

public function hotelOwners(Request $request)
{

    $query = User::where('role', 'hotel_owner');


    if ($request->has('search') && $request->search !== null) {
        $query->where('name', 'LIKE', '%' . $request->search . '%');
    }

    $owners = $query->withCount('hotels')->orderBy('created_at', 'desc')->get();



    return view('admin.hotelownermange', compact('owners'));
}

public function toggleStatus($id)
{
    $owner = User::findOrFail($id);
    $owner->status = $owner->status === 'active' ? 'inactive' : 'active';
    $owner->save();

    if ($owner->status === 'inactive') {
        Hotel::where('hotel_owner_id', $owner->id)
            ->update(['status' => 'rejected']);
    }



    return redirect()->back()->with('success', 'تم تغيير حالة الحساب وجميع الفنادق.');

}

public function destroy($id)
{
    $owner = User::findOrFail($id);
    $owner->hotels()->delete();
    $owner->delete();

    return redirect()->back()->with('success', 'تم حذف الحساب بنجاح.');
}



 public function showalluser(Request $request){

    $query = User::where('role', 'user');


    if ($request->has('search') && $request->search !== null) {
        $query->where('name', 'LIKE', '%' . $request->search . '%');
    }

    $allusers = $query->orderBy('created_at', 'desc')->get();


    return view('admin.usermangeforadmin',compact('allusers'));
 }

 public function deluser($id){
    $owner = User::findOrFail($id);
    $owner->delete();
    return redirect()->back()->with('success', 'تم حذف الحساب بنجاح.');
 }


 public function togglestatususer($id){
    $user=User::findOrFail($id);

    $user->status=$user->status === 'active' ? 'inactive' : 'active';
    $user->save();
    return redirect()->back()->with('success', 'تم تغيير حالة الحساب.');
 }



public function statistics()
{


    $usersCount = User::where('role', 'user')->count();
    $ownersCount = User::where('role', 'hotel_owner')->count();
    $hotelsCount = Hotel::count();


    $monthlyComments = Comment::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
    ->whereYear('created_at', Carbon::now()->year)
    ->groupByRaw('MONTH(created_at)')
    ->pluck('total', 'month');

    $commentsPerMonth = [];
    for ($i = 1; $i <= 12; $i++) {
        $commentsPerMonth[] = $monthlyComments->get($i, 0);
    }

    $hotelsByadress = Hotel::select('adress', DB::raw('count(*) as total'))
        ->groupBy('adress')
        ->pluck('total', 'adress');



    $recentActivities = [];

    $comments = comment::with('user', 'hotel')->latest()->take(5)->get()->map(function($comment) {
        return [
            'type' => 'comment',
            'user' => $comment->user->name,
            'text' => 'علق على فندق "' . $comment->hotel->name . '"',
            'time' => $comment->created_at->diffForHumans(),
        ];
    });


    $ratings = Rating::with('user', 'hotel')->latest()->take(5)->get()->map(function($rating) {
        return [
            'type' => 'rating',
            'user' => $rating->user->name,
            'text' => 'أضاف تقييم لـ "' . $rating->hotel->name . '"',
            'time' => $rating->created_at->diffForHumans(),
        ];
    });


    $hotels = Hotel::with('owner')->latest()->take(5)->get()->map(function($hotel) {
        return [
            'type' => 'hotel',
            'user' => $hotel->owner->name,
            'text' => 'أضاف فندق جديد "' . $hotel->name . '"',
            'time' => $hotel->created_at->diffForHumans(),
        ];
    });

    $newUsers = User::latest()->take(5)->get()->map(function($user) {
        return [
            'type' => 'user',
            'user' => 'نظام',
            'text' => 'مستخدم جديد "' . $user->name . '" قام بالتسجيل',
            'time' => $user->created_at->diffForHumans(),
        ];
    });

    $comments = collect($comments);
    $ratings = collect($ratings);
    $hotels = collect($hotels);
    $newUsers = collect($newUsers);

    $recentActivities = $comments
        ->merge($ratings)
        ->merge($hotels)
        ->merge($newUsers)
        ->sortByDesc('time')
        ->take(5);




    return view('admin.statistics', compact('recentActivities','usersCount', 'ownersCount', 'hotelsCount','commentsPerMonth', 'hotelsByadress'));
}


    public function showcomment(){

        $comments = Comment::with(['user', 'hotel', 'hotel.ratings'])->get();
        $commentstotal = Comment::count();

        return view('admin.ratingandcommentforadmin', compact('comments'));
    }

    public function destroycomment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->back()->with('success', 'تم حذف التعليق بنجاح');
    }


public function setting()
{
    $settings = AdminSetting::first();
    return view('admin.settingsforadmin', compact('settings'));
}

public function updatesetting(Request $request)
{


    $request->validate([
        'site_name' => 'required|string|max:255',
        'site_description'=> 'nullable|string|max:500',
        'site_language'=> 'nullable|string|max:10',
        'site_timezone'=> 'nullable|string|max:50',
        'admin_username'=> 'required|string|max:255',
        'admin_email' => 'required|email|max:255',
        'contact_email' => 'required|email|max:255',
        'contact_phone' => 'nullable|string|min:8|max:15',
        'contact_address'=> 'nullable|string|max:255',
        'contact_facebook'=> 'nullable',
        'contact_twitter' => 'nullable',
        'contact_instagram' => 'nullable',
    ], [
        'site_name.required' => 'اسم الموقع مطلوب.',
        'admin_username.required'=> 'اسم المستخدم للمسؤول مطلوب.',
        'admin_email.required'=> 'البريد الإلكتروني للمسؤول مطلوب.',
        'admin_email.email'=> 'صيغة بريد المسؤول غير صحيحة.',
        'contact_email.required'=> 'بريد التواصل مطلوب.',
        'contact_email.email'=> 'صيغة بريد التواصل غير صحيحة.',
        'contact_phone.min'=> 'رقم الهاتف قصير جداً.',
        'contact_phone.max'=> 'رقم الهاتف طويل جداً.',
    ]);


    $data = $request->only([
        'site_name',
        'site_description',
        'site_language',
        'site_timezone',
        'admin_username',
        'admin_email',
        'contact_email',
        'contact_phone',
        'contact_address',
        'contact_facebook',
        'contact_twitter',
        'contact_instagram',
    ]);

    $user = Auth::user();

    if ($request->filled('current_password') || $request->filled('new_password') || $request->filled('confirm_password')) {

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة.']);
        }

        if ($request->new_password !== $request->confirm_password) {
            return back()->withErrors(['confirm_password' => 'تأكيد كلمة المرور لا يطابق الجديدة.']);
        }

        $request->validate([
            'new_password' => 'required|min:6',
        ]);

        $user->password = Hash::make($request->new_password);
        $user->save();
    }

    $settings = AdminSetting::first();

    if (!$settings) {
        AdminSetting::create($data);
    } else {
        $settings->update($data);
    }

    return redirect()->back()->with('success', 'تم تحديث الإعدادات بنجاح.');
}

public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'تم تسجيل الخروج بنجاح.');
}


public function deleteall(Request $request)
{
    $ids=explode(',' , $request-> selected_ids);
    $hotelowner= User::whereIn('id' , $ids)->delete();
    return redirect()->back()->with('success', 'تم الحذف بنجاح ');
}


public function deleteallhotel(Request $request){
    $ids=explode(',', $request->selected_ids);
    $deletehotel=Hotel::whereIn('id',$ids)->delete();
    return redirect()->back()->with('success', 'تم الحذف بنجاح ');
}


}

<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;


class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('dashboard.profile.edit', [
            'user' => $user,
            'countries' => Countries::getNames(),
            'locales' => Languages::getNames(),
        ]);
    }

    public function update(Request $request)
    {
        
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birthday' => ['nullable', 'date', 'before:today'],
            'gender' => ['required', 'in:male,female'],
            'country' => ['required', 'string', 'size:2'],
        ]);

        $user = $request->user();

        $user->profile->fill( $request->all() )->save();

        return redirect()->route('dashboard.profile.edit')
            ->with('success', 'Profiel Update!');

        // $profile = $user->profile;
        // if ($profile->user_id)
        // {
        //     $profile->updata($request->all());
        // }
        // else 
        // {
        //     // $request->merge([
        //     //     'user_id' => $user->id,
        //     // ]);
        //     // Profile::create($request->all());

        //     $user->profile()->create($request->all());
        // }
    }
}

// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Auth;
// use Symfony\Component\Intl\Countries;
// use Symfony\Component\Intl\Languages;

// class ProfileController extends Controller
// {
//     public function edit()
//     {
//         $user = Auth::user();
//         return view('dashboard.profile.edit', [
//             'user' => $user,
//             'countries' => Countries::getNames(),
//             'locales' => Languages::getNames(),
//         ]);
//     }

//     public function update(Request $request)
//     {
//         $request->validate([
//             'first_name' => ['required', 'string', 'max:255'],
//             'last_name' => ['required', 'string', 'max:255'],
//             'birthday' => ['nullable', 'date', 'before:today'],
//             'gender' => ['required', 'in:male,female'],
//             'country' => ['required', 'string', 'size:2'],
//         ]);

//         $user = $request->user();

//         // تحديث بيانات الملف الشخصي للمستخدم
//         $user->profile->fill($request->only([
//             'first_name',
//             'last_name',
//             'birthday',
//             'gender',
//             'country'
//         ]))->save();

//         return redirect()->route('dashboard.profile.edit')
//             ->with('success', 'تم تحديث الملف الشخصي بنجاح!');
//     }
// }

<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Spatie\Permission\Models\Role;
use function Symfony\Component\String\s;

class UserController extends Controller
{
    function index(Request $request)
    {
        $roles = Role::get();
        $query = User::autosort();

        if ($request->search) {
            $query = $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $users = $query->paginate($request->perpage ?? 10);

        return view('users.list', compact('users', 'roles'));
    }

    function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'status' => 'required',
        ]);

        DB::beginTransaction();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role_id);

        DB::commit();

        return redirect()->back()->with('success', 'Kullanıcı oluşturuldu..');
    }

    function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'role_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'status' => 'required',
        ]);
        DB::beginTransaction();

        $user = User::find($request->id);
        if (!$user) {
            return redirect()->back()->withErrors(['Kullanıcı bulunamadı!']);
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        if ($request->password != "" && $request->password != null) {
            $user->password = Hash::make($request->password);
            $user->save();
        }
        $user->roles()->detach();
        $user->assignRole($request->role_id);

        DB::commit();

        return redirect()->back()->with('success', 'Kullanıcı düzenlendi..');
    }

    function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->withErrors(['Kullanıcı bulunamadı!']);
        }

        $user->roles()->detach();
        $user->delete();
        return  redirect()->back()->with('success', 'Kullanıcı silindi..');
    }

    function profile()
    {
        return view('settings.profile');
    }

    function changePass(Request $request)
    {
        $request->validate([
            'pass' => 'required|confirmed|min:6',
        ]);

        $user = User::findOrFail(auth()->user()->id);

        $user->password = Hash::make($request->pass);
        $user->save();

        return redirect()->back()->with('success', "Şifre değiştirme işlemi başarılı");
    }

    function settings() {
        $name = Helper::getSelectedDbName();
        return view('settings', compact('name'));
    }
}

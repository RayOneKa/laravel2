<?php

namespace App\Http\Controllers;

use App\Jobs\exportCategoriesJob;
use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function admin ()
    {
        return view('admin.admin');
    }

    public function users ()
    {

        $users = User::paginate(3);
        $roles = Role::get();

        $data = [
            'title' => 'Список пользователей',
            'users' => $users,
            'roles' => $roles,
        ];
        return view('admin.users', $data);
    }

    public function products ()
    {
        return view('admin.products');
    }

    public function categories ()
    {
        $categories = Category::get();
        return view('admin.categories', compact('categories'));
    }

    public function enterAsUser ($id)
    {
        Auth::loginUsingId($id);
        return redirect()->route('adminUsers');
    }

    public function addRole ()
    {
        request()->validate([
            'name' => 'required|min:3',
        ]);

        Role::create([
            'name' => request('name')
        ]);
        return back();
    }

    public function addRoleToUser ()
    {
        request()->validate([
            'user_id' => 'required',
            'role_id' => 'required',
        ]);

        $user = User::find(request('user_id'));
        $user->roles()->attach(Role::find(request('role_id')));
        return back();
    }

    public function exportCategories ()
    {
        exportCategoriesJob::dispatch(Auth::user()->id);
    }
}

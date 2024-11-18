<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::paginate(5);

        if ($request->ajax()) {
            return view("admin.users.users_list", compact("users"))->render();
        }

        return view("admin.users.index")->with(["users" => $users]);
    }

    public function userSearch(Request $request)
    {
        $name = $request->name;
        $email = $request->email;

        $query = User::query();
        if ($name) {
            $query->where("name", "like", "%{$name}%");
        }
        if ($email) {
            $query->where("email", "like", "%{$email}%");
        }
        $users = $query->paginate(5)->withQueryString();

        return view("admin.users.users_list", compact("users"))->render();
    }
}

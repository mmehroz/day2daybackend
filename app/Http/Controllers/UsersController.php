<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use DB;

class UsersController extends Controller
{
    /**
     * Display all users
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show form for creating user
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create', ['roles' => Role::all()]);
    }

    /**
     * Store a newly created user
     *
     * @param User $user
     * @param StoreUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|Integer|exists:roles,id',
            'status' => 'required|boolean',
            'tier' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);



        if ($request->file('photo')) {
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('assets/img/'), $imageName);
            $request->merge(['photo' => $imageName]);
        }
        else {
            $request->merge(['photo' => 'placeholder.jpg']);
        }
        if ($request->status == 1) {
            $request->merge(['status' => true]);
        }
        else {
            $request->merge(['status' => false]);
        }
        if ($request->verify == '1') {
            $request->merge(["email_verified_at"=> now()->format('Y-m-d H:i:s')]);
        }
        $user = User::create($request->all());
        // $user->assignRole([$request->role_id]);
        return redirect()->route('users.index')
            ->withSuccess(__('User created successfully.'));
    }

    /**
     * Show user data
     *
     * @param User $user
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Edit user data
     *
     * @param User $user
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'roles' => Role::all()
        ]);
    }

    /**
     * Update user data
     *
     * @param User $user
     * @param UpdateUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        // dd($user);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'username' => 'required|string|max:255|',
            'role_id' => 'required|Integer|exists:roles,id',
            'status' => 'required|boolean',
        ]);
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('assets/img/'), $imageName);
            $request->merge(['photo' => $imageName]);
        }
        else {
            $request->merge(['photo' => 'placeholder.jpg']);
        }
        if ($request->verify == "1") {
            // dd("test");
            DB::table('users')
            ->where('email', $request->email)
            ->update(['email_verified_at' => date('Y-m-d h:i:s')]);
            // $request->merge(["email_verified_at"=> date('Y-m-d h:i:s')]);
        }
        else {
            $request->merge(['email_verified_at' => null]);
        }
        $user->update($request->all());
        // $user->syncRoles([$request->role_id]);
        return redirect()->route('users.index')
            ->withSuccess(__('User updated successfully.'));
    }

    /**
     * Delete user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->withSuccess(__('User deleted successfully.'));
    }

    public function profile()
    {
        return view('users.show', [
            'user' => Auth::user()
        ]);
    }
    public function password_edit()
    {
        return view('users.password');
    }
    public function password_update(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);
        $user = User::find(Auth::user()->id);
        $user->password = $request->password;
        $user->save();

        return redirect()->route('dashboard')
            ->withSuccess(__('Password updated successfully.'));
    }
}

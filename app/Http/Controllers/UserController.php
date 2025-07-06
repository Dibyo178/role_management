<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get();
        return view('backend.pages.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::latest()->get();

         return view('backend.pages.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([

            'name'=>'required',
             'email' => 'required|unique:users,email',
             'password'=>'required|same:confirm_password',
              'roles' => 'required'

        ]);

        $User = User::create([

            'name'=>$request->name,
            'email'=> $request->email,
            'password'=>Hash::make($request->password)
        ]);

        $User->assignRole($request->roles);
        flash()->success('User Created sucessfully');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        $roles = Role::latest()->get();
        $userRole = $user->roles->pluck('name')->all();
        return view('backend.pages.users.edit',compact('user','roles','userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
          $request->validate([

            'name'=>'required',
             'email' => 'required|unique:users,email,'.$id,
             'password'=>'nullable|same:confirm_password', // nullable means i may enter the password or i may not
              'roles' => 'required'

        ]);

        $User = User::find($id);

        $User->update([

            'name' => $request->name,
            'email' => $request->email
        ]);

         if($request->has('paaword'))
         {
            $User->update([

                 'password' => Hash::make($request->password),

            ]);
            
         }
   

        $User->syncRoles($request->roles);
        flash()->success('User Created sucessfully');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
     
         $user = User::find($id)->delete();
        //  $user->delete();

          sweetalert()->success('User Delete Successfully.');

         return redirect()->back();





    }

    public function logout(Request $request){
      Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');

    }
}

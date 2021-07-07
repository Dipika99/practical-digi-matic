<?php
namespace App\Http\Controllers;

use App\Role;
use Auth;
use Storage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;

class UserController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth');
       $this->middleware('is_admin',['except'=>['index','edit','update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dump('another update in develop');
        $users = User::with('roles')->get();
        return  view('user.index',compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $admin_role = Role::where('slug','admin')->first();

        return  view('user.create',compact('roles','admin_role'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $path = NULL;
        
        $data = $request->all();
        $roles = $request->roles;
        unset($data['roles']);
        $admin_role = Role::where('slug','admin')->first();

        if ($request->file('avatar') && in_array($admin_role->id, $roles)) {
            $path = $request->file('avatar')->store('avatars');
        }

        $data['avatar'] = $path;
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        $user->roles()->sync($roles);

        if($user){
            return redirect()->back()->with('success', 'User created successfully.');

        }
        return back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->checkAdmin($user);
        $roles = Role::all();
        $admin_role = Role::where('slug','admin')->first();
        return view('user.edit',compact('user','roles','admin_role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserStoreRequest $request, User $user)
    {

        $path = $user->avatar;
        $data = $request->all();

        if (empty($request->password)) {
            unset($data['password']);
        }else{
            $data['password'] = Hash::make($data['password']);

        }

        $roles = $request->roles;
        unset($data['roles']);


        $admin_role = Role::where('slug','admin')->first();

        if ($request->file('avatar') && in_array($admin_role->id, $roles)) {
            $path = $request->file('avatar')->store('avatars');
        }

        $old_path = $user->avatar;

        $data['avatar'] = $path;

        if($user->update($data)){
            
            if(!empty($path) && !empty($old_path) && $path!=$old_path){
                Storage::delete($old_path);
            }

            $user->roles()->sync($roles);
            
            return redirect()->back()->with('success', 'User updated successfully.');

        }
        return back()->withInput();    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {   

        if($user){
            if($user->avatar!='avatar/default.png'){
                Storage::delete($user->avatar);
            }
            $user->delete();
            return redirect()->back()->with('success', 'User deleted successfully.');
        }

        return redirect()->back()->with('success', 'User can not be deleted.');
    }

    public function checkAdmin($user){
        if(!Auth::user()->isRole('admin')){
            if($user->id!=Auth::user()->id){
                abort(403);
            }
        }
    }
}

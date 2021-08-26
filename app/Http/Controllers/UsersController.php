<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Users;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

use DataTables;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }



    public function index(Request $request)
    {                  
        
         $roles = Role::All();    
         $repetidoras = DB::table('users')
            ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
            ->leftjoin('roles', 'roles.id', '=','role_user.id') 
            ->select('users.name', 'users.email','users.password', 'roles.description', 'role_user.role_id','role_user.user_id')
            ->get();

        if ($request->ajax()) {
                       // $data = User::latest()->get();
          
            return Datatables::of($repetidoras)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->user_id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fa fa-paint-brush"></i></a>';
                              $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->user_id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem"><i class="fa fa-window-close" aria-hidden="true"></i></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        
        $request->user()->authorizeRoles(['admin']);

        return view('users.users',compact('roles'));  
        //return dd( $repetidoras);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->actions == 1){
            $register=new User($request->all());
            $register->save();
            $register->roles()->attach($request->level);
            return  $register;

        }else{
            
            $item =  DB::table('users')
            ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
            ->leftjoin('roles', 'roles.id', '=','role_user.id') 
            ->where('role_user.user_id','=', $request->Item_id)   
            ->select('users.name', 'users.email','users.password', 'roles.description', 'role_user.role_id','role_user.user_id')
            ->get();    

           $register= User::find($request->Item_id);
           $register->name = $request->name;
           $register->email = $request->email;           
           $password = $request->password;
                    if ($password == $item[0]->password) {
                        $register->password = $password;
                    }else{
                        $register->password =  Hash::make($password);                  
                    }
            $register->save();
            $register->roles()->sync($request->level);   

          return  $register;

        }
           
         
               
        
    }




    


    

     
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = User::find($id);
        $repetidoras = DB::table('users')
        ->leftjoin('role_user', 'role_user.user_id', '=', 'users.id')
        ->leftjoin('roles', 'roles.id', '=','role_user.id') 
        ->where('role_user.user_id','=', $id)   
        ->select('users.name', 'users.email','users.password', 'roles.description', 'role_user.role_id','role_user.user_id')
        ->get();    
        
       return response()->json($repetidoras);
      //  return dd($repetidoras);

    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
     
       return response()->json(['success'=>'Item deleted successfully.']);
    }


    


}

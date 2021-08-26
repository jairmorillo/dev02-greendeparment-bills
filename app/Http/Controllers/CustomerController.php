<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Customer;

use DataTables;
class CustomerController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::latest()->get();
            return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action', function($row){
                                //http://bill.greendepartment.org/bill/billcustomer/
                                $btn = '<a href="http://localhost:8000/bill/billcustomer/'.$row->id.'" target="_blank" data-toggle="tooltip"  data-id="'.$row->id.'" class="btn btn-danger btn-sm" ><i class="fa fa-eye" aria-hidden="true"></i></a> <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fa fa-paint-brush" ></i></a>';
                                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem"><i class="fa fa-window-close" aria-hidden="true"></i>    </a>';
                                return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
             }        
        $request->user()->authorizeRoles(['admin']);
        return view('customer.customer');
       // return $data;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $item =  Customer::updateOrCreate(['id' => $request->Item_id],
        ['cust_name' => $request->cust_name, 
        'cust_adress' => $request->cust_adress,
        'cust_phone' => $request->cust_phone,
        'cust_email' => $request->cust_email,
        'cust_type_property' => $request->cust_type_property]);        
        
        return  response()->json($item);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $data = Customer::latest()->get();
        return response()->json($data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $item = Customer::find($id);
        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Customer::find($id)->delete();     
       return response()->json(['success'=>'Item deleted successfully.']);
    }




    public function search(Request $request)
    {
        
     $search = $request->search;

        if($search == ''){
           $customer = Customer::orderby('cust_name','asc')->limit(10)->get();
        }else{
           $customer = Customer::orderby('cust_name','asc')->where('cust_name', 'like', '%' .$search . '%')->limit(10)->get();
        }
    return response()->json($customer);


    }



}

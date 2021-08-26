<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\Purchase_request;
use App\Request_item;
use App\Item_request;


use DataTables;



class Purchase_requestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if ($request->ajax()) {
            $data = Purchase_request::latest()->get();
       return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        if($row->request_status=='PAID' OR $row->request_status=='ANULATED' OR $row->request_status=='PENDING'){ 
                            $btn = '<a href="http://localhost:8000/pdf/request/'.$row->id.'" target="_blank" data-toggle="tooltip"  data-id="'.$row->id.'" class="btn btn-danger btn-sm" ><i class="fa fa-print" aria-hidden="true"></i></a><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="status" class="status btn btn-primary btn-sm statusItem"><i class="fa fa-paint-brush" ></i></a>';
                         }else{
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fas fa-pen"></i></a>';
                            $btn = $btn .'<a href="http://localhost:8000/pdf/request/'.$row->id.'" target="_blank" data-toggle="tooltip"  data-id="'.$row->id.'" class="btn btn-danger btn-sm" ><i class="fa fa-print" aria-hidden="true"></i></a><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="status" class="status btn btn-primary btn-sm statusItem"><i class="fa fa-paint-brush" ></i></a>';
                         }
                       
                           return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
             }        
             $usu = auth();
             $request->user()->authorizeRoles(['admin']);
             return view('request.purchase')->with('usu', $usu );
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
        //

        $usu = auth()->id();
       
        if($_POST["request_number"]==""){
            $numerbill = Purchase_request::latest('id')->first();
            if($numerbill==null){$bill ='GD001';}else{$bill ='GD00'.$numerbill->id; } 
        }else{
            $bill = $_POST["request_number"];
        }        
     
           $bills = Purchase_request::updateOrCreate(
           ['id' =>$request->Item_idbill ],
           [
            'employer_id' =>$request->employer_id, 
            'employer_name' =>$request->employer_name, 
            'employer_adress' =>$request->employer_adress,
            'employer_phone' =>$request->employer_phone,
            'employer_email' =>$request->employer_email,
            'email_employer' =>$request->email_employer,
            'name_employer' =>$request->name_employer,
            'position_employer'=>$request->position_employer,
            'phone_employer' =>$request->phone_employer,
            'request_user_id' =>16,
            'request_type' =>$request->request_type,
            'request_status' =>$request->request_status ,
            'request_number' =>$bill,
            'request_total' =>$request->request_total ,
            'request_subtotal' =>$request->request_subtotal,
            'request_tax' =>$request->request_tax,
            'request_taxes_num' =>$request->request_taxes_num 
            ]
        );            
         //   dd($bills);

            $id = $bills->id;    
           

            foreach (array_keys($_POST['request_name']) as $key) {  
                Request_item::updateOrCreate(
                    ['id' => $_POST['id_tb'][$key]],    
                     ['request_id' => $id, 
                     'request_items_id' => $_POST['request_items_id'][$key],
                     'request_qty' => $_POST['request_qty'][$key],
                     'request_name' => $_POST['request_name'][$key],
                     'request_description' =>$_POST['request_description'][$key],
                     'request_price' =>$_POST['request_price'][$key],
                     'request_total_prices' =>$_POST['request_total_prices'][$key]                    
                ]);  
              }
            
        return $bills ;
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
    public function edit($id)
    {
        $item = Purchase_request::find($id);
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
        Purchase_request::find($id)->delete();     
         return response()->json(['success'=>'Item deleted successfully.']);
    }


    public function status(Request $request){  

            $item = Purchase_request::find($request->Item_idt)->update(['request_status' => $_POST['request_status']]);
            return $item ;


    }

    public function delet(Request $request){

        // BillServices::delete($request->id);
        $d = DB::table('request_item')->delete($request->id);
        return response()->json($request->id);
        
    }
}

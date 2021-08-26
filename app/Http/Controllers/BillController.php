<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaidInvoice;
use App\Mail\PartiallPaidInvoice;
use App\Mail\PendingPaidInvoice;

use App\User;
use App\Role;
use App\Services;
use App\Bill; 
use App\BillServices;
use App\Customer;
use App\Bill_transaccion;  
use App\Bills_part_paid;
use DataTables;

class BillController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

       $data = Bill::find(117); 
        
      if ($request->ajax()) {
          
       $data = Bill::latest()->get();
       return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        if($row->bill_type=='PAID' OR $row->bill_type=='ANULATED'  ){ 
                            $btn = '<a href="https://bill.greendepartment.org/pdf/invoice/'.$row->id.'" target="_blank" data-toggle="tooltip"  data-id="'.$row->id.'" class="btn btn-danger btn-sm" ><i class="fa fa-print" aria-hidden="true"></i></a><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="status" class="status btn btn-primary btn-sm statusItem"><i class="fa fa-paint-brush" ></i></a>';
                           // $btn = '<a href="http://localhost:8000/pdf/invoice/'.$row->id.'" target="_blank" data-toggle="tooltip"  data-id="'.$row->id.'" class="btn btn-danger btn-sm" ><i class="fa fa-print" aria-hidden="true"></i></a><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="status" class="status btn btn-primary btn-sm statusItem"><i class="fa fa-paint-brush" ></i></a>';

                        }else{
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fas fa-pen"></i></a>';
                            $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Paid" class="edit btn btn-primary btn-sm editpay"><i class="fas fa-money-check"></i></a>';
                            $btn = $btn .'<a href="https://bill.greendepartment.org/pdf/invoice/'.$row->id.'" target="_blank" data-toggle="tooltip"  data-id="'.$row->id.'" class="btn btn-danger btn-sm" ><i class="fa fa-print" aria-hidden="true"></i></a><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="status" class="status btn btn-primary btn-sm statusItem"><i class="fa fa-paint-brush" ></i></a><a href="javascript:void(0)" style=" background: #11386a !important; color: #fff !important; " data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="notinfication" class="notinfication btn btn-primary btn-sm notinficationItem"><i class="fas fa-envelope"></i></a>';
                           // $btn = $btn .'<a href="http://localhost:8000/pdf/invoice/'.$row->id.'" target="_blank" data-toggle="tooltip"  data-id="'.$row->id.'" class="btn btn-danger btn-sm" ><i class="fa fa-print" aria-hidden="true"></i></a><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="status" class="status btn btn-primary btn-sm statusItem"><i class="fa fa-paint-brush" ></i></a><a href="javascript:void(0)" style=" background: #11386a !important; color: #fff !important; " data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="notinfication" class="notinfication btn btn-primary btn-sm notinficationItem"><i class="fas fa-envelope"></i></a>';

                        }                       
                     return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
             }        
             $request->user()->authorizeRoles(['admin']);
             return view('bill.bill')->with('bill');
       // return $data; telnet greendepartment.org  465  #O[iDKynP~uo.rokmtF~OrN=0.rokmtF~OrN=0.
    }


    public function create()
    {
        $bill  = Bill::latest()->get();
        return view('bill.create')->with('bill', $bill);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

            $usu = auth()->id();
            $date =  date('Y-m-d H:i:s');

            if($_POST["bill_number"]==""){
                $numerbill = Bill::latest('id')->first();
                if($numerbill==null){$bill ='GD0001';}else{$bill ='GD00'.$numerbill->id; } 
            }else{
                $bill = $_POST["bill_number"];
              }        
            $customer = Customer::updateOrCreate(
                ['id' => $_POST["customer_id"]],
                 ['cust_name' => $_POST["customer_name"], 
                 'cust_adress' => $_POST["customer_adress"],
                 'cust_phone' =>$_POST["customer_phone"],
                 'cust_email' => $_POST["customer_email"],
                 'cust_type_property' => $_POST["customer_type_property"]               
                 ]);  

                 $customer_id = $customer->id;

                 if($_POST['bill_type']==='PAID'){

                    if( $_POST["partial_payment_restg"] === '0,00'){
                        $paid = $_POST["bill_totalg"];
                        $outstanding = '0,00';
                      }else{
                        $paid = $_POST["partial_payment_restg"];
                        $outstanding = '0,00';
                      }  

                    $bills_part   = Bills_part_paid::updateOrCreate(
                        ['id' =>''],
                        [
                            'bill_id_p' =>$_POST["Item_idbill"],
                            'bill_number_p' => $bill,
                            'bill_total_p' => $_POST["bill_totalg"],
                            'bill_subtotal_p' => $_POST["bill_subtotalg"], 
                            'bill_type_p' => $_POST["bill_type"],               
                            'partial_payment_percents' =>'0,00',
                            'partial_payment_cash' => '0,00',                
                            'partial_payment_mont' =>  $paid,
                            'partial_payment_rest' => $outstanding ,
                            'partial_payment_date' =>$date,
                              
                         ]); 
                 }
                 if($_POST['bill_type']==='ANULATED'){

                    Bills_part_paid::find($id)->delete();     
                    return response()->json(['success'=>'Item deleted successfully.']);

                    $paid = $_POST["partial_payment_montg"];
                    $outstanding = $_POST["partial_payment_restg"];

                 }
                 
                 else{

                    $paid = $_POST["partial_payment_montg"];
                    $outstanding = $_POST["partial_payment_restg"];
                 }


           $bills = Bill::updateOrCreate(
               ['id' =>$_POST["Item_idbill"]],
               ['customer_id' =>$customer_id, 
                'customer_name' => $_POST["customer_name"], 
                'customer_adress' => $_POST["customer_adress"],
                'customer_phone' =>$_POST["customer_phone"],
                'customer_email' => $_POST["customer_email"],
                'customer_type_property' => $_POST["customer_type_property"],
                'bill_number' =>$bill,
                'bill_description' =>$_POST["bill_description"],
                'bill_total' => $_POST["bill_totalg"],
                'bill_subtotal' => $_POST["bill_subtotalg"],                
                'bill_iva' => $_POST["bill_ivag"],
                'bill_discount' => $_POST["bill_discountg"],
                'partial_payment_percents' => '0,00',
                'partial_payment_cash' => '0,00',                
                'partial_payment_mont' =>  $paid, 
                'partial_payment_rest' => $outstanding ,
                'bill_user_id' =>$usu,
                'bill_date' =>$date,
                'bill_type' => $_POST["bill_type"],
                'tasa' =>  $_POST["tasa"],
                'discount' =>  $_POST["discount"],
                'discount_cash' =>  $_POST["discount_cash"],
                
                ]);            

                $id = $bills->id;                  



                foreach (array_keys($_POST['serv_name']) as $key) {  
                    BillServices::updateOrCreate(
                        ['id' => $_POST['id_tb'][$key]],    
                         ['bill_id' => $id, 
                         'services_id' => $_POST['serv_id'][$key],
                         'serv_qty' => $_POST['serv_qty'][$key],
                         'serv_name' =>htmlspecialchars( $_POST['serv_name'][$key]),
                         'serv_description' =>htmlspecialchars($_POST['serv_description'][$key]),
                         'serv_unit' =>$_POST['serv_unit'][$key],
                         'serv_price' =>$_POST['serv_price'][$key],
                         'serv_total_prices' =>$_POST['serv_total_prices'][$key]                    
                    ]);  
                  }

                                
              
  
      return $bills ;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Bill::find($id);
        return response()->json($item);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Bill::find($id)->delete();     
         return response()->json(['success'=>'Item deleted successfully.']);
    }


    public function billcustomer(Request $request,$id)
    {
        $bill = Bill::orderby('bill_number','asc')->where('customer_id', '=', $id)->get();
        if ($request->ajax()) {
            $data =  Bill::orderby('bill_number','asc')->where('customer_id', '=', $id)->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        if($row->bill_type=='PAID' OR $row->bill_type=='ANULATED' OR $row->bill_type=='PENDING'){ 
                            $btn = '<a href="https://bill.greendepartment.org/pdf/invoice/'.$row->id.'" target="_blank" data-toggle="tooltip"  data-id="'.$row->id.'" class="btn btn-danger btn-sm" ><i class="fa fa-print" aria-hidden="true"></i></a><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="status" class="status btn btn-primary btn-sm statusItem"><i class="fa fa-paint-brush" ></i></a>';
                         }else{
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fas fa-pen"></i></a>';
                            $btn = $btn .'<a href="https://bill.greendepartment.org/pdf/invoice/'.$row->id.'" target="_blank" data-toggle="tooltip"  data-id="'.$row->id.'" class="btn btn-danger btn-sm" ><i class="fa fa-print" aria-hidden="true"></i></a> <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="status" class="status btn btn-primary btn-sm statusItem"><i class="fa fa-paint-brush" ></i></a>  <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="notinfication" class="notinfication btn btn-primary btn-sm notinficationItem"><i class="fas fa-envelope"></i></a>';
                         }
                       
                           return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
             }        
        ///$request->user()->authorizeRoles(['admin']);
        return view('bill.billcustomer')->with('id', $id)->with('bill', $bill);
    }


    public function status(Request $request){  
       
           $date =  date('Y-m-d H:i:s');

            if($_POST['bill_type']==='PAID'){

                  if( $_POST["partial_payment_restp"] === '0,00'){
                    $paid = $_POST["bill_totalp"];
                    $recibido = $_POST["bill_totalp"];

                  }else{
                    $paid = $_POST["partial_payment_restp"];
                    $recibido = $_POST["partial_payment_restp"];
                  }  
                  
                $bills_part   = Bills_part_paid::updateOrCreate(
                    ['id' =>''],
                    [
                        'bill_id_p' =>$_POST["Item_idt"],
                        'bill_number_p' => $_POST["bill_number_p"],
                        'bill_total_p' => $_POST["bill_totalp"],
                        'bill_subtotal_p' => $_POST["bill_subtotalp"], 
                        'bill_type_p' => $_POST["bill_type"],               
                        'partial_payment_percents' =>'0,00' ,
                        'partial_payment_cash' => $recibido,                
                        'partial_payment_mont' => $paid,
                        'partial_payment_rest' => '0,00',
                        'partial_payment_date' =>$date,
                          
                     ]); 
                
                     $items = Bill::updateOrCreate(
                        ['id' =>$_POST["Item_idt"]],
                        [             
                         'bill_number' =>$_POST['bill_number_p'],                              
                         'partial_payment_percents' =>'0,00',
                         'partial_payment_cash' => $recibido,                
                         'partial_payment_mont' => $paid,
                         'partial_payment_rest' => '0,00',
                         'bill_type' => $_POST["bill_type"]
                         ]);       


                         $data = Bill::find($request->Item_idt);  
                         $mailable = new PaidInvoice($data);
                         $sentd  =  Mail::to($data->customer_email)->send($mailable);


            }
            if($_POST['bill_type']==='ANULATED'){
                //$items = Bills_part_paid::find($_POST["Item_idt"])->delete();     
               // return response()->json(['success'=>'Item deleted successfully.']);
               $d = DB::table('bills_part_paid')->where('bill_id_p', $request->Item_idt)->delete(); 
               $item = Bill::find($request->Item_idt)->update(['bill_type' => $_POST['bill_type']]);
               $items = Bill::find($request->Item_idt)->update(['bill_date' => $date]);              
             }
             if($_POST['bill_type']==='PENDING'){

                $item = Bill::find($request->Item_idt)->update(['bill_type' => $_POST['bill_type']]);
                $items = Bill::find($request->Item_idt)->update(['bill_date' => $date]);

                $data = Bill::find($request->Item_idt);  
                $mailable = new PendingPaidInvoice($data);
                $sentd  =  Mail::to($data->customer_email)->send($mailable);

             }                        
            else {
                $item = Bill::find($request->Item_idt)->update(['bill_type' => $_POST['bill_type']]);
                $items = Bill::find($request->Item_idt)->update(['bill_date' => $date]);
            }                

           return $items ;


    }

    public function delet(Request $request){
       // BillServices::delete($request->id);
        $d = DB::table('bill_services')->delete($request->id);
        return response()->json($request->id);        
    }

    public function partial_payment_delet(Request $request){
        // BillServices::delete($request->id);
         $d = DB::table('bills_part_paid')->delete($request->id);
         return response()->json($request->id);        
     }
 

    public function  partial_payment_store(Request $request){
        $date =  date('Y-m-d H:i:s');

        $bills_histori = Bills_part_paid::updateOrCreate(
            ['id' =>''],
            [
             'bill_id_p' =>$_POST['Item_idpc'],
             'bill_number_p' => $_POST["bill_number_c"],
             'bill_total_p' => $_POST["bill_totalc"],
             'bill_subtotal_p' => $_POST["bill_subtotalc"], 
             'bill_type_p' => $_POST["bill_typec"],               
             'partial_payment_percents' => $_POST["partial_payment_percents"],
             'partial_payment_cash' => $_POST["partial_payment_cash"],                
             'partial_payment_mont' => $_POST["partial_payment_montc"],
             'partial_payment_rest' => $_POST["partial_payment_restc"],
             'partial_payment_date' =>$date,
                  
             ]);  
             $items = Bill::updateOrCreate(
                ['id' =>$_POST["Item_idpc"]],
                [             
                 'bill_number' =>$_POST['bill_number_c'],                              
                 'partial_payment_percents' => $_POST["partial_payment_percents"],
                 'partial_payment_cash' => $_POST["partial_payment_cash"],                
                 'partial_payment_mont' => $_POST["partial_payment_montc"],
                 'partial_payment_rest' => $_POST["partial_payment_restc"],
                 'bill_type' => $_POST["bill_typec"]
                 ]);           

                 if($_POST['bill_typec']==='PAID'){                                          
                    $data = Bill::find($_POST["Item_idpc"]);  
                    $mailable = new PaidInvoice($data);
                    $sentd  =  Mail::to($data->customer_email)->send($mailable);
                 }else{
                    $data = Bill::find($_POST["Item_idpc"]);  
                    $mailable = new PartiallPaidInvoice($data);
                    $sentd  =  Mail::to($data->customer_email)->send($mailable);
                 }

            


                 return $bills_histori;
    }

    public function  partial_payment_list($id){
        $item = Bills_part_paid::orderby('bill_id_p','asc')->where('bill_id_p', '=', $id)->get();
        return response()->json($item);        
    }

    public function  notification_payment_pending($id){
        $data = Bill::find($id);  
        $mailable = new PendingPaidInvoice($data);
        $sentd  =  Mail::to($data->customer_email)->send($mailable);
       // $sentd  =  Mail::to('jairantoniom@gmail.com')->send($mailable);
        return $sentd;
    }
   


}

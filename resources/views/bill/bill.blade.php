@extends('adminlte::page')
@section('title', 'INVOICES')
@section('content_header')
    <h1>INVOICES</h1>
@stop

@section('content')
  <style>
  .modal-dialog{
          max-width: 80%;
  }
    .modal-dialog.modal-lg  {
        max-width: 100%;
        margin: 0rem !important;
    }
    .modal-lg {
            max-width: 100%;
        }
        
        .modal-header {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: start;
            align-items: flex-start;
            -ms-flex-pack: justify;
            justify-content: space-between;
            padding: 0.2rem 0.6rem !important;
            border-bottom: 1px solid #e9ecef;
            border-top-left-radius: .3rem;
            border-top-right-radius: .3rem;
        }
        .ui-widget.ui-widget-content {
            border: 1px solid #c5c5c5;
            position: absolute !important;
            top: 249px !important;
            left: 17px;
            z-index: 99999999999999999999!important;
            width: 424px;
        }
        #ui-id-2.ui-widget.ui-widget-content {
            border: px solid #c5c5c5;
            position: absolute !important;
            top: 208px !important;
            left: 17px;
            z-index: 99999999999999999999!important;
            width: 424px;
        }
        fieldset { border:none; width:100%;}
        legend { font-size:2em; margin:0px; padding:10px 0px; color:#00c819; font-weight:bold;}
        .prev, .next { background-color:#00c819 ; padding:5px 10px; color:#fff; text-decoration:none;}
        .prev:hover, .next:hover { background-color:#00c819 ; text-decoration:none;}
        .prev { float:left;}
        .next { float:right;}
        #steps { list-style:none; width:100%; overflow:hidden; margin:0px; padding:0px;}
        #steps li {font-size:24px; float:left; padding:10px; color:#000;}
        #steps li span {font-size:11px; display:block;}
        #steps li.current { color:#00c819;}
        .select2-container {
                box-sizing: border-box;
                display: inline-block;
                margin: 0;
                position: relative;
                vertical-align: middle;
                width: 100% !important;
            }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 18px !important;
    }
    .searchtxt{
        float:left;
    }
    .btn-sm {
    padding: .25rem .5rem;
    font-size: .875rem;
    line-height: 1.5;
    border-radius: .2rem;
    margin-left: 5px !important;
}
.form-group.two {
    margin-right: 10px;
    width: 46%;
    float: left;
}
  </style>
<div class="row">
     <div class="col-md-12">
       <div class="card mt-5">
         <div class="card-header">
            <div class="col-md-12">
                <h4 class="card-title"> 
                  <a class="btn btn-success ml-5" href="javascript:void(0)" id="createNewItem"> Create New Invoice</a>
                </h4>

            </div>
         </div>
         <div class="card-body">
           <table class="table table-bordered data-table"  width="100%">
                <thead>
                    <tr>
                        <th width="3%">No</th>
                        <th width="5%">Number</th>
                        <th  width="10%" >Customer</th>
                        <th  width="20%" >Description</th>
                        <th  width="10%">Sub Total</th>
                        <th  width="10%">Total</th>
                        <th width="5%">Status</th>
                        <th width="18%">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="modal fade bd-example-modal-lg" id="ajaxModel" aria-hidden="true">
            <div  id="modaltxt" class="modal-dialog modal-lg" style="height: 100vh;"  >
                <div id="modaltxt2" class="modal-content" style="height:100vh;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
               </div>
                    <div class="modal-body">
                        <form id="ItemForm" name="ItemForm" class="form-horizontal">
                                <input type="hidden" name="Item_idbill" id="Item_idbill">
                                <input type="hidden" name="bill_number" id="bill_number">
                                <input type="hidden" name="customer_id" id="customer_id">
      <div >
              <div >
      <fieldset>
      <legend>Customer Info</legend>
                    <!-- BEGIN ROW -->   
                         <div class="row">
                                <div class="col-sm-4">
                                        <div class="form-group ui-widget">
                                            <label for="customer_name" class="control-label">Customer Name</label>
                                                <input type="text" class="form-control" id="customer_name" name="customer_name"   >
                                        </div>
                                </div>
                                    <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">Phone </label>
                                                <input type="text" class="form-control" id="customer_phone" name="customer_phone" placeholder="Enter Phone" value="" maxlength="50" required="">
                                            </div>
                                    </div>
                                    <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="name" class="control-label">Email</label>
                                                <input type="email" class="form-control" id="customer_email" name="customer_email"  placeholder="Enter Email" value="" maxlength="50" required="">
                                            </div>
                                    </div>
                                    <div class="col-sm-6">
                                                <div class="form-group">
                                                <label for="name" class="control-label">Type Property</label>
                                                    <input type="text" class="form-control" id="customer_type_property" name="customer_type_property" placeholder="Enter Type" value="" maxlength="50" required="" style="height: 60px;">
                                                </div>
                                    </div>
                                    <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="name" class="control-label">Address</label>
                                                <textarea  class="form-control" name="customer_adress" id="customer_adress"> 
                                                </textarea>
                                            </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name" class=" control-label">Description</label>
                                                <input type="text" class="form-control" id="bill_description" name="bill_description" placeholder="Enter Description" value="" maxlength="50" required="">
                                        </div>
                                </div>
                                        <input type="hidden" id="actions" name="actions" value="1">
                   </div>
                <!-- END ROW  . bill_type  -->
                </fieldset>
                <fieldset>
                <!-- BEGIN ROW -->  
                <legend>Invoice Creation</legend>
                            <div class="row" style="margin-top: 20px;">                           
                                       <div class="col-sm-1">
                                                <div class="form-group">
                                                    <label for="name" class="control-label">Items</label>
                                                </div>                                                                         
                                        </div>
                                        <div class="col-sm-1">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-primary additems" id="additems" value="add">Add Item</button>
                                                </div>                                                                         
                                        </div>
                                        <div class="col-sm-2">
                                                <div class="form-group">
                                                <button type="button" class="btn btn-primary" id="createNewserv" value="create">Create Item</button>
                                                </div>                                                                         
                                        </div>
                                        <div class="col-sm-1">
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Taxes(%)</label>
                                                    <select id="tasa" name="tasa" class="form-control"> </select>
                                                </div>
                                        </div>
                                        <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Discount(%)</label>
                                                    <input type="text" class="form-control" id="discount" name="discount" autocomplete="off" placeholder="" value="0,00" maxlength="50" required="">

                                                </div>
                                        </div>
                                        <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Discount($)</label>
                                                    <input type="text" class="form-control" id="discount_cash" name="discount_cash" autocomplete="off" placeholder="" value="0,00" maxlength="50" required="">

                                                </div>
                                        </div>
                                  <!--      <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Partial Payment ($)</label>                                                 
                                                    <input type="text" class="form-control" id="partial_payment_cash" name="partial_payment_cash" placeholder="" value="0,00" maxlength="50" required="">

                                                </div>
                                        </div>
                                        <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Partial Payment (%)</label>                                                 
                                                    <input type="text" class="form-control" id="partial_payment_percents" name="partial_payment_percents" placeholder="" value="0,00" maxlength="50" required="">

                                                </div>
                                        </div> -->
                                          <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Status</label>
                                                    <input type="text" class="form-control"  id="bill_type" name="bill_type" value="OPEN"   readonly>

                                                     
                                                </div>
                                            </div>


                                        <div class="col-sm-12" style="margin-bottom: 10px;">
                                                <table width="100%" style=" width:100%; text-aling:center; ">
                                                <tr style=" width:100%; text-aling:center; ">
                                                        <th style="text-align: center;border-bottom: 1px solid #ccc; width:5%;">Id</th>
                                                        <th style="text-align: center;border-bottom: 1px solid #ccc; width:15%;">Tag/label</th>
                                                        <th style="text-align: center;border-bottom: 1px solid #ccc; width:20%;">Descriptions</th>
                                                        <th style="text-align: center;border-bottom: 1px solid #ccc;width:10%;">Qy</th>
                                                        <th style="text-align: center;border-bottom: 1px solid #ccc;width: 11%;">Unit</th>
                                                        <th style="text-align: center;border-bottom: 1px solid #ccc;width: 7%;">Prices</th>
                                                        <th style="text-align: right;border-bottom: 1px solid #ccc;width: 7%;">Total </th> 
                                                        <th style="text-align: right;border-bottom: 1px solid #ccc;width: 8%;">Action</th>   
                                                        </tr>
                                                </table>                                                                                                           
                                        </div>
                                        <div class="col-sm-12">
                                            <div id="itemx" class="row overflow-auto"  style="overflow-y:auto !important;min-height: 25vh;max-height: 50vh;" >
                                                
                                            </div>                                                                       
                                        </div>                                    
                                        <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Sub-Total</label>
                                                
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                         <input type="text" class="form-control"  id="bill_subtotalg" name="bill_subtotalg" value="0,00" required="" aria-label="Amount (to the nearest dollar)" readonly>
                                                    </div>                                                
                                                </div>
                                        </div>
                                        <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Tax</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                         <input type="text" class="form-control"  id="bill_ivag" name="bill_ivag" value="0,00" required="" aria-label="Amount (to the nearest dollar)" readonly>
                                                    </div>   
                                                </div>
                                        </div>
                                        <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Total Discount</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                         <input type="text" class="form-control"  id="bill_discountg" name="bill_discountg" value="0,00" required="" aria-label="Amount (to the nearest dollar)" readonly>
                                                    </div>   
                                                </div>
                                        </div>
                                        <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Total</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                         <input type="text" class="form-control"  id="bill_totalg" name="bill_totalg" value="0,00" required="" aria-label="Amount (to the nearest dollar)" readonly>
                                                    </div>  
                                                </div>
                                        </div>
                                        <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Partially paid</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                         <input type="text" class="form-control"  id="partial_payment_montg" name="partial_payment_montg" value="0,00" required="" aria-label="Amount (to the nearest dollar)" readonly>
                                                    </div>  
                                                </div>
                                        </div>
                                        <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Outstanding balance</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                         <input type="text" class="form-control"  id="partial_payment_restg" name="partial_payment_restg" value="0,00" required="" aria-label="Amount (to the nearest dollar)" readonly>
                                                    </div>  
                                                </div>
                                        </div>
                                </div>  
                       <!-- END ROW  . bill_type  -->

                       </fieldset>
            
                            </div>
                        </div>
                                      
                        <div class="row">
                            <div id="next" class="col-sm-8">
                            </div>
                            <div id="prev" class="col-sm-2"> 
                            <input type="button" class="btn btn-danger" id="preview" value="Preview" style="display: inline-block; width: 100%;">                            
                             </div>
                            <div class="col-sm-2"> 
                               <input type="submit" class="btn btn-primary" id="saveBtn" value="Create" style="display: inline-block; width: 100%;">                          
                            </div>
                        </form>
                    </div>
                </div>
            </div>
         </div>


   <!-- Modal create Services  -->

   <div class="modal fade" id="ajaxModel2" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelHeading2"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="ItemForm2" name="ItemForm2" class="form-horizontal">
                           <input type="hidden" name="Item_id" id="Item_id">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Tag/label </label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value=""  required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Descriptions or Name </label>
                                <div class="col-sm-12">
                                    <textarea id="description" name="description" required="" placeholder="Enter descriptions" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Unit</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="unit" name="unit"  value="" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Prices</label>
                                
                                <div class="col-sm-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                  <input type="text" class="form-control"  id="prices" name="prices" aria-label="Amount (to the nearest dollar)">
                                </div>                                </div>


                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Quantity</label>
                                <div class="col-sm-12">
                                <input type="text" min="1" max="100" class="form-control" id="quantityx" name="quantityx"  value=""  required="">

                                </div>
                            </div>
                         
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Total</label>
                                <div class="col-sm-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                  <input type="text" class="form-control"  id="total" name="total" aria-label="Amount (to the nearest dollar)" disabled>
                                </div>
                                </div>
                            </div>
                            <div class="col-sm-offset-2 col-sm-10">
                             <button type="submit" class="btn btn-primary" id="creatBtn" value="create">Save changes
                             </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
         </div>


            <!-- Modal add Services  -->

<div class="modal fade" id="ajaxModel3" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelHeading3"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="ItemForm3" name="ItemForm" class="form-horizontal">
                           <input type="hidden" name="Item_id" id="Item_id">
                        

                            <div class="form-group">
                                <div class="col-sm-12">
                                <input type="hidden" class="form-control" id="serv_id" name="serv_id"  value="" maxlength="50" required="" >


                                    <label for="name" class=" control-label">Descriptions</label>
                                   
                                    <select  id="serv_description" name="serv_description" class=" form-control js-example-basic-single js-states" >
        
                                    </select>

                                               
                                </div>
                            </div>

                            <div class="form-group">
                           <label for="name" class="col-sm-2 control-label">Tag/label </label>

                                <div class="col-sm-12">
                                <input type="text" class="form-control" id="serv_name" name="serv_unit"  value="" required="">

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Unit</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="serv_unit" name="serv_unit"  value="" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Quantity</label>
                                <div class="col-sm-12">
                                    <input type="text" min="1" max="100" class="form-control" id="serv_qty" name="serv_qty"  value="" maxlength="50" required="">
                                </div>
                            </div>
                 
                            <div class="form-group">

                                <label for="name" class="col-sm-2 control-label">Prices</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                  <input type="text" class="form-control"  id="serv_price" name="serv_price" aria-label="Amount (to the nearest dollar)">
                                </div>

                            </div>

                            

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Total</label>

                                <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control"  id="serv_total_prices" name="serv_total_prices" aria-label="Amount (to the nearest dollar)" disabled>
                               
                                </div>

                                
                            </div>
                            <div class="col-sm-offset-2 col-sm-10">
                             <button type="submit" class="btn btn-primary" id="addBtn" value="Add">Save changes </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
         </div>
       </div>
     </div>
   </div>
 </div>


  <!-- Modal change Status  -->

 <div class="modal fade" id="ajaxModel4" aria-hidden="true">
            <div class="modal-dialog" style = "width:400px !important">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelHeading4"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="ItemForm4" name="ItemForm4" class="form-horizontal">
                           <input type="hidden" name="Item_idt" id="Item_idt">
                           <input type="hidden" name="bill_number_p" id="bill_number_p">
                           <input type="hidden" name="bill_totalp" id="bill_totalp">
                           <input type="hidden" name="bill_subtotalp" id="bill_subtotalp">
                           <input type="hidden" name="partial_payment_percentsp" id="partial_payment_percentsp">
                           <input type="hidden" name="partial_payment_cashp" id="partial_payment_cashp">
                           <input type="hidden" name="partial_payment_montp" id="partial_payment_montp">
                           <input type="hidden" name="partial_payment_restp" id="partial_payment_restp">

								     <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Status</label>
                                                        <select id="bill_type" name="bill_type" class="form-control">
                                                            <option value="DRAFT">DRAFT</option>
                                                            <option value="OPEN">OPEN</option> 
                                                            <option value="PENDING">PENDING</option> 
                                                            <option value="PAID">PAID</option>
                                                            <option value="ANULATED">ANULATED</option>    
                                                        </select>
                                                </div>
                                            </div>    
                                            
                             <div class="col-sm-offset-2 col-sm-10">
                             <button type="submit" class="btn btn-primary" id="savestatusBtn" value="Add">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
 </div>
        
   <!-- Modal Make Partial Pay LIST  -->

 <div class="modal fade" id="ajaxModel5" aria-hidden="true">
            <div class="modal-dialog" style = "width:900px !important">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelHeading5">Partial payment</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <form id="ItemForm7" name="ItemForm7" class="form-horizontal">
                           <input type="hidden" name="Item_idpp" id="Item_idpp">                           
                          <div class="row">
                                 <div class="col-sm-12">
                                      <button type="button" class="btn btn-primary" id="newpayBtn" value="Add">New Partial Pay</button>
                                </div>
                              </div>  
                           <div class="row">
                           <div  class="col-sm-8" >
                            <table width="100%" id="">
                                            <tr>
                                                <th width="3%">No</th>
                                                <th  width="10%" >Paid</th>
                                                <th  width="10%" >To pay</th>
                                                <th width="18%">Date</th>
                                                <th width="18%">Action</th>

                                            </tr>
                                        
                                    
                                </table>
                                    <table width="100%" id="tablita">
                                           
                                        
                                    
                                </table>
                            </div>

								     <div class="col-sm-4" style="border-left: 2px solid #ccc;">
                                     <h3>Invoice information </h3>
                                     <div class="form-group">
                                                    <label for="name" class=" control-label">Invoices Nro</label>
                                                      <span id="invoicesnro"></span>
                                                </div>  
                                                 <div class="form-group">
                                                    <label for="name" class=" control-label">Customer</label>
                                                    <span id="customer"> </span>

                                                </div>   
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Total</label>
                                                    <span id="totalp"></span>

                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Outstanding balance</label>
                                                    <span id="rest"> </span>

                                                </div>
                                         <!-- <div class="form-group">
                                                    <label for="name" class=" control-label">Status</label>
                                                        <select id="bill_type" name="bill_type" class="form-control">
                                                            <option value="DRAFT">DRAFT</option>
                                                            <option value="OPEN">OPEN</option> 
                                                            <option value="PAID">PAID</option> 
                                                            <option value="PARTIALLY-PAID">PARTIALLY PAID</option>    
   
                                                        </select>
                                                </div> -->
                                      </div>  
                                    </div> 
                              <div class="row">
                                         <!-- <div class="form-group">
                                 <div class="col-sm-offset-2 col-sm-10">
                                      <button type="submit" class="btn btn-primary" id="savestatusBtn" value="Add">Save changes</button>
                                </div> -->
                              </div>             
                             
                        </form>
                    </div>
                </div>
            </div>
 </div>



      
   <!-- Modal Make Partial Pay  -->

   <div class="modal fade" id="ajaxModel6" aria-hidden="true">
            <div class="modal-dialog" style = "width:450px !important">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelHeading6"> Register Partial payment</h4>
                    </div>
                    <div class="modal-body">
                        <form id="ItemForm6" name="ItemForm6" class="form-horizontal">
                           <input type="hidden" name="Item_idpc" id="Item_idpc">
                           <input type="hidden" name="bill_number_c" id="bill_number_c">                           
                           <input type="hidden" name="partial_payment_restcx" id="partial_payment_restcx"> 
                           <div class="row">                     

								     <div class="col-sm-12" style="border-left: 0px solid #ccc;">
                                     <div class="form-group">
                                                    <label for="name" class=" control-label">Sub total</label>
                                                    <input type="text" class="form-control"  id="bill_subtotalc" name="bill_subtotalc" aria-label="Amount (to the nearest dollar)" readonly value="0,00"   >

                                                </div>  
                                                 <div class="form-group">
                                                    <label for="name" class=" control-label">Total</label>
                                                    <input type="text" class="form-control"  id="bill_totalc" name="bill_totalc" aria-label="Amount (to the nearest dollar)" readonly value="0,00" >

                                                </div>  
                                                <div class="form-group two">
                                                    <label for="name" class=" control-label">Partial Paid %</label>
                                                    <input type="text" class="form-control"  id="partial_payment_percents" name="partial_payment_percents" aria-label="Amount (to the nearest dollar)" value="0,00" >
                                                </div> 
                                                <div class="form-group two">
                                                    <label for="name" class=" control-label">Partial Paid $</label>
                                                    <input type="text" class="form-control"  id="partial_payment_cash" name="partial_payment_cash" aria-label="Amount (to the nearest dollar)" value="0,00" >
                                                </div> 
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Paid</label>
                                                    <input type="text" class="form-control"  id="partial_payment_montc" name="partial_payment_montc" aria-label="Amount (to the nearest dollar)" value="0,00" readonly>

                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Outstanding balance</label>
                                                    <input type="text" class="form-control"  id="partial_payment_restc" name="partial_payment_restc" aria-label="Amount (to the nearest dollar)" value="0,00"  readonly>

                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Status</label>
                                                        <select id="bill_typec" name="bill_typec" class="form-control">
                                                             <option value="PARTIALLY-PAID">PARTIALLY PAID</option> 
                                                             <option value="PAID">PAID</option>    
                                                        </select>
                                                </div>
                                      </div>  
                                    </div> 
                              <div class="row">
                                 <div class="col-sm-offset-2 col-sm-10">
                                      <button type="submit" class="btn btn-primary" id="savespartiallyBtn" value="Add">Save changes</button>
                                </div>
                              </div>             
                             
                        </form>
                    </div>
                </div>
            </div>
 </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>     
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script> 
   $('.js-example-basic-single').select2().on("select2:select", function (e) {
       var selected_element = $(e.currentTarget);
       var select_val = selected_element.val();
       console.log(select_val);

       $.get("{{url('/')}}/services/"+ select_val +"/edit", function (data) {  //   console.log('data:', data);
                $('#serv_id').val(data.id);
                $('#serv_name').val(data.name);
                //$('#serv_description').val(data.description); 
                $('#serv_price').val(data.prices);
                $('#serv_unit').val(data.unit);
                $('#serv_qty').val('');
                $('#serv_total_prices').val('');
            });
        });



$(document).ready(function(){
    var height = $(window).height();
   $('#modaltxt').height(height + 250);
   $('#modaltxt2').height( height + 250);
});
</script>
</body>




@stop

@section('css')
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@stop
@section('js')


    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('js/md5/jquery.md5.min.js') }}"></script>
    <script src="{{ asset('js/jquery-mask-plugin-master/src/jquery.mask.js') }}"></script>
<script type="text/javascript">
    //$('#myTabs a').tab('show')
    //$('#myTabs a:first').tab('show'); // Select first tab
    //$('#profile-tab').tab('show');
    //$('#serv_description').trigger('change');
    //$('.selectpicker').selectpicker();





var steps = $("#ItemForm fieldset");
var count = $("#ItemForm fieldset").length;

 $('#prices').mask('000.000.000.000.000,00', {reverse: true,
  translation: {
            'S': {
                pattern: /-/,
                optional: true
            }
        }
 
 });
 $('#serv_price').mask('000.000.000.000.000,00', {reverse: true,
    translation: {
            'S': {
                pattern: /-/,
                optional: true
            }
        }
 
 });


 $('#discount').mask('000.000.000.000.000,00', {reverse: true,
  translation: {
            'S': {
                pattern: /-/,
                optional: true
            }
        }
 
 });

 $('#discount_cash').mask('000.000.000.000.000,00', {reverse: true,
  translation: {
            'S': {
                pattern: /-/,
                optional: true
            }
        }
 
 });

 $('#partial_payment_percents').mask('000.000.000.000.000,00', {reverse: true,
  translation: {
            'S': {
                pattern: /-/,
                optional: true
            }
        }
 
 });


 $('#partial_payment_cash').mask('000.000.000.000.000,00', {reverse: true,
  translation: {
            'S': {
                pattern: /-/,
                optional: true
            }
        }
 
 });


$("#ItemForm").before("<ul id='steps'></ul>");
$("#saveBtn").hide();
$("#preview").hide();

steps.each(function(i) {
            $(this).wrap("<div id='step" + i + "'></div>");            
            $(this).append("<p id='step" + i + "commands'></p>");

            // 2
            var name = $(this).find("legend").html();			
            $("#steps").append("<li id='stepDesc" + i + "'>Step " + (i + 1) + "<span>" + name + "</span></li>");
            if (i == 0) {
                createNextButton(i);
                selectStep(i);
            }
            else if (i == count - 1) {
                $("#step" + i).hide();
                createPrevButton(i);
            }
            else {
                $("#step" + i).hide();
                createPrevButton(i);
                createNextButton(i);
            }
        });

function createPrevButton(i) {
            var stepName = "step" + i;
            $("#" + stepName + "commands").append("<a href='#' id='" + stepName + "Prev' class='prev'>< Back</a>");
            $("#" + stepName + "Prev").bind("click", function(e) {
                $("#" + stepName).hide();
                $("#step" + (i - 1)).show();
                $("#saveBtn").hide();
                $("#preview").hide();
                selectStep(i - 1);
            });
        }

        function createNextButton(i) {
            var stepName = "step" + i;
            $("#" + stepName + "commands").append("<a href='#' id='" + stepName + "Next' class='next'>Next ></a>");
            $("#" + stepName + "Next").bind("click", function(e) {
                $("#" + stepName).hide();
                $("#step" + (i + 1)).show();
                if (i + 2 == count)
                    $("#saveBtn").show();
                    $("#preview").show();
                selectStep(i + 1);
            });
        }

        function selectStep(i) {
            $("#steps li").removeClass("current");
            $("#stepDesc" + i).addClass("current");
        }
 


  $(function () {     
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
         /* Table bill */

    var table = $('.data-table').DataTable({
        processing: false,
        serverSide: true,
        ajax: "{{ route('bill.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'bill_number', name: 'bill_number'},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'bill_description', name: 'bill_description'},             
            {data: 'bill_subtotal', name: 'bill_subtotal'},
            {data: 'bill_total', name: 'bill_total'},
            {data: 'bill_type', name: 'bill_type'}, 
            {data: 'action', name: 'action', 
            orderable: false,
            searchable: false},
        ],
        initComplete: function(){    
    // Have this variable accessible for the whole initComplete
    var column;    
    // Iterate the column
    this.api().columns([6]).every( function(){
      column = this;
      var select = $('<select  class="form-control form-control-sm searchtxt" id="StartersTool"  style="margin-right: 15px; width: 120px;"><option value="">-Select One-</option></select>')
      .appendTo( $("#DataTables_Table_0_filter"));
      column.data().unique().sort().each( function ( d, j ){
        select.append( '<option class="" value="'+d+'" >'+d+'</option>' );
        
      });
    });
    
    // Once all appendings are done, register a click handler
    $("#StartersTool").on( 'change', function(){
        var val = $(this).val();
        console.log(val);
        column
          .search( val ? '^'+val+'$' : '', true, false )
          .draw();
      });   
    
     },
     "createdRow": function( row, data,cells ,dataIndex){ 
                            if( data.bill_type == 'PAID'  ){
                                $(row).css({'background-color': '#a2f181','color': '#000'});
                            }
                            else if( data.bill_type == 'PARTIALLY-PAID' ){
                                $(row).css('background-color', '#6eaeff');
                            }
                            else if( data.bill_type == 'PENDING' ){
                                $(row).css('background-color', '#ffef9a');
                            }
                            else if ( data.bill_type == 'ANULATED' ){
                                $(row).css({'background-color': '#ea4741','color': '#FFF'});
                            }
                            else{
                                $(row).css('background-color', '#fff');
                            }
                     },
}); 
    

    $( "#customer_name" ).autocomplete({
                source: function( request, response ) {
          // Fetch data
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          $.ajax({
            url:"{{url('/')}}/customer/search",
            type: 'post',
            dataType: "json",
            data: {
               _token: CSRF_TOKEN,
               search: request.term
            },
            success: function( data ) {
                var array = $.map(data,function(row){
                            return {
                                value:row.id,
                                label:row.cust_name,
                                name:row.cust_name,
                                phone:row.cust_phone,
                                email:row.cust_email,
                                adress:row.cust_adress,
                                type:row.cust_type_property,
                                id:row.id
                            }
                        })
               response($.ui.autocomplete.filter(array,request.term));            
               //response( data );
               console.log(data);
            }
          });
        },
        minLength:1,
        delay:500,
        select: function (event, ui) {
           // Set selection
           $('#ItemForm').trigger("reset");
           $('#customer_id').val(ui.item.id);
           $('#customer_name').val(ui.item.name); // display the selected text
           $('#customer_phone').val(ui.item.phone); // save selected id to input
           $('#customer_email').val(ui.item.email);
           $('#customer_adress').val(ui.item.adress);
           $('#customer_type_property').val(ui.item.type);
          
           return false;
        }
      
      });


    $("#serv_descriptionx" ).autocomplete({
                source: function( request, response ) {
          // Fetch data
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          $.ajax({
            url:"{{url('/')}}/services/search",
            type: 'post',
            dataType: "json",
            data: {
               _token: CSRF_TOKEN,
               search: request.term
            },
            success: function( data ) {
                var array = $.map(data,function(row){
                            return {
                                value:row.id,
                                label:row.description,
                                name:row.name,
                                description:row.description,
                                unit:row.unit,
                                prices:row.prices,
                                id:row.id
                            }
                        })
               response($.ui.autocomplete.filter(array,request.term));            
               //response( data );
               console.log(data);
            }
          });
        },
        minLength:1,
        delay:500,
        select: function (event, ui) {
           // Set selection
          $('#ItemForm3').trigger("reset");
          $('#serv_id').val(ui.item.id);
          $('#serv_name').val(ui.item.name);
          $('#serv_description').val(ui.item.description); 
          $('#serv_price').val(ui.item.prices);
          $('#serv_unit').val(ui.item.unit);
          $('#serv_qty').val('');
          $('#serv_total_prices').val('');          
           return false;
        }
      
      });
 function escapeHtml(str)
        {
            var map =
            {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return str.replace(/[&<>"']/g, function(m) {return map[m];});
        }

    
      /* Create bill */
     
   
    $('#createNewItem').click(function () {
        $('#ajaxModel').modal('show');
        $( "#itemx" ).empty();
        $('#saveBtn').val("Create");
        $('#Item_idbill').val('');
        $('#customer_id').val('');
        $('#bill_number').val('');
        $('#ItemForm').trigger("reset");
        $('#modelHeading').html("Create New Item");
        $('#bill_type').val('');
        $('#bill_type').val('OPEN');      
        $("#saveBtn").removeAttr("disabled");        
    });
    
    $('#createNewserv').click(function () {
        $('#ajaxModel2').modal('show');
        $('#saveBtn').val("Save");
        $('#Item_id').val('');   
        //$('#ItemForm').trigger("reset");
        $('#modelHeading2').html("Create New Item");
        $("#actions").removeAttr("value");
        $("#actions").attr("value","1");

        
    });


    $('#preview').click(function () {
        var formdata = $('#ItemForm').serialize();        
        window.open("{{url('/')}}/pdf/preview?"+formdata, '_blank');          
    });


    $('#savestatusBtn').click(function (e) {
        e.preventDefault();      
       // $(this).html('Sending..');    
        $.ajax({
          data: $('#ItemForm4').serialize(),
          url: "{{ route('bill.status') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {     
              $('#ItemForm4').trigger("reset");
              $('#ajaxModel4').modal('hide');
              Swal.fire({
                 title: 'Status Invoice Update successfully',
                 icon:"success",
                 type: "success"
                 });

              table.draw();         
          },
          error: function (data) {
              console.log('Error:', data);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
                footer: '<a href>Why do I have this issue?</a>'
                });
             // $('#saveBtn').html('Save Changes');
          }
      });



    });
     $('#savespartiallyBtn').click(function (e) {
        e.preventDefault();      
       // $(this).html('Sending..');    
       var disabled = $("#savespartiallyBtn").prop("disabled")            
           $('#savespartiallyBtn').attr("disabled", true);
        $.ajax({
          data: $('#ItemForm6').serialize(),
          url: "{{ route('bill.parialpay') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {     
              $('#ItemForm6').trigger("reset");
              $('#ajaxModel6').modal('hide');
              Swal.fire({
                 title: 'Status Invoice Update successfully',
                 icon:"success",
                 type: "success"
                 });
             console.log(data);
              $('#rest').html(''+data.partial_payment_rest+'');
            listpaid(data.bill_id_p);
              table.draw();         
          },
          error: function (data) {
              console.log('Error:', data);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
                footer: '<a href>Why do I have this issue?</a>'
                });
             // $('#saveBtn').html('Save Changes');
          }
      });
    });  




 /* Edit bill  -  List Items*/

 function listpaid(id){
          $("#tablita").empty();
          $.get("{{ route('bill.index') }}/partialpaylis/"+ id, function (data) {   
              console.log(data.length);
                      for(var i = 0; i < data.length; i++) {    
                          var count = i + 1;       
                             var out; 
                                out += '<tr>';
                                out += '<td width="3%" >' + count +'</td>';
                                out += '<td width="10%">' + data[i].partial_payment_mont +'</td>';
                                out += '<td width="10%">' + data[i].partial_payment_rest +'</td>';
                                out += '<td width="18%">' + data[i].partial_payment_date +'</td>';
                                out +=' <td width="18%"><a href="javascript:void(0)" data-toggle="tooltip" data-idpo="'+data[i].id+'" data-original-title="Delete" class="btn btn-danger btn-sm remove_pay">x</a> </td>'
                                out += '</tr>';
                       }         
                       $('#tablita').append(out);   

      });
    }



    $('body').on('click', '.editpay', function () {
        var Item_id = $(this).data('id');
        $.get("{{ route('bill.index') }}" +'/' + Item_id +'/edit', function (data) {  //   console.log('data:', data);
            $('#modelHeading').html("Edit Status");
            $('#savestatusBtn').val("Save Changes");
            $('#ajaxModel5').modal('show');
                $('#Item_idpp').val(data.id); 
                $('#invoicesnro').html(''+data.bill_number+'');
                $('#customer').html(''+data.customer_name+'');  
                $('#totalp').html(''+data.bill_total+'');
                $('#rest').html(''+data.partial_payment_rest+'');
                listpaid(data.id);
                $('#partial_payment_percentsp').val(data.partial_payment_percents);   
                $('#partial_payment_cashp').val(data.partial_payment_cash);   
                $('#partial_payment_restp').val(data.partial_payment_rest);
                $('#partial_payment_montp').val(data.partial_payment_mont);    
                $('#bill_subtotalp').val(data.bill_subtotal);                  
              //  $("#bill_type option[value="+ data.bill_type +"]").attr("selected",true);
       
     
        });
        
    });  






    $('body').on('click', '#newpayBtn', function () {
        var Item_id = $('#Item_idpp').val();
        $("#savespartiallyBtn").removeAttr("disabled"); 
        $.get("{{ route('bill.index') }}" +'/' + Item_id +'/edit', function (data) {  //   console.log('data:', data);
            $('#modelHeading').html("Edit Status");
            $('#savestatusBtn').val("Save Changes");
            $('#ajaxModel6').modal('show');
                $('#bill_number_c').val(data.bill_number);  
                $('#Item_idpc').val(data.id);      
                $('#bill_subtotalc').val(data.bill_subtotal);     
                $('#bill_totalc').val(data.bill_total);
                $('#partial_payment_restcx').val(data.partial_payment_rest);                
                 console.log(data.partial_payment_rest);
                if(data.partial_payment_rest == '0,00'){
                 $('#partial_payment_restc').val('0,00'); 
                }else{
                $('#partial_payment_restc').val(data.partial_payment_rest); 
                 }          
                $("#bill_typec option[value="+ data.bill_type +"]").attr("selected",true);
       
     
        });
        
    });

    $('#tablita').on('click', '.remove_pay', function(e){
				e.preventDefault();                
                var idinv = $('#Item_idpp').val(); 
                var itemid = $(this).data('idpo');              
                $.ajax({
                    type: "POST",
                    url: "{{url('/')}}/bill/deletpay", 
                    data: {'id': itemid},
                    success: function (data) {
                        listpaid(idinv);
                        Swal.fire("Item Remove successfully", "", "success");
                        },
                    error: function (data) {
                        console.log('Error:', data);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            footer: '<a href>Why do I have this issue?</a>'
                            });
                    }
                });
				   
			});

 

         /* Edit bill     */

    $('body').on('click', '.editItem', function (e) {
        e.preventDefault();     
        $("#saveBtn").removeAttr("disabled"); 
        var Item_id = $(this).data('id');
        $.get("{{ route('bill.index') }}" +'/' + Item_id +'/edit', function (data) {  //   console.log('data:', data);
            $('#modelHeading').html("Edit Bill");
            $('#saveBtn').val("Save Changes");
            $('#ajaxModel').modal('show');
            //$("#bill_type").removeAttr("readonly","readonly");

                $('#Item_idbill').val(data.id);
                $('#customer_id').val(data.customer_id);
                $('#customer_name').val(data.customer_name);
                $('#customer_adress').val(data.customer_adress);
                $('#customer_phone').val(data.customer_phone);
                $('#customer_email').val(data.customer_email);
                $('#customer_type_property').val(data.customer_type_property);
                listItem(data.id);
                $('#bill_number').val(data.bill_number);
                $('#bill_description').val(data.bill_description);
                $('#bill_totalg').val(data.bill_total);
                $('#bill_subtotalg').val(data.bill_subtotal); 
                $('#bill_ivag').val(data.bill_iva);
                $('#bill_discountg').val(data.bill_discount);
               // $('#partial_payment_percents').val(data.partial_payment_percents);
               // $('#partial_payment_percents').val(data.partial_payment_percents);   
               // $('#partial_payment_cash').val(data.partial_payment_cash);  
                $('#partial_payment_montg').val(data.partial_payment_mont);                
                $('#partial_payment_restg').val(data.partial_payment_rest);
                $('#bill_type').val('');
                $('#bill_type').val(data.bill_type);   
                $("#tasa option[value="+ data.tasa +"]").attr("selected",true);
                $('#discount').val(data.discount); 
                $('#discount_cash').val(data.discount_cash);                           
                $("#actions").removeAttr("value");
                $("#actions").attr("value","2");      
               // console.log('Error:', data.bill_type );

        });
        
    });
    $('#itemx').on('click', '.remove_button', function(e){
				e.preventDefault();                
                var itemid = $(this).data('idx');              
                $.ajax({
                    type: "POST",
                    url: "{{url('/')}}/bill/delet", 
                    data: {'id': itemid},
                    success: function (data) {
                        table.draw();
                        Swal.fire("Item Remove successfully", "", "success");
                        },
                    error: function (data) {
                        console.log('Error:', data);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            footer: '<a href>Why do I have this issue?</a>'
                            });
                    }
                });
				    $(this).parent().parent().parent('div.row').remove();
                    update_total();
			});



            $('#itemx').on('click', '.remove_buttonx', function(e){
				e.preventDefault();                
                var itemid = $(this).data('idx');                        
				    $(this).parent().parent().parent('div.row').remove();
                    update_total();
			});


    /* Edit bill  -  List Items*/

    function listItem(id){
        $("#itemx").empty();
        $.get("{{ route('billservises.index') }}" +'/' + id +'/edit', function (data) {  //   console.log('data:', data);
          for(var i = 0; i < data.length; i++) {           
                var out;          
                    out = ' <div class="row" style="margin-right: 0px; margin-left: 0px;"><div class="col-sm-1" >  <div class="form-group "><input type="hidden"  value="' + data[i].id + '" name="id_tb[]" id="id_tb[]"/><input type="text" class="form-control " id="serv_id[]" name="serv_id[]"  value="' + data[i] .services_id + '" maxlength="50" required="" readonly></div> </div> ';
                    out += '<div class="col-sm-2" >  <div class="form-group"><input type="text" class="form-control " id="serv_name[]" name="serv_name[]"  value="' + data[i] .serv_name + '" maxlength="50" required="" ></div> </div>';
                    out += '<div class="col-sm-3" >  <div class="form-group"><input type="text" class="form-control " id="serv_description[]" name="serv_description[]"  value="' + data[i] .serv_description + '" maxlength="50" required=""  ></div> </div>';
                    out += '<div class="col-sm-1" >  <div class="form-group"><input type="text" class="form-control " id="serv_qty[]" name="serv_qty[]"  value="' + data[i] .serv_qty + '" maxlength="50" required="" readonly></div> </div>';
                    out += '<div class="col-sm-2" >  <div class="form-group"><input type="text" class="form-control " id="serv_unit[]" name="serv_unit[]"  value="' + data[i].serv_unit + '" maxlength="50" required="" ></div> </div>';
                    out += '<div class="col-sm-1" >  <div class="form-group"><input type="text" class="form-control " id="serv_price[]" name="serv_price[]"  value="' + data[i].serv_price  + '" maxlength="50" required="" readonly></div> </div>';
                    out += '<div class="col-sm-1" >  <div class="form-group"><input type="text" class="form-control itemsx" id="serv_total_prices[]" name="serv_total_prices[]"  value="' + data[i] .serv_total_prices + '" maxlength="50" required="" readonly> </div> </div>';
                    out += '<div class="col-sm-1" >  <div class="form-group"><a href="javascript:void(0)" data-toggle="tooltip"  data-idX="' + data[i].id + '" data-original-title="Delete" class="btn btn-danger btn-sm remove_button">x</a> </div> </div>';
                    out += '</div>';
             $('#itemx').append(out);   
          }         
      });
    }




    $('body').on('click', '.statusItem', function () {
        var Item_id = $(this).data('id');
        $.get("{{ route('bill.index') }}" +'/' + Item_id +'/edit', function (data) {  //   console.log('data:', data);
            $('#modelHeading').html("Edit Status");
            $('#savestatusBtn').val("Save Changes");
            $('#ajaxModel4').modal('show');
                $('#Item_idt').val(data.id);   
                $('#bill_number_p').val(data.bill_number);   
                $('#bill_totalp').val(data.bill_total);   
                $('#partial_payment_percentsp').val(data.partial_payment_percents);   
                $('#partial_payment_cashp').val(data.partial_payment_cash);   
                $('#partial_payment_restp').val(data.partial_payment_rest);
                $('#partial_payment_montp').val(data.partial_payment_mont);    
                $('#bill_subtotalp').val(data.bill_subtotal);                  
                $("#bill_type option[value="+ data.bill_type +"]").attr("selected",true);    
     
        });
        
    });


    $('body').on('click', '.notinficationItem', function () {
        var Item_id = $(this).data('id');
                    Swal.fire({
                        title: 'Are you sure ? you want to send this notification message',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(
                            'Success!',
                            'Message has been sent',
                            'success'
                            )
                            $.get("{{ route('bill.index') }}/notificactionpartialpay" +'/' + Item_id , function (data) {  });        

                        }
                    })
    });



  
    select = document.getElementById("tasa");
        for(i = 0; i <= 100; i++){
            option = document.createElement("option");
            option.value = i;
            option.text = i;
            select.appendChild(option);
        }



    function reverseFormatNumber(val,locale){
        var group = new Intl.NumberFormat(locale).format(1111).replace(/1/g, '');
        var decimal = new Intl.NumberFormat(locale).format(1.1).replace(/1/g, '');
        var reversedVal = val.replace(new RegExp('\\' + group, 'g'), '');
        reversedVal = reversedVal.replace(new RegExp('\\' + decimal, 'g'), '.');
        return Number.isNaN(reversedVal)?0:reversedVal;
    }

 

        function update_total(){
            sub_total = 0;
            iva  = 0;
            discount = 0;
            partial = 0;

            tasa = $("#tasa").val();  

           
 
             //console.log(discount);
             console.log(dis);            
              $(".itemsx").each(
                function(index, value) {
                    sub_total = sub_total + eval( reverseFormatNumber($(this).val(),'de') );
                    }
                );
                if( $("#discount").val() == '0,00'){             
                   var   discount = eval(reverseFormatNumber($("#discount_cash").val(),'de'));
                   var dis = discount;      
                }          
      
      if( $("#discount_cash").val() == '0,00'){
        var  discount = eval(reverseFormatNumber($("#discount").val(),'de'));
        var dis = (sub_total * discount)/100;         
     }        
          var iva = (sub_total * tasa)/100;               
          var total = sub_total + iva - dis;


          if( $("#partial_payment_restg").val() == '0,00'){
            //partial_payment_montg
             var  newrest = 0.00;
          }else{
             var  monts =  eval(reverseFormatNumber($("#partial_payment_montg").val(),'de'));
             var newrest = total - monts;
          }

            var sub_totalformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(sub_total);
            var ivaformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(iva);
            var disformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(dis);
            var totalformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(total);
            var newrestformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(newrest);

                $("#bill_subtotalg").val(sub_totalformat);
                $("#bill_ivag").val(ivaformat);
                $("#bill_discountg").val(disformat);
                $("#bill_totalg").val(totalformat);
                $("#partial_payment_restg").val(newrestformat)
                
        }


        function partial_pay_total(){
         
            partial = 0;
            totalinvoice=0;
            sub_total = 0;
            iva  = 0;
            discount = 0;
 
          percent =  eval( reverseFormatNumber($("#partial_payment_percents").val(),'de'));
          rest  =   eval( reverseFormatNumber($("#partial_payment_restcx").val(),'de') ); 
          total =  eval( reverseFormatNumber($("#bill_totalc").val(),'de') );
       
        // alert(rest);
         if( rest == 0){
          var paypercet = (total * percent)/100;  
          var totalx =  total - paypercet;
         }else{
          var paypercet = (total * percent)/100;  
          var totalx =  rest - paypercet;
         }
          

          var percentformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(paypercet);
          var totalformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(totalx);
            
                $("#partial_payment_montc").val(percentformat);
                $("#partial_payment_restc").val(totalformat);
                var select ="PAID";
                var select1 ="PARTIALLY-PAID";

             if( $("#partial_payment_restc").val() =='0,00'){
                $("#bill_typec option[value="+ select1 +"").removeAttr("selected","selected");
                $("#bill_typec option[value="+ select +"]").attr("selected",true);
             }else{
                $("#bill_typec option[value="+ select +"").removeAttr("selected","selected");
                $("#bill_typec option[value="+ select1 +"]").attr("selected",true);
             }

        }


        function partial_pay_total_cash(){
         
         partial = 0;
         totalinvoice=0;
         sub_total = 0;
         iva  = 0;
         discount = 0;

            percent =  eval( reverseFormatNumber($("#partial_payment_cash").val(),'de') );
            var paypercet =  percent      
            rest  =   eval( reverseFormatNumber($("#partial_payment_restcx").val(),'de') ); 
            total =  eval( reverseFormatNumber($("#bill_totalc").val(),'de') );

         if( rest == 0){
          var totalx =  total - paypercet;
         }else{
          var totalx =  rest - paypercet;
         }

       
       var percentformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(paypercet);
       var totalformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(totalx);
         
             $("#partial_payment_montc").val(percentformat);
             $("#partial_payment_restc").val(totalformat);

             var select ="PAID";
             var select1 ="PARTIALLY-PAID";

             if( $("#partial_payment_restc").val() =='0,00'){
                $("#bill_typec option[value="+ select1 +"").removeAttr("selected","selected");
                $("#bill_typec option[value="+ select +"]").attr("selected",true);
             }else{
                $("#bill_typec option[value="+ select +"").removeAttr("selected","selected");
                $("#bill_typec option[value="+ select1 +"]").attr("selected",true);
             }

     }






        function listServises(){
        $("#serv_description").empty();
        $("#serv_description").append('<option></option>');              
        $.get("{{url('/')}}/services/show", function (data) {  //   console.log('data:', data);
          for(var i = 0; i < data.length; i++) {
            var out = '<option  value ="' + data[i] .id +'">' + data[i].description + ' </option>';
             $('#serv_description').append(out);              
                }         
            });
        }

    $('#tasa').on('change', function() {      
        update_total();
    ///partial_pay_total();
    //partial_pay_total_cash();     
    });      


      $('#discount').on('input', function() {      
        update_total();
        //partial_pay_total();
        //partial_pay_total_cash();
    });

    $('#discount_cash').on('input', function() {      
        update_total();
        //partial_pay_total();
        // partial_pay_total_cash();

    });



    $('#partial_payment_percents').on('input', function() {      
       // update_total();
        partial_pay_total();

    }); 
    
    $('#partial_payment_cash').on('input', function() {      
       // update_total();
        partial_pay_total_cash();
    }); 


    $('#itemx #serv_price').on('input', function() {      
        update_total();
        //partial_pay_total();
//partial_pay_total_cash();
    });


    $('#itemx #serv_qty').on('input', function() {      
        update_total();
       // partial_pay_total();
       // partial_pay_total_cash();
    });
   

         /* Edit bill  -   Cal prices - Add Items */
    
    $('#serv_qty').on('change', function() {
        var num = reverseFormatNumber($('#serv_price').val(),'de');
        var num2 = $('#serv_qty').val();
        var sum = num * num2; 
        var  value = parseFloat(sum).toFixed(2);      
        var sumformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(value);
        $('#serv_total_prices').val(sumformat);
    });


    $('#serv_price').on('change', function() {
        var num = reverseFormatNumber($('#serv_price').val()  ,'de');
        var num2 = $('#serv_qty').val();
        var sum = num * num2;  
        var  value = parseFloat(sum).toFixed(2);      

        var sumformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(value);

        $('#serv_total_prices').val(sumformat);
    });

       /* Edit bill  -   Cal prices - Create Items */

       $('#quantityx').on('change', function() {
        var num2 = $('#quantityx').val();    
        var num = reverseFormatNumber($('#prices').val()  ,'de');
        var sum = num * num2;        
        var  value = parseFloat(sum).toFixed(2);     
        var sumformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(value); 
        $('#total').val(sumformat);
        });
         /* Edit bill  -  Create new Items*/
     $('#prices').on('change', function() {
        var num2 = $('#quantityx').val();    
        var num = reverseFormatNumber($('#prices').val()  ,'de');
        var sum = num * num2;    
        var  value = parseFloat(sum).toFixed(2);     
         var sumformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(value); 
            $('#total').val(sumformat);
        });



         /* Edit bill  -  Add new Items*/

   $('.additems').click(function () {
        $('#ajaxModel3').modal('show');
        $('#modelHeading3').html("Add Services");
        $('#ItemForm3').trigger("reset");
          $('#serv_price').val('');
          $('#serv_qty').val('');
          $('#serv_total_prices').val('');
        listServises();
        $('#addBtn').html('Save');
        $("#actions").removeAttr("value");
        $("#actions").attr("value","1");
        
    });


    $('#addBtn').click(function (e) {
        e.preventDefault();       

            if($("#serv_qty").val().length < 1) {  
                alert("El Cantidad es obligatorio");
                $("#serv_qty").css({'border':'1px solid #f70a0a'});
  
                return false;  
            }  
            if(isNaN($("#serv_qty").val())) {  
                alert("El Cantidad solo debe contener números");  
                $("#serv_qty").css({'border':'1px solid #f70a0a'});

                return false;  
            }

        $(this).html('Sending..');    
                 
        var item1 =  $('#serv_id').val();
        var item2 =  $('#serv_name').val();
        var item3 =  $('#serv_description :selected').text();
        var item7 =  $('#serv_unit').val();
        var item4 =  $('#serv_qty').val();
        var item5 =  $('#serv_price').val();
        var item6 =  $('#serv_total_prices').val();

         var out;          
             out = ' <div class="row" style="margin-right: 0px; margin-left: 0px;"><div class="col-sm-1" >  <div class="form-group"><input type="hidden"  value="" name="id_tb[]" id="id_tb[]"/><input type="text" class="form-control" id="serv_id[]" name="serv_id[]"  value="' +item1 + '" maxlength="50" required="" readonly></div> </div> ';
             out += '<div class="col-sm-2" >  <div class="form-group"><input type="text" class="form-control" id="serv_name[]" name="serv_name[]"  value="' + escapeHtml(item2) + '" maxlength="50" required="" ></div> </div>';
             out += '<div class="col-sm-3" >  <div class="form-group"><input type="text" class="form-control" id="serv_description[]" name="serv_description[]"  value="' + escapeHtml(item3) + '" maxlength="50" required="" ></div> </div>';
             out += '<div class="col-sm-1" >  <div class="form-group"><input type="text" class="form-control" id="serv_qty[]" name="serv_qty[]"  value="' + item4 + '" maxlength="50" required="" readonly></div> </div>';
             out += '<div class="col-sm-2" >  <div class="form-group"><input type="text" class="form-control" id="serv_unit[]" name="serv_unit[]"  value="' + item7 + '" maxlength="50" required="" ></div> </div>';
             out += '<div class="col-sm-1" >  <div class="form-group"><input type="text" class="form-control" id="serv_price[]" name="serv_price[]"  value="' + item5 + '" maxlength="50" required="" readonly></div> </div>';
             out += '<div class="col-sm-1" >  <div class="form-group"><input type="text" class="form-control itemsx" id="serv_total_prices[]" name="serv_total_prices[]"  value="' +item6 + '" maxlength="50" required="" readonly></div> </div>';
             out += '<div class="col-sm-1" >  <div class="form-group"><a href="javascript:void(0)" data-toggle="tooltip"  data-idX="' + item1+ '" data-original-title="Delete" class="btn btn-danger btn-sm remove_buttonx">x</a> </div> </div>';
             out += '</div>';
             $('#itemx').append(out);  
             // $('#ItemForm').trigger("reset");
              $('#ajaxModel3').modal('hide');
              Swal.fire("item added successfully", "", "success");
              update_total();
    });


    $('#creatBtn').click(function (e) {
        e.preventDefault();  
  
        if($("#name").val().length < 1) {  
                alert("No debe estar vacio");  
                $("#name").css({'border':'1px solid #f70a0a'});
                return false;  
            } 
           if($("#name").val().length < 5) {  
                alert("El nombre debe tener como mínimo 5 caracteres");  
                $("#name").css({'border':'1px solid #f70a0a'});
                return false;  
            }  
            if($("#description").val().length < 1) {  
                alert("No debe estar vacio");  
                $("#customer_name").css({'border':'1px solid #f70a0a'});
                return false; 
            } 
           if($("#description").val().length < 5) {  
                alert("El nombre debe tener como mínimo 5 caracteres");  
                $("#customer_name").css({'border':'1px solid #f70a0a'});
                return false;  
            }  
            if($("#prices").val().length < 1) {  
                alert("El precio es obligatorio");
                $("#prices").css({'border':'1px solid #f70a0a'});
                  return false;  
            }  
            if($("#prices").val().length < 4) {  
                alert("El precio es obligatorio");
                $("#prices").css({'border':'1px solid #f70a0a'});
                  return false;  
            } 

            if($("#quantityx").val().length < 1) {  
                alert("El Cantidad es obligatorio");
                $("#serv_qty").css({'border':'1px solid #f70a0a'});
  
                return false;  
            }  
            if(isNaN($("#quantityx").val())) {  
                alert("El Cantidad solo debe contener números");  
                $("#serv_qty").css({'border':'1px solid #f70a0a'});

                return false;  
            }

        var item1 =  $('#quantityx').val();
        var item2 =  $('#total').val();
      //  $(this).html('Sending..');   
        var disabled = $("#creatBtn").prop("disabled")            
           $('#creatBtn').attr("creatBtn", true);
        $.ajax({
          data: $('#ItemForm2').serialize(),
          url: "{{url('/')}}/services",
          type: "POST",
          dataType: 'json',
          success: function (data) {    
           // console.log('Exito:', data); 
              $('#ItemForm2').trigger("reset");
              $('#ajaxModel2').modal('hide');
               var out;          
                out = ' <div class="row" style="margin-right: 0px; margin-left: 0px;"><div class="col-sm-1" >  <div class="form-group"><input type="hidden"  value="" name="id_tb[]" id="id_tb[]"/><input type="text" class="form-control" id="serv_id[]" name="serv_id[]"  value="' +data.id + '" maxlength="50" required="" readonly></div> </div> ';
                out += '<div class="col-sm-2" >  <div class="form-group"><input type="text" class="form-control" id="serv_name[]" name="serv_name[]"  value="' + escapeHtml(data.name) + '" maxlength="50" required="" ></div> </div>';
                out += '<div class="col-sm-3" >  <div class="form-group"><input type="text" class="form-control" id="serv_description[]" name="serv_description[]"  value="' + escapeHtml(data.description) + '" maxlength="50" required="" ></div> </div>';
                out += '<div class="col-sm-1" >  <div class="form-group"><input type="text" class="form-control" id="serv_qty[]" name="serv_qty[]"  value="' + item1 + '" maxlength="50" required="" readonly></div> </div>';
                out += '<div class="col-sm-2" >  <div class="form-group"><input type="text" class="form-control" id="serv_unit[]" name="serv_unit[]"  value="' + data.unit + '" maxlength="50" required="" ></div> </div>';
                out += '<div class="col-sm-1" >  <div class="form-group"><input type="text" class="form-control" id="serv_price[]" name="serv_price[]"  value="' + data.prices + '" maxlength="50" required="" readonly></div> </div>';
                out += '<div class="col-sm-1" >  <div class="form-group"><input type="text" class="form-control itemsx" id="serv_total_prices[]" name="serv_total_prices[]"  value="' +item2 + '" maxlength="50" required="" readonly> </div> </div>';
                out += '<div class="col-sm-1" >  <div class="form-group"><a href="javascript:void(0)" data-toggle="tooltip"  data-idX="' + data.id+ '" data-original-title="Delete" class="btn btn-danger btn-sm remove_buttonx">x</a> </div> </div>';
                out += '</div>';
             $('#itemx').append(out); 
             Swal.fire("item added successfully", "", "success");
             update_total();

          },
          error: function (data) {
              console.log('Error:', data);
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
                footer: '<a href>Why do I have this issue?</a>'
                }) ;     
            $('#creatBtn').html('Save Changes');
          }
      });
    });

    
    $('#saveBtn').click(function (e) {
        e.preventDefault();
         
         if($("#customer_name").val().length < 1) {  
                alert("No debe estar vacio");  
                $("#customer_name").css({'border':'1px solid #f70a0a'});
                return false;  
            } 
           if($("#customer_name").val().length < 5) {  
                alert("El nombre debe tener como mínimo 5 caracteres");  
                $("#customer_name").css({'border':'1px solid #f70a0a'});

                return false;  
            }  
            if($("#customer_phone").val().length < 1) {  
                alert("El teléfono es obligatorio");
                $("#customer_phone").css({'border':'1px solid #f70a0a'});
  
                return false;  
            }  

            if(isNaN($("#customer_phone").val())) {  
                alert("El teléfono solo debe contener números");  
                $("#customer_phone").css({'border':'1px solid #f70a0a'});

                return false;  
            } 
            if($("#customer_phone").val().length < 9) {  
                alert("El teléfono debe tener 9 caracteres. Ej. 666112233");  
                $("#customer_phone").css({'border':'1px solid #f70a0a'});

                return false;  
            }  
            if($("#customer_email").val().length < 1) {  
                alert("La dirección e-mail es obligatoria");  
                $("#customer_email").css({'border':'1px solid #f70a0a'});

                return false;  
            } 
            if($("#customer_email").val().indexOf('@', 0) == -1 || $("#customer_email").val().indexOf('.', 0) == -1) {  
                alert("La dirección e-mail parece incorrecta");  
                $("#customer_email").css({'border':'1px solid #f70a0a'});
                return false;  
            }  

            if($("#customer_type_property").val().length < 1) {  
                alert(" La propiedad No debe estar vacio"); 
                $("#customer_type_property").css({'border':'1px solid #f70a0a'});
 
                return false;  
            } 
            if($("#customer_type_property").val().length < 5) {  
                alert("La propiedad debe tener como mínimo 5 caracteres");  
                $("#customer_type_property").css({'border':'1px solid #f70a0a'});

                return false;  
            } 
            if($("#customer_adress").val().length < 1) {  
                alert("No debe estar vacio"); 
                $("#customer_adress").css({'border':'1px solid #f70a0a'});
 
                return false;  
            } 
            
            if($("#customer_adress").val().length < 5) {  
                alert("El nombre debe tener como mínimo 5 caracteres");  
                $("#customer_adress").css({'border':'1px solid #f70a0a'});
                return false;  
            } 

            var disabled = $("#saveBtn").prop("disabled")            
           $('#saveBtn').attr("disabled", true);

           
        //$(this).html('Sending..');    
        $.ajax({
          data: $('#ItemForm').serialize(),
          url: "{{ route('bill.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {     
              $('#ItemForm').trigger("reset");
              $('#ajaxModel').modal('hide');

              Swal.fire({
                 title: 'Invoice created successfully',
                 icon:"success",
                 type: "success",
                 html: '<a href="http://bill.greendepartment.org/pdf/invoice/'+data.id +'" target="_blank" data-toggle="tooltip"   class="btn btn-danger btn-sm" ><b>VIEW or DOWLOAD PDF</b></a>',
                 });


              table.draw();         
          },
          error: function (data) {
              console.log('Error:', data);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
                footer: '<a href>Why do I have this issue?</a>'
                });
              $('#saveBtn').html('Save Changes');
          }
      });
    });
    
  /*  $('body').on('click', '.deleteItem', function () {     
             confirm("Are You sure want to delete !");  
             $.ajax({
            type: "DELETE",
            url: "{{ route('bill.store') }}"+'/'+Item_id,
            success: function (data) {
                table.draw();
                },
            error: function (data) {
                console.log('Error:', data);
            }
        });    
      
    });*/


    $('body').on('click', '.deleteItem', function() {
            var that = this;
            Swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this informaton",
                type: "warning",
                icon: "warning",
                buttons: true,
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }).then(function(yes) {
                if (yes) {                    
                    var id = $(that).data("id");
                    $.ajax({
                    type: "DELETE",
                    url: "{{route('bill.store')}}"+'/'+id,
                    success: function (data) {
                        table.draw();
                        },
                    error: function (data) {
                       swal("Uff something went wrong", "", "error");
                        console.log('Error:', data);
                    }
                });
                
                }
                else {
                    return false;
                }
            })
        });
   
  });
</script>
@stop
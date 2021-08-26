@extends('adminlte::page')
@section('title', 'REQUEST')
@section('content_header')
    <h1>REQUEST</h1>
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
    table.table-bordered.dataTable th:last-child, table.table-bordered.dataTable th:last-child, table.table-bordered.dataTable td:last-child, table.table-bordered.dataTable td:last-child {
    border-right-width: 0;
    width: 100px;
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
           <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Number</th>
                        <th>Empleado</th>
                        <th>Type</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
 <div class="modal fade bd-example-modal-lg" id="ajaxModel" aria-hidden="true">
            <div  id="modaltxt" class="modal-dialog modal-lg">
                <div id="modaltxt2" class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
               </div>
                    <div class="modal-body">
                        <form id="ItemForm" name="ItemForm" class="form-horizontal">
                                <input type="hidden" name="Item_idbill" id="Item_idbill">
                                <input type="hidden" name="request_number" id="request_number">
                                <input type="hidden" name="employer_id" id="employer_id" value="{{ auth()->user()->id }}">
      <div >
              <div >
      <fieldset>
      <legend>Employee Info</legend>
                    <!-- BEGIN ROW -->   
                         <div class="row">
                                <div class="col-sm-4">
                                        <div class="form-group ui-widget">
                                            <label for="employer_name" class="control-label">Name</label>
                                                <input type="text" class="form-control" id="employer_name" name="employer_name"  value="{{ auth()->user()->name }}"  >
                                        </div>
                                </div>
                                    <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label">Phone </label>
                                                <input type="text" class="form-control" id="employer_phone" name="employer_phone" placeholder="Enter Phone" value="" maxlength="50" required="">
                                            </div>
                                    </div>
                                    <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="name" class="control-label">Email</label>
                                                <input type="email" class="form-control" id="employer_email" name="employer_email"  placeholder="Enter Email" value="{{ auth()->user()->email }}" maxlength="50" required="">
                                            </div>
                                    </div>
                                    <div class="col-sm-6">
                                                <div class="form-group">
                                                <label for="name" class="control-label">Address</label>
                                                <textarea  class="form-control" name="employer_adress" id="employer_adress"> 
                                                </textarea>
                                               
                                                </div>
                                    </div>
                                    <div class="col-sm-6">
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                                <label for="name" class="control-label">Manager's name</label>
                                                <input type="text" class="form-control" id="name_employer" name="name_employer" placeholder="Enter Name" value="" maxlength="50" required="" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                                <label for="name" class=" control-label">Manager Email</label>
                                                <input type="email" class="form-control" id="email_employer" name="email_employer" placeholder="Enter email" value="" maxlength="50" required="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                                <label for="name" class="control-label">Manager's Phone</label>
                                                <input type="text" class="form-control" id="phone_employer" name="phone_employer" placeholder="Enter Phone" value="" maxlength="50" required="" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                                <label for="name" class=" control-label"> Position</label>
                                                <input type="text" class="form-control" id="position_employer" name="position_employer" placeholder="Enter Position" value="" maxlength="50" required="">
                                        </div>
                                    </div>
                                        <input type="hidden" id="actions" name="actions" value="1">
                   </div>
                <!-- END ROW  . bill_type  -->
                </fieldset>
                <fieldset>
                <!-- BEGIN ROW -->  
                <legend>Request Creation</legend>
                            <div class="row" style="margin-top: 20px;">                           
                                       <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="name" class="control-label">Items</label>
                                                </div>                                                                         
                                        </div>
                                        <div class="col-sm-2">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-primary additems" id="additems" value="add">Add Item</button>
                                                </div>                                                                         
                                        </div>
                                        <div class="col-sm-2">
                                                <div class="form-group">
                                                <button type="button" class="btn btn-primary" id="createNewserv" value="create">Create Item</button>
                                                </div>                                                                         
                                        </div>
                                        <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Taxes(%)</label>
                                                    <select id="request_tax" name="request_tax" class="form-control"> </select>
                                                </div>
                                        </div>
                                        <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Type</label>
                                                    <select id="request_type" name="request_type" class="form-control">
                                                        <option value="PURCHASE" selected>PURCHASE</option>                                                 
                                                    </select>
                                                </div>
                                        </div>
                                          <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Status</label>
                                                        <select id="request_status" name="request_status" class="form-control">
                                                            <option value="DRAFT">DRAFT</option>
                                                            <option value="OPEN">OPEN</option>
                                                            <option value="PENDING">PENDING</option> 
                                                            <option value="APPROVED">APPROVED</option>    
                                                            <option value="ANULATED">ANULATED</option>       
                                                        </select>
                                                </div>
                                            </div>


                                        <div class="col-sm-12" style="margin-bottom: 10px;">
                                                  <table width="100%" style="width: 92%;text-aling:center;">
                                                        <tr style=" width:100%; text-aling:center; ">
                                                        <th style="text-align: center;border-bottom: 1px solid #ccc;width: 0;">Id</th>
                                                        <th style="text-align: center;border-bottom: 1px solid #ccc;width: 0;">Tag/label</th>
                                                        <th style="text-align: center;border-bottom: 1px solid #ccc;width: 0;">Descriptions</th>
                                                        <th style="text-align: center;border-bottom: 1px solid #ccc;width: 0;">Qy</th>
                                                        <th style="text-align: center;border-bottom: 1px solid #ccc;width: 0;">Prices</th>
                                                        <th style="text-align: left;border-bottom: 1px solid #ccc;width: 0;">Total </th> 
                                                        <th style="text-align: left;border-bottom: 1px solid #ccc;width: 0;">Action</th>   
                                                        </tr>
                                               </table>                                                                                                          
                                        </div>
                                        <div class="col-sm-12">
                                            <div id="itemx" class="row overflow-auto"  style="overflow-y: auto !important; min-height: 100px; max-height: 100px;">  </div>                                                                       
                                        </div>                                    
                                        <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Sub-Total</label>
                                                
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                         <input type="text" class="form-control"  id="request_subtotal" name="request_subtotal" value="0" required="" aria-label="Amount (to the nearest dollar)" readonly>
                                                    </div>                                                
                                                </div>
                                        </div>
                                        <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Tax</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                         <input type="text" class="form-control"  id="request_taxes_num" name="request_taxes_num" value="0" required="" aria-label="Amount (to the nearest dollar)" readonly>
                                                    </div>   
                                                </div>
                                        </div>
                   
                                        <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Total</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                         <input type="text" class="form-control"  id="request_total" name="request_total" value="0" required="" aria-label="Amount (to the nearest dollar)" readonly>
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
                                <input type="hidden" class="form-control" id="request_items_id" name="request_items_id"  value="" maxlength="50" required="" >


                                    <label for="name" class=" control-label">Descriptions</label>
                                   
                                    <select  id="request_description" name="request_description" class=" form-control js-example-basic-single js-states" >
        
                                    </select>

                                               
                                </div>
                            </div>

                            <div class="form-group">
                           <label for="name" class="col-sm-2 control-label">Tag/label </label>

                                <div class="col-sm-12">
                                <input type="text" class="form-control" id="request_name" name="request_name"  value="" required="">

                                </div>
                            </div>
   
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Quantity</label>
                                <div class="col-sm-12">
                                    <input type="text" min="1" max="100" class="form-control" id="request_qty" name="request_qty"  value="" maxlength="50" required="">
                                </div>
                            </div>
                 
                            <div class="form-group">

                                <label for="name" class="col-sm-2 control-label">Prices</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                  <input type="text" class="form-control"  id="request_price" name="request_price" aria-label="Amount (to the nearest dollar)">
                                </div>

                            </div>

                            

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Total</label>

                                <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control"  id="request_total_prices" name="request_total_prices" aria-label="Amount (to the nearest dollar)" disabled>
                               
                                </div>

                                
                            </div>
                            <div class="col-sm-offset-2 col-sm-10">
                             <button type="submit" class="btn btn-primary" id="addBtn" value="Add">Save changes                    </button>
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

 <div class="modal fade" id="ajaxModel4" aria-hidden="true">
            <div class="modal-dialog" style = "width:400px !important">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelHeading4"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="ItemForm4" name="ItemForm4" class="form-horizontal">
                           <input type="hidden" name="Item_idt" id="Item_idt">
                        
								     <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="name" class=" control-label">Status</label>
                                                        <select id="request_status" name="request_status" class="form-control">
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>     
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script> 
   $('.js-example-basic-single').select2().on("select2:select", function (e) {
       var selected_element = $(e.currentTarget);
       var select_val = selected_element.val();
       console.log(select_val);
       $.get("{{url('/')}}/items/"+ select_val +"/edit", function (data) {  //   console.log('data:', data);
          $('#request_items_id').val(data.id);
          $('#request_name').val(data.name);
          //$('#request_description').val(data.description); 
          $('#request_price').val(data.prices);
          $('#request_qty').val('');
          $('#request_total_prices').val('');
      });
});



$(document).ready(function(){
    var height = $(window).height();
    $('#modaltxt').height(height);
    $('#modaltxt2').height(height);
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
 $('#request_price').mask('000.000.000.000.000,00', {reverse: true,
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
        ajax: "{{ route('request.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
           
            {data: 'request_number', name: 'request_number'},
            {data: 'employer_name', name: 'employer_name'},
            {data: 'request_type', name: 'request_type'},           
            {data: 'request_total', name: 'request_total'},
            {data: 'request_status', name: 'request_status'}, 
            
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
                            if( data.request_status == 'PAID'  ){
                                $(row).css({'background-color': '#a2f181','color': '#000'});
                            }
                            else if( data.request_status == 'PENDING' ){
                                $(row).css('background-color', '#ffef9a');
                            }
                            else if ( data.request_status == 'ANULATED' ){
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
           $('#employer_id').val(ui.item.id);
           $('#employer_name').val(ui.item.name); // display the selected text
           $('#employer_phone').val(ui.item.phone); // save selected id to input
           $('#employer_email').val(ui.item.email);
           $('#employer_adress').val(ui.item.adress);
           $('#name_employer').val(ui.item.type);
          
           return false;
        }
      
      });


    $("#serv_descriptionx" ).autocomplete({
                source: function( request, response ) {
          // Fetch data
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          $.ajax({
            url:"{{url('/')}}/items/search",
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
          $('#request_items_id').val(ui.item.id);
          $('#request_name').val(ui.item.name);
          $('#request_description').val(ui.item.description); 
          $('#request_price').val(ui.item.prices);
          $('#request_qty').val('');
          $('#request_total_prices').val('');          
           return false;
        }
      
      });


    
      /* Create bill */
   
   
   
   
    $('#createNewItem').click(function () {
        $('#ajaxModel').modal('show');
        $( "#itemx" ).empty();
        $('#saveBtn').val("Create");
        $('#Item_idbill').val('');
        $('#employer_id').val('');
        $('#request_number').val('');
        $('#ItemForm').trigger("reset");
        $('#modelHeading').html("Create New Item");
        var item =2;
        $("#level option[value="+ item +"]").removeAttr("selected");
        $("#level option[value="+ item +"]").attr("selected",true);
        $("#actions").removeAttr("value");
        $("#actions").attr("value","1");        
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
        window.open("{{url('/')}}/pdf/previewresquest?"+formdata, '_blank');          
    });




    $('#savestatusBtn').click(function (e) {
        e.preventDefault();      
       // $(this).html('Sending..');    
        $.ajax({
          data: $('#ItemForm4').serialize(),
          url: "{{ route('request.status') }}",
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


         /* Edit bill     */

    $('body').on('click', '.editItem', function (e) {
        e.preventDefault();     
        $("#saveBtn").removeAttr("disabled"); 
        var Item_id = $(this).data('id');
        $.get("{{ route('request.index') }}" +'/' + Item_id +'/edit', function (data) {  //   console.log('data:', data);
            $('#modelHeading').html("Edit Bill");
            $('#saveBtn').val("Save Changes");
            $('#ajaxModel').modal('show');
                $('#Item_idbill').val(data.id);
                $('#employer_id').val(data.employer_id);
                $('#employer_name').val(data.employer_name);
                $('#employer_adress').val(data.employer_adress);
                $('#employer_phone').val(data.employer_phone);
                $('#employer_email').val(data.employer_email);
                $('#email_employer').val(data.email_employer);
                $('#name_employer').val(data.name_employer);
                $('#position_employer').val(data.position_employer);
                $('#phone_employer').val(data.phone_employer);


                listItem(data.id);

                $('#request_number').val(data.request_number);
                $('#request_description').val(data.request_description);
                $('#request_total').val(data.request_total);
                $('#request_subtotal').val(data.request_subtotal); 
                $('#request_tax').val(data.request_tax);
                $('#request_taxes_num').val(data.request_taxes_num);   
                $("#request_type option[value="+ data.request_type +"]").attr("selected",true);
                $("#request_status option[value="+ data.request_status +"]").attr("selected",true);
                $("#actions").removeAttr("value");
                $("#actions").attr("value","2");        
        });
        
    });
    $('#itemx').on('click', '.remove_button', function(e){
				e.preventDefault();                
                var itemid = $(this).data('idx');              
                $.ajax({
                    type: "POST",
                    url: "{{url('/')}}/request/delet", 
                    data: {'id': itemid},
                    success: function (data) {
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
        $.get("{{ route('requestitem.index') }}" +'/' + id +'/edit', function (data) {  //   console.log('data:', data);
          for(var i = 0; i < data.length; i++) {           
                var out;          
                    out = ' <div class="row" style="margin-right: 0px; margin-left: 0px;"><div class="col-sm-1" >  <div class="form-group "><input type="hidden"  value="' + data[i].id + '" name="id_tb[]" id="id_tb[]"/><input type="text" class="form-control " id="request_items_id[]" name="request_items_id[]"  value="' + data[i] .request_items_id + '" maxlength="50" required="" readonly></div> </div> ';
                    out += '<div class="col-sm-2" >  <div class="form-group"><input type="text" class="form-control " id="request_name[]" name="request_name[]"  value="' + data[i] .request_name + '" maxlength="50" required="" readonly></div> </div>';
                    out += '<div class="col-sm-3" >  <div class="form-group"><input type="text" class="form-control " id="request_description[]" name="request_description[]"  value="' + data[i] .request_description + '" maxlength="50" required="" readonly></div> </div>';
                    out += '<div class="col-sm-1" >  <div class="form-group"><input type="text" class="form-control " id="request_qty[]" name="request_qty[]"  value="' + data[i] .request_qty + '" maxlength="50" required="" readonly></div> </div>';
                    out += '<div class="col-sm-1" >  <div class="form-group"><input type="text" class="form-control " id="request_price[]" name="request_price[]"  value="' + data[i].request_price  + '" maxlength="50" required="" readonly></div> </div>';
                    out += '<div class="col-sm-1" >  <div class="form-group"><input type="text" class="form-control itemsx" id="request_total_prices[]" name="request_total_prices[]"  value="' + data[i] .request_total_prices + '" maxlength="50" required="" readonly> </div> </div>';
                    out += '<div class="col-sm-1" >  <div class="form-group"><a href="javascript:void(0)" data-toggle="tooltip"  data-idX="' + data[i].id + '" data-original-title="Delete" class="btn btn-danger btn-sm remove_button">x</a> </div> </div>';
                    out += '</div>';
             $('#itemx').append(out);   
          }         
      });
    }



    $('body').on('click', '.statusItem', function () {
        var Item_id = $(this).data('id');
        $.get("{{ route('request.index') }}" +'/' + Item_id +'/edit', function (data) {  //   console.log('data:', data);
            $('#modelHeading').html("Edit Status");
            $('#savestatusBtn').val("Save Changes");
            $('#ajaxModel4').modal('show');
                $('#Item_idt').val(data.id);             
                $("#request_type option[value="+ data.request_type +"]").attr("selected",true);
       
     
        });
        
    });
  
    select = document.getElementById("request_tax");
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

    function calcular_total(){
        sub_total = 0;
        iva = 0;
        //discount = 0;
        
        tasa = $("#request_tax").val(); 
       // discount = $("#discount").val();
            $(".itemsx").each(
                function(index, value) {
                    sub_total = sub_total + eval( reverseFormatNumber($(this).val(),'de') );
                    }
                );
          var iva = (sub_total * tasa)/100;
        //  var dis = (sub_total * discount)/100;          
          var total = sub_total + iva;


            var sub_totalformat = new Intl.NumberFormat('de-DE',{ minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(sub_total);
            var ivaformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(iva);
          //  var disformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(dis);
            var totalformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(total);
            
                $("#request_subtotal").val(sub_totalformat);
                $("#request_taxes_num").val(ivaformat);
               // $("#bill_discount").val(disformat);
                $("#request_total").val(totalformat);
        }


        function update_total(){
            sub_total = 0;
            iva  = 0;
         //   discount = 0;

            tasa = $("#request_tax").val();        
          //  discount = $("#discount").val();
             $(".itemsx").each(
                function(index, value) {
                    sub_total = sub_total + eval( reverseFormatNumber($(this).val(),'de') );
                    }
                );
          var iva = (sub_total * tasa)/100;
        //  var dis = (sub_total * discount)/100;          
          var total = sub_total + iva;


            var sub_totalformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(sub_total);
            var ivaformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(iva);
         //   var disformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(dis);
            var totalformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(total);
            
                $("#request_subtotal").val(sub_totalformat);
                $("#request_taxes_num").val(ivaformat);
             //   $("#bill_discount").val(disformat);
                $("#request_total").val(totalformat);
        }


        function listServises(){
        $("#request_description").empty();
        $("#request_description").append('<option></option>');              
        $.get("{{url('/')}}/items/show", function (data) {  //   console.log('data:', data);
          for(var i = 0; i < data.length; i++) {
            var out = '<option  value ="' + data[i] .id +'">' + data[i].description + ' </option>';
             $('#request_description').append(out);              
                }         
            });
        }

    $('#request_tax').on('change', function() {      
        update_total();
    });

  /*  $('#discount').on('change', function() {      
        update_total();
    }); */
         /* Edit bill  -   Cal prices - Add Items */
    
    $('#request_qty').on('change', function() {
        var num = reverseFormatNumber($('#request_price').val(),'de');
        var num2 = $('#request_qty').val();
        var sum = num * num2; 
        var  value = parseFloat(sum).toFixed(2);      
        var sumformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(value);
        $('#request_total_prices').val(sumformat);
    });


    $('#request_price').on('change', function() {
        var num = reverseFormatNumber($('#request_price').val()  ,'de');
        var num2 = $('#request_qty').val();
        var sum = num * num2;  
        var  value = parseFloat(sum).toFixed(2);      
        var sumformat = new Intl.NumberFormat('de-DE',{  minimumFractionDigits: 2,  maximumFractionDigits: 2 }).format(value);
        $('#request_total_prices').val(sumformat);
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
          $('#request_price').val('');
          $('#request_qty').val('');
          $('#request_total_prices').val('');
        listServises();
        $('#addBtn').html('Save');
        $("#actions").removeAttr("value");
        $("#actions").attr("value","1");
        
    });


    $('#addBtn').click(function (e) {
        e.preventDefault();       

            if($("#request_qty").val().length < 1) {  
                alert("El Cantidad es obligatorio");
                $("#request_qty").css({'border':'1px solid #f70a0a'});
  
                return false;  
            }  
            if(isNaN($("#request_qty").val())) {  
                alert("El Cantidad solo debe contener números");  
                $("#request_qty").css({'border':'1px solid #f70a0a'});

                return false;  
            }

        $(this).html('Sending..');    
                 
        var item1 =  $('#request_items_id').val();
        var item2 =  $('#request_name').val();
        var item3 =  $('#request_description :selected').text();
        var item4 =  $('#request_qty').val();
        var item5 =  $('#request_price').val();
        var item6 =  $('#request_total_prices').val();

        var out;          
             out = ' <div class="row" style="margin-right: 0px; margin-left: 0px;"><div class="col-sm-1" >  <div class="form-group"><input type="hidden"  value="" name="id_tb[]" id="id_tb[]"/><input type="text" class="form-control" id="request_items_id[]" name="request_items_id[]"  value="' +item1 + '" maxlength="50" required="" readonly></div> </div> ';
             out += '<div class="col-sm-2" >  <div class="form-group"><input type="text" class="form-control" id="request_name[]" name="request_name[]"  value="' + item2 + '" maxlength="50" required="" readonly></div> </div>';
             out += '<div class="col-sm-3" >  <div class="form-group"><input type="text" class="form-control" id="request_description[]" name="request_description[]"  value="' + item3 + '" maxlength="50" required="" readonly></div> </div>';
             out += '<div class="col-sm-1" >  <div class="form-group"><input type="text" class="form-control" id="request_qty[]" name="request_qty[]"  value="' + item4 + '" maxlength="50" required="" readonly></div> </div>';
             out += '<div class="col-sm-1" >  <div class="form-group"><input type="text" class="form-control" id="request_price[]" name="request_price[]"  value="' + item5 + '" maxlength="50" required="" readonly></div> </div>';
             out += '<div class="col-sm-1" >  <div class="form-group"><input type="text" class="form-control itemsx" id="request_total_prices[]" name="request_total_prices[]"  value="' +item6 + '" maxlength="50" required="" readonly></div> </div>';
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
          url: "{{url('/')}}/items",
          type: "POST",
          dataType: 'json',
          success: function (data) {    
           // console.log('Exito:', data); 
              $('#ItemForm2').trigger("reset");
              $('#ajaxModel2').modal('hide');
              var out;          
                out = ' <div class="row" style="margin-right: 0px; margin-left: 0px;"><div class="col-sm-1" >  <div class="form-group"><input type="hidden"  value="" name="id_tb[]" id="id_tb[]"/><input type="text" class="form-control" id="request_items_id[]" name="request_items_id[]"  value="' +data.id + '" maxlength="50" required="" readonly></div> </div> ';
                out += '<div class="col-sm-2" >  <div class="form-group"><input type="text" class="form-control" id="request_name[]" name="request_name[]"  value="' + data.name + '" maxlength="50" required="" readonly></div> </div>';
                out += '<div class="col-sm-3" >  <div class="form-group"><input type="text" class="form-control" id="request_description[]" name="request_description[]"  value="' + data.description + '" maxlength="50" required="" readonly></div> </div>';
                out += '<div class="col-sm-1" >  <div class="form-group"><input type="text" class="form-control" id="request_qty[]" name="request_qty[]"  value="' + item1 + '" maxlength="50" required="" readonly></div> </div>';
                out += '<div class="col-sm-1" >  <div class="form-group"><input type="text" class="form-control" id="request_price[]" name="request_price[]"  value="' + data.prices + '" maxlength="50" required="" readonly></div> </div>';
                out += '<div class="col-sm-1" >  <div class="form-group"><input type="text" class="form-control itemsx" id="request_total_prices[]" name="request_total_prices[]"  value="' +item2 + '" maxlength="50" required="" readonly> </div> </div>';
                out += '<div class="col-sm-1" >  <div class="form-group"><a href="javascript:void(0)" data-toggle="tooltip"  data-idX="' + data.id+ '" data-original-title="Delete" class="btn btn-danger btn-sm remove_buttonx">x</a> </div> </div>';
                out += '</div>';
             $('#itemx').append(out); 
             Swal.fire("item added successfully", "", "success");
             calcular_total();

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
         
         if($("#employer_name").val().length < 1) {  
                alert("No debe estar vacio");  
                $("#employer_name").css({'border':'1px solid #f70a0a'});
                return false;  
            } 
           if($("#employer_name").val().length < 5) {  
                alert("El nombre debe tener como mínimo 5 caracteres");  
                $("#employer_name").css({'border':'1px solid #f70a0a'});

                return false;  
            }  
            if($("#employer_phone").val().length < 1) {  
                alert("El teléfono es obligatorio");
                $("#employer_phone").css({'border':'1px solid #f70a0a'});
  
                return false;  
            }  

            if(isNaN($("#employer_phone").val())) {  
                alert("El teléfono solo debe contener números");  
                $("#employer_phone").css({'border':'1px solid #f70a0a'});

                return false;  
            } 
            if($("#employer_phone").val().length < 9) {  
                alert("El teléfono debe tener 9 caracteres. Ej. 666112233");  
                $("#employer_phone").css({'border':'1px solid #f70a0a'});

                return false;  
            }  
            if($("#employer_email").val().length < 1) {  
                alert("La dirección e-mail es obligatoria");  
                $("#employer_email").css({'border':'1px solid #f70a0a'});

                return false;  
            } 
            if($("#employer_email").val().indexOf('@', 0) == -1 || $("#employer_email").val().indexOf('.', 0) == -1) {  
                alert("La dirección e-mail parece incorrecta");  
                $("#employer_email").css({'border':'1px solid #f70a0a'});
                return false;  
            }  

          
            if($("#employer_adress").val().length < 1) {  
                alert("No debe estar vacio"); 
                $("#employer_adress").css({'border':'1px solid #f70a0a'});
 
                return false;  
            } 
            
            if($("#employer_adress").val().length < 5) {  
                alert("El nombre debe tener como mínimo 5 caracteres");  
                $("#employer_adress").css({'border':'1px solid #f70a0a'});

                return false;  
            } 


            if($("#email_employer").val().length < 1) {  
                alert("La dirección e-mail es obligatoria");  
                $("#email_employer").css({'border':'1px solid #f70a0a'});

                return false;  
            } 
            if($("#email_employer").val().indexOf('@', 0) == -1 || $("#email_employer").val().indexOf('.', 0) == -1) {  
                alert("La dirección e-mail parece incorrecta");  
                $("#email_employer").css({'border':'1px solid #f70a0a'});
                return false;  
            }  



            if($("#name_employer").val().length < 1) {  
                alert(" La propiedad No debe estar vacio"); 
                $("#name_employer").css({'border':'1px solid #f70a0a'});
 
                return false;  
            } 
            if($("#position_employer").val().length < 3) {  
                alert("La propiedad debe tener como mínimo 5 caracteres");  
                $("#position_employer").css({'border':'1px solid #f70a0a'});

                return false;  
            } 


            
            if($("#position_employer").val().length < 1) {  
                alert(" La propiedad No debe estar vacio"); 
                $("#position_employer").css({'border':'1px solid #f70a0a'});
 
                return false;  
            } 
            if($("#position_employer").val().length < 3) {  
                alert("La propiedad debe tener como mínimo 5 caracteres");  
                $("#position_employer").css({'border':'1px solid #f70a0a'});

                return false;  
            } 

            if($("#phone_employer").val().length < 1) {  
                alert("El teléfono es obligatorio");
                $("#phone_employer").css({'border':'1px solid #f70a0a'});
  
                return false;  
            }  

            if(isNaN($("#phone_employer").val())) {  
                alert("El teléfono solo debe contener números");  
                $("#phone_employer").css({'border':'1px solid #f70a0a'});

                return false;  
            } 
            if($("#phone_employer").val().length < 9) {  
                alert("El teléfono debe tener 9 caracteres. Ej. 666112233");  
                $("#phone_employer").css({'border':'1px solid #f70a0a'});

                return false;  
            }  

            var disabled = $("#saveBtn").prop("disabled")            
           $('#saveBtn').attr("disabled", true);

           
        //$(this).html('Sending..');    
        $.ajax({
          data: $('#ItemForm').serialize(),
          url: "{{ route('request.store') }}",
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
                    url: "{{route('request.store')}}"+'/'+id,
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
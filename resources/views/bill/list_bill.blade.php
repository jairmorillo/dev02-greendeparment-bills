@extends('adminlte::page')
@section('title', 'Customer')
@section('content_header')
    <h1>Payments received this month  </h1>
    <div class="row" style="margin-top: 20px;">        
    <div class="col-md-3 estimates">
        Full Paid:<span> @money($mes_act_t)</span>
        </div>
        <div class="col-md-3 estimates1 ">
        Partally Paid:<span> @money($mes_act_p)</span>
        </div>
        <div class="col-md-3 estimates2">  
        Total: <span> @money($mes_act)</span>
        </div>    
    </div>
@stop
@section('content')
<style>
 .estimates span {
    display: block;
    background: #d6b824;
    padding: 10px;
    color: #fff;
    font-size: 20px;
    font-weight: 700;
    border-radius: 11px;
    margin-top: 10px;
    width: 100%;
}
.estimates1 span {
    display: block;
    background: #3d86e2;
    padding: 10px;
    color: #fff;
    font-size: 20px;
    font-weight: 700;
    border-radius: 11px;
    margin-top: 10px;
    width: 100%;
}
.estimates2 span {
    display: block;
    background: #009544;
    padding: 10px;
    color: #fff;
    font-size: 20px;
    font-weight: 700;
    border-radius: 11px;
    margin-top: 10px;
    width: 100%;
}
.mt-5, .my-5 {
    margin-top: 0rem!important;
}
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
                </h4>
            </div>
         </div>
         <div class="card-body">
         <table class="table table-bordered data-table"  width="100%">
                <thead>
                    <tr>
                        <th width="3%">No</th>
                        <th width="5%">Number</th>
                        <th  width="15%" >Customer</th>
                        <th  width="15%">Total</th>
                        <th  width="15%">Paid</th>
                        <th width="15%">Date</th>
                        <th width="15%">to pay</th>
                        <th width="10%">Status</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>



        <div class="modal fade" id="ajaxModel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelHeading"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="ItemForm" name="ItemForm" class="form-horizontal">
                           <input type="hidden" name="Item_id" id="Item_id">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="cust_name" name="cust_name" placeholder="Enter Name" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Adress</label>
                                <div class="col-sm-12">
                                    <textarea id="cust_adress" name="cust_adress" required="" placeholder="Enter descriptions" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Phone</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="cust_phone" name="cust_phone" placeholder="Enter Name" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="cust_email" name="cust_email" placeholder="Enter Name" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label">Type Property</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="cust_type_property" name="cust_type_property" placeholder="Enter Name" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="col-sm-offset-2 col-sm-10">
                             <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                             </button>
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
</body>




@stop

@section('css')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>     
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

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
  $(function () {
     
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    

     
    var table = $('.data-table').DataTable({
        processing: false,
        serverSide: true,
        ajax: "{{url('/')}}/dashboard/money",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'bill_number_p', name: 'bill_number_p'},
            {data: 'customer_name', name: 'customer_name'},
           // {data: 'bill_description', name: 'bill_description'},             
            {data: 'bill_total_p', name: 'bill_total_p'},
            {data: 'partial_payment_mont', name: 'partial_payment_mont'},
            {data: 'partial_payment_date', name: 'partial_payment_date'}, 
            {data: 'partial_payment_rest', name: 'partial_payment_rest'}, 
            {data: 'bill_type_p', name: 'bill_type_p',
            orderable: true, 
            searchable: false},
        ],
        initComplete: function(){    
    // Have this variable accessible for the whole initComplete
    var column;    
    // Iterate the column
    this.api().columns([7]).every( function(){
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
                            if( data.bill_type_p == 'PAID'  ){
                                $(row).css({'background-color': '#a2f181','color': '#000'});
                            }
                            else if( data.bill_type_p == 'PARTIALLY-PAID' ){
                                $(row).css('background-color', '#6eaeff');
                            }
                            else if( data.bill_type_p == 'PENDING' ){
                                $(row).css('background-color', '#ffef9a');
                            }
                            else if ( data.bill_type_p == 'ANULATED' ){
                                $(row).css({'background-color': '#ea4741','color': '#FFF'});
                            }
                            else{
                                $(row).css('background-color', '#fff');
                            }
                     },
}); 
    

    
  

  


     
  });
</script>
@stop
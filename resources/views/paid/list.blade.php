@extends('adminlte::page')
@section('title', 'Transaction')
@section('content_header')
    <h1>Transaction</h1>
@stop

@section('content')

<div class="row">


                
                   
     <div class="col-md-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success fade in alert-dismissible show">                
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true" style="font-size:20px">×</span>
                                        </button>
                                        {{ $message}}
                </div>
                    @endif
       <div class="card mt-5">
         <div class="card-header">

            <div class="col-md-12">
                <h4 class="card-title"> 
                  <a class="btn btn-success ml-5" href="/transaction/create" id="createNewItem"> Create New Item</a>
                </h4>

             
            </div>
         </div>
         <div class="card-body">
           <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Code</th>
                        <th>Customer</th>
                        <th>Description</th>
                        <th>Total</th>
                        <th>to Pay</th>
                        <th>Status</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>       
       </div>
     </div>
   </div>
 </div>
</body>




@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@stop
@section('js')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('js/jquery-mask-plugin-master/src/jquery.mask.js') }}"></script>

<script type="text/javascript">





 $('#prices').mask('000.000.000.000.000,00', {reverse: true});

  $(function () {
     
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('transaction.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'payment_bill_code', name: 'payment_bill_code'},
            {data: 'payment_bill_customer', name: 'payment_bill_customer'},
            {data: 'payment_bill_description', name: 'payment_bill_description'},
            {data: 'payment_bill_total', name: 'payment_bill_total'},
            {data: 'amount', name: 'amount'},
            {data: 'payment_transaction_status', name: 'payment_transaction_status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     


 

    
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
            }).then(function(result) {

                if (result.value) {                    
                    var Item_id = $(that).data("id");
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('transaction.store') }}/"+Item_id,
                        success: function (data) {
                            table.draw();
                            },
                        error: function (data) {
                        swal("Uff something went wrong", "", "error");
                            console.log('Error:', data);
                        }
                    });
                }else {
                    return false;
                }


            })
        });


        function copy(id_elemento) {
        var aux = document.createElement("input");
                    aux.setAttribute("value", document.getElementById(id_elemento).value);
                    document.body.appendChild(aux);
                    aux.select();
                    document.execCommand("copy");
                    document.body.removeChild(aux);
                    Swal.fire({
                        type: "success",
                        title: 'Url was successfully copied to clipboard',
                        showConfirmButton: false,
                        timer: 1500
                        })

        }

        $('body').on('click', '.copy', function () {    
            copy('p2');
         });  


        
    $('body').on('click', '.enlace', function () {
        var Item_id = $(this).data('id');
    
        const urlState = "{{ route('transaction.index') }}" +'/show/' + Item_id +'';
                    fetch(urlState, {
                        method: 'GET',
                      })
                      .then(res => res.json())
                      .then(data => {
                       
                      console.log(data);
                      const urlpay = '{{ URL::to('/') }}/pay/'+ data.payment_token;
                      const id='p2';
                      var htmlInput ;
                            htmlInput +='<div class="input-group mb-3"><input type="text" id="p2" class="form-control" value="'+urlpay+'">';
                            htmlInput +='<div class="input-group-append">';
                            htmlInput +='<button class="btn btn-outline-secondary copy" type="button"  >Copy</button>';
                            htmlInput +='</div>';
                            htmlInput +='</div>';
                      Swal.fire({
                            title: 'Here you can copy the payment link',
                            type: "success",
                            html: htmlInput
                            });
 
                     
                      })
                      .catch(function(error) {
                        console.error("¡Error!", error);
                      })
        
    });  



     
  });
</script>
    <script> console.log('Hi!'); </script>
@stop
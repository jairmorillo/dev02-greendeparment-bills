@extends('adminlte::page')
@section('title', 'Transaction')
@section('content_header')
    <h1>Create Transaction</h1>
@stop

@section('content')




<div class="row">
     <div class="col-md-12">
       <div class="card mt-5">
         <div class="card-header">
            <div class="col-md-12">
                <h4 class="card-title"> 
                    New Transaction
                </h4>
            </div>
         </div>
         <div class="card-body">
         @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('transaction.store') }}">
      <input type="hidden" class="form-control" name="payment_bill_id" id="payment_bill_id"  value=""/>
      <input type="hidden" class="form-control" name="payment_transaction_status" id="payment_transaction_status" value="PENDING" />
      <input type="hidden" class="form-control" name="payment_bill_code" id="payment_bill_code" value="PENDING" />
      <input type="hidden" class="form-control" name="idt" id="idt"  value=""/>

      @csrf

         <div class="form-group">
         <label for="country_name">Bill Number:</label>
         <select id="payment_bill_num"  name="payment_bill_num"  class="form-control">
         <option value="">-Select Bill-</option>   
            @foreach($bill as $select)
                @if ($select->bill_type === 'PAID' )
                @elseif ($select->bill_type === 'ANULATED')
                @elseif ($select->bill_type === 'DRAFT')
                @else
                    <option value="{{ $select->id }}">{{ $select->bill_number }}</option>
                @endif
            @endforeach
        </select>
         </div>
           
      
          <div class="form-group">
              <label for="country_name">Customer  Name:</label>
              <input type="text" class="form-control" name="payment_bill_customer" id="payment_bill_customer" readonly/>
          </div>
          <div class="form-group">
              <label for="symptoms">Description :</label>
              <input type="text" class="form-control" name="payment_bill_description" id="payment_bill_description" readonly >
          </div>
          <div class="form-group">
              <label for="cases">Total :</label>
              <input type="text" class="form-control" name="payment_bill_total" id="payment_bill_total"  value="0,00" readonly/>
          </div>
          <div class="form-group">
              <label for="cases">Last paid :</label>
              <input type="text" class="form-control" name="payment_partial_payment_mont" id="payment_partial_payment_mont"   value="0,00" readonly/>
          </div>
          <div class="form-group">
              <label for="cases">Outstanding balance :</label>
              <input type="text" class="form-control" name="payment_partial_payment_rest" id="payment_partial_payment_rest" value="0,00" readonly/>
          </div>
          <div class="form-group">
              <label for="cases">Amount :</label>
              <input type="text" class="form-control" name="amount"   value="0,00"  id="amount"/>
          </div>
          <button type="submit" class="btn btn-primary">Generate payment link </button>
      </form>
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
 $('#amount').mask('000.000.000.000.000,00', {reverse: true});

  $(function () {
     
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });  
    
    $('select#payment_bill_num').on('change',function(){
        var id = $(this).val();
                      $('#payment_bill_code').val('');
                      $('#payment_bill_customer').val('');
                      $('#payment_bill_description').val('');
                      $('#payment_bill_total').val('0,00');
                      $('#payment_partial_payment_mont').val('0,00');
                      $('#payment_partial_payment_rest').val('0,00');
        billInfo(id);
      });



     function billInfo(id){      
       
              console.log(id);

                  const urlState = "{{ route('bill.index') }}" +'/' + id +'/edit';
                    fetch(urlState, {
                        method: 'GET',
                      })
                      .then(res => res.json())
                      .then(data => {
                       
                      console.log(data);
                      $('#payment_bill_id').val(data.id);
                      $('#payment_bill_code').val(data.bill_number);
                      $('#payment_bill_customer').val(data.customer_name);
                      $('#payment_bill_description').val(data.bill_description);
                      $('#payment_bill_total').val(data.bill_total);
                      $('#payment_partial_payment_mont').val(data.partial_payment_mont);
                      $('#payment_partial_payment_rest').val(data.partial_payment_rest);

      
                      })
                      .catch(function(error) {
                        console.error("¡Error!", error);
                      })

     }





    
  });
</script>
    <script> console.log('Hi!'); </script>
@stop
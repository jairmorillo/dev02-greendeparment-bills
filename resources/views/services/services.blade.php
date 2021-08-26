@extends('adminlte::page')
@section('title', 'Services')
@section('content_header')
    <h1>Services</h1>
@stop

@section('content')
  <style>
      .modal-dialog {
        max-width: 601px !important;
        margin: 1.75rem auto;
        }
  </style>
<div class="row">
     <div class="col-md-12">
       <div class="card mt-5">
         <div class="card-header">
            <div class="col-md-12">
                <h4 class="card-title"> 
                  <a class="btn btn-success ml-5" href="javascript:void(0)" id="createNewItem"> Create New Item</a>
                </h4>
            </div>
         </div>
         <div class="card-body">
           <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Name</th>
                        <th>Descriptions</th>
                        <th>Unit</th>
                        <th>Prices</th>
                        <th width="15%">Action</th>
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
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">descriptions</label>
                                <div class="col-sm-12">
                                    <textarea id="description" name="description" required="" placeholder="Enter descriptions" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Unit</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="unit" name="unit" placeholder="Enter Name" value="" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Prices</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="prices" name="prices" placeholder="Enter Name" value="" maxlength="50" required="">
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
        processing: false,
        serverSide: true,
        ajax: "{{ route('services.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'description', name: 'description'},
            {data: 'unit', name: 'unit'},
            {data: 'prices', name: 'prices'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     
    $('#createNewItem').click(function () {
        $('#ajaxModel').modal('show');
        $('#saveBtn').val("create-Item");
        $('#Item_id').val('');
        $('#ItemForm').trigger("reset");
        $('#modelHeading').html("Create New Item");
        
    });
    
    $('body').on('click', '.editItem', function () {
      var Item_id = $(this).data('id');
      $.get("{{ route('services.index') }}" +'/' + Item_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Item");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#Item_id').val(data.id);
          $('#name').val(data.name);
          $('#description').val(data.description);
          $('#unit').val(data.unit);
          $('#prices').val(data.prices);
      })
   });
    
    $('#saveBtn').click(function (e) {
        e.preventDefault();
      //  $(this).html('Sending..');
    
        $.ajax({
          data: $('#ItemForm').serialize(),
          url: "{{ route('services.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#ItemForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
    
   /* $('body').on('click', '.deleteItem', function () {
     
        var Item_id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('services.store') }}"+'/'+Item_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
*/



    
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
                        url: "{{ route('services.store') }}/"+Item_id,
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


     
  });
</script>
    <script> console.log('Hi!'); </script>
@stop
@extends('adminlte::page')
@section('title', 'Users')
@section('content_header')
    <h1>Users</h1>
@stop

@section('content')
  <style>
      .modal-dialog {
        max-width: 701px !important;
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
                        <th>user_id</th>
                        <th>Name</th>
                        <th>Email</th>
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
                                <label class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-12">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="" maxlength="50" required="">

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-12">
                                    <input type="password" class="form-control" id="password" name="password" value="" maxlength="50" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Level</label>
                                <div class="col-sm-12">
                                    <select  id="level" name="level" class="form-control">
                                      <option value="2" >User<option>
                                      <option value="1" >Admin<option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" id="actions" name="actions" value="1">

                            <div class="col-sm-offset-2 col-sm-10">
                             <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
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
<link rel="stylesheet" href="/css/app.css">
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
    <script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>

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
        ajax: "{{ route('users.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'user_id', name: 'user_id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     
    $('#createNewItem').click(function () {
        $('#ajaxModel').modal('show');
        $('#saveBtn').val("create-Item");
        $('#Item_id').val('');
        $('#ItemForm').trigger("reset");
        $('#modelHeading').html("Create New Item");
        var item =2;
        $("#level option[value="+ item +"]").removeAttr("selected");
        $("#level option[value="+ item +"]").attr("selected",true);
        $("#actions").removeAttr("value");
        $("#actions").attr("value","1");

        
    });
    
    $('body').on('click', '.editItem', function () {
      var Item_id = $(this).data('id');
      $.get("{{ route('users.index') }}" +'/' + Item_id +'/edit', function (data) {  //   console.log('data:', data);
          $('#modelHeading').html("Edit Item");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#Item_id').val(data[0].user_id);
          $('#name').val(data[0].name);
          $('#email').val(data[0].email);
          $('#password').val(data[0].password);
          
          if(data[0].role_id== 1){
            var item =2;
            $("#level option[value="+ item +"]").removeAttr("selected");
            $("#level option[value="+ data[0].role_id +"]").attr("selected",true);
          }else{
            var item =1;
            $("#level option[value="+ item +"]").removeAttr("selected");
            $("#level option[value="+ data[0].role_id +"]").attr("selected",true);
          }
            $("#actions").removeAttr("value");
            $("#actions").attr("value","2");
 });

     
   });
    
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');    

        $.ajax({
          data: $('#ItemForm').serialize(),
          url: "{{ route('users.store') }}",
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
    
/*$('body').on('click', '.deleteItem', function () {
     
        var Item_id = $(this).data("id");
        //confirm("Are You sure want to delete !");
         swal("Are You sure want to delete !", "You clicked the button!", "error");

      
        $.ajax({

            type: "DELETE",
            url: "{{ route('users.store') }}"+'/'+Item_id,
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
            }).then(function(result) {

                if (result.value) {                    
                    var Item_id = $(that).data("id");
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('users.store') }}/"+Item_id,
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
@stop
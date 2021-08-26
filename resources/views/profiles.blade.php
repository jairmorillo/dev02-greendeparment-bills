@extends('adminlte::page')
@section('title', 'Profile')
@section('content_header')
    <h1>Profile</h1>
@stop
@section('content')
@foreach($item as $items)

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="https://www.greendepartment.org/assets/green_department_logo.png"
                       style="width:128px; height: 128px;"
                       alt="User profile picture">
                </div>
                <h3 class="profile-username text-center" id="name_label">{{$items->name}}</h3>
                <p class="text-muted text-center">Administrador</p>         
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
  
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
               Information
              </div><!-- /.card-header -->
              <div class="card-body">
              <form class="form-horizontal" id="ItemForm">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                        <input type="hidden" class="form-control" id="id" placeholder="id" name="Item_id" value="{{$items->user_id}}">
                          <input type="email" class="form-control" id="name" name="name" placeholder="Name" value="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="password"  name="password" >
                        </div>
                      </div>
                     
                      <div class="form-group row">
                      <label for="inputName2" class="col-sm-2 col-form-label">Level</label>
                      <div class="col-sm-10">

                              <select  id="level" name="level" class="form-control">
                                      <option value="2" >User<option>
                                      <option value="1" >Admin<option>
                                    </select>
                                    </div>
                      </div>
                 
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="buttom" id="save" class="btn btn-danger">Save</button>
                        </div>
                      </div>
                    </form>
              </div>
            </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    @endforeach

    <!-- /.content -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
   
@stop

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>     
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>  
<script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
<script type="text/javascript">
  $(function () {
     
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    

  
    
 
      var Item_id = $("#id").val();

      $.get("{{ route('users.index') }}" +'/' + Item_id +'/edit', function (data) {  //   console.log('data:', data);
         // $('#id').val(data[0].user_id);
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

     
   
    
    $('#save').click(function (e) {
        e.preventDefault();
        
        $.ajax({
          data: $('#ItemForm').serialize(),
          url: "{{ route('users.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {            
            //$('#ItemForm').trigger("reset");
            //  $('#ajaxModel').modal('hide');
            //  table.draw();     

          $('#name').val(data.name);
          $('#name_label').empty();
          $('#name_label').append(data.name);
          $('#email').val(data.email);
          $('#password').val(data.password);          
          if(data.role_id== 1){
            var item =2;
            $("#level option[value="+ item +"]").removeAttr("selected");
            $("#level option[value="+ data.role_id +"]").attr("selected",true);
          }else{
            var item =1;
            $("#level option[value="+ item +"]").removeAttr("selected");
            $("#level option[value="+ data.role_id +"]").attr("selected",true);
          }    
            $('#save').html('Save Changes');
          },

          error: function (data) {
              console.log('Error:', data);
              $('#save').html('Error  Changes');
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
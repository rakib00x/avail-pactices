@extends('marketing.employee-master')
@section('title','Marketer Product List')
@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="invoice-create-btn mb-1">
            </div>
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Products List</h4>
                                   
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">

                                        <span id="table_data">
                                            

                                        </span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    @endsection
    @section('js')
    <script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>
    <script>
        $( document ).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                'url':"{{ url('/getMaeketerProductData') }}",
                'type':'post',
                'dataType':'text',
                success:function(data){
                    $("#table_data").empty();
                    $("#table_data").html(data);
                }
            });
        });
        
        $(function(){
        $('body').on('click', '#master', function (e) {
            e.preventDefault();
         if($(this).is(':checked',true))  

         {

            $(".sub_chk").prop('checked', true);  

         } else {  

            $(".sub_chk").prop('checked',false);  

         }  

        });
        
        
        
        });


        $(function(){
            $('body').on('click', '.changeProductStatus', function (e) {
                e.preventDefault();

                var product_id = $(this).attr('getProductID');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'url':"{{ url('/changeProductStatus') }}",
                    'type':'post',
                    'dataType':'text',
                    data:{product_id:product_id},
                    success:function(data)
                    {
                        $.ajax({
                            'url':"{{ url('/getMaeketerProductData') }}",
                            'type':'post',
                            'dataType':'text',
                            success:function(data){
                                $("#table_data").empty();
                                $("#table_data").html(data);
                            }
                        });

                        if(data == "success"){
                            toastr.success('Thanks !! The status has activated', { positionClass: 'toast-bottom-full-width', });
                            return false;
                        }else{
                            toastr.error('Thanks !! The status has deactivated', { positionClass: 'toast-bottom-full-width', });
                            return false;
                        }
                    }
                });

            });

        });

        function deleteProductInfo(id){
                var r = confirm("Are You Sure To Delete Product!");
                if (r == true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        'url':"{{ url('/deleteProductInfo') }}",
                        'type':'post',
                        'dataType':'text',
                        data:{product_id:id},
                        success:function(data){

                            if (data == "success") {

                                $.ajax({
                                    'url':"{{ url('/getSupplierProductData') }}",
                                    'type':'post',
                                    'dataType':'text',
                                    success:function(data){
                                        $("#table_data").empty();
                                        $("#table_data").html(data);
                                    }
                                });

                                toastr.success('Thanks !! Product Delete Successfully ', { positionClass: 'toast-bottom-full-width', });
                            }else{
                                toastr.error('Sorry !! Prodcut Not Delete', { positionClass: 'toast-bottom-full-width', });
                                return false;
                            }
                            
                        }
                    });
                } else {
                    toastr.error('Thanks !! Delete Cancel', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }
            }
    </script>
    <script type="text/javascript">

    $(document).ready(function () {


        


        $('.delete_all').on('click', function(e) {


            var allVals = [];  

            $(".sub_chk:checked").each(function() {  

                allVals.push($(this).attr('data-id'));

            });  


            if(allVals.length <=0)  

            {  

                alert("Please select row.");  

            }  else {  


                var check = confirm("Are you sure you want to delete this row?");  

                if(check == true){  


                    var join_selected_values = allVals.join(","); 


                    $.ajax({

                        url: $(this).data('url'),

                        type: 'DELETE',

                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

                        data: 'ids='+join_selected_values,

                        success: function (data) {

                            if (data['success']) {

                                $(".sub_chk:checked").each(function() {  

                                    $(this).parents("tr").remove();

                                });

                                alert(data['success']);

                            } else if (data['error']) {

                                alert(data['error']);

                            } else {

                                alert('Whoops Something went wrong!!');

                            }

                        },

                        error: function (data) {

                            alert(data.responseText);

                        }

                    });


                  $.each(allVals, function( index, value ) {

                      $('table tr').filter("[data-row-id='" + value + "']").remove();

                  });

                }  

            }  

        });


        $('[data-toggle=confirmation]').confirmation({

            rootSelector: '[data-toggle=confirmation]',

            onConfirm: function (event, element) {

                element.trigger('confirm');

            }

        });


        $(document).on('confirm', function (e) {

            var ele = e.target;

            e.preventDefault();


            $.ajax({

                url: ele.href,

                type: 'DELETE',

                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

                success: function (data) {

                    if (data['success']) {

                        $("#" + data['tr']).slideUp("slow");

                        alert(data['success']);

                    } else if (data['error']) {

                        alert(data['error']);

                    } else {

                        alert('Whoops Something went wrong!!');

                    }

                },

                error: function (data) {

                    alert(data.responseText);

                }

            });


            return false;

        });

    });

</script>
    @endsection
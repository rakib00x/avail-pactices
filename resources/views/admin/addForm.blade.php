@extends('admin.masterAdmin')
@section('title','Social Media')
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- users list start -->
            <section class="users-list-wrapper">
                <div class="users-list-filter px-1">
                    <div class="row border rounded py-2 mb-2">
                        <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
                            <h5>Add New Form</h5>
                        </div>
                    </div>
                </div>
    <div class="col-sm-12">
        <div class="panel">
            <div class="panel-body">
                <form action="" method="post">
                  
                    <div class="row">
                        <div class="col-lg-8 form-horizontal" id="form">
                               <!--      <div class="form-group" style="background:rgba(0,0,0,0.1);padding:10px 0;">
                                        <input type="hidden" name="type[]" value="">
                                        <div class="col-lg-12">
                                            <label class="control-label">Text</label>
                                        </div>
                                        <div class="col-lg-10">
                                            <input class="form-control" type="text" name="label[]" value="" placeholder="Label">
                                        </div> 
                                    </div>
                                    <div class="form-group" style="background:rgba(0,0,0,0.1);padding:10px 0;">
                                        <input type="hidden" name="type[]" value="">
                                        <input type="hidden" name="option[]" class="option" value="">
                                        <div class="col-lg-3">
                                            <label class="control-label"></label>
                                        </div>
                                        <div class="col-lg-7">
                                            <input class="form-control" type="text" name="label[]" value="" placeholder="Select Label" style="margin-bottom:10px">
                                            <div class="customer_choice_options_types_wrap_child">
                                                        <div class="form-group">
                                                            <div class="col-sm-6 col-sm-offset-4">
                                                                <input class="form-control" type="text" name="" value="" required="">
                                                            </div>
                                                            <div class="col-sm-2"> <span class="btn btn-icon btn-circle icon-lg fa fa-times" onclick="delete_choice_clearfix(this)"></span></div>
                                                        </div>
                                            </div>
                                            <button class="btn btn-success pull-right" type="button" onclick="add_customer_choice_options(this)"><i class="glyphicon glyphicon-plus"></i> Add option</button>
                                        </div>
                                        <div class="col-lg-2"><span class="btn btn-icon btn-circle icon-lg fa fa-times" onclick="delete_choice_clearfix(this)"></span></div>
                                    </div> -->
                                    
                        </div>
                        <div class="col-lg-4">
                            <ul class="list-group">
                                <li class="list-group-item btn" style="text-align: left;" onclick="appenddToForm('text')">{{__('Text Input')}}</li>
                                <li class="list-group-item btn" style="text-align: left;" onclick="appenddToForm('select')">{{__('Select')}}</li>
                                <li class="list-group-item btn" style="text-align: left;" onclick="appenddToForm('multi-select')">{{__('Multiple Select')}}</li>
                                <li class="list-group-item btn" style="text-align: left;" onclick="appenddToForm('radio')">{{__('Radio')}}</li>
                                <li class="list-group-item btn" style="text-align: left;" onclick="appenddToForm('file')">{{__('File')}}</li>
                            </ul>
                        </div>
                    </div><br>
                    <div class="panel-footer text-right">
                        <button class="btn btn-success" type="submit">{{__('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
            </section>
            <!-- users list ends -->
        </div>
    </div>
</div>
<!-- END: Content-->
    <script type="text/javascript">

        var i = 0;

        function add_customer_choice_options(em){
            var j = $(em).closest('.form-group').find('.option').val();
            var str = '<div class="form-group">'
                            +'<div class="col-sm-6 col-sm-offset-4">'
                                +'<input class="form-control" type="text" name="options_'+j+'[]" value="" required>'
                            +'</div>'
                            +'<div class="col-sm-2"> <span class="btn btn-icon btn-circle icon-lg fa fa-times" onclick="delete_choice_clearfix(this)"></span>'
                            +'</div>'
                        +'</div>'
            $(em).parent().find('.customer_choice_options_types_wrap_child').append(str);
        }
        function delete_choice_clearfix(em){
            $(em).parent().parent().remove();
        }
        function appenddToForm(type){
            //$('#form').removeClass('seller_form_border');
            if(type == 'text'){
                var str = '<div class="form-group" style="background:rgba(0,0,0,0.1);padding:10px 0;">'
                                +'<input type="hidden" name="type[]" value="text">'
                                +'<div class="col-lg-3">'
                                    +'<label class="control-label">Text</label>'
                                +'</div>'
                                +'<div class="col-lg-7">'
                                    +'<input class="form-control" type="text" name="label[]" placeholder="Label">'
                                +'</div>'
                                +'<div class="col-lg-2">'
                                    +'<span class="btn btn-icon btn-circle icon-lg fa fa-times" onclick="delete_choice_clearfix(this)"></span>'
                                +'</div>'
                            +'</div>';
                $('#form').append(str);
            }
            else if (type == 'select') {
                i++;
                var str = '<div class="form-group" style="background:rgba(0,0,0,0.1);padding:10px 0;">'
                                +'<input type="hidden" name="type[]" value="select"><input type="hidden" name="option[]" class="option" value="'+i+'">'
                                +'<div class="col-lg-3">'
                                    +'<label class="control-label">Select</label>'
                                +'</div>'
                                +'<div class="col-lg-7">'
                                    +'<input class="form-control" type="text" name="label[]" placeholder="Select Label" style="margin-bottom:10px">'
                                    +'<div class="customer_choice_options_types_wrap_child">'

                                    +'</div>'
                                    +'<button class="btn btn-success pull-right" type="button" onclick="add_customer_choice_options(this)"><i class="glyphicon glyphicon-plus"></i> Add option</button>'
                                +'</div>'
                                +'<div class="col-lg-2">'
                                    +'<span class="btn btn-icon btn-circle icon-lg fa fa-times" onclick="delete_choice_clearfix(this)"></span>'
                                +'</div>'
                            +'</div>';
                $('#form').append(str);
            }
            else if (type == 'multi-select') {
                i++;
                var str = '<div class="form-group" style="background:rgba(0,0,0,0.1);padding:10px 0;">'
                                +'<input type="hidden" name="type[]" value="multi_select"><input type="hidden" name="option[]" class="option" value="'+i+'">'
                                +'<div class="col-lg-3">'
                                    +'<label class="control-label">Multiple select</label>'
                                +'</div>'
                                +'<div class="col-lg-7">'
                                    +'<input class="form-control" type="text" name="label[]" placeholder="Multiple Select Label" style="margin-bottom:10px">'
                                    +'<div class="customer_choice_options_types_wrap_child">'

                                    +'</div>'
                                    +'<button class="btn btn-success pull-right" type="button" onclick="add_customer_choice_options(this)"><i class="glyphicon glyphicon-plus"></i> Add option</button>'
                                +'</div>'
                                +'<div class="col-lg-2">'
                                    +'<span class="btn btn-icon btn-circle icon-lg fa fa-times" onclick="delete_choice_clearfix(this)"></span>'
                                +'</div>'
                            +'</div>';
                $('#form').append(str);
            }
            else if (type == 'radio') {
                i++;
                var str = '<div class="form-group" style="background:rgba(0,0,0,0.1);padding:10px 0;">'
                                +'<input type="hidden" name="type[]" value="radio"><input type="hidden" name="option[]" class="option" value="'+i+'">'
                                +'<div class="col-lg-3">'
                                    +'<label class="control-label">Radio</label>'
                                +'</div>'
                                +'<div class="col-lg-7">'
                                    +'<input class="form-control" type="text" name="label[]" placeholder="Radio Label" style="margin-bottom:10px">'
                                    +'<div class="customer_choice_options_types_wrap_child">'

                                    +'</div>'
                                    +'<button class="btn btn-success pull-right" type="button" onclick="add_customer_choice_options(this)"><i class="glyphicon glyphicon-plus"></i> Add option</button>'
                                +'</div>'
                                +'<div class="col-lg-2">'
                                    +'<span class="btn btn-icon btn-circle icon-lg fa fa-times" onclick="delete_choice_clearfix(this)"></span>'
                                +'</div>'
                            +'</div>';
                $('#form').append(str);
            }
            else if (type == 'file') {
                var str = '<div class="form-group" style="background:rgba(0,0,0,0.1);padding:10px 0;">'
                                +'<input type="hidden" name="type[]" value="file">'
                                +'<div class="col-lg-3">'
                                    +'<label class="control-label">File</label>'
                                +'</div>'
                                +'<div class="col-lg-7">'
                                    +'<input class="form-control" type="text" name="label[]" placeholder="Label">'
                                +'</div>'
                                +'<div class="col-lg-2">'
                                    +'<span class="btn btn-icon btn-circle icon-lg fa fa-times" onclick="delete_choice_clearfix(this)"></span>'
                                +'</div>'
                            +'</div>';
                $('#form').append(str);
            }
        }
    </script>

@endsection
<style type="text/css">
    .table-responsive {
    min-height: .01%;
    overflow-x: inherit;
}
</style>

<section class="content">

 <!-- <section class="content-header"> -->
<?php
echo $this->session->userdata('msg');
$this->session->unset_userdata('msg');
?>
    <div >
     <!--    <div class="block-header">
            <h2>
               <?= $title ?>
               
            </h2>
        </div> -->
        <!-- Basic Examples -->

        <div class="row clearfix "  >

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card" >
                                    
                    <section class="content-header header-breadcrumb">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-8 breadcrumb-area pl-0">

                                </div>
                                <div class="col-sm-4 text-right d-flex justify-content-end align-items-end">
                                    <a style="display: inline-block;padding-top:11px" href="javascript:void(0)" onclick="addUserModal()" class="btn btn-primary btn-lg btn-dashboard custom-btn custom-btn-lg"> <i class="fa fa-plus" aria-hidden="true" style="font-weight:600;font-size:15px;"></i>&nbsp; Add</a>
                                </div>
                            </div>
                        </div><!-- /.container-fluid -->
                    </section>
            <div class="body">
                <div class="table-responsive">
                    <table id="userList" class="table table-no-bordered table-hover" data-locale="en-US" data-cookie="true" data-cookie-id-table="userList" data-toolbar="#toolbar" data-search="true" data-show-columns="true" data-click-to-select="true" data-minimum-count-columns="2" data-pagination="true" data-id-field="id" data-pagination-pre-text="Previous" data-pagination-next-text="Next" data-page-list="[10, 25, 50, 100, all]" data-show-footer="false" data-unique-id="id">
                        <thead>
                            <tr>

                                <th data-field="first_name" data-sortable="true">First Name</th>
                                <th data-field="last_name" data-sortable="true">Last Name</th>
                                <th data-field="email" data-sortable="true">Email</th>
                                <th data-field="mobile" data-sortable="true">Mobile</th>
                                <th data-field="address" data-sortable="true">Address</th>
                                <th data-field="role" data-sortable="true">Role</th>
                                <th data-field="added_date" data-sortable="true">Added Date</th>
                                <th data-field="added_date" data-sortable="true">Updated Date</th>
                                <th data-formatter="operateFormatter" data-searchable="false" data-halign="center" data-align="center">Actions</th>
                            </tr>
                        </thead>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>


</div>


</section>

<!-- Credential Credit Modal -->
<div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="creditModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="creditModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_user_form">
                    <div class="form-group row">
                        <label for="role_name" class="col-sm-3 col-form-label">Role Name <span class="required" aria-required="true">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control select2" id="role_name" name="role_name" required>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="first_name" class="col-sm-3 col-form-label">First Name <span class="required" aria-required="true">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="first_name" name="first_name" value="" required>                            
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="last_name" class="col-sm-3 col-form-label">Last Name <span class="required" aria-required="true">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="last_name" name="last_name" value="" required>                            
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Email <span class="required" aria-required="true">*</span></label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" name="email" value="" required>                            
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="mobile" class="col-sm-3 col-form-label">Mobile <span class="required" aria-required="true">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="mobile" name="mobile" value="" required>                            
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="address" class="col-sm-3 col-form-label">Address <span class="required" aria-required="true">*</span></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="address" name="address" required> </textarea>                           
                        </div>
                    </div>

                    
                    <div class="form-group row">
                        <label for="city" class="col-sm-3 col-form-label">City <span class="required" aria-required="true">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control select2"  data-live-search="true" data-placeholder="Select City" id="city" name="city" required>
                            
                            </select>
                                                        
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="state" class="col-sm-3 col-form-label">State <span class="required" aria-required="true">*</span></label>
                        <div class="col-sm-9">                        
                            <select class="form-control select2" id="state" name="state" required>
                            </select>                                                        
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="zipcode" class="col-sm-3 col-form-label">Zip Code <span class="required" aria-required="true">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="zipcode" name="zipcode" value="" required>                            
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary btn-lg custom-btn ml-4" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-lg custom-btn add_user">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModel" tabindex="-1" role="dialog" aria-labelledby="creditModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="creditModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit_user_form">
                    <div class="form-group row">
                        <label for="role_name" class="col-sm-3 col-form-label">Role Name <span class="required" aria-required="true">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control  select2" id="role_name1" name="role_name" required>

                            </select>
                            <input type="hidden" value='' name="id" id="id">
                            <input type="hidden" value='' name="admin_id" id="admin_id1">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="first_name" class="col-sm-3 col-form-label">First Name <span class="required" aria-required="true">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="first_name1" name="first_name" value="" required>                            
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="last_name" class="col-sm-3 col-form-label">Last Name <span class="required" aria-required="true">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="last_name1" name="last_name" value="" required>                            
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Email <span class="required" aria-required="true">*</span></label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email1" name="email" value="" required>                            
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="mobile" class="col-sm-3 col-form-label">Mobile <span class="required" aria-required="true">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="mobile1" name="mobile" value="" required>                            
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="address" class="col-sm-3 col-form-label">Address <span class="required" aria-required="true">*</span></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="address1" name="address" required> </textarea>                           
                        </div>
                    </div>

                    
                    <div class="form-group row">
                        <label for="city" class="col-sm-3 col-form-label">City <span class="required" aria-required="true">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control  select2" id="city1" name="city" required>
                            
                            </select>
                                                        
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="state" class="col-sm-3 col-form-label">State <span class="required" aria-required="true">*</span></label>
                        <div class="col-sm-9">                        
                            <select class="form-control select2" id="state1" name="state" required>
                            </select>                                                        
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="zipcode" class="col-sm-3 col-form-label">Zip Code <span class="required" aria-required="true">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="zipcode1" name="zipcode" value="" required>                            
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary btn-lg custom-btn ml-4" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-lg custom-btn edit_user">Update</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#city1').select2();
        $('#city').select2();
        $('#state1').select2();
        $('#state').select2();
        $('#role_name1').select2();
        $('#role_name').select2();
    } );

</script> 
    
<!-- <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>  
<script>
   
      
jQuery(document).ready(function()
 {
    $(".target_table tr td:not(:last-child)").click(function() {
       var tr = $(this).closest('tr').data("href");
        window.location=tr;        
    });
});
</script> -->

<script src="<?= base_url('new_ui/plugins/inputmask/min/jquery.inputmask.bundle.min.js?ver=' . filemtime(FCPATH . 'new_ui/plugins/inputmask/min/jquery.inputmask.bundle.min.js')) ?>"> </script>
<script src="<?= base_url('new_ui/custom/js/userList.js?ver=' . filemtime(FCPATH . 'new_ui/custom/js/userList.js')) ?>"></script>
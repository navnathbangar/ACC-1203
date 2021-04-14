$dealerSites = $('#userList');
$dealerSites.bootstrapTable()

const fetchUserData = () => {
    jQuery.ajax({
        type: 'POST',
        url: BASE_URL + 'dealer/portal_users/userList',
        async: false,
        dataType: "json",
        beforeSend: function () {
            $('.custom-loader').show()
        },
        success: function (response) {
            $('.custom-loader').hide()
            if (response) {
                var data = response
                $dealerSites.bootstrapTable('load', data)
                setTimeout(() => {
                    $('tr th[data-field="name"]').css('padding-right', '4rem')
                    $('tr th[data-field="status"]').css('padding-right', '3rem')
                }, 100);


            }
        },
        error: function (e) { }
    });
}
fetchUserData()

function operateFormatter(value, row, index) {
    var action_string = '';
    action_string = '<div class="dropdown table-option"><button class="btn" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h" ></i></button><ul class="dropdown-menu" aria-labelledby="dLabel">';
    action_string += '<li><a class="dropdown-item" onclick="editUserModal(\'' + row.admin_id + '\')" href="javascript:void(0)" >Edit</a></li>';
    action_string += '<li><a class="dropdown-item" onclick="deleteUser(\'' + row.admin_id + '\')" href="javascript:void(0)" >Delete</a></li>';
    return [action_string].join('')
}
$dealerSites.on("click-cell.bs.table", function (
    e,
    field,
    value,
    row,
    $element
) {
    if (field == 'name') {
        window.open(row.access_url)
    } else if (field == 'status' && row.equipment_status == true) {
        window.open(row.equipment_url)
    }
});
const activateOrganisation = (id, status, org_id) => {
    jQuery.ajax({
        type: 'POST',
        url: BASE_URL + 'dashboard/changeorgstatus',
        data: {
            id,
            status,
            org_id
        },
        beforeSend: function () {
            $('.custom-loader').show()
        },
        success: function (response) {
            $('.custom-loader').hide()
            let data = JSON.parse(response)
            if (data.status == true) {
                toastr.success(data.message)
                $dealerSites.bootstrapTable('load', data.data)
                setTimeout(() => {
                    $('tr th[data-field="name"]').css('padding-right', '4rem')
                    $('tr th[data-field="status"]').css('padding-right', '3rem')
                }, 100);
            } else {
                toastr.error(data.message)
            }
        },
        error: function (e) { }
    });
}
const fetch_data_from_ict = (u, i, p, org_id, s) => {
    if (s) {

        $('#FetchICTDataLabel').html('Fetch Data From ICT');
        $('.fetch_ict_data').html('Fetch')
        $('#ict_ipAddress').val(i)
        $('#ict_userName').val(u)
        $('#ict_userPassword').val(p)
        $('#ict_site_id').val(s)
        $('#FetchICTData .form-control').attr('readonly', true)
        $('#FetchICTData .form-control').addClass('form-control-plaintext')
        $('#FetchICTData .form-control-plaintext').removeClass('form-control')
        $('.fetch_ict_data').addClass('pushtoICT')
        $('.fetch_ict_data').removeClass('addtoICT')
        // $('.ict_site_id').hide()
        setTimeout(() => {
            $('form').valid()
        }, 200);
    } else {
        $('#ict_ipAddress').val('')
        $('#ict_userName').val('')
        $('#ict_userPassword').val('')
        $('#ict_site_id').val('')
        $('#FetchICTDataLabel').html('Add to ICT');
        $('.fetch_ict_data').html('Add to ICT')
        $('#FetchICTData .form-control-plaintext').removeAttr('readonly')
        $('#FetchICTData .form-control-plaintext').addClass('form-control')
        $('#FetchICTData .form-control-plaintext').removeClass('form-control-plaintext')
        // $('.ict_site_id').show()
        $('.fetch_ict_data').addClass('addtoICT')
        $('.fetch_ict_data').removeClass('pushtoICT')
    }
    $('#org_id').val(org_id)
    $('#FetchICTData').modal('show')
}
jQuery.validator.addMethod("mask", function (value, element) {
    var isSuccess = false;
    if ($(element).val().length > 0) {
        if ($(element).inputmask("isComplete")) {
            isSuccess = true
        }
    } else {
        isSuccess = true
    }

    return isSuccess;
});
$('#ict_ipAddress').inputmask({
    alias: "ip",
    greedy: false
})
const addUserModal = () => {
    $('#add_user_form').validate().resetForm();
    jQuery.ajax({
        type: 'POST',
        url: `${BASE_URL}dealer/portal_users/add_data`,
        data: {
        },
        beforeSend: function () {
            $('.custom-loader').show()
        },
        success: function (response) {
            
           // alert(response);return;
            $('.custom-loader').hide()
            let data1 = JSON.parse(response)
            let htl = "<option value=''>Select Role Name</option>";
            $.each(data1.all_role, function( index, value ) {
                
                    htl += "<option value='"+value.id+"'>"+value.description+"</option>";
                
            });
            let city = "<option value=''>Select City</option>";
            $.each(data1.cities, function( index, value ) {
                
                    city += "<option value='"+value.id+"'>"+value.name+"</option>";
                
            });
           
            $('#role_name').html(htl);
            $('#city').html(city);
            $('#addModel').modal('show');

        },
        error: function (e) { }
    });
}

$('.add_user').click(function () {
    if ($('#add_user_form').valid()) {
        //ajax/wallet_data
        jQuery.ajax({
            type: 'POST',
            url: `${BASE_URL}dealer/portal_users/add_user_data`,
            data: {
                'role_id': $('#role_name').val(),
                'f_name': $('#first_name').val(),
                'l_name': $('#last_name').val(),
                'email': $('#email').val(),
                'mobile': $('#mobile').val(),
                'address': $('#address').val(),
                'city': $('#city').val(),
                'state': $('#state').val(),
                'zip_code': $('#zipcode').val(),
            },
            beforeSend: function () {
                $('.custom-loader').show()
            },
            success: function (response) {
                $('.custom-loader').hide()
                let data = JSON.parse(response)
                if (data.status == true) {
                    toastr.success(data.message)
                } else {
                    toastr.error(data.message)
                }
                clearForms('#add_user');
                $('#addModel').modal('hide');
                
                location.reload();

            },
            error: function (e) { }
        });
    }
});

const editUserModal = (id) => {
    
    
    $('#edit_user_form').validate().resetForm();
    jQuery.ajax({
        type: 'POST',
        url: `${BASE_URL}dealer/portal_users/edit_data`,
        data: {
            'id': id
        },
        beforeSend: function () {
            $('.custom-loader').show()
        },
        success: function (response) {
            
            //alert(response);return;
            $('.custom-loader').hide()
            let data1 = JSON.parse(response)
            let htl = "<option value=''>Select Role Name</option>";
            $.each(data1.all_role, function( index, value ) {
                if(value.id == data1.data[0].role_id){
                    htl += "<option value='"+value.id+"' selected>"+value.description+"</option>";
                }else{
                    htl += "<option value='"+value.id+"'>"+value.description+"</option>";
                }
            });
            let city = "<option value=''>Select City</option>";
            $.each(data1.cities, function( index, value ) {
                if(value.id == data1.data[0].city){
                    city += "<option value='"+value.id+"' selected>"+value.name+"</option>";
                }else{
                    city += "<option value='"+value.id+"'>"+value.name+"</option>";
                }
            });
            let state = "<option value=''>Select State</option>";
            $.each(data1.states, function( index, value ) {
                if(value.id == data1.data[0].state){
                    state += "<option value='"+value.id+"' selected>"+value.name+"</option>";
                }else{
                    state += "<option value='"+value.id+"'>"+value.name+"</option>";
                }
            });
            
            $('#id').val(data1.data[0].id);
            $('#role_name1').html(htl);
            $('#first_name1').val(data1.data[0].first_name);
            $('#last_name1').val(data1.data[0].last_name);
            $('#admin_id1').val(data1.data[0].admin_id);
            $('#email1').val(data1.data[0].email);
            $('#mobile1').val(data1.data[0].mobile);
            $('#address1').val(data1.data[0].address);
            $('#city1').html(city);
            $('#state1').html(state);
            $('#zipcode1').val(data1.data[0].zip_code);
            $('#editModel').modal('show');

        },
        error: function (e) { }
    });
    //$('#editModel').modal('show')

}
$('.edit_user').click(function () {
    if ($('#edit_user_form').valid()) {
        //ajax/wallet_data
        jQuery.ajax({
            type: 'POST',
            url: `${BASE_URL}dealer/portal_users/update_user_data`,
            data: {
                'id': $('#admin_id1').val(),
                'role_id': $('#role_name1').val(),
                'f_name': $('#first_name1').val(),
                'l_name': $('#last_name1').val(),
                'email': $('#email1').val(),
                'mobile': $('#mobile1').val(),
                'address': $('#address1').val(),
                'city': $('#city1').val(),
                'state': $('#state1').val(),
                'zip_code': $('#zipcode1').val(),
            },
            beforeSend: function () {
                $('.custom-loader').show()
            },
            success: function (response) {
                $('.custom-loader').hide();
                let data = JSON.parse(response);
                if (data.status == true) {
                    toastr.success(data.message)
                } else {
                    toastr.error(data.message)
                }
                clearForms('#edit_user');
                $('#editModel').modal('hide');
                location.reload();

            },
            error: function (e) { }
        });
    }
});

const deleteUser = (id) => {
    
    
    jQuery.ajax({
        type: 'POST',
        url: `${BASE_URL}dealer/portal_users/delete_data`,
        data: {
            'id': id
        },
        beforeSend: function () {
            $('.custom-loader').show()
        },
        success: function (response) {
            
            //alert(response);return;
            $('.custom-loader').hide()
            let data = JSON.parse(response);
            if (data.status == true) {
                toastr.success(data.message);
                location.reload();
            } else {
                toastr.error(data.message)
            }
            
            
        },
        error: function (e) { }
    });
    //$('#editModel').modal('show')

}

$("select#city1").change(function(){
    var city_id= $('#city1').val();
     //alert(city_id);
    jQuery.ajax({

      type :'POST',
      data : {'city_id':city_id},
      url : `${BASE_URL}Country_city/get_states_us`,

      success : function(data){
          //alert(data);
        console.log(data);
        $('#state1').html(data);
        $('#state1').selectpicker('refresh');
      },
      error :function(e){

      }
    });

});

$("select#city").change(function(){
    var city_id= $('#city').val();
     //alert(city_id);
    jQuery.ajax({

      type :'POST',
      data : {'city_id':city_id},
      url : `${BASE_URL}Country_city/get_states_us`,

      success : function(data){
          //alert(data);
        console.log(data);
        $('#state').html(data);
        $('#state').selectpicker('refresh');
      },
      error :function(e){

      }
    });

});

$('#creditModal').on('hidden.bs.modal', function (e) {
    $(this)
        .find("input,textarea,select")
        .val('')
        .end()
        .find("input[type=checkbox], input[type=radio]")
        .prop("checked", "")
        .end();
})
$("#connect_ict").validate({
    rules: {
        ict_ipAddress: {
            mask: true
        }
    },
    messages: {
        ict_ipAddress: {
            mask: 'Invalid IP Address'
        },

    },
    errorPlacement: function (error, element) {
        if (element.prop("type") == 'select-one') {
            error.insertAfter(element.next('span')); // for select2
        } else {
            error.insertAfter(element); // default     
        }

    },

});

$('.fetch_ict_data').click(function () {

    let url;
    let orgId = $('#org_id').val();
    let site_id = $('#ict_site_id').val()
    let ip_address = $('#ict_ipAddress').val()
    let username = $('#ict_userName').val()
    let password = $('#ict_userPassword').val()
    if ($('.pushtoICT').length) {
        url = `${BASE_URL}dealer/Organizations/fetch`;
    } else {
        url = `${BASE_URL}dealer/Organizations/addtoict`;
    }
    if (orgId && site_id && ip_address && username && password && $('form').valid()) {
        jQuery.ajax({
            type: 'POST',
            url,
            data: {
                orgId,
                site_id,
                'admin_id': orgId,
                username,
                password,
                ip_address

            },
            beforeSend: function () {
                $('.custom-loader').show()
            },
            success: function (response) {
                $('.custom-loader').hide()
                let data = JSON.parse(response)
                if (data.status == true) {
                    toastr.success(data.message)
                    setTimeout(() => {
                        location.reload(); ``
                    }, 1000);
                } else {
                    toastr.error(data.message)
                }

                $('#FetchICTData').modal('hide')
            },
            error: function (e) { }
        });
    } else {
        $('form').valid()
    }

});
// toggle password
$('#ict_userPassword').click(function () {
    if ($(this).attr('type') === "password") {
        $(this).prop('type', 'text');
    } else {
        $(this).prop('type', 'password');
    }
})

// Portal Modules
$('body').on('click', '.proptia_module_popup', function () {
    let id = $(this).data('id')
    fetchModules(id)
})

const fetchModules = (id) => {
    jQuery.ajax({
        type: 'POST',
        url: BASE_URL + 'dashboard/fetchModule',
        dataType: "json",
        data: {
            id
        },
        beforeSend: function () {
            $('.custom-loader').show()
        },
        success: function (response) {
            $('.custom-loader').hide()
            // let data = JSON.parse(response);
            if (response.status == true) {
                $('#moduleContent').html(response.data)
            }
            $('#ProptiaModuleModal').modal('show')
        },
        error: function (e) {
            $('.custom-loader').hide()
            if (e.status !== 200) {
                toastr.error(e.statusText)
            }
        }
    });
}

const addCredits = (id) => {

}
$('body').on('click', '#ProptiaModuleModal div i.fa', function () {
    let module = $(this).data('id');
    if ($(this).hasClass('fa-angle-up')) {
        $('.' + module).show()
        $(this).addClass('fa-angle-down');
        $(this).removeClass('fa-angle-up');
    } else {
        $('.' + module).hide()
        $(this).addClass('fa-angle-up');
        $(this).removeClass('fa-angle-down');
    }
})

$('body').on('click', '.moduleBox', function () {
    let id = $(this).data('id');
    let module = $(this).data('module');
    let OrgId = $(this).data('aid');
    jQuery.ajax({
        type: 'POST',
        url: BASE_URL + 'dashboard/fetchSingleModule',
        dataType: "json",
        data: {
            id,
            module,
            OrgId
        },
        beforeSend: function () {
            $('.custom-loader').show()
        },
        success: function (response) {
            $('.custom-loader').hide()
            if (response.status === true) {
                $('.singleModule').html(response.data)
            }
            $('#softwareActivationModule').modal('show')
        },
        error: function (e) {
            $('.custom-loader').hide()
            if (e.status !== 200) {
                toastr.error(e.statusText)
            }
        }
    });

})
$('body').on('keyup', 'input[id^="dealer_rate_"]', function () {
    $(this).valid()
})
const editSoftwareActication = (type) => {
    if (type == 1) {
        $('.save-singleModuletab').show();
        $('input[id^="quantiity_"],input[id^="dealer_rate_"]').removeAttr('readonly')
        $('.edit-singleModuletab').hide();
        $('.save-singleModuletab').addClass('save_mode');

    } else {
        //save settings
        let isvalid = true;
        $('input[id^="dealer_rate_"]').each(function () {
            if (!$(this).valid()) {
                isvalid = false;
                return;
            }
        });

        if ($('#add_product').valid() && isvalid === true) {
            activateModule()
            $('input[id^="quantiity_"],input[id^="dealer_rate_"]').attr('readonly', true)
            $('.edit-singleModuletab').show();
            $('.save-singleModuletab').hide();
            $('.save-singleModuletab').removeClass('save_mode');
        }


    }
}

$('body').on('click', '.singleproptiaModule', function () {
    let c = $(this).children();
    let allowActivation = $('#moduleStatus').data('checked');
    if ($('.save_mode:visible').length) {

        if ($(this).children().hasClass('active')) {
            if (allowActivation) {
                c.addClass('disabled');
                c.removeClass('active');
            } else {
                toastr.info("Deactivate other modules first")
            }

        } else {
            c.removeClass('disabled');
            c.addClass('active');
        }
        var checked = $("#moduleStatus").is(":checked");
        if (checked) {
            $("#moduleStatus").prop("checked", false);
        } else {
            $("#moduleStatus").prop("checked", true);
        }

    }


})
const activateModule = () => {
    let oid = $('input[name="aid"]').val();
    let mid = $('input[name="mid"]').val();
    let checked = $("#moduleStatus").is(":checked")

    if (oid && mid) {
        jQuery.ajax({
            type: 'POST',
            url: BASE_URL + 'dashboard/moduleStatusUpdate',
            dataType: "json",
            data: $('#add_product').serialize() + "&oid=" + oid + "&mid=" + mid + "&checked=" + checked,
            beforeSend: function () {
                $('.custom-loader').show()
            },
            success: function (response) {
                $('.custom-loader').hide()

                if (response.status === true) {

                    $('#moduleContent').html(response.data.allModule)
                    $dealerSites.bootstrapTable('load', response.data.allOrg)
                    setTimeout(() => {
                        $('tr th[data-field="name"]').css('padding-right', '4rem')
                        $('tr th[data-field="status"]').css('padding-right', '3rem')
                    }, 100);
                    toastr.success(response.message)
                    $('#softwareActivationModule').modal('hide')
                } else {
                    toastr.error(response.message)
                }
                // $('#softwareActivationModule').modal('show')
            },
            error: function (e) {
                $('.custom-loader').hide()
                if (e.status !== 200) {
                    toastr.error(e.statusText)
                }
            }
        });
    }
}


const clearForms = (appenDiv) => {
    $(appenDiv + ' :input, ' + appenDiv + ' :checkbox, ' + appenDiv + ' :radio').not(
        ':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
    // $(':checkbox, :radio').prop('checked', false);
    $("form").data("validator").resetForm()
}

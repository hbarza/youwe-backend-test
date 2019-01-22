var insurance = 
{
    // formChanged: false,
    oldPassangerForm: '',

    init: function ()
    {
        insurance.getCountries();
        insurance.getDurations();
        insurance.saveCountryName();
        insurance.addSupervisor();
        insurance.addNewPassenger();
        insurance.editPassenger();
        insurance.removePassenger();
        insurance.closePassengerModal();
        insurance.getCustomer();
        // insurance.saveGender();
        // insurance.submitListener();
        // this.toggleCovers();
    },

    getCountries: function ()
    {
        $('.bilit-serach-box').on('click', '.tab-insurance .field-insurance-country .btn', function () {
            codnitive.ajax(codnitive.getBaseUrl() + 'insurance/ajax/getCountries');
        });
    },

    getDurations: function ()
    {
        $('.bilit-serach-box').on('click', '.tab-insurance .field-insurance-duration .btn', function () {
            codnitive.ajax(codnitive.getBaseUrl() + 'insurance/ajax/getDurations');
        });
    },

    saveCountryName: function ()
    {
        $('.bilit-serach-box').on('change', '#insurance-country', function() {
            $('#insurance-country_name').val($('#insurance-country option:selected').text());
        });
    },

    // saveGender: function ()
    // {
    //     $('#insurance_registration_form').on('change', '.gender-drop', function() {
    //         var gendorDrop = $(this);
    //         gendorDrop.parents('.passenger-form-fields-wrapper').find('.gender').val(gendorDrop.val());
    //     });
    // },

    getCustomer: function ()
    {
        $('#insurance_registration_form').on('change', '.national-id', function () {
            var section = '.passenger-form-fields-wrapper';
            var loadingMsg = '<i class="fa fa-spinner rotating"></i>در حال دریافت اطلاعات شما...';
            codnitive.showLoading(section, loadingMsg);
            var currentField  = $(this);
            var fieldsWrapper = currentField.parents(section);
            var url = BASE_URL + '/insurance/ajax/getCustomer';
            var data = {'national_id': currentField.val()};
            
            $.ajax({
                method: "POST",
                url: url,
                data: data
            })
            .done(function (response) {
                var response = $.parseJSON(response);
                var customer = response.customer;
                fieldsWrapper.find('.persian-name').val(customer.firstName).prop('readonly', false);
                fieldsWrapper.find('.persian-lastname').val(customer.lastName).prop('readonly', false);
                fieldsWrapper.find('.english-name').val(customer.firstNameLatin).prop('readonly', false);
                fieldsWrapper.find('.english-lastname').val(customer.lastNameLatin).prop('readonly', false);
                fieldsWrapper.find('.passport-no').val(customer.lastNameLatin).prop('readonly', false);
                fieldsWrapper.find('.birthday').val(customer.birthDate);//.addClass('disable-style');
                customer.mobile
                    ? fieldsWrapper.find('.cell-phone').val(customer.mobile).prop('readonly', false)
                    : fieldsWrapper.find('.cell-phone').val('').prop('readonly', false);
                customer.email
                    ? fieldsWrapper.find('.email').val(customer.email).prop('readonly', false)
                    : fieldsWrapper.find('.email').val('').prop('readonly', false);
                fieldsWrapper.find('.gender-drop').val(customer.isMale ? 1 : 0).prop('disabled', false);
                fieldsWrapper.find('.gender-drop').selectpicker('refresh');
                fieldsWrapper.find('.gender').val(customer.isMale ? 1 : 0).prop('readonly', false);

                if (customer.nationalCode == undefined || customer.errorCode != '-1') {
                    $('#'+fieldsWrapper.find('.birthday').prop('id')).MdPersianDateTimePicker('clearDate');
                }
                else {
                    $('#'+fieldsWrapper.find('.birthday').prop('id')).MdPersianDateTimePicker('setDate', new Date(customer.birthDate));
                }
                $('#'+fieldsWrapper.find('.birthday').prop('id')).MdPersianDateTimePicker('disable', false);
                /** destroy datepicker to don't let user change field */
                /*var datepicker = $('#'+fieldsWrapper.find('.birthday').prop('id')).data('Zebra_DatePicker');
                datepicker.destroy();*/

                fieldsWrapper.find('.extra-fields-wrapper').slideDown();
                $(section+' .loading').remove();
            })
            .fail(function (response) {
                // console.log(response.responseText);
                console.log(response.status + ': ' + response.statusText);
                fieldsWrapper.find('.persian-name').val('').prop('readonly', false);
                fieldsWrapper.find('.persian-lastname').val('').prop('readonly', false);
                fieldsWrapper.find('.english-name').val('').prop('readonly', false);
                fieldsWrapper.find('.english-lastname').val('').prop('readonly', false);
                fieldsWrapper.find('.passport-no').val('').prop('readonly', false);
                fieldsWrapper.find('.birthday').val('').removeClass('disable-style');
                fieldsWrapper.find('.cell-phone').val('').prop('readonly', false);
                fieldsWrapper.find('.email').val('').prop('readonly', false);
                fieldsWrapper.find('.gender-drop').val('').prop('disabled', false);
                fieldsWrapper.find('.gender-drop').selectpicker('refresh');
                fieldsWrapper.find('.gender').val('').prop('readonly', false);
                fieldsWrapper.find('.extra-fields-wrapper').slideDown();

                $('#'+fieldsWrapper.find('.birthday').prop('id')).MdPersianDateTimePicker('clearDate');
                $('#'+fieldsWrapper.find('.birthday').prop('id')).MdPersianDateTimePicker('disable', false);
                /** create datepicker for destroyed field */
                /*var datepickerId = fieldsWrapper.find('.birthday').prop('id');
                var datepickerVariable = datepickerId.replace(/\-/g, '_');
                window[datepickerVariable] = $('input#'+datepickerId).Zebra_DatePicker(
                    $('input#'+datepickerId).data('insurance_registration_birthday_config')
                );*/
                
                $(section+' .loading').remove();
            });
        });
    },

    addSupervisor: function ()
    {
        $('#insurance_registration_form .add-passenger').on('click', function () {
            if (!insurance.validatePassengerForm(0)) {
                alert('لطفا ابتدا اطلاعات سرپرست را کامل نمایید.');
                return false;
            }
            $('.passengers-supervisor-wrapper').slideUp();
            $('.passengers-list').slideDown();
            $('.insurance .modal-dialog .modal-body').html('');
            codnitive.cloneHtml('.insurance .passenger-info-wrapper', '.insurance .modal-dialog .modal-body');
            insurance.addPassengerTableRow('.passengers-info .supervisor', false, 0);
        });

        //$('#myTable tr').length
    },

    addNewPassenger: function ()
    {
        $('#insurance_registration_form').on('click', '.submit-new-passenger', function () {
            var index = parseInt($('.insurance .passenger-info-wrapper').attr('data-index')) - 1;
            if (!insurance.validatePassengerForm(index)) {
                alert('لطفا اطلاعات مسافر را کامل نمایید.');
                return false;
            }
            var wrapper = '.submitted-passengers-placeholder #passenger-'+index;
            // // var form = $('.insurance .modal-body #passenger-'+index).eq(0).clone();
            // var form = $('.insurance .modal-body #passenger-'+index).clone();
            // $('.submitted-passengers-placeholder').append(form);
            if ($(wrapper).length) {
                $(wrapper).remove()
            }
            // if ($(wrapper).find('.national-id').val() == undefined) {
            //     $('.insurance .modal-dialog .modal-body').html('');
            //     $('#insurance_registration_form .add-pass-info.modal').modal('hide');
            //     return;
            // }
            insurance.cloneForm(
                '.insurance .modal-body #passenger-' + index, 
                '.submitted-passengers-placeholder',
                wrapper,
                true
            );

            $('.insurance .modal-dialog .modal-body').html('');
            $('#insurance_registration_form .add-pass-info.modal').modal('hide');
            $(wrapper + ' .selectpicker').selectpicker('refresh');
            $(wrapper + ' .birthday').MdPersianDateTimePicker({
                targetTextSelector: '#insurance_registration-birthday_persian-' + index,
                targetDateSelector: '#insurance_registration-birthday-' + index,
                dateFormat: 'yyyy-MM-dd',
                disableAfterToday: true,
                englishNumber: true,
                yearOffset: 100
            });
            insurance.addPassengerTableRow('#insurance_registration_form #passenger-'+index, true, index);
        });
    },

    validatePassengerForm: function (index)
    {
        // /** Trigger validation for the whole form */
        // /** can't use because of this bug: https://github.com/yiisoft/yii2/issues/13105 */
        // return $('#insurance_registration_form').yiiActiveForm('validate', true);


        var isValid = true;
        $('#insurance_registration_form input[aria-required="true"][name*='+index+'], #insurance_registration_form select[aria-required="true"][name*='+index+']').each(function () {
            if (codnitive.isEmpty($(this).val())) {
                isValid = false;
            }

            /** Triggering validation for individual form fields */
            // /** can't use because of this bug: https://github.com/yiisoft/yii2/issues/13105 */
            // console.log($(this).prop('name'));
            // $('#insurance_registration_form').yiiActiveForm('validateAttribute', 'insurance_registration[visa_type][0]', true);
            // console.log($('#insurance_registration_form').yiiActiveForm('validateAttribute', 'insurance_registration[visa_type][0]'));
            // if (!$('#insurance_registration_form').yiiActiveForm('validateAttribute', $(this).prop('name'), true)) {
            //     console.log($('#insurance_registration_form').yiiActiveForm('validateAttribute', $(this).prop('name'), true));
            //     console.log($(this).prop('name'));
            //     isValid = false;
            // }
        });
        return isValid;
    },

    addPassengerTableRow: function (wrapperSelector, bothActions, index)
    {
        wrapper = $(wrapperSelector);
        var name = wrapper.find('input[name*=persian_name]').val();
        name += ' ' + wrapper.find('input[name*=persian_lastname]').val();

        var englishName = wrapper.find('input[name*=english_name]').val();
        englishName += ' ' + wrapper.find('input[name*=english_lastname]').val();

        var nationalId = wrapper.find('input[name*=national_id]').val();
        var passportNo = wrapper.find('input[name*=passport_no]').val();

        var actions = '<a href="javascript:;" class="mx-1 edit-passenger" title="ویرایش" data-index="'+index+'"><i class="fa fa-edit"></i></a>';
        if (bothActions) {
            actions += '<a href="javascript:;" class="mx-1 remove-passenger" title="حذف" data-index="'+index+'"><i class="fa fa-trash"></i></a>';
        }
        
        var rowId = wrapper.prop('id')+'_row';
        // var count = index == 0 ? 1 : $('.passengers-list-table table tbody tr').length;
        //                    <td>'+count+'</td>\
        var template = '<tr id="'+rowId+'" data-index="'+index+'">\
                            <td class="index"></td>\
                            <td>'+name+'</td>\
                            <td>'+englishName+'</td>\
                            <td>'+nationalId+'</td>\
                            <td>'+passportNo+'</td>\
                            <td class="action">'+actions+'</td>\
                        </tr>';
        var row = '.passengers-list-table table tbody tr:last';
        if ($('#'+rowId).length) {
            row = '#'+rowId;
            $(row).after(template);
            $(row).addClass('remove');
            $(row+'.remove').remove();
        }
        else {
            $(row).after(template);
        }
        insurance.refreshTableRowsCount();
    },

    editPassenger: function ()
    {
        $('#insurance_registration_form').on('click', '.edit-passenger', function () {
            var index = $(this).attr('data-index');
            if (index == 0) {
                document.getElementById('insurance_registration_form').scrollIntoView();
                $('.passengers-supervisor-wrapper').slideDown();
                return;
            }

            var wrapper = '.submitted-passengers-placeholder #passenger-'+index;
            insurance.oldPassangerForm = $(wrapper).html();
            // insurance.listenForPassengersFromChanges();
            
            // if ($(wrapper).length) {
                $(wrapper).detach().appendTo('.insurance .modal-dialog .modal-body');
            // }
            // else {
            //     // var form = $(wrapper).clone();
            //     // $('.insurance .modal-dialog .modal-body').html(form);
            //     var form = insurance.cloneForm(
            //         wrapper, 
            //         '.insurance .modal-dialog .modal-body',
            //         '.insurance .modal-dialog .modal-body #passenger-' + index,
            //         false
            //     );
            //     $('.insurance .modal-dialog .modal-body').html(form);
            // }

            $('#insurance_registration_form .add-pass-info.modal').modal('show');
            // $(".selectpicker").selectpicker("refresh");
            // $('.birthday').MdPersianDateTimePicker({
            //     targetTextSelector: '#insurance_registration-birthday_persian-' + index,
            //     targetDateSelector: '#insurance_registration-birthday-' + index,
            //     dateFormat: 'yyyy-MM-dd',
            //     disableAfterToday: true,
            //     englishNumber: true,
            //     yearOffset: 100
            // });
        });
    },

    removePassenger: function ()
    {
        $('#insurance_registration_form').on('click', '.remove-passenger', function () {
            var index = $(this).attr('data-index');
            // $('.submitted-passengers-placeholder #passenger-'+index).remove();
            $('#insurance_registration-removed-'+index).val(1);
            if ($('.passengers-list-table tbody #passenger-'+index+'_row').remove()) {
                insurance.refreshTableRowsCount();
            }
        });
    },

    closePassengerModal: function ()
    {
        $('#insurance_registration_form').on('click', '.close-new-passenger', function () {
            var index = $('.insurance .modal-dialog .modal-body .passenger-form-fields-wrapper').attr('data-index');
            if (!$('.submitted-passengers-placeholder #passenger-' + index).length && insurance.oldPassangerForm != '') {
                var html = '<div class="p-2 passenger-form-fields-wrapper " id="passenger-'+index+'" data-index="'+index+'">'+insurance.oldPassangerForm+'</div>';
                $('.submitted-passengers-placeholder').append(html);
                // $('.insurance .modal-dialog .modal-body #passenger-' + index).detach().appendTo('.submitted-passengers-placeholder');
            }
            $('.insurance .modal-dialog .modal-body').html('');
        });
    },

    cloneForm: function (source, destination, wrapper, append)
    {
        // var form = $('.submitted-passengers-placeholder .passenger-'+index).eq(0).clone();
        var form = $(source).clone();
        if (append) {
            $(destination).append(form);
        }
        else {
            $(destination).html(form);
        }

        var selects = $(source).find("select");
        $(selects).each(function(i) {
            var select = this;
            $(wrapper).find("select").eq(i).val($(select).val());
        });
    },

    registerPolicies: function ()
    {
        codnitive.ajax(codnitive.getBaseUrl() + 'insurance/ajax/registerPolicies');
    },

    refreshTableRowsCount: function ()
    {
        $i = 0;
        $('.passengers-list-table tbody tr').each(function(){
            $(this).find('.index').text($i++);
        })
    },

    // listenForPassengersFromChanges: function() 
    // {
    //     $('#insurance_registration_form').on('change', 'input, select', function() {
    //         insurance.formChanged = true;
    //     });
    // }

    // ajax: function (url, data)
    // {
    //     $.ajax({
    //         method: "POST",
    //         url: url,
    //         data: data
    //     })
    //     .done(function (response) {
    //         response = $.parseJSON(response);
    //         console.log(response);
    //     })
    //     .fail(function (response) {
    //         // console.log(response.responseText);
    //         console.log(response.status + ': ' + response.statusText);
    //     });
    //     return this;
    // }

    /**
     * function to get all available plans for selected country and duration of
     * stay by ajax
     * 
     * @call    insurance/ajax/getPlans
     * @return  html    plans
     */
    /*getPlans: function()
    {
        // $('#plans_wrapper').html('');
        codnitive.showLoading('#plans_wrapper');
        codnitive.ajax(
            codnitive.getBaseUrl() + 'insurance/ajax/getPlans',
            $('#insurance_form').serializeArray()
        );
    },*/

    /**
     * function to listen insurance search form submit, first checks form for 
     * valid input and then call getPlans
     */
    // submitListener: function()
    // {
    //     $('body').on('click', '#insurance-submit', function() {
    //         var form = $('#insurance_form');
    //         if (form.valid()) {
    //             form.submit();
    //         }
    //     });
    // },

    /**
     * function to toggle insurance plan detail and covers when click on view
     * covers button
     */
    // toggleCovers: function()
    // {
    //     $('#plans_wrapper').on('click', 'a.btn.covers', function () {
    //         $(this).parent('li').children('dl').toggleClass('hidden');
    //     });
    // }
}

$(document).ready(function () {
    insurance.init();
    // insurance.submitListener();
    // insurance.toggleCovers();
});

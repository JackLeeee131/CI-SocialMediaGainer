/**
 * Created by Bruno Alves on 14/10/2015.
 */
function ajax_call(json_config) {

    $('.alert').hide();
    if (IsJsonString(json_config) == false) {
        console.log('Is not a json object');
        return false;
    }

    var configData = jQuery.parseJSON(json_config);
    console.log(configData);

    if (configData.loadingDiv != null && configData.loadingDiv != '' && configData.loadingDiv != 'undefined') {
        var loadingDiv = configData.loadingDiv;
        $('#' + loadingDiv).show();
    }
    if (configData.errorsDiv != null && configData.errorsDiv != '' && configData.errorsDiv != 'undefined') {
        var errorsDiv = configData.errorsDiv;
        $('#' + errorsDiv).html('');
    }
    if (configData.triggerId != null && configData.triggerId != '' && configData.triggerId != 'undefined') {
        var triggerId = $('#' + configData.triggerId);
        console.log(triggerId);
        triggerId.attr('disabled', true);
    }
    if (configData.method != null && configData.method != '' && configData.method != 'undefined') {
        var callMethod = data.method;
    }
    else {
        callMethod = 'POST';
    }
    if (configData.formId != null && configData.formId != '' && configData.formId != 'undefined') {
        var postData = $('#' + configData.formId).serialize();
        console.log('POST DATA:' + postData);
    }
    if (configData.formData != null && configData.formData != '' && configData.formData != 'undefined') {
        postData = configData.formData;
        console.log('POST DATA:' + postData);
    }
    if (configData.ajaxUrl != null && configData.ajaxUrl != '' && configData.ajaxUrl != 'undefined') {
        var ajaxUrl = configData.ajaxUrl;
        console.log('Ajax URL:' + ajaxUrl);
    }
    else {
        ajaxUrl = $('#' + configData.formId).attr('action');
        console.log('Ajax URL:' + ajaxUrl);
    }

    $.ajax
    ({
        type: callMethod, // POST or GET
        url: ajaxUrl, // The URL ( Dont touch )
        data: postData, // The Form Data ( Dont touch )
        xhrFields: {withCredentials: true},
        success: function (data, textStatus, jqXHR) {
            $('#' + loadingDiv).hide();

            if (triggerId != '' && triggerId != null && triggerId != 'undefined') {
                triggerId.removeAttr('disabled');
            }

            console.log("Data: " + data);
            if (IsJsonString(data) == false) {
                $('#' + errorsDiv).html('<div class="alert error rounded" data-close="true"><strong>Opps!</strong> There was an error performing your request! If the problem persists please contact the administration.</div>');
            }
            var Data = jQuery.parseJSON(data); // Parse the Json that we got from the POST
            console.log("Data array:" + Data);

            if (Data.errorMessage != '' && Data.errorMessage != null && Data.errorMessage != 'undefined') {
                $('#' + errorsDiv).html(Data.errorMessage);
            }

            if (Data.domEnable == 1 || Data.domEnable == '1') {
                var domElements = Data.dom;
                responseDom(domElements);
            }

            if (Data.redirect == 1 || Data.redirect == '1') {
                if (Data.redirectUrl != '') {
                    console.log("REDIRECT TO : " + Data.redirectUrl);
                    window.location.replace('' + Data.redirectUrl);
                }
            }

            if (Data.tableReload != '' && Data.tableReload != null && Data.tableReload != 'undefined') {
                console.log('Datatable Reload: ' + Data.tableReload);
                $("#" + Data.tableReload).bootgrid("reload", true).bootgrid('deselect');
                $('#' + Data.tableReload + '-header-actions').hide();
                $('#' + Data.tableReload + '-header').show();
            }
            initAlerts();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#' + loadingDiv).hide();
            $('#' + errorsDiv).html('Error on Ajax Calling');
            initAlerts();
        }
    });
}

function responseDom(domElements) {
    if (domElements.elementController.length >= 1) {
        $.each(domElements.elementController, function (i, item) {
            console.log('Checking for element with ID ' + domElements.elementController[i].id);
            //console.log(item);
            var currentElement = $('#' + domElements.elementController[i].id);
            if (currentElement != null && currentElement != 'undefined') {
                /******* ATTR ******/
                if (domElements.elementController[i].attr != null && domElements.elementController[i].attr != 'undefined') {
                    $.each(domElements.elementController[i].attr, function (k, v) {

                        if (k == 'value') {
                            console.log('Value : ' + k + ' to ' + v);
                            currentElement.val(v);
                        }
                        else if (k == 'readonly') {
                            if (v == 'false') {
                                currentElement.removeAttr('readonly');
                            }
                            else {
                                currentElement.attr('readonly', true);
                            }
                        }

                        else if (k == 'remove') {
                            console.log('Remove Attr : ' + k + ' to ' + v);
                            currentElement.removeAttr(v);
                        }
                        else {
                            console.log('Attr : ' + k + ' to ' + v);
                            currentElement.attr(k, v);
                        }
                    });
                }
                /******* Class ******/
                if (domElements.elementController[i].class != null && domElements.elementController[i].class != 'undefined') {
                    $.each(domElements.elementController[i].class, function (k, v) {

                        if (k == 'remove') {
                            console.log('Remove Class : ' + k + ' to ' + v);
                            currentElement.removeClass(v);
                        }
                        else {
                            console.log('Class : ' + k + ' to ' + v);
                            currentElement.addClass(v);
                        }
                    });
                }
                /*******CSS******/
                if (domElements.elementController[i].css != null && domElements.elementController[i].css != 'undefined') {
                    $.each(domElements.elementController[i].css, function (k, v) {
                        if (k == 'display') {
                            if (v == 'block' || v == 'show') {
                                currentElement.show();
                            }
                            else if (v == 'none' || v == 'hide') {
                                currentElement.hide();
                            }
                        }
                        else {
                            currentElement.css(k, v);
                        }
                    });
                }
                /*******HTML******/
                if (domElements.elementController[i].html == 1) {
                    console.log('HTML changes in ' + domElements.elementController[i].id);
                    currentElement.html(domElements.elementController[i].html_content);
                }
                /******* Focus Field ******/
                if (domElements.elementController[i].focusFields == 1) {
                    console.log(domElements.elementController[i].id);
                    $('#' + domElements.elementController[i].id).addClass('error').attr('onclick', "setFieldError('" + domElements.elementController[i].id + "','error')");
                }
                /******* RESET FORM ******/
                if (domElements.elementController[i].resetForm == 1) {
                    console.log('Resetting form with ID  ' + domElements.elementController[i].id);
                    $("#" + domElements.elementController[i].id)[0].reset(); // Clear Previous div if not to append
                    //$(".selectpicker").selectpicker("refresh");
                }
                /******* Modals Control ******/
                if (domElements.elementController[i].modalControl == 1) {
                    console.log('Control of Modal ID:  ' + domElements.elementController[i].id);
                    setTimeout(function () {
                        if (domElements.elementController[i].modalClose == 1) {
                            $("#" + domElements.elementController[i].id).modal("hide");
                        }
                        if (domElements.elementController[i].modalOpen == 1) {
                            $("#" + domElements.elementController[i].id).modal("show");
                        }
                    }, 1000);
                }
                /***<OPTION>(just for AddOrderForm for now ) ***/
                if (domElements.elementController[i].optAppend != null && domElements.elementController[i].optAppend != 'undefined') {
                    //$('#product option:gt(0)').remove();
                    var newList = '';
                    newList += '<option value="0">Select the product</option>'
                    $.each(domElements.elementController[i].optAppend, function (k, v) {
                        console.log('Value : ' + k + ' to ' + v);
                        //newList.append($("<option></option>").attr("value",k).text(v));
                        newList += '<option value=' + k + '>' + v + '</option>'
                        //newList += $("<option></option>").attr("value",k).text(v);
                        //console.log(newList);
                        //alert(newList);

                        //$('#product').append($("<option></option>").attr("value",k).text(v));
                        //$('#product').html($("<option></option>").attr("value",k).text(v));
                    });
                    $('#product').html(newList);
                }

            }
        });
    }

}

function ajaxCallModal(modal_id, ajaxUrl) {

    console.log('Modal ID: ' + modal_id);
    console.log('Ajax URL: ' + ajaxUrl);
    $.ajax
    ({
        type: 'POST', // POST or GET
        url: ajaxUrl, // The URL ( Dont touch )
        //data: $form_data, // The Form Data ( Dont touch )
        xhrFields: {withCredentials: true},
        success: function (data, textStatus, jqXHR) {
            console.log("Data: " + data);
            if (IsJsonString(data) == false) {
                console.log("Is not json !");
                $('#' + modal_id).modal('show');
                $('#' + modal_id + '-title').html('Error on Get the Info!');
                $('#' + modal_id + '-body').html('<p>The system have an error while try to get the info. Please refresh the page. If the problem persist contact the administration</p>');
            }

            var json_response = jQuery.parseJSON(data); // Parse the Json that we got from the POST
            console.log("Data array:" + json_response);
            if (json_response.status == 'ok') {

                $('#' + modal_id).modal('show');

                if (json_response.modalBody == '' || json_response.modalBody == null || json_response.modalBody == 'undefined') {
                    $('#' + modal_id + '-body').html('Error on Get the Body Content.');
                }
                else {
                    $('#' + modal_id + '-body').html(json_response.modalBody);
                }
                if (json_response.modalTitle != '' || json_response.modalTitle != null || json_response.modalTitle != 'undefined') {
                    $('#' + modal_id + '-title').html(json_response.modalTitle);
                }
            }
            else {
                console.log('Status: ' + json_response.status);
                console.log('Message: ' + json_response.message);
                $('#' + modal_id).modal('hide');
                $('#' + modal_id + '-title').html('');
                $('#' + modal_id + '-body').html('');
            }


        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('Ajax response error');
            var json_response = jQuery.parseJSON(data); // Parse the Json that we got from the POST
            $('#' + modal_id).modal('hide');
            $('#' + modal_id + '-title').html('');
            $('#' + modal_id + '-body').html('');
        }
    });


}

function generateApiKey(url, fieldID, errorsDiv, loadingDiv) {

    $('#' + errorsDiv).html('');
    $('#' + loadingDiv).css('display', 'block');

    console.log("Field to update : " + fieldID);
    console.log("GET Url : " + url);

    $.ajax
    ({
        type: 'GET', // POST or GET
        url: url, // The URL ( Dont touch )
        //data: $form_data, // The Form Data ( Dont touch )
        xhrFields: {withCredentials: true},
        success: function (data, textStatus, jqXHR) {
            console.log(data);
            if (IsJsonString(data) == false) {
                $('#' + errorsDiv).html('<div class="alert error rounded" data-close="true"><strong>Opps!</strong> There was an error performing your request! If the problem persists please contact the administration</div>');
                $('#' + loadingDiv).css('display', 'none');
            }

            var json_response = jQuery.parseJSON(data); // Parse the Json that we got from the POST
            console.log("Data array:" + json_response);

            if (json_response.status == 'ok' && json_response.newContent != '') {

                $('#' + errorsDiv).html("" + json_response.html_data);
                $('#' + loadingDiv).css('display', 'none');
                $('#' + fieldID).val(json_response.newContent);
            }
            else {
                $('#' + errorsDiv).html("" + json_response.html_data);
                $('#' + loadingDiv).css('display', 'none');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#' + errorsDiv).html('<div class="alert error rounded" data-close="true"><strong>Opps!</strong> There was an error performing your request! If the problem persists please contact the administration</div>');
            $('#' + loadingDiv).css('display', 'none');
        }

    });
}

function authAjax(Page) {
    console.log(Page);

    var loginDiv = 'LoginDiv';
    var registerDiv = 'RegisterDiv';
    var forgotDiv = 'ForgotDiv';
    var update_passwordDiv = 'update_passwordDiv';

    if (Page == '' || Page == 'undefined') {
        Page = 'login';
    }
    if (Page == 'login') {
        console.log('Into Login');
        $('#' + registerDiv).fadeOut('slow');
        $('#' + forgotDiv).fadeOut('slow');
        $('#' + update_passwordDiv).fadeOut('slow');
        $('#' + loginDiv).fadeIn(700);
    }
    if (Page == 'register') {
        console.log('Into Register');
        $('#' + loginDiv).fadeOut('slow');
        $('#' + forgotDiv).fadeOut('slow');
        $('#' + update_passwordDiv).fadeOut('slow');
        $('#' + registerDiv).fadeIn(0);
    }
    if (Page == 'forgot') {
        console.log('Into Forgot');
        $('#' + registerDiv).fadeOut('slow');
        $('#' + loginDiv).fadeOut('slow');
        $('#' + update_passwordDiv).fadeOut('slow');
        $('#' + forgotDiv).fadeIn(700);
    }
    if (Page == 'update_password') {
        console.log('Update Forgot');
        $('#' + registerDiv).fadeOut('slow');
        $('#' + loginDiv).fadeOut('slow');
        $('#' + forgotDiv).fadeOut('slow');
        $('#' + update_passwordDiv).fadeIn(0);
    }
}

function unlockedFields(field, defaultContent) {
    FieldAttr = document.getElementById("" + field).disabled;
    console.log(FieldAttr);

    if (FieldAttr == false) {
        console.log('Disabled On');
        $('#' + field).attr('disabled', 'disabled').addClass('disabled').val(defaultContent);
        $('#keyField').html('Unlock Field');
    }
    else if (FieldAttr == true) {
        console.log('Disabled Off');
        $('#' + field).removeAttr('disabled').removeClass('disabled');
        $('#keyField').html('Lock Field');

    }
}

function setFieldError(fieldId, fieldClass) {
    $('#' + fieldId).removeClass('' + fieldClass);
    return false;
}

function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}



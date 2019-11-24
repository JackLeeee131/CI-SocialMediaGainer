



//-------- Instagram Package Setup validation ------------------

var package_setup = $('#package_setup');
var errorpackage_setup = $('.alert-danger', package_setup);
var successpackage_setup = $('.alert-success', package_setup);

package_setup.validate({
    errorElement: 'span', //default input error message container
    errorClass: 'help-block help-block-error', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    ignore: "", // validate all fields including form hidden input
    rules: {
        likes_range_from: {
            required: true,
            digits: true
        },
        likes_range_to: {
            required: true,
            digits: true
        },
        likes_discount: {
            required: true,
            digits: true
        },
        likes_min_order: {
            required: true,
            digits: true
        },
        likes_max_order: {
            required: true,
            digits: true
        },
        likes_price: {
            required: true,
        },


        views_range_from: {
            required: true,
            digits: true
        },
        views_range_to: {
            required: true,
            digits: true
        },
        views_discount: {
            required: true,
            digits: true
        },
        views_min_order: {
            required: true,
            digits: true
        },
        views_max_order: {
            required: true,
            digits: true
        },
        views_price: {
            required: true,
        },


        comments_range_from: {
            required: true,
            digits: true
        },
        comments_range_to: {
            required: true,
            digits: true
        },
        comments_discount: {
            required: true,
            digits: true
        },
        comments_min_order: {
            required: true,
            digits: true
        },
        comments_max_order: {
            required: true,
            digits: true
        },
        comments_price: {
            required: true,
        },


        followers_range_from: {
            required: true,
            digits: true
        },
        followers_range_to: {
            required: true,
            digits: true
        },
        followers_discount: {
            required: true,
            digits: true
        },
        followers_min_order: {
            required: true,
            digits: true
        },
        followers_max_order: {
            required: true,
            digits: true
        },
        followers_price: {
            required: true,
        }


    },

    messages: {

        likes_range_from: "Likes Range From is required",
        likes_range_to: "Likes Range To is required",
        likes_discount: "Likes Discount is required",
        likes_min_order: "Likes Minimum Order is required",
        likes_max_order: "Likes Maximum Order is required",
        likes_price: "Likes Price is required",

        views_range_from: "Views Range From is required",
        views_range_to: "Views Range To is required",
        views_discount: "Views Discount is required",
        views_min_order: "Views Minimum Order is required",
        views_max_order: "Views Maximum Order is required",
        views_price: "Views Price is required",

        comments_range_from: "Comments Range From is required",
        comments_range_to: "Comments Range To is required",
        comments_discount: "Comments Discount is required",
        comments_min_order: "Comments Minimum Order is required",
        comments_max_order: "Comments Maximum Order is required",
        comments_price: "Comments Price is required",

        followers_range_from: "Followers Range From is required",
        followers_range_to: "Followers Range To is required",
        followers_discount: "Followers Discount is required",
        followers_min_order: "Followers Minimum Order is required",
        followers_max_order: "Followers Maximum Order is required",
        followers_price: "Followers Price is required",
    },

    errorPlacement: function (error, element) { // render error placement for each input type
        if (element.parent(".input-group").size() > 0) {
            error.insertAfter(element.parent(".input-group"));
        } else if (element.attr("data-error-container")) {
            error.appendTo(element.attr("data-error-container"));
        } else if (element.parents('.radio-list').size() > 0) {
            error.appendTo(element.parents('.radio-list').attr("data-error-container"));
        } else if (element.parents('.radio-inline').size() > 0) {
            error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
        } else if (element.parents('.checkbox-list').size() > 0) {
            error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
        } else if (element.parents('.checkbox-inline').size() > 0) {
            error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
        } else {
            error.insertAfter(element); // for other inputs, just perform default behavior
        }
    },
    invalidHandler: function (event, validator) { //display error alert on form submit
        successpackage_setup.hide();
        errorpackage_setup.hide();
    },
    highlight: function (element) { // hightlight error inputs
        $(element)
            .closest('.form-group').addClass('has-error'); // set error class to the control group
    },
    unhighlight: function (element) { // revert the change done by hightlight
        $(element)
            .closest('.form-group').removeClass('has-error'); // set error class to the control group
    },
    success: function (label) {
        label
            .closest('.form-group').removeClass('has-error'); // set success class to the control group
    }
});

///----------------------------------//






//-------- API Setup validation ------------------

var api_setup = $('#api_setup');
var errorapi_setup = $('.alert-danger', api_setup);
var successapi_setup = $('.alert-success', api_setup);

api_setup.validate({
    errorElement: 'span', //default input error message container
    errorClass: 'help-block help-block-error', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    ignore: "", // validate all fields including form hidden input
    rules: {
        likes_service_id: {
            required: true
        },
        views_service_id: {
            required: true
        },
        comments_service_id: {
            required: true
        },
        followers_service_id: {
            required: true
        },
        api_url: {
            required: true
        },
        api_key: {
            required: true
        }
    },

    messages: {
        likes_service_id: "Likes Service Id is required",
        views_service_id: "Views Service Id is required",
        comments_service_id: "Comments Service Id is required",
        followers_service_id: "Followers Service Id is required",
        api_url: "API URL is required",
        api_key: "API KEY is required"
    },

    errorPlacement: function (error, element) { // render error placement for each input type
        if (element.parent(".input-group").size() > 0) {
            error.insertAfter(element.parent(".input-group"));
        } else if (element.attr("data-error-container")) {
            error.appendTo(element.attr("data-error-container"));
        } else if (element.parents('.radio-list').size() > 0) {
            error.appendTo(element.parents('.radio-list').attr("data-error-container"));
        } else if (element.parents('.radio-inline').size() > 0) {
            error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
        } else if (element.parents('.checkbox-list').size() > 0) {
            error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
        } else if (element.parents('.checkbox-inline').size() > 0) {
            error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
        } else {
            error.insertAfter(element); // for other inputs, just perform default behavior
        }
    },

    invalidHandler: function (event, validator) { //display error alert on form submit
        successapi_setup.hide();
        errorapi_setup.hide();
    },
    highlight: function (element) { // hightlight error inputs
        $(element)
            .closest('.form-group').addClass('has-error'); // set error class to the control group
    },
    unhighlight: function (element) { // revert the change done by hightlight
        $(element)
            .closest('.form-group').removeClass('has-error'); // set error class to the control group
    },
    success: function (label) {
        label
            .closest('.form-group').removeClass('has-error'); // set success class to the control group
    }
});

///----------------------------------//




//-------- Payment Setup validation ------------------

var payment_setup = $('#payment_setup');
var errorpayment_setup = $('.alert-danger', payment_setup);
var successpayment_setup = $('.alert-success', payment_setup);

payment_setup.validate({
    errorElement: 'span', //default input error message container
    errorClass: 'help-block help-block-error', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    ignore: "", // validate all fields including form hidden input
    rules: {
        payment_method: {
            required: true
        },
        amount: {
            required: true
        },
        email: {
            required: true
        }
    },

    messages: {
        payment_method: "Payment Method is required",
        amount: "Amount is required",
        email:{
            required: "Email Address is Required.",
            email: "Enter a valid email address."
        }
    },

    errorPlacement: function (error, element) { // render error placement for each input type
        if (element.parent(".input-group").size() > 0) {
            error.insertAfter(element.parent(".input-group"));
        } else if (element.attr("data-error-container")) {
            error.appendTo(element.attr("data-error-container"));
        } else if (element.parents('.radio-list').size() > 0) {
            error.appendTo(element.parents('.radio-list').attr("data-error-container"));
        } else if (element.parents('.radio-inline').size() > 0) {
            error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
        } else if (element.parents('.checkbox-list').size() > 0) {
            error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
        } else if (element.parents('.checkbox-inline').size() > 0) {
            error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
        } else {
            error.insertAfter(element); // for other inputs, just perform default behavior
        }
    },

    invalidHandler: function (event, validator) { //display error alert on form submit
        successpayment_setup.hide();
        errorpayment_setup.hide();
    },
    highlight: function (element) { // hightlight error inputs
        $(element)
            .closest('.form-group').addClass('has-error'); // set error class to the control group
    },
    unhighlight: function (element) { // revert the change done by hightlight
        $(element)
            .closest('.form-group').removeClass('has-error'); // set error class to the control group
    },
    success: function (label) {
        label
            .closest('.form-group').removeClass('has-error'); // set success class to the control group
    }
});

///----------------------------------//



//-------- Payment Setup validation ------------------

var admin_comments = $('#admin_comments');
var erroradmin_comments = $('.alert-danger', admin_comments);
var successadmin_comments= $('.alert-success', admin_comments);

admin_comments.validate({
    errorElement: 'span', //default input error message container
    errorClass: 'help-block help-block-error', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    ignore: "", // validate all fields including form hidden input
    rules: {
        comment_subject: {
            required: true
        },
        comment_description: {
            required: true
        }
    },

    messages: {
        comment_subject: "Comment Subject is required",
        comment_description: "Comment Description is required"
    },

    errorPlacement: function (error, element) { // render error placement for each input type
        if (element.parent(".input-group").size() > 0) {
            error.insertAfter(element.parent(".input-group"));
        } else if (element.attr("data-error-container")) {
            error.appendTo(element.attr("data-error-container"));
        } else if (element.parents('.radio-list').size() > 0) {
            error.appendTo(element.parents('.radio-list').attr("data-error-container"));
        } else if (element.parents('.radio-inline').size() > 0) {
            error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
        } else if (element.parents('.checkbox-list').size() > 0) {
            error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
        } else if (element.parents('.checkbox-inline').size() > 0) {
            error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
        } else {
            error.insertAfter(element); // for other inputs, just perform default behavior
        }
    },

    invalidHandler: function (event, validator) { //display error alert on form submit
        successadmin_comments.hide();
        erroradmin_comments.hide();
    },
    highlight: function (element) { // hightlight error inputs
        $(element)
            .closest('.form-group').addClass('has-error'); // set error class to the control group
    },
    unhighlight: function (element) { // revert the change done by hightlight
        $(element)
            .closest('.form-group').removeClass('has-error'); // set error class to the control group
    },
    success: function (label) {
        label
            .closest('.form-group').removeClass('has-error'); // set success class to the control group
    }
});

///----------------------------------//
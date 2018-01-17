$(document).ready(function() {
	// validate client form
    jQuery.validator.addMethod("digitsAndPlus", function (value, element) {
            return this.optional(element) || /^\+[0-9]*$/i.test(value);
        }, "Please enter only Numbers, Comma and Dot.");

	$('#createClientForm').validate({
        rules: {
            name: {
                required: true
            },
            country: {
                required: true
            },
            client_id: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            phone_no: {
                required: true
            },
            address: {
                required: true
            }
        },     
        messages: {
            name: {
                required: "Please Enter Name"
            },
            country: {
                required: "Please Select a Country Name"
            },
            client_id: {
                required: "Please Enter Client Id"
            },
            email: {
                required: "Please Enter Email Address",
                email: "Please Enter a Valid Email Address"
            },
            phone_no: {
                required: "Please Enter Phone No.",
            },
            address: {
                required: "Please Enter Address"
            }
        }
    });
    //Add validation rule for dynamically generated name fields
	$('form#createClientForm').on('submit', function(event) {
	    $('.project_title_input').each(function() {
	        $(this).rules("add", 
            	{
                required: true,
                messages: {
                    required: "Enter Project Title",
                }
            });
	    });
	    $('.project_description_textarea').each(function() {
	        $(this).rules("add", 
            	{
                required: true,
                messages: {
                    required: "Enter Project Description",
                }
            });
	    });
	});

    // Manage Invoice Id form validation
    $('#manageInvoiceId').validate({
        rules: {
            invoice_digits: {
                digits: true,
                max:12
            },
            starting_no: {
                digits: true,
                max:100000000000
            }
        },     
        messages: {
            invoice_digits: {
                digits: "Please Enter digits only.",
                max: "Please number less than or equal to 12"
            },
            starting_no: {
                digits: "Please Enter digits only.",
                max: "Please number less than or equal to 100000000000"
                
            }
        }
    });
    // invoiceForm validate
    $('#invoiceForm').validate({
        rules: {
            invoice_type: {
                required: true
            },
            client_name: {
                required: true
            }
            ,
            client_address: {
                required: true
            },
            client_gstin: {
                required: true
            },
            client_state: {
               required: true
            },
            mode_of_invoice: {
               required: true
            },
            invoice_no: {
               required: true
            },
            sac_code: {
               required: true
            },
            admin_gstin: {
               required: true
            },
            admin_state: {
               required: true
            },
            desc_of_service: {
               required: true
            },
            price: {
               required: true,
               digits: true
            }
            ,
            cgst: {
               digits: true
            },
            sgst: {
               digits: true
            },
            igst: {
               digits: true
            }
        },     
        messages: {
            invoice_type: {
                required: "Please Select Invoice Type."
            },
            client_name: {
                required: "Please Enter Client Name."
            },
            client_address: {
                 required: "Please Enter Client Address."
                
            },
            client_gstin: {
                 required: "Please Enter Client GSTIN."
                
            },
            client_state: {
               required: "Please Select Client state."
            },
            mode_of_invoice: {
               required: "Please Select Mode of Invoice."
            },
            invoice_no: {
               required: "Please Enter Invoice No."
            },
            sac_code: {
               required: "Please Select SAC code."
            },
            admin_gstin: {
               required: "Please Enter your GSTIN."
            },
            admin_state: {
               required: "Please Select your state."
            },
            desc_of_service: {
               required: "Please Enter Service Description."
            },
            price: {
               required: "Please Enter Price.",
               digits: "Please Enter only Number."
            },
            cgst: {
               digits: "Please Enter only Number-will be calculated as % (Percentage)."
            },
            sgst: {
               digits: "Please Enter only Number-will be calculated as % (Percentage)."
            },
            igst: {
               digits: "Please Enter only Number-will be calculated as % (Percentage)."
            }
        }
    });
    //Add validation rule for dynamically generated name fields
    $('form#invoiceForm').on('submit', function(event) {
        var count = 0;
        $('input.gst-validate').each(function() {
            //alert($(this).val().lenght);
            if($(this).val() == null) {
                var messageGST = 'Please provide at least one GST %';
                count++;
                alert(messageGST);
            }
        });
        //alert(count);
        if(count == 3) {
           alert(messageGST); 
        }
        $('input.quantity').each(function() {
            $(this).rules("add", 
                {
                    digits: true,
                    required:true
                })
        });
         $('input.price').each(function() {
            $(this).rules("add", 
                {
                    digits: true,
                    required:true
                })
        });
        // $('input.cgst').each(function() {
        //     $(this).rules("add", 
        //         {
        //             digits: true,
        //             required:true
        //         })
        // });
        // $('input.sgst').each(function() {
        //     $(this).rules("add", 
        //         {
        //             digits: true,
        //             required:true
        //         })
        // });
        // $('input.igst').each(function() {
        //     $(this).rules("add", 
        //         {
        //             digits: true,
        //             required:true
        //         })
        // });
        $('input.desc_of_service').each(function() {
            $(this).rules("add", 
                {
                    required:true
                })
        });
        // prevent default submit action         
            
            // test if form is valid 
            if($('form#invoiceForm').validate().form()) {
                console.log("validates");
            } else {
                event.preventDefault();
                console.log("does not validate");
            }


        // initialize the validator
        $('form#invoiceForm').validate()
    });

    // validate receive invoice form

    $('#receiveInvoiceForm').validate({
        rules: {
            client_name: {
                required: true
            },
            client_address: {
                required: true
            },
            client_gstin: {
                required: true
            },
            client_email: {
               required: true,
               email: true
            },
            client_contact_no: {
               required: true,
            },
            invoice_date: {
               required: true
            },
            invoice_amount: {
               required: true
            },
            desc_of_service: {
               required: true
            },
            price: {
               required: true,
               digits: true
            },
            cgst: {
               digits: true
            },
            sgst: {
               digits: true
            },
            igst: {
               digits: true
            }
        },     
        messages: {
            client_name: {
                required: "Please Enter Client Name."
            },
            client_address: {
                 required: "Please Enter Client Address."
                
            },
            client_gstin: {
                 required: "Please Enter Client GSTIN."
                
            },
            client_email: {
               required: "Please Select Client state.",
               email: "Please Enter a Valid Email."
            },
            client_contact_no: {
               required: "Please Enter Contact No."
            },
            invoice_date: {
               required: "Please Enter Invoic Date."
            },
            invoice_amount: {
               required: "Please Enter Invoice Amount."
            },
            admin_gstin: {
               required: "Please Enter your GSTIN."
            },
            desc_of_service: {
               required: "Please Enter Service Description."
            },
            price: {
               required: "Please Enter Price.",
               digits: "Please Enter only Number."
            },
            cgst: {
               digits: "Please Enter only Number-will be calculated as % (Percentage)."
            },
            sgst: {
               digits: "Please Enter only Number-will be calculated as % (Percentage)."
            },
            igst: {
               digits: "Please Enter only Number-will be calculated as % (Percentage)."
            }
        }
    });

    // dynamic added field of receive invoice
    $('form#receiveInvoiceForm').on('submit', function(event) {
        var count = 0;
        $('input.gst-validate').each(function() {
            //alert($(this).val().lenght);
            if($(this).val() == null) {
                var messageGST = 'Please provide at least one GST %';
                count++;
                alert(messageGST);
            }
        });
        //alert(count);
        if(count == 3) {
           alert(messageGST); 
        }
        $('input.quantity').each(function() {
            $(this).rules("add", 
                {
                    digits: true,
                    required:true
                })
        });
         $('input.price').each(function() {
            $(this).rules("add", 
                {
                    digits: true,
                    required:true
                })
        });
        // $('input.cgst').each(function() {
        //     $(this).rules("add", 
        //         {
        //             digits: true,
        //             required:true
        //         })
        // });
        // $('input.sgst').each(function() {
        //     $(this).rules("add", 
        //         {
        //             digits: true,
        //             required:true
        //         })
        // });
        // $('input.igst').each(function() {
        //     $(this).rules("add", 
        //         {
        //             digits: true,
        //             required:true
        //         })
        // });
        $('input.desc_of_service').each(function() {
            $(this).rules("add", 
                {
                    required:true
                })
        });
        // prevent default submit action         
            
            // test if form is valid 
            if($('form#receiveInvoiceForm').validate().form()) {
                console.log("validates");
            } else {
                event.preventDefault();
                console.log("does not validate");
            }


        // initialize the validator
        $('form#receiveInvoiceForm').validate()
    });
});

$(document).ready(function() {
    // Change Password form   Validation
    $("#changePasswordForm").validate({
        rules: {
            currentPassword: {
                required: true,
                minlength: 6
            },
            newPassword: {
                required: true,
                minlength: 6
            },
            confirmPassword: {
                required: true,
                minlength: 6,
                equalTo : "#password"
            }
        },     
        messages: {
            currentPassword: {
                required: "Please enter your current password ",
                minlength: "Your current password must be of 6 characters" 
            },
            newPassword: {
                required: "Please enter your password ",
                minlength: "Your password must be consist of at least 6 characters" 
            },
            confirmPassword: {
                required: "Please re-enter your password ",
                minlength: "Your password must be consist of at least 6 characters" ,
                equalTo : "Password doesnot match !!!"
            } 
        }
    });

    // create Employee validation form
    $("#createEmployeeForm").validate({
        rules: {
            name : {
                required: true,
                minlength: 3
            },
            designation : {
                required: true
            },
            password: {
                required: true,
                minlength: 6
            },
            confirm_password: {
                required: true,
                minlength: 6,
                equalTo : "#password"
            },
            bank_account: {
                required:true
            },
            ifsc_code : {
                required: true
            },
            employee_id: {
                required:true
            },
            email: {
                required:true,
                email: true
            },
            phone_no: {
                required:true,
                digits: true,
                minlength:10,
                maxlength:10
            },
            current_address: {
                required: true
            },
            permanent_address: {
                required:true
            },
            father_name: {
                required:true
            },
            date_of_joining: {
                required:true
            },
            date_of_birth : {
                required:true
            },
            pan: {
                required: true
            }
        },     
        messages: {
            name : {
                required: "Please enter Name of the Employee",
                minlength: "Name must be consist of at least 3 characters" 
            },
            designation : {
                required: "Please Select Employee designation"
            },
            password: {
                required: "Please Enter Password ",
                minlength: "Password must be consist of at least 6 characters" 
            },
            confirm_password: {
                required: "Please re-enter your Password ",
                minlength: "Password must be consist of at least 6 characters" ,
                equalTo : "Password doesnot match !!!"
            },
            bank_account: {
                required: "Please Enter Bank Account Details"
            },
            ifsc_code: {
                required: "Please Enter IFSC code"
            },
            employee_id: {
                required: "Please Enter Employee Id"
            },
            email: {
                required: "Please Enter Employee Email",
                email: "Please Enter a valid Email Address"
            },
            phone_no: {
                required: "Please Enter Employee Phone Number",
                digit: "Please Enter digits only",
                 minlength: "Phone Number must be of atleast 10 digits",
                maxlength: "Phone Number should be grearter than 10 digits"
            },
            current_address: {
                required:"Plese Enter Current Address"
            },
            permanent_address: {
                required: "Please Enter Permanent Address"
            },
            father_name: {
                required: "Please Enter Employee's Father Name"
            },
            date_of_joining: {
                required: "Please Enter Employee's Date of Joining"
            },
            date_of_birth: {
                required: "Please Enter Employee's Date of Birth"
            },
            pan: {
                required: "Please Enter Employess's PAN"
            }

        }
    });

    // payroll for validation

    
    jQuery.validator.addMethod("digitsDotComma", function (value, element) {
        return this.optional(element) || /^[0-9,]*(\.\d{0,6})?$/i.test(value);
    }, "Please enter only Numbers, Comma and Dot.");

    $("#payrollForm").validate({
        rules: {
            name: {
                required: true
            },
            basic: {
                required: true,
                digitsDotComma: true
            },
            overtime: {
               digits: true
            },
            house_rent_allowance: {
               digitsDotComma: true
            },
            conveyance_allowance: {
               digitsDotComma: true
            },
            special_allowance: {
               digitsDotComma: true
            },
            bonus: {
               digitsDotComma: true
            },
            professional_tax: {
               digitsDotComma: true
            },
            income_tax: {
               digitsDotComma: true
            },
            provident_fund: {
               digitsDotComma: true
            },
            health_insurance: {
               digitsDotComma: true
            },
            un_paid_days_count: {
               digits: true,
               min: 0,
               max: function(){ return parseInt($('#max_value').val());}
            },
            misc: {
               digitsDotComma: true
            }
        },     
        messages: {
            name: {
                required: "Please enter employee name"
            },
            basic: {
                required: "Please enter basic pay amount",
                digitsDotComma: "Please enter only Numbers, Comma and Dot." 
            },
            overtime: {
                digits: "Please enter only digits only." 
            },
            house_rent_allowance: {
                digitsDotComma: "Please enter only Numbers, Comma and Dot." 
            },
            conveyance_allowance: {
                digitsDotComma: "Please enter only Numbers, Comma and Dot." 
            },
            special_allowance: {
                digitsDotComma: "Please enter only Numbers, Comma and Dot." 
            },
            bonus: {
                digitsDotComma: "Please enter only Numbers, Comma and Dot." 
            },
            professional_tax: {
                digitsDotComma: "Please enter only Numbers, Comma and Dot." 
            },
            income_tax: {
                digitsDotComma: "Please enter only Numbers, Comma and Dot." 
            },
            provident_fund: {
                digitsDotComma: "Please enter only Numbers, Comma and Dot." 
            },
            health_insurance: {
                digitsDotComma: "Please enter only Numbers, Comma and Dot." 
            },
            un_paid_days_count: {
                digits: "Please enter only Numbers." 
            },
            misc: {
                digitsDotComma: "Please enter only Numbers, Comma and Dot." 
            }
        }
    });

    // Company Profile form validation

    $("#companyProfileForm").validate({
        rules: {
            company_name: {
                required: true
            },
            company_address: {
                required: true
            },
            contact_number: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            gstin: {
                required: true
            },
            pan: {
                required: true
            }
        },     
        messages: {
            company_name: {
                required: "Please Enter Company Name"
            },
            company_address: {
                required: "Please Enter Company Address"
            },
            contact_number: {
                required: "Please Enter Contact Number"
            },
            email: {
                required: "Please Enter Email Address",
                email: "Please Enter a Valid Email Address"
            },
            gstin: {
                required: "Please Enter GSTIN"
            },
            pan: {
                required: "Please Enter PAN"
            }

        }
    });
    // fade error message div
    $( ".clear-error-msg" ).click(function() {
        $( ".error-message" ).fadeOut( "slow" );
    });
});

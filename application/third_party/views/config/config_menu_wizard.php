<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Settings Menu</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Admin</a>
            </li>
            <li>
                <a>Config</a>
            </li>
            <li class="active">
                <strong>Menus</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<!-- START WIZARD -->
<div class="wrapper wrapper-content animated fadeInRight">    
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Wizard with Validation</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <h2>
                        Validation Wizard Form
                    </h2>
                    <p>
                        This example show how to use Steps with jQuery Validation plugin.
                    </p>

                    <form id="form" action="#" class="wizard-big">
                        <h1>Account</h1>
                        <fieldset>
                            <h2>Account Information</h2>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label>Username *</label>
                                        <input id="userName" name="userName" type="text" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label>Password *</label>
                                        <input id="password" name="password" type="text" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password *</label>
                                        <input id="confirm" name="confirm" type="text" class="form-control required">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="text-center">
                                        <div style="margin-top: 20px">
                                            <i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </fieldset>
                        <h1>Profile</h1>
                        <fieldset>
                            <h2>Profile Information</h2>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>First name *</label>
                                        <input id="name" name="name" type="text" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label>Last name *</label>
                                        <input id="surname" name="surname" type="text" class="form-control required">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Email *</label>
                                        <input id="email" name="email" type="text" class="form-control required email">
                                    </div>
                                    <div class="form-group">
                                        <label>Address *</label>
                                        <input id="address" name="address" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <h1>Warning</h1>
                        <fieldset>
                            <div class="text-center" style="margin-top: 120px">
                                <h2>You did it Man :-)</h2>
                            </div>
                        </fieldset>

                        <h1>Finish</h1>
                        <fieldset>
                            <h2>Terms and Conditions</h2>
                            <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms">I agree with the Terms and Conditions.</label>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>


<!-- END WIZARD -->

<script type="text/javascript">
    /** START SETTING WIZARD **/

    $(document).ready(function(){
        $("#wizard").steps();
        $("#form").steps({
            bodyTag: "fieldset",
            onStepChanging: function (event, currentIndex, newIndex)
            {
                // Always allow going backward even if the current step contains invalid fields!
                if (currentIndex > newIndex)
                {
                    return true;
                }

                // Forbid suppressing "Warning" step if the user is to young
                if (newIndex === 3 && Number($("#age").val()) < 18)
                {
                    return false;
                }

                var form = $(this);

                // Clean up if user went backward before
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    $(".body:eq(" + newIndex + ") label.error", form).remove();
                    $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                }

                // Disable validation on fields that are disabled or hidden.
                form.validate().settings.ignore = ":disabled,:hidden";

                // Start validation; Prevent going forward if false
                return form.valid();
            },
            onStepChanged: function (event, currentIndex, priorIndex)
            {
                // Suppress (skip) "Warning" step if the user is old enough.
                if (currentIndex === 2 && Number($("#age").val()) >= 18)
                {
                    $(this).steps("next");
                }

                // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                if (currentIndex === 2 && priorIndex === 3)
                {
                    $(this).steps("previous");
                }
            },
            onFinishing: function (event, currentIndex)
            {
                var form = $(this);

                // Disable validation on fields that are disabled.
                // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                form.validate().settings.ignore = ":disabled";

                // Start validation; Prevent form submission if false
                return form.valid();
            },
            onFinished: function (event, currentIndex)
            {
                var form = $(this);

                // Submit form input
                form.submit();
            }
        }).validate({
                        errorPlacement: function (error, element)
                        {
                            element.before("");
                        },
                        rules: {
                            confirm: {
                                equalTo: "#password"
                            }
                        }
                    });


         $("#form").bootstrapValidator({
            /** live: 'disabled', **/
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {            
                userName: {
                    message: 'Username anda salah',
                    validators: {
                        notEmpty: {
                            message: 'Username tidak boleh kosong'
                        },                    
                        regexp: {
                            regexp: /^[a-zA-Z0-9\.]+$/,
                            message: 'Username hanya boleh huruf/nomor/titik'
                        }
                    }
                }
            }
        });
   });


/** END SETTING WIZARD **/
    
</script>



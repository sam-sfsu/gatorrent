<!--Copyright San Francisco State University Software Engineering CSC 648/848 F16G13-->

<div class="container">
    <div class="row">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-4">
            <form id="registrationForm" class="form-horizontal" action='<?php echo URL ?>register/registerUser' method="POST">
                <fieldset>
                    <br />
                    <div id="legend">
                        <legend class="">Create Account</legend>
                    </div>
                    <div class="form-group">
                        <!-- First name -->
                        <label class="control-label">Full Name*</label>
                        <div class="controls">
                            <input type="text" id="firstName" name="firstName" placeholder="First Name" class="form-control" value="<?php if (isset($currentForm['firstName'])) { echo htmlspecialchars($currentForm['firstName']); } ?>">
                            <?php if (isset($formErrors['firstName'])) { ?>
                                <span style="color:red"><?php echo $formErrors['firstName']; ?></span>
                                <br />
                            <?php } ?>
                            <br />
                            <input type="text" id="lastName" name="lastName" placeholder="Last Name" class="form-control" value="<?php if (isset($currentForm['firstName'])) { echo htmlspecialchars($currentForm['lastName']); } ?>">
                            <?php if (isset($formErrors['lastName'])) { ?>
                                <span style="color:red"><?php echo $formErrors['lastName']; ?></span>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- User type -->
                    <div class="form-group">
                        <label for="userType">Identify yourself as*</label>
                        <select class="form-control" id="userType" name="userType">
                            <option value="" <?php if (isset($currentForm['userType']) && $currentForm['userType'] === '') { echo htmlspecialchars('selected'); } ?>>--Select one--</option>
                            <option value="Renter" <?php if (isset($currentForm['userType']) && $currentForm['userType'] === 'Renter') { echo htmlspecialchars('selected'); } ?>>Renter</option>
                            <option value="Lessor" <?php if (isset($currentForm['userType']) && $currentForm['userType'] === 'Lessor') { echo htmlspecialchars('selected'); } ?>>Lessor</option>
                        </select>
                        <?php if (isset($formErrors['userType'])) { ?>
                            <span style="color:red"><?php echo $formErrors['userType']; ?></span>
                        <?php } ?>
                    </div>
                    <div class="form-group" id="studentIdField" style="display: none;">
                        <!-- Renter ID -->
                        <label class="control-label" for="renterId">Student ID</label>
                        <div class="controls">
                            <input type="text" id="renterId" name="renterId" placeholder="Please provide your student ID (required for renters)" class="form-control">
                            <?php if (isset($formErrors['renterId'])) { ?>
                                <span style="color:red"><?php echo $formErrors['renterId']; ?></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- E-mail -->
                        <label class="control-label" for="email">E-mail*</label>
                        <div class="controls">
                            <input type="text" id="email" name="email" placeholder="Please provide your E-mail" class="form-control" value="<?php if (isset($currentForm['email'])) { echo htmlspecialchars($currentForm['email']); } ?>">
                            <?php if (isset($formErrors['email'])) { ?>
                                <span style="color:red"><?php echo $formErrors['email']; ?></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- Password -->
                        <label class="control-label" for="password">Password*</label>
                        <div class="controls">
                            <input type="password" id="password" name="password" placeholder="Password should be at least 4 characters" class="form-control">
                            <?php if (isset($formErrors['password'])) { ?>
                                <span style="color:red"><?php echo $formErrors['password']; ?></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- Password Verify-->
                        <label class="control-label"  for="passwordVerify">Password Verify*</label>
                        <div class="controls">
                            <input type="password" id="passwordVerify" name="passwordVerify" placeholder="Verify password" class="form-control">
                        </div>
                        <?php if (isset($formErrors['passwordVerify'])) { ?>
                            <span style="color:red"><?php echo $formErrors['passwordVerify']; ?></span>
                        <?php } ?>
                    </div>
                    <br />
                    <!-- Conditions of use and Privacy notice agreement. -->
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="tosComply" name="tosComply">
                            I agree to GatorRent's <a href="<?php echo URL; ?>home/conditionsofuse" target="_blank">Conditions of Use</a> and <a href="<?php echo URL; ?>home/privacynotice" target="_blank">Privacy Notice</a>.
                        </label>
                        <?php if (isset($formErrors['tosComply'])) { ?>
                            <span style="color:red"><?php echo $formErrors['tosComply']; ?></span>
                        <?php } ?>
                    </div>
                    <br />
                    <div class="form-group">
                        <!-- Create account button -->
                        <div class="controls">
                            <button id="submitForm" class="btn btn-primary center-block">Create your GatorRent account</button>
                        </div>
                    </div>
                </fieldset>
            </form>
            <div class="footer">
                * Required field
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script type="text/javascript">
    $(function () {
        var storedForm = {};

        // Check for stored registration form data and restore
        if (sessionStorage.getItem('storedForm')) {
            storedForm = $.parseJSON(sessionStorage.getItem('storedForm'));
            if (storedForm.firstName) {
                $('#firstName').val(storedForm.firstName);
            }
            if (storedForm.lastName) {
                $('#lastName').val(storedForm.lastName);
            }
            if (storedForm.userType) {
                $('#userType').val(storedForm.userType);
            }
            if (storedForm.email) {
                $('#email').val(storedForm.email);
            }
        }

        // Listen for changes on certain fields and store them
        $('#firstName').on('change paste keyup', function () {
            storedForm.firstName = $(this).val();
        });
        $('#lastName').on('change paste keyup', function () {
            storedForm.lastName = $(this).val();
        });
        $('#userType').on('change', function () {
            storedForm.userType = $(this).val();
        });
        $('#email').on('change paste keyup', function () {
            storedForm.email = $(this).val();
        });

        // Store registration form data in session storage and submit form
        $('#submitForm').on('click submit', function (e) {
            e.preventDefault();
            var parsedForm = JSON.stringify(storedForm);
            sessionStorage.setItem('storedForm', parsedForm);
            $('#registrationForm').submit();
        })
    });
</script>

<script>
    $(function () {
        if ($('#userType').val() === "Renter")
            $("#studentIdField").show();
        else
            $("#studentIdField").hide();

        $("#userType").change(function() {
            if ($(this).val() === "Renter")
                $("#studentIdField").show();
            else
                $("#studentIdField").hide();
        });
    });
</script>

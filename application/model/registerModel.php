<?php
/*
 * Copyright San Francisco State University Software Engineering CSC 648/848 F16G13
 */
class RegisterModel {

    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function register($registration) {
        // Validate registration and store any errors
        $errors = $this->_validateRegistration($registration);

        // If registration is invalid, return errors to prompt user
        if (!empty($errors)) {
            return $errors;
        }

        // Query builder for adding new user to database
        $sql = "INSERT INTO ";
        if ($registration['userType'] == 'Renter') {
            $sql .= 'Renters (renter_id, ';
        } else if ($registration['userType'] == 'Lessor') {
            $sql .= 'Lessors (';
        }
        $sql .= "first_name, last_name, email, password, tos_comply) VALUES (";
        if ($registration['userType'] == 'Renter') {
            $sql .= ':renter_id, ';
        }
        $sql .= ":first_name, :last_name, :email, :password, :tos_comply)";

        $query = $this->db->prepare($sql);

        $password = hash('sha256', $registration['password']);

        $parameters = array();
        if ($registration['userType'] == 'Renter') {
            $parameters[':renter_id'] = $registration['renterId'];
        }
        $parameters[':first_name'] = $registration['firstName'];
        $parameters[':last_name'] = $registration['lastName'];
        $parameters[':email'] = $registration['email'];
        $parameters[':password'] = $password;
        $parameters[':tos_comply'] = 1;

        // DEBUG
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    /**
     * Function for validating registration before creating account.
     * @return boolean: true if valid; false if invalid
     */
    private function _validateRegistration($registration)
    {
        $errors = array();

        // userType
        if ($registration['userType'] !== 'Renter' && $registration['userType'] !== 'Lessor') {
            $errors['userType'] = 'Please select a valid user type.';
        }

        // firstName
        if (is_null($registration['firstName']) || $registration['firstName'] === '') {
            $errors['firstName'] = 'Please enter your first name.';
        } else if (!preg_match('/^[- A-Za-z]+$/', $registration['firstName'])) {
            $errors['firstName'] = 'First name may only contain letters, dashes (-), and spaces';
        } else if (strlen($registration['firstName']) > 20) {
            $errors['firstName'] = 'First name may be no longer than 20 characters.';
        }

        // lastName
        if (is_null($registration['lastName']) || $registration['lastName'] === '') {
            $errors['lastName'] = 'Please enter your last name';
        } else if (!preg_match('/^[- A-Za-z]+$/', $registration['lastName'])) {
            $errors['lastName'] = 'Last name may only contain letters, dashes (-), and spaces';
        } else if (strlen($registration['lastName']) > 20) {
            $errors['lastName'] = 'Last name may be no longer than 20 characters.';
        }

        // email
        if (is_null($registration['email']) || $registration['email'] === '') {
            $errors['email'] = 'Please enter your email address.';
        } else if (!filter_var($registration['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email.';
        } else if ($registration['userType'] === 'Renter' && substr($registration['email'], -13) !== 'mail.sfsu.edu') {
            $errors['email'] = 'Email must be a valid "mail.sfsu.edu" email.';
        } else if (strlen($registration['email']) > 40) {
            $errors['email'] = 'Email may be no longer than 40 characters.';
        }

        // password
        if (is_null($registration['password']) || $registration['password'] === '') {
            $errors['password'] = 'Please enter a valid password.';
        } else if (strlen($registration['password']) < 4) {
            $errors['password'] = 'Password must contain at least 4 characters.';
        }

        // passwordVerify
        if (!is_null($registration['password']) && $registration['password'] !== '') {
            if (is_null($registration['passwordVerify']) || $registration['passwordVerify'] === '') {
                $errors['passwordVerify'] = 'Please verify your password.';
            } else if ($registration['passwordVerify'] !== $registration['password']) {
                $errors['passwordVerify'] = 'Passwords do not match.';
            }
        }

        // renterId
        if ($registration['userType'] === 'Renter') {
            if (is_null($registration['renterId']) || $registration['renterId'] === '') {
                $errors['renterId'] = 'Student ID must be provided.';
            } else if (!ctype_digit($registration['renterId'])) {
                $errors['renterId'] = 'Student ID may consist of numbers only.';
            } else if (strlen($registration['renterId']) !== 9){
                $errors['renterId'] = 'Student ID must be 9 digits long.';
            }
        }

        // tosComply
        if (!isset($registration['tosComply']) || $registration['tosComply'] !== 'on') {
            $errors['tosComply'] = 'Please agree to the Conditions of Use and Privacy Notice.';
        }

        return $errors;
    }
}

?>

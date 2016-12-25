<?php
/*
 * Copyright San Francisco State University Software Engineering CSC 648/848 F16G13
 */
class UserModel {

    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function register($user_type, $first_name, $last_name, $email, $password, $renter_id = NULL) {
        $sql = "INSERT INTO ";
        if ($user_type == 'Renter') {
            $sql .= 'Renters (renter_id, ';
        } else if ($user_type == 'Lessor') {
            $sql .= 'Lessors (';
        }
        $sql .= "first_name, last_name, email, password) VALUES (";
        if ($user_type == 'Renter') {
            $sql .= ':renter_id, ';
        }
        $sql .= ":first_name, :last_name, :email, :password)";

        $query = $this->db->prepare($sql);

        $password = hash('sha256', $password);

        $parameters = array();
        if ($user_type == 'Renter') {
            $parameters[':renter_id'] = $renter_id;
        }
        $parameters[':first_name'] = $first_name;
        $parameters[':last_name'] = $last_name;
        $parameters[':email'] = $email;
        $parameters[':password'] = $password;

        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public function login($email, $password) {
        $Lessors = "SELECT * FROM Lessors WHERE email=:email AND password=:password ;";
        $Renters = "SELECT * FROM Renters WHERE email=:email AND password=:password ;";
        for ($i = 0; $i < 2; $i++) {
            if ($i == 0) {
                $sql = $Lessors;
            } else {
                $sql = $Renters;
            }
            $query = $this->db->prepare($sql);
            $query->bindParam(':email', $email);
            // hash the password using sha256 and compares with the hashed pw in db
            $password1 = hash('sha256', $password);
            $query->bindParam(':password', $password1);
            $query->execute();
            $result = $query->fetch();
            //if $i = 0 then it is Lessors
            //if $i = 1 then it is Renters
            if ($result) {
                $accountType = ($i === 0) ? 'Lessor' : 'Renter';
                break;
            }
        }
        //If the username's and password match, result will have an item.
        //If result is blank, then no match is found.
        if (!$result) {
            //If login fails, we redirect to home and exit() so php does not keep executing.
            $session = array(
                'loggedIn' => false,
                'loginError' => 'Email and password do not match.'
            );
            setcookie('session', json_encode($session), 0, '/');
            header("location:" . URL . "home/login");
            exit();
        } else {
            // Creates a session to store the users ID, and make them always log in upon visiting the site
            $session = array(
                'loggedIn' => true,
                'accountType' => $accountType,
                'email' => $result->email,
            );
            if ($accountType === 'Renter') {
                $session['id'] = $result->renter_id;
            } else if ($accountType === 'Lessor') {
                $session['id'] = $result->lessor_id;
            }
            setcookie('session', json_encode($session), 0, '/');
            header("location:" . URL . "home");
        }
    }

}

?>

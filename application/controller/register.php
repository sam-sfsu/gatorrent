<?php

/*
 * Copyright San Francisco State University Software Engineering CSC 648/848 F16G13
 */
    class Register extends Controller
    {
   		/**
		 * PAGE: Index
		 * Handles main registration page
		 */
		public function index($errId=NULL)
		{
			$search_options = $this->model->getSearchOptions();

			$formErrors = array();
			if (!empty($errId)) {
				session_id($errId);
				session_start();
				$formErrors = $_SESSION['formErrors'];
				session_destroy();
			}
			require APP . 'view/_templates/header.php';
			require APP . 'view/register/index.php';
			require APP . 'view/_templates/footer.php';
		}

		/**
		 * PAGE: Success
		 * Handles successful registration page
		 */
		public function success()
		{
			$search_options = $this->model->getSearchOptions();

			require APP . 'view/_templates/header.php';
			require APP . 'view/register/success.php';
			require APP . 'view/_templates/footer.php';
		}

		/**
		 * ACTION: RegisterUser
		 * Handles the actual registration process (validation, return errors, store to DB)
		 */
		public function registerUser()
		{
			$registration = array(
				'userType' => $_POST['userType'],
				'firstName' => $_POST['firstName'],
				'lastName' => $_POST['lastName'],
				'email' => $_POST['email'],
				'password' => $_POST['password'],
				'passwordVerify' => $_POST['passwordVerify'],
				'renterId' => $_POST['renterId']
			);
			if (isset($_POST['tosComply'])) {
				$registration['tosComply'] = $_POST['tosComply'];
			} else {
				$registration['tosComply'] = NULL;
			}

			$result = $this->registerModel->register($registration);
			if (!empty($result)) {
				// Store validation errors
				$errId = 'err-' . rand();
				session_id($errId);
				session_start();
				$_SESSION['formErrors'] = $result;
				session_write_close();

				// Redirect to registration page to display validation errors
				header('location: ' . URL . 'register/index/' . $errId);
			} else {
				// Clear validation errors
				$formErrors = array();

				// Redirect to registration success page
				header('location: ' . URL . 'register/success');
			}
		}
	}
?>

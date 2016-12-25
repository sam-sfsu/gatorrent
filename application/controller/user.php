<?php    
/*
 * Copyright San Francisco State University Software Engineering CSC 648/848 F16G13
 */

    class User extends Controller
	{
		public function index()
		{
			require APP . 'view/_templates/header.php';
			require APP . 'view/user/index.php';
			require APP . 'view/_templates/footer.php';
		}

		public function createlisting()
		{
			$session = json_decode($_COOKIE['session'], true);
			if ($session['loggedIn'] === false || $session['accountType'] !== 'Lessor') {
				$session['loginError'] = 'You must be logged in to do that!';
				setcookie('session', json_encode($session), 0, '/');
				header('location: ' . URL . 'home/login');
				exit();
			}
			$search_options = $this->model->getSearchOptions();
			$currentListings = $this->model->getApartmentsByUser($session['id']);
			$location = 'createlisting';
			$editing = false;

			require APP . 'view/_templates/header.php';
			require APP . 'view/user/create_listing.php';
			require APP . 'view/_templates/footer.php';
		}

		public function editlisting($apartmentId=NULL)
		{
			$session = json_decode($_COOKIE['session'], true);
			if ($session['loggedIn'] === false || $session['accountType'] !== 'Lessor') {
				$session['loginError'] = 'You must be logged in to do that!';
				setcookie('session', json_encode($session), 0, '/');
				header('location: ' . URL . 'home/login');
				exit();
			}
			if (empty($apartmentId) || !is_numeric($apartmentId)) {
				// no apartmentId - go to create listing page instead
				$editing = false;
				header('location: ' . URL . 'user/createlisting');
				exit();
			}
			$listingInfo = $this->model->getSingleApartmentInfo($apartmentId);
			if (empty($listingInfo)) {
				// no apartment info found, go to create listingInfo
				$editing = false;
				header('location: ' . URL . 'user/createlisting');
				exit();
			}
			// getSingleApartmentInfo returns an array, use the first entry
			$listingInfo= $listingInfo[0];
			$location = 'createlisting';
			$editing = true;

			$search_options = $this->model->getSearchOptions();
			$currentListings = $this->model->getApartmentsByUser($session['id']);
			require APP . 'view/_templates/header.php';
			require APP . 'view/user/create_listing.php';
			require APP . 'view/_templates/footer.php';
		}

		public function login()
		{
			$email = $_POST['email'];
			$password = $_POST['password'];

			$this->userModel->login($email, $password);
		}

		public function logout() {
			$session = array(
				'loggedIn' => false
			);
			setcookie('session', json_encode($session), 0, '/');
			header('location: ' . URL . 'home');
	    }
	}
?>

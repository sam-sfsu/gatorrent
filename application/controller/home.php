<?php
/**
 *
 * Copyright San Francisco State University Software Engineering CSC 648/848 F16G13
 *
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */

class Home extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */

    /**
     *
     * $location helps to active the current location in the navbar.
     */
    private $location = "";


    public function getCurrentLocation(){
        return $this->location;
    }

    public function index()
    {
        $search_options = $this->model->getSearchOptions();
        $location = "home";
        $recentListings = $this->model->getRecentListings();
        $listingContacts = array();
        forEach($recentListings as $listing) {
            $listingContacts[$listing->lessor_id] = $this->model->getLessorEmailById($listing->lessor_id);
        }
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function login()
    {
        $session = json_decode($_COOKIE['session'], true);
        $search_options = $this->model->getSearchOptions();
        $location = "login";
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/login.php';
        require APP . 'view/_templates/footer.php';
    }

    public function aboutus()
    {
        $search_options = $this->model->getSearchOptions();
        $location = "aboutus";
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/aboutus.php';
        require APP . 'view/_templates/footer.php';
    }

    /**
     * PAGE: search
     * This method handles getting listings from the database that match the search criteria
     */
    public function search()
    {
        $search_options = $this->model->getSearchOptions();

        if (isset($_POST['submit_search'])) {
            try {
                $results = $this->model->search($_POST['search_option'], $_POST['search_query']);
            } catch (Exception $err) {
                $results = $err;
            }
        } else {
            $results = $this->model->search();
        }
        $resultContacts = array();
        forEach($results as $result) {
            $resultContacts[$result->lessor_id] = $this->model->getLessorEmailById($result->lessor_id);
        }

        require APP . 'view/_templates/header.php';
        require APP . 'view/home/results.php';
        require APP . 'view/_templates/footer.php';
    }

    public function singleview($apartmentId)
    {
        $search_options = $this->model->getSearchOptions();
        $apartment = $this->model->getSingleApartmentInfo($apartmentId);
        $contact = $this->model->getLessorEmailById($apartment[0]->lessor_id);
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/singleview.php';
        require APP . 'view/_templates/footer.php';
    }

    public function conditionsofuse()
    {
        $search_options = $this->model->getSearchOptions();
        $location = "conditionsofuse";
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/condition_of_use.php';
        require APP . 'view/_templates/footer.php';
    }

    public function privacynotice()
    {
        $search_options = $this->model->getSearchOptions();
        $location = "privacynotice";
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/privacy_notice.php';
        require APP . 'view/_templates/footer.php';
    }

    public function contactus()
    {
        $search_options = $this->model->getSearchOptions();
        $location = "contactus";
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/contact_us.php';
        require APP . 'view/_templates/footer.php';
    }
}

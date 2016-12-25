<?php
/*
 * Copyright San Francisco State University Software Engineering CSC 648/848 F16G13
 */

class ListModel{

    function __construct($db){
        try{
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function create($info, $callback)
    {
        $sql = "INSERT INTO Apartments (lessor_id, title, street_address, zipcode, price, rooms, baths, description, picture_1, picture_2, picture_3, picture_4) VALUES (:lessor_id, :title, :street_address, :zipcode, :price, :rooms, :baths, :description, :picture_1, :picture_2, :picture_3, :picture_4)";
        $query = $this->db->prepare($sql);

        $parameters = array();
        $parameters[':lessor_id'] = $info['lessor_id'];
        $parameters[':title'] = $info['title'];
        $parameters[':street_address'] = $info['address'];
        $parameters[':zipcode'] = $info['zipcode'];
        $parameters[':price'] = $info['price'];
        $parameters[':rooms'] = $info['rooms'];
        $parameters[':baths'] = $info['baths'];
        $parameters[':description'] = $info['description'];
        $parameters[':picture_1'] = $info['picture_1'];
        $parameters[':picture_2'] = $info['picture_2'];
        $parameters[':picture_3'] = $info['picture_3'];
        $parameters[':picture_4'] = $info['picture_4'];

        $query->execute($parameters);

        // gets apartment_id of newly created listing
        $apartmentId = $this->db->lastInsertId();

        $callback($apartmentId);
    }

    public function update($info)
    {
        $sql = "UPDATE Apartments SET title = :title, street_address = :street_address, zipcode = :zipcode, price = :price, rooms = :rooms, baths = :baths, description = :description WHERE apartment_id = :apartment_id";
        $query = $this->db->prepare($sql);

        $parameters = array();
        $parameters[':title'] = $info['title'];
        $parameters[':street_address'] = $info['address'];
        $parameters[':zipcode'] = $info['zipcode'];
        $parameters[':price'] = $info['price'];
        $parameters[':rooms'] = $info['rooms'];
        $parameters[':baths'] = $info['baths'];
        $parameters[':description'] = $info['description'];
        $parameters[':apartment_id'] = $info['apartment_id'];

        $query->execute($parameters);
    }

    public function delete($apartmentId, $callback)
    {
        $sql = "DELETE FROM Apartments WHERE apartment_id = :apartment_id";
        $query = $this->db->prepare($sql);

        $parameters = array(':apartment_id' => $apartmentId);

        $query->execute($parameters);

        $callback();
    }

    private function _validateListing($info)
    {
        $errors = array();

        // title
        if (is_null($info['title']) || $info['title'] === '')
            $errors['title'] = 'Please enter a title';
        else if (!preg_match('/^[- A-Za-z]+$/', $info['title']))
            $errors['title'] = 'Title may only contain letters, dashes (-), and spaces';
        else if (strlen($info['title']) > 50)
            $errors['title'] = 'First name may be no longer than 50 characters.';

        // address
        if (is_null($info['address']) || $info['address'] === '')
            $errors['address'] = 'Please enter an address';
        else if (strlen($info['address']) > 50)
            $errors['address'] = 'address may be no longer than 50 characters.';

        // zipcode
        if (is_null($info['zipcode']) || $info['zipcode'] === '')
            $errors['zipcode'] = 'Please enter a zipcode';
        else if (!preg_match('^\d{5}$', $info['zipcode']))
            $errors['zipcode'] = 'Zipcode may only contain five digits';

        // price
        if (is_null($info['price']) || $info['price'] === '')
            $errors['price'] = 'Please enter a price';
        else if (!preg_match('^\d{0,5}$', $info['price']))
            $errors['price'] = 'Price may only contain up to five digits';

        // rooms
        if (is_null($info['rooms']) || $info['rooms'] === '')
            $errors['rooms'] = 'Please enter a number for rooms';
        else if (!preg_match('/^[1-5]$/', $info['rooms']))
            $errors['rooms'] = 'Please enter a digit between one and five';

        return $errors;
        //pictures?
    }

}

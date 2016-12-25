<?php

/*
 * Copyright San Francisco State University Software Engineering CSC 648/848 F16G13
 */
    class Listing extends Controller
    {
        /*
         * Action: create
         * Handles creating a listing
         */
        public function create($lessorId)
        {
            $info = array(
                'lessor_id' => $lessorId,
                'title' => $_POST['title'],
                'address' => $_POST['address'],
                'zipcode' => $_POST['zipcode'],
                'price' => $_POST['price'],
                'rooms' => $_POST['rooms'],
                'baths' => $_POST['baths'],
                'description' => $_POST['description'],
                'picture_1' => $_FILES['picture1']['name'],
                'picture_2' => $_FILES['picture2']['name'],
                'picture_3' => $_FILES['picture3']['name'],
                'picture_4' => $_FILES['picture4']['name']
            );

            $this->listModel->create($info, function ($apartmentId) {
                // Move pictures to imgfs
                $dir = '/home/f16g13/public_html/imgfs/' . $apartmentId;
                if (!file_exists($dir)) {
                    mkdir($dir);
                }
                foreach($_FILES as $picture) {
                    $target = $dir . '/' . $picture['name'];
                    move_uploaded_file($picture['tmp_name'], $target);
                }

                // Called after listing is saved to database and pictures moved to imgfs
                header('location: ' . URL . 'user/createlisting');
            });
        }

        /*
         * Action: update
         * Handles updating a listing
         */
        public function update($apartmentId)
        {
            $info = array(
                'title' => $_POST['title'],
                'address' => $_POST['address'],
                'zipcode' => $_POST['zipcode'],
                'price' => $_POST['price'],
                'rooms' => $_POST['rooms'],
                'baths' => $_POST['baths'],
                'description' => $_POST['description'],
                'apartment_id' => $apartmentId
            );

            $this->listModel->update($info);

            header('location: ' . URL . 'user/createlisting');
        }

        /*
         * Action: delete
         * Handles deleting a listing
         */
        public function delete($apartmentId)
        {
            // Delete listing from database
            $this->listModel->delete($apartmentId, function () {
                // Delete listing's photos
                $dir = '/home/f16g13/public_html/imgfs/' . $apartmentId;
                if ($dh = opendir($dir)) {
                    while (($file = readdir($dh)) !== false) {
                        $path = $dir . '/' . $file;
                        if (is_file($path)) {
                            unlink($path);
                        }
                    }
                    closedir($dh);
                    rmdir($dir);
                }
            });

            header('location: ' . URL . 'user/createlisting');
        }
    }

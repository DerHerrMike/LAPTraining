<?php
include __DIR__ . '/../inc/dbconnect.php';

class User extends Connection

{
    /**
     * @throws Exception
     */
    public function userRegistration($regData)
    {

        $email = $regData['email'];
        $password = sha1($regData['password']);
        $password2 = sha1($regData['password2']);
        $first_name = $regData['first_name'];
        $last_name = $regData['last_name'];
        $address = $regData['address'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception ('Please enter a valid email address.');
        }
        if (strlen($password) < 4) {
            throw new Exception ('Password must be at least 4 characters');
        }

        if ($password === $password2) {
            $sql = "SELECT * FROM user WHERE email = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$email]);

            if ($stmt->rowCount() == 0) {
                $sql = 'INSERT INTO user (email, password, first_name, last_name, address) VALUES (?, ?, ?, ?, ?)';
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$email, $password, $first_name, $last_name, $address]);
                echo "Registration successful, you will be redirected shortly";
                header("Refresh: 3; url=login.php");
            } else {
                throw new Exception("Registration failed, email address already exists");
            }
        } else {
            throw new Exception("Registration failed, passwords do not match");
        }
    }

    /**
     * @throws Exception
     */
    public function register($regData)
    {

        $email = $regData["email"];
        $password = $regData["password"];
        $password2 = $regData["password2"];
        $first_name = $regData["first_name"];
        $last_name = $regData["last_name"];
        $address = $regData["address"];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Registration failed, email address is invalid");
        }

        if (strlen($email) < 4) {
            throw new Exception("Registration failed, password must be at least 4 characters long");
        }

        if ($password === $password2) {
            $sql = "SELECT * FROM user WHERE email = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute($email);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($res->rowCount() == 0) {
                $sql = 'INSERT INTO user (email, password, first_name, last_name, address) VALUES (?, ?, ?, ?, ?)';
                $stmt = $this->connect()->prepare($sql);
                $stmt->execute([$email, $password, $first_name, $last_name, $address]);
                echo 'Registration successful. You will be redirected shortly';
                header('Refresh:2, url="login.php"');
            } else {
                throw new Exception ('Registration failed, email already registered!');
            }
        } else {
            throw new Exception("Registration failed, passwords do not match!");
        }


    }


    public function userLogin($email, $password)
    {
        $sql = "SELECT * FROM user WHERE email = ?  AND password = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$email, $password]);
        $userData = $stmt->fetch();
        if ($stmt->rowCount() == 1) {

            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $userData['id'];
            $_SESSION['user_role'] = $userData['is_admin'];
            echo 'You have been logged in successfully!';
            if ($_SESSION['user_role'] == 1) {
                header('Refresh: 2; url=admin_panel.php');
            } else {
                header('Refresh: 3; url=shop.php');
            }
        } else {
            echo 'Credentials are not valid, please try again or register first!';
        }
    }

    public function loadAllUsers()
    {

        $sql = 'SELECT * FROM user';
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();

        while ($userData = $stmt->fetch()) {
            echo "
            <tr>
            <td>" . $userData['id'] . "</td>
            <td>" . $userData['email'] . "</td>
            <td>" . $userData['password'] . "</td>
            <td>" . $userData['is_admin'] . "</td>
            <td><a href='userProfile.php?uid=" . $userData['id'] . "'>Profile</a></td>
            <td><a href='userProfile.php?uid=" . $userData['id'] . "'>Edit</a></td>
            </tr>
            ";
        }

    }

    public function userSearch($email)
    {

        $query = "SELECT * FROM user WHERE email like ? ";


        $sb = '%' . $email . '%';
        $stmt = $this->connect()->prepare($query);
        $stmt->execute([$sb]);

        if ($stmt->rowCount() == 0) {


            echo "<br>no users found";
        }

        while ($users = $stmt->fetch()) {


            echo "<br>User:  " . $users['email'];
        }
    }


    /**
     * @throws Exception
     */
    public function loadUserFirstname($id)
    {
        $sql = 'SELECT first_name FROM user WHERE id = ' . $id;
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $userData = $stmt->fetch();
        if ($stmt->rowCount() == 1) {
            $_SESSION['first_name'] = $userData['first_name'];
        } else {
            throw new Exception ('User not found');
        }
    }
























//    public function loadAllUsers2(){
//
//        $sql = 'SELECT * FROM user';
//        $stmt = $this->connect()->prepare();
//        $stmt->execute();
//
//        while ($userData = $stmt->fetch()){
//            echo"
//            <tr>
//            <td>" . $userData['id'] ."</td>
//            <td>" . $userData['email'] ."</td>
//            <td>" . $userData['password'] ."</td>
//            <td>" . $userData['is_admin'] ."</td>
//            <td><a href='userprofile.php?uid=" . $userData['id'] . "'>Profile</a></td>
//            <td><a href='userprofile.php?uid=" . $userData['id'] . "'>Edit</a></td>
//            </tr>
//            ";
//        }


}

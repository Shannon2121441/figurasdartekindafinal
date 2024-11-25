<?php
require_once 'models/users.php';

class UserController {
    private $user;

    public function __construct($db) {
        $this->user = new User($db);
    }

    // Register a new user
    public function register($email, $password, $name, $image, $number) {
        $this->user->user_email = $email;
        $this->user->user_password = $password;
        $this->user->user_name = $name;
        $this->user->user_date_reg = date('Y-m-d H:i:s');  // Current date-time
        $this->user->user_type_id = 3;  // Default user type (can be modified based on your needs)
        $this->user->image = $image;
        $this->user->number = $number;

        if ($this->user->create()) {
            return true;
        }
        return false;
    }

    // Login a user and manage session/cookies
    public function handleLogin($email, $password) {
        $this->user->user_email = $email;

        if ($this->user->getByEmail()) {
            // Verify password
            if (sha1($password) === $this->user->user_password) {
                setcookie('user_id', $this->user->id, time() + 60*60*24*30, '/');
                return ['status' => true, 'message' => 'Login successful'];
            } else {
                return ['status' => false, 'message' => 'Incorrect Email or Password'];
            }
        } else {
            return ['status' => false, 'message' => 'Incorrect Email or Password'];
        }
    }


    // Update user profile
    public function updateProfile($id, $email, $name, $image, $number) {
        $this->user->id = $id;
        $this->user->user_email = $email;
        $this->user->user_name = $name;
        $this->user->image = $image;
        $this->user->number = $number;

        if ($this->user->update()) {
            return true;
        }
        return false;
    }

    // Delete user account
    public function deleteUser($id) {
        $this->user->id = $id;

        if ($this->user->delete()) {
            return true;
        }
        return false;
    }
    
}
?>

<?php

namespace App\Model;

use App\Config\DatabaseConnection;
use PDO;

include_once('Database.php');

class User extends DatabaseConnection
{
    private $table_name = 'users';
    public $id;
    public $name;
    public $email;
    public $password;

    public function register()
    {

        $query1 = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query1);

        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        if ($stmt->rowCount > 0) {
            return false;
        }
        $query = "INSERT INTO " . $this->table_name . "(name, email, password) VALUES (:name,:email,:password)";
        $stmt = $this->conn->prepare($query);
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function login()
    {
        $query1 = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query1);

        // Bind the email parameter
        $stmt->bindParam(':email', $this->email);

        // Execute the statement
        if ($stmt->execute()) {

            // Check if any user is returned
            if ($stmt->num_rows > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the user data

                // Verify the password with the hashed password
                if (password_verify($this->password, $user['password'])) {
                    $this->id = $user['id'];
                    $this->name = $user['name'];
                    $this->email = $user['email'];
                    return true; // Login successful
                } else {
                    return false; // Password is incorrect
                }
            } else {
                return false; // No user found with that email
            }
        } else {
            return false; // Query execution failed
        }
    }
}

<?php

class Post {
    private $conn;
    private $table = 'post';

    public $id;
    public $post_type_id;
    public $post_status;
    public $post_title;
    public $post_content;
    public $post_date;
    public $post_excerpt;
    public $post_author_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new post
    public function create() {
        try {
            $query = "INSERT INTO $this->table 
                      (post_type_id, post_status, post_title, post_content, post_date, post_excerpt, post_author_id) 
                      VALUES 
                      (:post_type_id, :post_status, :post_title, :post_content, :post_date, :post_excerpt, :post_author_id)";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':post_type_id', $this->post_type_id);
            $stmt->bindParam(':post_status', $this->post_status);
            $stmt->bindParam(':post_title', $this->post_title);
            $stmt->bindParam(':post_content', $this->post_content);
            $stmt->bindParam(':post_date', $this->post_date);
            $stmt->bindParam(':post_excerpt', $this->post_excerpt);
            $stmt->bindParam(':post_author_id', $this->post_author_id);

            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Failed to create post: " . implode(" | ", $stmt->errorInfo()));
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    // Get all posts
    public function getAll() {
        try {
            $query = "SELECT 
                        p.*, 
                        pt.type_name AS post_type, 
                        u.name AS author_name 
                      FROM $this->table p
                      LEFT JOIN post_type pt ON p.post_type_id = pt.id
                      LEFT JOIN users u ON p.post_author_id = u.id";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $posts = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $posts[] = $row;
            }

            return $posts;
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return [];
        }
    }

    // Get a single post by ID
    public function getById($id) {
        try {
            $query = "SELECT 
                        p.*, 
                        pt.type_name AS post_type, 
                        u.name AS author_name 
                      FROM $this->table p
                      LEFT JOIN post_type pt ON p.post_type_id = pt.id
                      LEFT JOIN users u ON p.post_author_id = u.id
                      WHERE p.id = :id";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return null;
        }
    }

    // Delete a post by ID
    public function delete($id) {
        try {
            $query = "DELETE FROM $this->table WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Failed to delete post: " . implode(" | ", $stmt->errorInfo()));
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return false;
        }
    }
}
?>
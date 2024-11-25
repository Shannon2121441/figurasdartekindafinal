<?php
class UserType {
    public $id;
    public $type_name;

    private $connDb;

    public function __construct($connDb) {
        $this->connDb = $connDb;
    }

    function save() {
        try {
            $sql = "";
            if (empty($this->id)) {
                $sql = "INSERT INTO user_type (type_name)
                        VALUES ('" . $this->type_name . "')";
            } else {
                $sql = "UPDATE user_type SET
                        type_name = '" . $this->type_name . "'
                        WHERE id = '" . $this->id . "'";
            }
            mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    function getAll() {
        try {
            $sql = "SELECT * FROM user_type";
            $result = mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
            $rows = [];
            while ($row = mysqli_fetch_object($result)) {
                $rows[] = $row;
            }
            return $rows;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    function getSingle($id) {
        try {
            $sql = "SELECT * FROM user_type WHERE id = '" . $id . "'";
            $result = mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
            $row = mysqli_fetch_object($result);

            return $row;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    function delete($id) {
        try {
            $sql = "DELETE FROM user_type WHERE id = '" . $id . "'";
            mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
?>
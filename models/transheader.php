<?php
class Transheader {
    public $id;
    public $user_id;
    public $date;
    public $total_due;
    public $payment_method;
    public $payment_status;

    private $connDb;

    #
    public function __construct($connDb) {
        $this->connDb = $connDb;
        $this->date = date('Y-m-d H:i:s');
    }

    #
    function save() {
        try {
            $sql = "INSERT INTO transheader (user_id, date, total_due, payment_method, payment_status) 
                    VALUES ('" . $this->user_id . "',
                            '" . $this->date . "',
                            '" . $this->total_due . "',
                            '" . $this->payment_method . "',
                            '" . $this->payment_status . "')";
            mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    #
    function update() {
        try {
            $sql = "UPDATE transheader SET
                        user_id = '" . $this->user_id . "',
                        total_due = '" . $this->total_due . "',
                        payment_method = '" . $this->payment_method . "',
                        payment_status = '" . $this->payment_status . "'
                    WHERE id = '" . $this->id . "'";
            mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    #
    function getAll() {
        try {
            $sql = "SELECT * FROM transheader";
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

    #
    function getSingle($id) {
        try {
            $sql = "SELECT * FROM transheader WHERE id = '" . $id . "'";
            $result = mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
            return mysqli_fetch_object($result);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    #
    function delete($id) {
        try {
            $sql = "DELETE FROM transheader WHERE id = '" . $id . "'";
            mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
?>
<?php
class Transline {
    public $header_id;
    public $product_id;
    public $desc;
    public $price;
    public $qty;
    public $discount;
    public $line_total;

    private $connDb;

    #
    public function __construct($connDb) {
        $this->connDb = $connDb;
    }

    #
    function save() {
        try {
            $sql = "INSERT INTO transline (header_id, product_id, `desc`, price, qty, discount, line_total)
                    VALUES ('" . $this->header_id . "',
                            '" . $this->product_id . "',
                            '" . $this->desc . "',
                            '" . $this->price . "',
                            '" . $this->qty . "',
                            '" . $this->discount . "',
                            '" . $this->line_total . "')";
            mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    #
    function getAll() {
        try {
            $sql = "SELECT * FROM transline";
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
    function getByHeaderId($header_id) {
        try {
            $sql = "SELECT * FROM transline WHERE header_id = '" . $header_id . "'";
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
    function delete($id) {
        try {
            $sql = "DELETE FROM transline WHERE id = '" . $id . "'";
            mysqli_query($this->connDb, $sql) or die(mysqli_error($this->connDb));
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
?>
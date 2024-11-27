<?php 

class myDB{
    private $servername ='localhost';
    private $username ='root';
    private $password='';
    private $db_name='blog';
    public $res;
    private $conn;

    public function __construct(){
        try{
            $this->conn = new mysqli($this->servername,$this->username,$this->password,$this->db_name);
        }catch(Exception $e){
            die("Database connection error!. <br>".$e);
        }
    }
    public function __destruct(){
        $this->conn->close();
    }

    public function getConnection() {
        return $this->conn;
    }
    public function getblog(){
        try{
            $stmt = $this->conn->prepare("SELECT * FROM blog");
            $stmt->execute();
            $this->res = $stmt->get_result();
        }catch(Exception $e){
            die("Error requesting data!. <br>".$e);
        }
    }
    public function delete($table,$id){
        try{
            mysqli_query($this->conn,"DELETE from $table where id=$id" );
        }catch(Exception $e){
            die("Error requesting data!. <br>".$e);
        }
    }

    
    public function registerUser($table, $data) {
        try {
            $table_columns = implode(',', array_keys($data)) . ",join_date";
            $prep = $types = "";
    
            foreach ($data as $key => $value) {
                $prep .= "?,";
                $types .= substr(gettype($value), 0, 1);
            }
    
            $prep = rtrim($prep, ',');
            $stmt = $this->conn->prepare("INSERT INTO $table($table_columns) VALUES ($prep, NOW())");
            $stmt->bind_param($types, ...array_values($data));
            $stmt->execute();
            $stmt->close();
        } catch(Exception $e) {
            die("Error while inserting data!. <br>" . $e);
        }
    }
    
}
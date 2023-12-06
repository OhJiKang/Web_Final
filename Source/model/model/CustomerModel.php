<?php 

require_once (__DIR__.'/../System/Database.php');
require_once (__DIR__.'/../entity/Customer.php');

class CustomerModel {
    public $conn;
    public function __construct(){
        $this->conn = Database::getConnection();
       
    } 
    public function getCustomerByID($id) {
        $stmt = $this->conn->prepare("SELECT  FullName, Address	, Email	, Phone,account_id, CustomerID		 FROM customer WHERE CustomerID =:CustomerID");
        $stmt->bindParam(':CustomerID', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS,'Customer');
        $stmt->execute();
        $customer = $stmt->fetchObject();
        header('Content-Type: application/json');

        if($customer!=null){
            return json_encode(array("success"=>true,"customer"=>$customer));
        }else{
            return json_encode(array("success"=>false,"error"=>"Khách hàng không tồn tại"));
        }


    }
    public function getCustomerByEmail($email) {
        $stmt = $this->conn->prepare("SELECT  FullName, Address	, Email	, Phone,account_id, CustomerID		 FROM customer WHERE email =:email");
        $stmt->bindParam(':email', $email);
        $stmt->setFetchMode(PDO::FETCH_CLASS,'Customer');
        $stmt->execute();
        $customer = $stmt->fetchObject();
         header('Content-Type: application/json');

        if($customer!=null){
            return json_encode(array("success"=>true,"customer"=>$customer));
        }else{
            header('Content-Type: application/json');
            return json_encode(array("success"=>false,"error"=>"Khách hàng không tồn tại"));
        }


    }
    
    public function updateCustomer(Customer $customer){
        try{
            $id = $customer->get_CustomerID();
            $name = $customer->get_FullName();
            $address = $customer->get_Address();
            $email = $customer->get_Email();
            $phone = $customer->get_Phone();
            $stmt = $this->conn->prepare("SELECT  Email	FROM customer WHERE CustomerID =:CustomerID");
            $stmt->bindParam(':CustomerID', $id);
            $stmt->execute();
            $temp = $stmt->fetchColumn();   
            // die(json_encode($customer->get_CustomerID()));       
            if($temp==null){
                return json_encode(array("success" => false, "error" => "Tài khoản không tồn tại"));
            }
            $stmt =$this->conn->prepare("UPDATE Customer set FullName=:name,Address=:address,Email=:email,Phone=:phone where CustomerID=:id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->execute();
            header('Content-Type: application/json');
            return json_encode(array("success" => true));
       }catch(Exception $e){
          return json_encode(array("success"=>false,"error"=>$e->getMessage()));
       }
   }
    public function addCustomer(Customer $customer){
         try{
            $stmt =$this->conn->prepare("INSERT INTO customer VALUES (:id, :name, :address, :email,:phone ,:account_id)");
            $id = $this->createNewIDCustomer();
        $name = $customer->get_FullName();
        $address = $customer->get_Address();
        $email = $customer->get_Email();
        $phone = $customer->get_Phone();
        $account_id = $customer->get_Account_Id();
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':account_id', $account_id);
            $stmt ->execute();
            return json_encode(array("success"=>true));
   
        }catch(Exception $e){
           return json_encode(array("success"=>false,"error"=>$e->getMessage()));
        }
    }
    private function createNewIDCustomer() {
        $query = "SELECT CustomerID FROM customer ORDER BY CAST(RIGHT(CustomerID, LENGTH(CustomerID) - 2) AS UNSIGNED) DESC LIMIT 1";
        $result = $this->conn->query($query);
        $lastId = 0;
    
        if ($result->rowCount() > 0) {
            $lastId = intval(substr($result->fetchColumn(), 2));
        }
    
        $newId = "KH" . ($lastId + 1);
        return $newId;
    }
    
    public function getAllCustomer($page = 1 ){
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $stmt = $this->conn->prepare("SELECT c.FullName, c.Address, c.Email, c.Phone, c.account_id,c.CustomerID, a.password 
                                      FROM customer c 
                                      INNER JOIN account a ON c.account_id = a.id
                                      LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $customers = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $customer = new Customer($row['FullName'], $row['Email'], $row['Address'], $row['Phone'],$row['account_id'], $row['CustomerID']);
            $customer->setPassword( $row['password']);
            $customers[] = $customer;
        }
        return json_encode(array("success" => true, "list" => $customers));
    }
    
    public function deleteCustomer($customer_id){
        try{
            $countStmt = $this->conn->prepare("SELECT COUNT(*) FROM customer WHERE customerid=:customer_id");
            $countStmt->bindParam(':customer_id', $customer_id);
            $countStmt->execute();
            $count = $countStmt->fetchColumn();
            header('Content-Type: application/json');
    
            if ($count == 0) {
                return json_encode(array("success"=>false,"error"=>"Customer does not exist."));
            } else {
                $stmt = $this->conn->prepare("DELETE FROM customer WHERE customerid=:customer_id");
                $stmt->bindParam(':customer_id', $customer_id);
                $stmt->execute();
                return json_encode(array("success"=>true));
            }
        } catch(Exception $e) {
            return json_encode(array("success"=>false,"error"=>$e->getMessage()));
        }
    }
    
}   
$temp = new Customer("ling","ling@gmail.com","Việt nam Trái Đất","04234","AC27","C001");

(new CustomerModel())->updateCustomer($temp);
?>
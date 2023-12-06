<?php
require_once(__DIR__.'/../entity/Account.php');
require_once(__DIR__.'/../System/Database.php');


class AccountModel {
    public $conn;
    public function __construct(){
        $this->conn = Database::getConnection();
       
    }
    public function changePassword($id,$newPassword,$oldPassword){
     
            $account = $this->getAcountByID($id);
            $acco = json_decode($account,true);
            if($acco['success']){
                if(strcmp($acco['account']['password'] ,$oldPassword)==0){
                    $acc = new Account($acco['account']['email'],$newPassword,$acco['account']['role_id'],$acco['account']['id']);
                    return $this->updateAccount($acc);
                }
            }
            return json_encode(array("success" =>false, "message" =>"Sai mật khẩu vui lòng thử lại"));
      
    }
    public function getAcountByID($id) {
        $stmt = $this->conn->prepare("SELECT  email, password,role_id,id  FROM account WHERE id=:id");
        $stmt->bindParam(':id',$id);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Account');
        $stmt->execute();
    
        $account = $stmt->fetchObject();

        header('Content-Type: application/json');
        if($account == null) {
            return json_encode(array("success" => false, "error" => "Đăng nhập thất bại"));
        } else {
            return json_encode(array("success" => true, "account" => $account));
        }
    }
    
    public function getAcountByEmail($email) {
        $stmt = $this->conn->prepare("SELECT  email, password,role_id,id  FROM account WHERE email=:email");
        $stmt->bindParam(':email',$email);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Account');
        $stmt->execute();
    
        $account = $stmt->fetchObject();

        header('Content-Type: application/json');
        if($account == null) {
            return json_encode(array("success" => false, "error" => "Đăng nhập thất bại"));
        } else {
            return json_encode(array("success" => true, "account" => $account));
        }
    }
    public function getAcount($email, $pas) {
        $stmt = $this->conn->prepare("SELECT email, password,role_id ,id FROM account WHERE email=:email AND password=:password");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $pas);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Account');
        $stmt->execute();
    
        $account = $stmt->fetchObject();
        header('Content-Type: application/json');
        if($account == null) {
            return json_encode(array("success" => false, "error" => "Đăng nhập thất bại"));
        } else {
            return json_encode(array("success" => true, "account" => $account));
        }
    }
    public function updateAccount(Account $account){
        try{
            $id = $account->getId();
            $email = $account->getEmail();
            $password = $account->getPassword();
           
            $stmt = $this->conn->prepare("UPDATE account SET Email=:email, Password=:password WHERE ID=:id");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password',  $password);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            header('Content-Type: application/json');
            return json_encode(array("success"=>true));
        }catch(Exception $e){
            header('Content-Type: application/json');
            return json_encode(array("success"=>false,"error"=>$e->getMessage()));
        }
    }
    
    private function createNewIdAcount() {
        $query = "SELECT id FROM account ORDER BY CAST(RIGHT(id, LENGTH(id) - 2) AS UNSIGNED) DESC LIMIT 1";
        $result = $this->conn->query($query);
        if($result->rowCount()==0){
            return "AC1";
        }
        $lastId = intval(substr($result->fetchColumn(), 2));
        $newId = "AC" . ($lastId + 1);
        return $newId;
    }
    
    public function addAcount(Account $account){
        try{
            $stmt =$this->conn->prepare("INSERT INTO account VALUES (:id,:email, :password, :role)");
            $id = $this->createNewIdAcount();
            $email = $account->getEmail();
            $password = $account->getPassword();
            $role = $account->getRole();
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':role',$role );
            $stmt->bindParam(':id',$id);
            $stmt ->execute();
            header('Content-Type: application/json');
            return json_encode(array("success"=>true));
   
        }catch(Exception $e){
            header('Content-Type: application/json');
           return json_encode(array("success"=>false,"error"=>$e->getMessage()));
        }
      
    }
    public function deleteAccount($email){
        try{
        

        $stmt = $this->conn->prepare("DELETE FROM account WHERE email=:email");
        $stmt ->bindParam(':email',$email);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Account');

        $stmt->execute();
        header('Content-Type: application/json');
        return (array("success"=>true));
        }catch(Exception $e){
            header('Content-Type: application/json');
            return (array("success"=>false,"error"=>$e->getMessage()));
        }
    }
    public function getAllAccounts() {
        $stmt = $this->conn->prepare("SELECT email, password, id, role_id FROM account");
        $stmt->execute();
        $accounts = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $account = new Account( $row['email'], $row['password'], $row['role_id'],$row['id']);
            $accounts[] = $account;
        }
        header('Content-Type: application/json');
        return json_encode(array("success" => true, "list" => $accounts));
    }
    
}

?>

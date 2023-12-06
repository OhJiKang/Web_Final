<?php  
require_once '../../model/model/AccountModel.php';
require_once '../../model/model/CustomerModel.php';
require_once '../../model/model/ManagerModel.php';
require_once '../../model/entity/Account.php';
require_once '../../model/entity/Customer.php';
require_once '../../model/entity/Manager.php';
class UserController {
    public function getUserByEmail($email) {
        $account =  (new AccountModel())->getAcountByEmail($email); // thiếu dấu chấm phẩy ở cuối dòng này
        $data = json_decode($account, true);
        
    //    return $account;
       
        if($data['success']) {
            header('Content-Type: application/json');
            // echo $data['account']['role_id'];
            if($data['account']['role_id']==1){ // thiếu dấu bằng ở đây
                $customer  = (new CustomerModel())->getCustomerByEmail($email);
                return array( "success" => true,"role"=>$data['account']['role_id'],"user"=>$customer);
            } else {
                $admin  = (new ManagerModel())->getManagerByEmail($email);
                return array("success" => true,"role"=>$data['account']['role_id'],"user"=>$admin);
            }
        } else {
            header('Content-Type: application/json');

            return array("success" => false,"message"=>"Đăng nhập thất bại");
        }

    }
    public function getUserByID($id) {
        $account =  (new AccountModel())->getAcountByID($id); 
        $data = json_decode($account, true);
        
    //    return $account;
       
        if($data['success']) {
            header('Content-Type: application/json');
            $email = $data['account']['email'];

            if($data['account']['role_id']==1){ 
                $customer  = (new CustomerModel())->getCustomerByEmail($email);
                return array( "success" => true,"role"=>$data['account']['role_id'],"user"=>$customer);
            } else {
                $admin  = (new ManagerModel())->getManagerByID($email);
                return array("success" => true,"role"=>$data['account']['role_id'],"user"=>$admin);
            }
        } else {
            header('Content-Type: application/json');

            return array("success" => false,"message"=>"Đăng nhập thất bại"); 
        }

    }
    public function login($email,$password){
            $account =  (new AccountModel())->getAcount($email,$password); // thiếu dấu chấm phẩy ở cuối dòng này
            $data = json_decode($account, true);
            
        //    return $account;
           
            if($data['success']) {
                header('Content-Type: application/json');
                // echo $data['account']['role_id'];
                if($data['account']['role_id']==1){ // thiếu dấu bằng ở đây
                    $customer  = (new CustomerModel())->getCustomerByEmail($email);
                    return array( "success" => true,"role"=>$data['account']['role_id'],"user"=>$customer);
                } else {
                    $admin  = (new ManagerModel())->getManagerByEmail($email);
                    return array("success" => true,"role"=>$data['account']['role_id'],"user"=>$admin);
                }
            } else {
                header('Content-Type: application/json');

                return array("success" => false,"message"=>"Đăng nhập thất bại"); // xoá dòng => ở đây và thêm giá trị false vào mảng này
            }
    
    }
    public function registerCustomer($data) {
        $email = $data['email'];
        $password = $data['password'];
        $fullname = $data['fullname'];
        $address = $data['address'];
        $phone = $data ['phone'];
        $account =     (new AccountModel())->addAcount(new Account($email,$password,1));
        $result = json_decode($account, true);
        header('Content-Type: application/json');
        if($result['success']){
            $acc = (new AccountModel())->getAcount($email,$password);
            $acc = json_decode($acc, true);
            $customer = (new CustomerModel())->addCustomer(new Customer($fullname,$email,$address,$phone,$acc['account']['id']));
            $customer = json_decode($customer, true);

            if($customer['success']){
                $cus = (new CustomerModel())->getCustomerByEmail($email);
                return array("success" => true,'role' =>1,'user' =>$cus);
            }else {
                return array("success" => false,"message"=>$customer['error']); 

            }
        }
        return array("success" => false,"message"=>"Đăng ký thất bại"); 

    }
    public function getAllCustomer($page){
        return (new CustomerModel())->getAllCustomer($page);
    }
    public function getAllManager($page){
        return (new ManagerModel())->getAllManager($page);
    }
    public function changePassword($id ,$newPassword,$oldPassword){
        return (new AccountModel())->changePassword($id,$newPassword,$oldPassword);
    }
    public function updateInformationForCustomer($data){
        $email = $data['email'];
        $password = $data['password'];
        $fullname = $data['fullname'];
        $address = $data['address'];
        $phone = $data ['phone'];
        $customer_id = $data['id'];
        $acc = (new AccountModel())->getAcount($email,$password);
        $account = json_decode($acc,true);
        if($account['success']){
            $customer = new Customer($fullname, $email, $address, $phone, "", $customer_id);
            return (new CustomerModel)->updateCustomer($customer);
        }else{
            return json_encode(array("success" => true,"error" => $account['error']));
        }
    }
    public function updateCustomerForAdmin($data){
        $email = $data['email'];
        $password = $data['password'];
        $fullname = $data['fullname'];
        $address = $data['address'];
        $phone = $data ['phone'];
        $customer_id = $data['custome_id'];
        $acc = (new AccountModel())->getAcountByEmail($email);

        $acc = json_decode($acc, true);

        if($acc['success']){
            $account = new Account($email,$password,"",$acc['account']['id']);
            $result = (new AccountModel())->updateAccount($account);
             if(!$result['success']){
            return array('success'=>false , "message"=>"Update Thông tin thất bạ1");
            }
        }else{
            return array('success'=>false , "message"=>"Update Thông tin thất bại2");
            
        }
            $customer = new Customer($fullname, $email, $address, $phone, "", $customer_id);
            // die((new CustomerModel)->updateCustomer($customer));
            return (new CustomerModel)->updateCustomer($customer);
        }    
    public function deteleManager($email){
        $manager = (new ManagerModel())->deleteManager($email);
        if(!$manager['success']){
            return array("success" =>false,"message"=>"Xóa tài khoản thất bại");

        }
        $acc = (new AccountModel())->deleteAccount($email);
        if(!$acc['success']){
            return array("success" =>false,"message"=>"Xóa tài khoản thất bại");
            
        }
        return array("success" =>true,"message"=>"Xóa tài khoản thành công ");

    }
    public function updateInformationForManager($data){
        $email = $data['email'];
        $password = $data['password'];
        $fullname = $data['fullname'];
        $phone = $data ['phone'];
        $id = $data['id'];
        $acc = (new AccountModel())->getAcount($email,$password);
        $account = json_decode($acc,true);
        if($account['success']){
            $Manager = new Manager($fullname, $email, $phone, "", $id);
            return (new ManagerModel)->updateManager($Manager);
        }else{
            return json_encode(array("success" => true,"error" => $account['error']));
        }
         
        
    }
    public function addManager($data)
{
    $email = $data['email'];
        $password = $data['password'];
        $fullname = $data['fullname'];
        $phone = $data ['phone'];
        $role = $data ['role'];

        $account = (new AccountModel())->addAcount(new Account($email,$password,$role));
        $result = json_decode($account, true);
        if($result['success']){
            $acc = (new AccountModel())->getAcount($email,$password);
            $acc = json_decode($acc, true);
           
            $manage = (new ManagerModel())->addManager(new Manager($fullname,$email,$phone,$acc['account']['id']));
           $manage =  json_decode($manage,true);
        //    return $manager;
          
           if($manage['success']){
                $ma = (new ManagerModel())->getManagerByEmail($email);
                return array("success" => true,'role' =>2,'user' =>$ma);
            }else {
                return array("success" => false,"message"=>"Đăng ký thất bại"); // xoá dòng => ở đây và thêm giá trị false vào mảng này

            }
        }
        return array("success" => false,"message"=>"Đăng ký thất bại"); // xoá dòng => ở đây và thêm giá trị false vào mảng này
}




}
?>
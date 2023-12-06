<?php 
require_once '../../model/model/BookingModel.php';
require_once '../../model/model/TicketModel.php';
require_once '../../model/model/PromotionModel.php';
require_once '../../model/model/MenuDetailModel.php';
require_once '../../model/entity/Booking.php';
require_once '../../model/entity/Promotion.php';
class BookingController {
    function getAllBookings($page) {
        return (new BookingModel())->getAllBookings($page);
    }
    function getBookingById($id) {
        return (new BookingModel())->getBookingByID($id);

    }
    public function getAllBookingsByCustomerID($customer,$page){
        return (new BookingModel())->getAllBookingsByCustomerID($customer,$page);
        
    }
    public function getBookingDetailsByBookingID($bookingid){
        return (new BookingModel())->getBookingDetails($bookingid);
    }
    function caluateBookingByCode($data){
        $TotalPrice = $data['TotalPrice'];
        $code = $data['code'];
        $promotion = (new PromotionModel())->getPromotionsByCode($code);
        if($promotion==null){
            return array("totalPrice"=>$TotalPrice, "success"=>false,"message"=>"Thêm mã giảm giá thất bại12");
        }
        $now = time();
$start_time = strtotime($promotion->get_StartTime());
$end_time = strtotime($promotion->get_EndTime());

if($start_time <= $now && $end_time >= $now) {
    $TotalPrice = (floatval($TotalPrice) * (100.0 - floatval($promotion->get_Discount()))) / 100;
    return array("totalPrice" => $TotalPrice, "success" => true, "message" => "Thêm mã giảm giá thành công");
}

       
        return array("totalPrice"=>$TotalPrice, "success"=>false,"message"=>"Thêm mã giảm giá thất bại312");
    }
    function changeStatusBooking($data){
        $booking_id = $data["booking_id"];
        $status =  $data["status"];
        return (new BookingModel())->updateBookingStatus($booking_id,$status);

    }
    function addBooking($data){

        $NumberOfTickets = $data['NumberOfTickets'];
        $TotalPrice = $data['TotalPrice'];
        $BookingTime = $data['BookingTime'];
        $Voucher = $data['Voucher'];
        $customer_id = $data['customer_id'];
        $ListTicket = $data['ListTicket'];
        $ListMenu = $data['ListMenu'];
        $ShowTimeID = $data['ShowTimeID'];
        $status = 0;
        $booking =((new BookingModel())->addBooking(new Booking($NumberOfTickets, $BookingTime, $TotalPrice,  $Voucher,$customer_id ,$status)));
        if(!$booking['success']){
            return array('success' =>false, 'message' =>"Đặt vé thất bại");

        }
       
       
       
        $booking_id = $booking['booking_id'];
        
        foreach($ListTicket as $ticket){
            $t = (new TicketModel())->addTicket(new Ticket($ShowTimeID,$ticket['SeatID'],"S1"));
            // die(json_encode($t));
            if(!$t['success']){
                (new BookingModel())->deleteBooking($booking_id);
                return array('success' =>false, 'message' =>"Đặt vé thất bại1");
            }

            $dt =(new TicketModel())->addTicketsDetails(new DetailTicket($t['TicketID'],$booking_id));
           
            if(!$dt['success']){
                (new BookingModel())->deleteBooking($booking_id);
                return array('success' =>false, 'message' =>"Đặt vé thất bại");
            }
        }
        foreach($ListMenu as $menu){
          $number =  $menu['Number'];
          $total =  floatval($menu['Price'])* $number;
          $md = (new MenuDetailModel())->addMenu(new MenuDetail($number,$total,$booking_id,$menu['ItemID']));
            if(!$md['success']){
                (new BookingModel())->deleteBooking($booking_id);
                return array('success' =>false, 'message' =>"Đặt vé thất bại");

            }
        }
        return array('success' =>true, 'message' =>"Đặt vé thành công","id"=>$booking_id);
    }
    function removeBooking($id){
        return (new BookingModel())->deleteBooking($id);

    }

    function updateBooking($data){
        $BookingID = $data['BookingID'];
        $NumberOfTickets = $data['NumberOfTickets'];
        $TotalPrice = $data['TotalPrice'];
        $BookingTime = $data['BookingTime'];
        $Voucher = $data['Voucher'];
        $customer_id = $data['customer_id'];
        $status = $data['status'];
        $Booking = new Booking( $NumberOfTickets, $BookingTime, $TotalPrice,  $Voucher,$customer_id ,$status,$BookingID);
        return (new BookingModel())->updateBooking($Booking);

    }
}

?>
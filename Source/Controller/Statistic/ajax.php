<?php
require_once 'StatisticController.php';
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'];
    header('Content-Type: application/json');
    switch($action) {
        case 'getRevenueForDate':
            if(isset($_GET['date'])){
                $date = $_GET['date'];
            }else{
                $date = null;
            }
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }else{
               $page = 1;
            }
            echo json_encode((new StatisticController())->getRevenueForDate($date,$page));
            break;
        case 'getRevenueForMonth':
            if(isset($_GET['month'])){
                $month = $_GET['month'];
            }else{
                $month = null;
            }
            if(isset($_GET['year'])){
                $year = $_GET['year'];
            }else{
                $year = null;
            }
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }else{
               $page = 1;
            }
            echo json_encode((new StatisticController())->getRevenueForMonth($year,$month,$page));
            break;
        case 'getRevenueForYear':
          
            if(isset($_GET['year'])){
                $year = $_GET['year'];
            }else{
                $year = null;
            }
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }else{
                $page = 1;
            }
            echo json_encode((new StatisticController())->getRevenueForYear($year,$page));
            break;
        case 'getRevenueForQuarterOfYear':
            if(isset($_GET['year'])){
                $year = $_GET['year'];
            }else{
                $year = null;
            }
            if(isset($_GET['quarter'])){
                $quarter = $_GET['quarter'];
            }else{
                $quarter = null;
            }
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }else{
                $page = 1;
            }
            echo json_encode((new StatisticController())->getRevenueForQuarterOfYear($year,$quarter,$page));
           
            break;
            //timeframe day / month / year
        case 'getTopHighestGrossingMovie':
            if(isset($_GET['date'])){
                $date = $_GET['date'];
            }else{
                $date = date('Y-m-d');
            }
            if(isset($_GET['timeframe'])){
                $timeframe = $_GET['timeframe'];
            }else{
                $timeframe = 'day';
            }
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }else{
                $page = 1;
            }
            echo json_encode((new StatisticController())->getTopHighestGrossingMovie($page, $date, $timeframe));   
            break;
        //timeframe day / month / year
        case 'getTopHighestGrossingThearts':
            if(isset($_GET['date'])){
                $date = $_GET['date'];
            }else{
                $date = date('Y-m-d');
            }
            if(isset($_GET['timeframe'])){
                $timeframe = $_GET['timeframe'];
            }else{
                $timeframe = 'day';
            }
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }else{
                $page = 1;
            }
            echo json_encode((new StatisticController())->getTopHighestGrossingThearts($page, $date, $timeframe));   
            break;
                        
        }
}
?>
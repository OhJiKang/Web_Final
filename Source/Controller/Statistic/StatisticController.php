<?php 
require_once '../../model/model/StatisticModel.php';

class StatisticController{

    public function getRevenueForDate($date=null,$page=1){
        return (new StatisticModel() )->getRevenueForDate($date,$page);
    }
    public function getRevenueForMonth($year=null, $month=null,$page = 1){
        return (new StatisticModel() )->getRevenueForMonth($year,$month,$page);
    }
    public function getRevenueForYear($year=null, $page = 1){
        return (new StatisticModel() )->getRevenueForYear($year,$page);

    }
    public function getRevenueForQuarterOfYear($year=null, $quarter=null,$page = 1){
        return (new StatisticModel() )->getRevenueForQuarterOfYear($year,$quarter,$page);

    }
    public function getTopHighestGrossingMovie($page, $date, $timeframe) {
        return (new StatisticModel())->getTopHighestGrossingMovie($page,$date,$timeframe);
    }
    public function getTopHighestGrossingThearts($page, $date, $timeframe) {
        return (new StatisticModel())->getTopHighestGrossingTheater($page,$date,$timeframe);
    }

}
?>
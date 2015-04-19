<?
set_time_limit(0);
//	mac numer
file_get_contents("http://admin.16610.com/statistics/intval_days.php");

sleep(50);
//	mac bill
file_get_contents("http://admin.16610.com/statistics/intval_bill.php");

sleep(50);
//	browse
file_get_contents("http://admin.16610.com/statistics/intval_days_browse.php");

sleep(30);

//	mac
file_get_contents("http://admin.16610.com/statistics/intval_days_mac.php");

exit;
sleep(30);
//	extsta
file_get_contents("http://admin.16610.com/statistics/intval_days_extsta.php");

?>
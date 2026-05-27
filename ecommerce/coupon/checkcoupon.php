<?php

include "../connect.php";

$couponName = filterRequest("couponName");
$now = date("Y-m-d H:i:s");


getData("coupon" , "`coupon_name` = ? AND `coupon_expiredate` > ? AND `coupon_count` > ?",array($couponName, $now, 0) );
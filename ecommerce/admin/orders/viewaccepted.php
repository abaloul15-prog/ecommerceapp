<?php

include __DIR__ . "/../../connect.php";


getAllData("ordersview" , "orders_status != 3 AND orders_status != 0");
<?php

include "../connect.php";

$search = filterRequest('search');

getAllData("items1view", "items_name LIKE '%$search%' OR items_name_nl LIKE '%$search%'");
// getAllData("items", "items_name LIKE ? OR items_name_nl LIKE ?", array("%$search%", "%$search%"));

<?php

include('../models/ck_database.php');
include('../models/charise_offense.php');

date_default_timezone_set('Asia/Manila');

$offense = new Offense();

if (isset($_POST['categorySelect1'])) {
    $data = $offense->categoryLevel("2", $_POST['category1']);
    echo $data;
} else if (isset($_POST['categorySelect2'])) {
    $data = $offense->categoryLevel("3", $_POST['category2']);
    echo $data;
}

if (isset($_POST['employeeName'])) {
    $table = $offense->getTable($_POST['employee']);
    echo $table;
} else if (isset($_POST['getOffense'])) {
    $table = $offense->getTable('', 'offenseList');
    echo $table;
}

if (isset($_POST['addOffense'])) {
    $data = [];
    $dateToday = date("Y-m-d H:i:s");
    $data = array(
        'employee'      => $_POST['employee'],
        'category1'     => $_POST['category1'],
        'category2'     => isset($_POST['category2']) ? $_POST['category2'] : '',
        'date'          => $dateToday
    );

    $add = $offense->addOffense($data);

    echo $add;
}

if (isset($_POST['button'])) {
    $employeeId = $_POST['employee'];

    $button = $offense->selectTerminatedOffense($employeeId);

    echo $button;
}

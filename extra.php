<?php
function getdaydiffer($start, $end)
{
    $startDate = date("Y-m-d", strtotime($start));
    $endDate = date("Y-m-d", strtotime($end));
    $differentDate = abs(strtotime($endDate) - strtotime($startDate));
    $yearDiff = floor($differentDate / (365 * 60 * 60 * 24));
    $monthDiff = floor(($differentDate - $yearDiff * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
    $dayDiff = floor(($differentDate - $yearDiff * 365 * 60 * 60 * 24 - $monthDiff * 30 * 60 * 60 * 24) / (60 * 60 * 24));
    return $yearDiff * 365 + $monthDiff * 30 + $dayDiff;
}

function checkStartDate($std)
{
    $newDate = date("Y-m-d", strtotime($std));
    $arr = explode("-", $newDate);
    $message = "";
    if ($arr[0] < date("Y")) {
        $message = "<span style='color:red;'>*year error must start from same today date: " . date("Y-m-d") . " or more.</span>";
    } else {
        if ($arr[1] < date("m")) {
            $message = "<span style='color:red;'>*month error must start from same today date: " . date("Y-m-d") . " or more.</span>";
        } else {
            if ($arr[2] < date("d"))
                $message = "<span style='color:red;'>*day error must start from same today date: " . date("Y-m-d") . " or more.</span>";
        }
    }
    return $message;
}

<?php

use App\Models\ref;
use App\Models\transactions;
use App\Models\users_transactions;

function createTransaction($accountID, $date, $cr, $db, $notes, $ref){
    transactions::create(
        [
            'accountID' => $accountID,
            'date' => $date,
            'cr' => $cr,
            'db' => $db,
            'notes' => $notes,
            'refID' => $ref,
        ]
    );

}

function createUserTransaction($userID, $date, $cr, $db, $notes, $ref){
    users_transactions::create(
        [
            'userID' => $userID,
            'date' => $date,
            'cr' => $cr,
            'db' => $db,
            'notes' => $notes,
            'refID' => $ref,
        ]
    );

}

function getAccountBalance($id){
    $transactions  = transactions::where('accountID', $id);

    $cr = $transactions->sum('cr');
    $db = $transactions->sum('db');
    $balance = $cr - $db;

    return $balance;
}

function getUserAccountBalance($id){
    $transactions  = users_transactions::where('userID', $id);

    $cr = $transactions->sum('cr');
    $db = $transactions->sum('db');
    $balance = $cr - $db;

    return $balance;
}


function numberToWords($number)
{
    $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
    return ucfirst($f->format($number));
}


function spotBalanceBefore($id, $ref)
{
    $cr = transactions::where('accountID', $id)->where('refID', '<', $ref)->sum('cr');
    $db = transactions::where('accountID', $id)->where('refID', '<', $ref)->sum('db');
    return $balance = $cr - $db;
}

function spotBalance($id, $ref)
{
    $cr = transactions::where('accountID', $id)->where('refID', '<=', $ref)->sum('cr');
    $db = transactions::where('accountID', $id)->where('refID', '<=', $ref)->sum('db');
    return $balance = $cr - $db;
}

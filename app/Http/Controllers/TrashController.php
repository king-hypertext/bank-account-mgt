<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountLocation;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function index(int $location)
    {
        // Fetch all deleted records from the database
        $account_location = AccountLocation::findOrFail($location);
        $accounts =  $account_location->accounts()->onlyTrashed()->get();
        $page_title = 'Deleted Records';
        return view('trash.index', compact('accounts', 'page_title', 'account_location'));
    }
}

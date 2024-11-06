<?php

namespace App\Http\Controllers;

use App\Models\AccountLocation;
use App\Models\AccountStatus;
use App\Models\AccountType;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index()
    {
        $page_title = 'accounts';
        $account_locations = AccountLocation::all();
        if ($account_locations->isEmpty()) {
            return redirect()->to(route('l.create'));
        }
        return view('app.index', compact('page_title', 'account_locations'));
    }
    public function createLocation()
    {
        $page_title = 'set up location for account';
        $account_types = AccountType::all(['id', 'type']);
        $account_statuses = AccountStatus::all(['id', 'status']);
        return view('locations.create', compact('page_title', 'account_types', 'account_statuses'));
    }
    public function storeLocation(Request $request)
    {
        $validated =  $request->validate([
            'ref' => 'nullable|string|max:255',
            'account_location' => 'unique:account_locations,name',
            'name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'account_type' => 'required|exists:account_types,id',
            'account_status' => 'required|exists:account_statuses,id',
            'account_description' => 'nullable|string|max:255',
            'account_address' => 'required|string|max:255',
            'initial_amount' => 'nullable|numeric',
            'created_at' => 'date'
        ]);
        $account_location = AccountLocation::create([
            'name' => $validated['account_location'],
        ]);
        $account_location->accounts()->create([
            'ref' => $validated['ref'],
            'name' => $validated['name'],
            'bank_name' => $validated['bank_name'],
            'account_name' => $validated['account_name'],
            'account_type_id' => $validated['account_type'],
            'account_status_id' => $validated['account_status'],
            'account_description' => $validated['account_description'],
            'account_address' => $validated['account_address'],
            'initial_amount' => $validated['initial_amount'],
            'created_at' => $validated['created_at'] ?? now(),
        ]);
        return redirect()->to(route('account.home', $account_location->id));
    }
}

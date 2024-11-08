<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Http\Requests\StoreEntryRequest;
use App\Http\Requests\UpdateEntryRequest;
use App\Models\AccountLocation;
use App\Models\EntryType;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(int $location)
    {
        $account_location = AccountLocation::findOrFail($location);
        $entries = Entry::belongsToAccounts($account_location->accounts->pluck('id'));
        return view('entries.index', compact('entries', 'account_location'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $location)
    {
        $page_title = 'create account';
        $account_location = AccountLocation::findOrFail($location);
        $entry_types = EntryType::all();
        $accounts = $account_location->accounts;
        return view('entries.create', compact('account_location', 'page_title', 'entry_types', 'accounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(int $location, StoreEntryRequest $request)
    {
        $account = AccountLocation::findOrFail($location)->accounts()->findOrFail($request->account);
        $account->entries()->create([
            'entry_type_id' => $request->entry_type,
            'description' => $request->description,
            'amount' => $request->amount,
            'date' => $request->date,
            'status' => $request->status,
            'reference_number' => $request->reference_number,
            'created_at' => $request->date ?? now(),
        ]);
        return redirect()->to(route('entries.index', $location))->with('success', 'Entries created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Entry $entry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entry $entry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEntryRequest $request, Entry $entry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entry $entry)
    {
        //
    }
}

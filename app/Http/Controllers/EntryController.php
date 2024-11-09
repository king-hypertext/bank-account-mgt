<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Http\Requests\StoreEntryRequest;
use App\Http\Requests\UpdateEntryRequest;
use App\Models\AccountLocation;
use App\Models\EntryType;
use Illuminate\Http\Request;

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
    public function edit(int $location, Entry $entry)
    {
        $account_location = AccountLocation::findOrFail($location);
        if ($entry->account->accountLocation->id !== $location) {
            abort(403, 'Entry does not belongs to this location.');
        }
        $page_title = 'edit entry';
        $entry_types = EntryType::all();
        return view('entries.edit', compact('entry', 'account_location', 'page_title', 'entry_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $location, UpdateEntryRequest $request, Entry $entry)
    {
        return $entry;
        if ($entry->is_reconciled) {
            $entry->update();
        }
        $entry->update();
        $url = redirect()->back()->with('success', 'Entry updated successfully')->getTargetUrl();
        return response()->json(['success' => true, 'url' => $url]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $location, Request $request, Entry $entry)
    {
        return $entry;
        $entry->destroy($request->entries);
        $url = redirect()->back()->with('success', 'Entries deleted successfully')->getTargetUrl();
        return response()->json(['success' => true, 'url' => $url]);
    }
    public function reconcile(int $location, Entry $entry)
    {
        return $entry;
        $entry->update(['is_reconciled' => true]);
        $url = redirect()->back()->with('success', 'Entry reconciled successfully')->getTargetUrl();
        return response()->json(['success' => true, 'url' => $url]);
    }
}

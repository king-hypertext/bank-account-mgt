<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\AccountLocation;
use App\Models\AccountStatus;
use App\Models\AccountType;
use App\Models\EntryType;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(int $location)
    {
        $account_location =  AccountLocation::findOrFail($location);
        $accounts = $account_location->accounts()->orderBy('created_at', 'DESC')->get();
        $page_title = $account_location->name;
        return view('accounts.index', compact('accounts', 'account_location', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $location)
    {
        $page_title = 'create account';
        $account_location = AccountLocation::findOrFail($location);
        $account_types = AccountType::all();
        $account_statuses = AccountStatus::all();
        return view('accounts.create', compact('account_location', 'page_title', 'account_types', 'account_statuses'));
    }
    private function getAcronym($str)
    {
        // $words = explode(' ', trim($str));
        // $acronym = '';
        // foreach ($words as $word) {
        //     if (strlen($word) > 3) {
        //         $acronym .= strtoupper($word[0]);
        //     }
        // }
        // return $acronym;
        $words = explode(' ', trim($str));

        if (count($words) <= 2) {
            return strtoupper($str);
        } else {
            $acronym = '';
            foreach ($words as $word) {
                if (strlen($word) >= 4) {
                    $acronym .= strtoupper($word[0]);
                }
            }
            return $acronym;
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(int $location, StoreAccountRequest $request)
    {
        $account_location = AccountLocation::findOrFail($location);
        $value_date = now()->parse($request->input('value_date'))->toDateString();
        $date = now()->parse($request->input('created_at'))->toDateString();
        $account = $account_location->accounts()->create([
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'name' => $this->getAcronym($request->bank_name),
            'account_type_id' => $request->account_type,
            'account_status_id' => $request->account_status,
            'account_description' => $request->account_description,
            'account_address' => $account_location->name . ' - ' . $this->getAcronym($request->bank_name),
            'initial_amount' => $request->initial_amount ?? 0, 
            'balance' => 0,
            'created_at' => $date ?? now(),
        ]);
        //create an entry with description initial deposit
        $account->entries()->create([
            'entry_type_id' => EntryType::CREDIT_ID,
            'amount' => $request->initial_amount,
            'description' => 'intial deposit',
            'date' => $date,
            'reference_number' => now()->format('Ymdhisv'),
            'value_date' => $value_date ?? now(),
        ]);
        // $request->initial_amount > 0 && $account->updateBalance($request->initial_amount ?? 0, 'credit');
        $routeName = $request->has('exist') ? 'account.home' : 'account.create';
        return redirect()->to(route($routeName, $location))->with('success', 'account created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $location, Request $request, Account $account)
    {
        $page_title = 'account';
        $account_location = AccountLocation::findOrFail($location);
        if ($account->accountLocation->id !== $location) {
            abort(403, 'Account does not belongs to this location.');
        }
        $account->load('entries');
        $entries = $account->entries()->where('is_reconciled', true)->orderBy('created_at', 'ASC')->get();
        if ($request->filled(['start_date', 'end_date'])) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $entries = $account->entries()->where('is_reconciled', true)->whereBetween('value_date', [$start_date, $end_date])->orderBy('created_at', 'ASC')->get();
        }
        return view('accounts.show', compact('account', 'account_location', 'page_title', 'entries'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $location, Account $account)
    {
        $page_title = 'edit account';
        $account_location = AccountLocation::findOrFail($location);
        if ($account->accountLocation->id !== $location) {
            abort(403, 'Account does not belongs to this location.');
        }
        $account_types = AccountType::all();
        $account_statuses = AccountStatus::all();
        return view('accounts.edit', compact('account', 'account_location', 'page_title', 'account_types', 'account_statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $location, UpdateAccountRequest $request, Account $account)
    {
        if ($account->accountLocation->id !== $location) {
            abort(403, 'Account does not belongs to this location.');
        }
        $value_date = now()->parse($request->input('created_at'))->toDateString();
        // $date = now()->parse($request->input('date'))->toDateString();
        if ($account->entries->isEmpty() && $request->initial_amount > 0) {
            $account->entries()->create([
                'entry_type_id' => EntryType::CREDIT_ID,
                'amount' => $request->initial_amount,
                'description' => 'intial deposit',
                'date' => $value_date ?? now(),
                'reference_number' => now()->format('Ymdhisv'),
                'value_date' => $value_date ?? now(),
            ]);
        }
        $account->update([
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'name' => $this->getAcronym($request->bank_name),
            'account_type_id' => $request->account_type,
            'account_status_id' => $request->account_status,
            'account_description' => $request->account_description,
            'account_address' => $account->accountLocation->name . ' - ' . $this->getAcronym($request->bank_name),
            'initial_amount' => $request->initial_amount,
            'created_at' => $value_date ?? now(),
        ]);

        // if ($request->initial_amount <> $previousInitialAmount) {
        //     $difference = $request->initial_amount - $previousInitialAmount;
        //     $account->updateBalance($difference, 'credit');
        // }

        return back()->with('success', 'Account updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $location, Account $account)
    {
        // return $account;
        if ($account->accountLocation->id !== $location) {
            abort(403, 'Account does not belongs to this location.');
        }
        $account->delete();
        $url = back()->with('warning', 'Account deleted successfully')->getTargetUrl();
        return response()->json(['success' => true, 'url' => $url]);
    }
    private function generateAccountNumber(): int
    {
        return (int) now()->format('Ymdhisv');
    }

    public function cloneAccounts(int $location)
    {
        $accountLocation = AccountLocation::findOrFail($location);
        $clonedAccountLocation = $accountLocation->replicate();
        $clonedAccountLocation->name .= ' - Cloned';
        $clonedAccountLocation->save();

        foreach ($accountLocation->accounts as $account) {
            $clonedAccount = $account->replicate();
            $clonedAccount->account_location_id = $clonedAccountLocation->id;
            $clonedAccount->account_number = $this->generateAccountNumber();
            $clonedAccount->account_address = $account->name;
            $clonedAccount->initial_amount = 0;
            $clonedAccount->balance = 0;
            $clonedAccount->save();
        }

        $url = redirect()->route('account.home', $clonedAccountLocation->id)
            ->with('success', 'Accounts cloned successfully')->getTargetUrl();
        return response()->json(['success' => true, 'url' => $url]);
    }
    public function restore(int $location, $account)
    {
        $account = Account::withTrashed()->where('id', $account)->first();
        $account->restore();
        $url = redirect()->route('account.home', $location)->with('success', 'Account restored successfully')->getTargetUrl();
        return response()->json(['success' => true, 'url' => $url]);
    }
}

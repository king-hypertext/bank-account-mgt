<?php

namespace App\Http\Controllers;

use App\Models\AccountLocation;
use App\Models\AccountStatus;
use App\Models\AccountType;
use App\Models\EntryType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{

    public function init()
    {
        $page_title = 'initialize banking system';
        return view('app.init', compact('page_title'));
    }
    public function storeAdmin(Request $request)
    {
        $request->validate(
            [
                'username' => 'required|string|min:4',
                'password' => 'required|string|min:6',
                'confirm_password' => 'required|same:password',
            ],
            [
                'confirm_password.same' => 'Passwords do not match.',
                'password.min' => 'Password must be at least 6 characters long.',
                'username.min' => 'Username must be at least 4 characters long.',
            ]
        );
        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);
        Auth::login($user, true);
        return to_route('l.create')->with('user', $user->username);
    }
    public function index()
    {
        $page_title = 'home';
        $account_locations = AccountLocation::all();
        if ($account_locations->isEmpty()) {
            return redirect()->to(route('l.create'));
        }
        return view('app.index', compact('page_title', 'account_locations'));
    }
    public function createLocation()
    {
        Artisan::call('db:seed');
        $page_title = 'set up location for account';
        $account_types = AccountType::all(['id', 'type']);
        $account_statuses = AccountStatus::all(['id', 'status']);
        return view('locations.create', compact('page_title', 'account_types', 'account_statuses'));
    }


    function getAcronym($str)
    {
        $words = explode(' ', trim($str));

        if (count($words) == 1) {
            return strtoupper($str);
        } else {
            $acronym = '';
            foreach ($words as $word) {
                if (strlen($word) > 3) {
                    $acronym .= strtoupper($word[0]);
                }
            }
            return $acronym;
        }
    }


    public function storeLocation(Request $request)
    {
        $request->validate([
            'account_number' => 'required|string|max:255',
            'location' => 'required|unique:account_locations,name',
            // 'name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'account_type' => 'required|exists:account_types,id',
            'account_status' => 'required|exists:account_statuses,id',
            'account_description' => 'nullable|string|max:255',
            // 'account_address' => 'required|string|max:255',
            'initial_amount' => 'nullable|numeric',
            'created_at' => 'date'
        ], [
            'location.unique' => 'Location already exists.',
            'location.required' => 'Account location is required.',
            'bank_name.required' => 'Bank name is required.',
            'name.required' => 'Account name is required.',
            'account_description.max' => 'Account description cannot be more than 255 characters.',
            'created_at.date' => 'account creation date should be a valid date.',
        ]);
        $account_location = AccountLocation::create([
            'name' => $request->location,
        ]);
        $account = $account_location->accounts()->create([
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'name' => $this->getAcronym($request->bank_name),
            'account_type_id' => $request->account_type,
            'account_status_id' => $request->account_status,
            'account_description' => $request->account_description,
            'account_address' => $request->location . ' - ' . $this->getAcronym($request->bank_name),
            'initial_amount' => $request->initial_amount,
            'balance' => 0,
            'created_at' => $request->created_at ?? now(),
        ]);
        if ($request->initial_amount > 0) {
            $account->entries()->create([
                'entry_type_id' => EntryType::CREDIT_ID,
                'amount' => $request->initial_amount ?? 0,
                'date' => now(),
                'description' => 'initial deposit',
                'reference_number' => now()->format('Ymdhisv'),
                'value_date' => $request->created_at ?? now(),
            ]);
        }
        return redirect()->to(route('account.home', $account_location->id));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:account_locations,name'
        ]);
        $location = AccountLocation::create([
            'name' => $request->name,
        ]);
        $route = redirect()->route('account.home', $location->id)->getTargetUrl();
        return response()->json(['success' => true, 'url' => $route]);
    }
    public function update(int $id, Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|unique:account_locations,name',
            ],
            [
                'name.unique' => 'The entered location already exists',
            ]
        );
        $account = AccountLocation::findOrFail($id);
        $account->update(['name' => $request->name]);
        $url = redirect()->back()->with('success', 'Location name updated successfully')->getTargetUrl();
        return response()->json(['success' => true, 'url' => $url]);
        // return redirect()->route('account.home', $account->id);
    }
}

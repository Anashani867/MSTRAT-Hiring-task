<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    return Customer::paginate(10); // Admin view
    }

    public function indexView()
{
    return view('customers.index');
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:customers',
        'phone' => 'required|string',
        'gender' => 'nullable|in:Male,Female,Other',
        'date_of_birth' => 'nullable|date',
        'photo' => 'nullable|image|max:2048', // تحقق من الصورة
    ]);

    $customer = new Customer();
    $customer->name = $request->name;
    $customer->email = $request->email;
    $customer->phone = $request->phone;
    $customer->gender = $request->gender;
    $customer->date_of_birth = $request->date_of_birth;
    $customer->status = 'Active';
    $customer->server_datetime = now();
    $customer->datetime_utc = now()->setTimezone('UTC');

    // ✔️ رفع الصورة وتخزين المسار
    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $path = $file->store('customers', 'public');
        $customer->photo = $path;
    }

    $customer->save();

    return response()->json(['message' => 'Customer added successfully', 'data' => $customer]);
}


    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
 $customer->update($request->all());
    return $customer;    }

    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:الا,Inactive,Deleted,Expired'
    ]);

    $customer = Customer::findOrFail($id);
    $customer->status = $request->status;
    $customer->save();

    return response()->json([
        'message' => 'Status updated successfully',
        'data' => $customer
    ]);
}


    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Request $request)
{
    $ids = $request->input('ids');  

    if(!$ids || !is_array($ids)) {
        return response()->json(['message' => 'No customer IDs provided or invalid format'], 400);
    }

    Customer::whereIn('id', $ids)->delete();

    return response()->json(['message' => 'Customers deleted.']);
}

}


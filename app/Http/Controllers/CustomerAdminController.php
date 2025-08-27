<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CustomerAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $q = Customer::query();
        if ($s = $request->get('s')) {
            $q->where(function($qq) use ($s) {
                $qq->where('name','like',"%$s%")
                   ->orWhere('email','like',"%$s%" )
                   ->orWhere('login_id','like',"%$s%");
            });
        }
        $customers = $q->orderBy('id','desc')->paginate(10)->withQueryString();
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.form', ['customer' => new Customer()]);
    }

    public function store(CustomerStoreRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $customer = Customer::create($data);
        event(new Registered($customer));
        return redirect()->route('admin.customers.index')->with('status','Member created');
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customers.form', compact('customer'));
    }

    public function update(CustomerUpdateRequest $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $data = $request->validated();
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $customer->update($data);
        return redirect()->route('admin.customers.index')->with('status','Member updated');
    }

    public function exportCsv()
    {
        $response = new StreamedResponse(function() {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['id','name','email','login_id','email_verified_at','created_at']);
            Customer::chunk(200, function($rows) use ($handle) {
                foreach ($rows as $r) {
                    fputcsv($handle, [$r->id,$r->name,$r->email,$r->login_id,$r->email_verified_at,$r->created_at]);
                }
            });
            fclose($handle);
        });
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="customers.csv"');
        return $response;
    }
}

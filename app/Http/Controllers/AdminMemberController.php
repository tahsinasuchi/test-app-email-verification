<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRegisterRequest;
use App\Http\Requests\AdminUpdateRequest;
use Illuminate\Auth\Events\Registered;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $q = Admin::query();
        if ($s = $request->get('s')) {
            $q->where(function($qq) use ($s) {
                $qq->where('name','like',"%$s%")
                   ->orWhere('email','like',"%$s%" )
                   ->orWhere('login_id','like',"%$s%");
            });
        }
        $admins = $q->orderBy('id','desc')->paginate(10)->withQueryString();
        return view('admin.members.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.members.form', ['admin' => new Admin()]);
    }

    public function store(AdminRegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $admin = Admin::create($data);
        event(new \Illuminate\Auth\Events\Registered($admin)); 

        return redirect()->route('admin.members.index')->with('status','Admin created');
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.members.form', compact('admin'));
    }

    public function update(AdminUpdateRequest $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $data = $request->validated();
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $admin->update($data);
        return redirect()->route('admin.members.index')->with('status','Admin updated');
    }

    public function exportCsv()
    {
        $response = new StreamedResponse(function() {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['id','name','email','login_id','email_verified_at','created_at']);
            Admin::chunk(200, function($rows) use ($handle) {
                foreach ($rows as $r) {
                    fputcsv($handle, [$r->id,$r->name,$r->email,$r->login_id,$r->email_verified_at,$r->created_at]);
                }
            });
            fclose($handle);
        });
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="admins.csv"');
        return $response;
    }
}

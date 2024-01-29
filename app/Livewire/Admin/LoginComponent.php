<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use DB;

class LoginComponent extends Component
{
    public $admin_pass;
    public $admin_id;

    protected $rules = [
        'admin_pass' => 'required|min:8',
        'admin_id' => 'required|email',
    ];

    public function render()
    {
        return view('livewire.admin.login-component');
    }

    public function login()
    {
        $this->validate();

        $checkData = DB::table('admin')
            ->where([
                ['admin_id', '=', $this->admin_id],
                ['admin_pass', '=', $this->admin_pass],
            ])
            ->first();

        if (!empty($checkData)) {
            $adminStatus = $checkData->admin_u_status;

            if ($adminStatus == '0') {
                // Storing only necessary information in session
                session()->put([
                    'adminId' => $checkData->id,
                    'adminName' => $checkData->admin_name,
                    'adminEmail' => $checkData->admin_id,
                    'userRole' => $checkData->user_type,
                ]);

                return redirect()->to('/emplist')->with('success', 'Logged Successfully');
            } else {
                return redirect()->back()->with('warning', 'Your Account is Not Active');
            }
        } else {
            
            return redirect()->to('/')->with('error', 'Invalid Credentials');
        }
    }
}

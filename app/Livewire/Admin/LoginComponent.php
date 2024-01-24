<?php

namespace App\Livewire\Admin;
use Livewire\Component;
use DB;

class LoginComponent extends Component
{
  
    public $admin_pass, $admin_id;

    public function render()
    {
        // return view('livewire.admin.login-component');
        return view('livewire.admin.login-component');
        // return view('livewire.admin.login-component')->layout('livewire.admin.layouts.base');
    }

    public function login()
    {
   
        $this->validate([
            'admin_id' => 'required',
            'admin_pass' => 'required',
        ]);

        $checkData = DB::table('admin')
        ->where([
            ['admin_id', '=', $this->admin_id],
            ['admin_pass', '=',$this->admin_pass]
        ])
        ->first();

        if(!empty($checkData)){

            $adminStatus = $checkData->admin_u_status;
            $adminName = $checkData->admin_name;
            $adminEmail = $checkData->admin_id;
            $adminId = $checkData->id;
            $adminPassword = $checkData->admin_pass;
            $userRole = $checkData->user_type; // $userRole = 1 for admin , 2 for telecaller , 3 for hospital user , 4 for Medcab Accounts and 5 for medcab Blog User
            if($adminStatus == '0' ){

                session()->flash('adminId', $adminId);
                session()->flash('adminName', $adminName);
                session()->flash('adminEmail', $adminEmail);
                session()->flash('adminPassword', $adminPassword);
                session()->flash('userRole', $userRole);

                return redirect()->to('/emplist')->with('success','Logged Successfully');

            }else{
                return redirect()->back()->with('warning','Your Accounts is Not Active');
            }

        }else{

        }

        return redirect()->to('/')->with('error','Invalide Credentials');
        $this->emit('alert_remove');
        return;
    }
}

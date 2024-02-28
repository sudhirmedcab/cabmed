<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB; 
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Response;

class LoginComponent extends Component
{
    public $admin_pass,$admin_id,$login_as;
    
    
    public function render()
    {
        return view('livewire.admin.login-component')->layout('livewire.admin.layouts.login-base');
    }
    public function loginForm()
    {
        $this->validate([
            'login_as' => 'required',
            'admin_id' => 'email|required',
            'admin_pass' => 'required',
        ],[
        'login_as.required' => 'This field required',
        'admin_id.required' => 'This field required',
        'admin_id.email' => 'Enter correct email',
        'admin_pass.required' => 'This field required',
        ]);
        DB::beginTransaction();
        try{
            //for hased start
            // if (Auth::guard('admin')->attempt(['admin_id' => $this->admin_id, 'admin_pass' => $this->admin_pass])) {
            //     session()->flash('message', 'Login form submitted  !!');
                
            //     return redirect('/generate-booking');
    
            // } else {
            //     session()->flash('message', 'Invalid Login credential');
            // }
            //for hased end
            $user = DB::table('admin')->where('admin_id', $this->admin_id)->first();
         if ($user && $user->admin_pass == $this->admin_pass) {
            Auth::guard('admin')->loginUsingId($user->id);

             session()->flash('message', 'Login form submitted !!');
            return redirect('/generate-booking');
        } else {
            session()->flash('message', 'Invalid Login credential');
            //  return back()->withInput($request->only('email'))->with('message','Invalid Login credentials');
        }

        DB::commit();

    } catch (\Exception $e) {
        session()->flash('message', 'login form something went wrong!!'.$e->getMessage());
        DB::rollback();
        \Log::error('Error occurred while processing login form: ' . $e->getMessage());
        }
    }
    public function login()
    {
         dd($this);
         $this->validate([
            'selectedRow.base_rate' => 'numeric|required',
            'selectedRow.per_km_rate' => 'numeric|required',
            'selectedRow.per_ext_km_rate' => 'numeric|required',
        ], 
        [
        'selectedRow.base_rate.required' => 'Base rate is required',
        'selectedRow.base_rate.numeric' => 'Base rate must be numeric',
        'selectedRow.per_km_rate.required' => 'Per km rate is required',
        'selectedRow.baseper_km_rate_rate.numeric' => 'Per km rate must be numeric',
        'selectedRow.per_ext_km_rate.required' => 'Per km rate is required',
        'selectedRow.per_ext_km_rate.numeric' => 'Per km rate must be numeric'
        ]);
        
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

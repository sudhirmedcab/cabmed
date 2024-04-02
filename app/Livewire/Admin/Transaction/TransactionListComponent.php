<?php

namespace App\Livewire\Admin\Transaction;
use Illuminate\Support\Facades\DB; 
use Livewire\Component;
use Carbon\Carbon;
use App\models\consumer;
use App\Models\Notification;
// use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class TransactionListComponent extends Component
{
    public $selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate, $driver_id, $name, $email,
    $position, $employee_id, $consumer_status,$PaymentServiceFiter,$check_for,
    $ambulanceServiceFiter,$ambulanceService,$ServiceFiter,$driver_transection_id,$driver_acc_dtl_acc_no,$driver_acc_dtl_ifsc,$driver_acc_dtl_acc_holder,$driver_transection_amount,$cpt_mode_of_payment,$cpt_transfer_image,$cpt_time_transaction_id,$cpt_time_unix,

    $activeTab;
    
    public $isOpen = 0;
    use WithPagination;
    // use WithoutUrlPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    // 
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    #[Layout('livewire.admin.layouts.base')]    //......... add the layout dynamically for the all ...........//

            public function resetFilters(){
          
                $this->search='';
                $this->selectedDate=null;
                $this->ServiceFiter="ALL";
                $this->PaymentServiceFiter="ALL";
                $this->resetPage();

            }

            public function filterCondition($value){
                $this->resetFilters();
              
                if($value=='consumerTransaction'){            
                    $this->activeTab=$value;
                }
            
                if($value=='driverTransaction'){
                    $this->activeTab=$value;
                }
                if($value=='partnerTransaction'){
                    $this->activeTab=$value;
                }
                if($value=='labTransaction'){
                    $this->activeTab=$value;
                }
                if($value=='driverWithdrawTransaction'){
                    $this->activeTab=$value;
                }
                
          
        }

    public function render()
    {
        $PaymentServiceFiter = $this->PaymentServiceFiter ? $this->PaymentServiceFiter : "Success";
        $ServiceFiter = $this->ServiceFiter ? $this->ServiceFiter : "All";
        $fromDate = $this->selectedFromDate ? Carbon::createFromFormat('Y-m-d', $this->selectedFromDate)->startOfDay() : null;
        $toDate = $this->selectedToDate ? Carbon::createFromFormat('Y-m-d', $this->selectedToDate)->endOfDay() : null;
        
        if($this->selectedDate == 'custom'){
            $this->selectedFromDate;
            $this->selectedToDate;
        }else{
            $this->selectedFromDate ='';
            $this->selectedToDate =''; 
        }
     
        switch ($this->selectedDate) {
            case 'all':
                $fromDate = null;
                $toDate = null;
                break;
            case 'today':
                $fromDate = Carbon::today();
                $toDate = Carbon::today()->endOfDay();
                break;
            case 'yesterday':
                $fromDate = Carbon::yesterday();
                $toDate = Carbon::yesterday()->endOfDay();
                break;
            case 'thisWeek':
                $fromDate = Carbon::now()->subDays(7)->startOfDay();
                $toDate = Carbon::now();
                break;
            case 'thisMonth':
                $fromDate = Carbon::now()->startOfMonth();
                $toDate = Carbon::now()->endOfMonth();
                break;
            default:
                $fromDate = $fromDate;
                $toDate = $toDate;
                break;
        }

        if($this->activeTab =='consumerTransaction'){

            $consumerTransaction = DB::table('consumer_transection')
            ->leftJoin('consumer', 'consumer.consumer_id', '=', 'consumer_transection.consumer_transection_done_by')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('consumer_transection.created_at', [$fromDate, $toDate]);
            }) 
            ->where(function ($query) {
                $query->where('consumer.consumer_name', 'like', '%' . $this->search . '%')
                    ->orWhere('consumer.consumer_mobile_no', 'like', '%' . $this->search . '%');
            })
            ->when($PaymentServiceFiter == 'Success', function ($query) use ($PaymentServiceFiter) {
                return $query
                    ->where('consumer_transection.consumer_transection_status',0);
            })
            ->when($PaymentServiceFiter == 'Failed', function ($query) use ($PaymentServiceFiter) {
                return $query
                    ->where('consumer_transection.consumer_transection_status',1);
            })
            ->orderBy('consumer_transection.consumer_transection_id', 'desc')
            ->paginate(10);

            if($this->check_for == 'custom'){
                return view('livewire.admin.transaction.transaction-list-component',[
                    'isCustom' => true
                ],compact('consumerTransaction'));
            }
            return view('livewire.admin.transaction.transaction-list-component',[
                'isCustom' => false
            ],compact('consumerTransaction'));

        }
        if($this->activeTab =='partnerTransaction'){

            $partnerTransaction = DB::table('partner_transection')
            ->leftJoin('partner', 'partner.partner_id', '=', 'partner_transection.partner_transection_by')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('partner_transection.created_at', [$fromDate, $toDate]);
            }) 
            ->where(function ($query) {
                $query->where('partner.partner_f_name', 'like', '%' . $this->search . '%')
                    ->orWhere('partner.partner_l_name', 'like', '%' . $this->search . '%')
                    ->orWhere('partner.partner_mobile', 'like', '%' . $this->search . '%');
            })
            ->when($PaymentServiceFiter == 'Success', function ($query) use ($PaymentServiceFiter) {
                return $query
                    ->where('partner_transection.partner_transection_status',0);
            })
            ->when($PaymentServiceFiter == 'Failed', function ($query) use ($PaymentServiceFiter) {
                return $query
                    ->where('partner_transection.partner_transection_status',1);
            })
            ->when($ServiceFiter == 'BankTransfer', function ($query) use ($ServiceFiter) {
                return $query
                    ->where('partner_transection.partner_transection_type',2);
            })
            ->when($ServiceFiter == 'AddWallet', function ($query) use ($ServiceFiter) {
                return $query
                    ->where('partner_transection.partner_transection_type',1);
            })
            ->when($ServiceFiter == 'FetchAmount', function ($query) use ($ServiceFiter) {
                return $query
                    ->where('partner_transection.partner_transection_type',3);
            })
            ->orderBy('partner_transection.partner_transection_id', 'desc')
            ->paginate(10);

            if($this->check_for == 'custom'){
                return view('livewire.admin.transaction.transaction-list-component',[
                    'isCustom' => true
                ],compact('partnerTransaction'));
            }
            return view('livewire.admin.transaction.transaction-list-component',[
                'isCustom' => false
            ],compact('partnerTransaction'));

        }

        if($this->activeTab =='driverTransaction'){

            $driverTransaction = DB::table('driver_transection')
            ->leftJoin('driver', 'driver.driver_id', '=', 'driver_transection.driver_transection_by')
            ->leftJoin('partner', 'partner.partner_id', '=', 'driver_transection.driver_transection_by_type_pid')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('driver_transection.created_at', [$fromDate, $toDate]);
            }) 
            ->where(function ($query) {
                $query->where('driver.driver_name', 'like', '%' . $this->search . '%')
                    ->orWhere('driver.driver_last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('driver.driver_mobile', 'like', '%' . $this->search . '%');
            })
            ->when($PaymentServiceFiter == 'Success', function ($query) use ($PaymentServiceFiter) {
                return $query
                    ->where('driver_transection.driver_transection_status',0);
            })
            ->when($PaymentServiceFiter == 'Failed', function ($query) use ($PaymentServiceFiter) {
                return $query
                    ->where('driver_transection.driver_transection_status',1);
            })
            ->when($ServiceFiter == 'All', function ($query) use ($ServiceFiter) {
                return $query
                    ->whereIn('driver_transection.driver_transection_type',[0,1,2,3,4,5,6,7,8,9]);
            })
            ->when($ServiceFiter == 'OnlineBooking', function ($query) use ($ServiceFiter) {
                return $query
                    ->where('driver_transection.driver_transection_type',4);
            })
            ->when($ServiceFiter == 'CancelationCharge', function ($query) use ($ServiceFiter) {
                return $query
                    ->where('driver_transection.driver_transection_type',2);
            })
            ->when($ServiceFiter == 'CashCollet', function ($query) use ($ServiceFiter) {
                return $query
                    ->where('driver_transection.driver_transection_type',3);
            })
            ->when($ServiceFiter == 'TransferBank', function ($query) use ($ServiceFiter) {
                return $query
                    ->where('driver_transection.driver_transection_type',5);
            })
            ->when($ServiceFiter == 'FetchPartner', function ($query) use ($ServiceFiter) {
                return $query
                    ->where('driver_transection.driver_transection_type',6);
            })
            ->when($ServiceFiter == 'IncentiveCompany', function ($query) use ($ServiceFiter) {
                return $query
                    ->where('driver_transection.driver_transection_type',7);
            })
            ->when($ServiceFiter == 'WalletRecharge', function ($query) use ($ServiceFiter) {
                return $query
                    ->where('driver_transection.driver_transection_type',8);
            })
            ->when($ServiceFiter == 'WalletRechargeByPartner', function ($query) use ($ServiceFiter) {
                return $query
                    ->where('driver_transection.driver_transection_type',9);
            })
            ->when($ServiceFiter == 'AddWallet', function ($query) use ($ServiceFiter) {
                return $query
                    ->where('driver_transection.driver_transection_type',1);
            })
           
            ->orderBy('driver_transection.driver_transection_id', 'desc')
            ->paginate(10);

            if($this->check_for == 'custom'){
                return view('livewire.admin.transaction.transaction-list-component',[
                    'isCustom' => true
                ],compact('driverTransaction'));
            }
            return view('livewire.admin.transaction.transaction-list-component',[
                'isCustom' => false
            ],compact('driverTransaction'));

        }

        if($this->activeTab =='driverWithdrawTransaction'){

            $driverWithdrawTransaction =  DB::table('driver_transection')
            ->leftJoin('driver', 'driver.driver_id', '=', 'driver_transection.driver_transection_by')
            ->leftJoin('driver_withdraw_payment_history', 'driver_withdraw_payment_history.dwph_driver_transection_id', '=', 'driver_transection.driver_transection_id')
            ->leftJoin('partner', 'partner.partner_id', '=', 'driver_transection.driver_transection_by_type_pid')
            ->leftJoin('driver_acc_dtl', 'driver_acc_dtl.driver_acc_dtl_d_id', '=', 'driver.driver_id')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('driver_transection.created_at', [$fromDate, $toDate]);
            }) 
            ->where(function ($query) {
                $query->where('driver.driver_name', 'like', '%' . $this->search . '%')
                    ->orWhere('driver.driver_last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('driver.driver_mobile', 'like', '%' . $this->search . '%');
            })
            ->when($PaymentServiceFiter == 'Success', function ($query) use ($PaymentServiceFiter) {
                return $query
                    ->where('driver_transection.driver_transection_status',0);
            })
            ->when($PaymentServiceFiter == 'Failed', function ($query) use ($PaymentServiceFiter) {
                return $query
                    ->where('driver_transection.driver_transection_status',1);
            })
            ->where('driver_transection.driver_transection_type','=', '5')
            ->orderBy('driver_transection.driver_transection_id', 'desc')
            ->paginate(10);

            if($this->check_for == 'custom'){
                return view('livewire.admin.transaction.transaction-list2-component',[
                    'isCustom' => true
                ],compact('driverWithdrawTransaction'));
            }
            return view('livewire.admin.transaction.transaction-list2-component',[
                'isCustom' => false
            ],compact('driverWithdrawTransaction'));

        }


        $transitionList = DB::table('booking_payments')
        ->leftjoin('consumer', 'booking_payments.consumer_id', '=', 'consumer.consumer_id')
        ->leftjoin('booking_view', 'booking_payments.booking_id', '=', 'booking_view.booking_id')
        ->select('booking_payments.*', 'consumer.*','booking_view.booking_id','booking_view.booking_type','booking_view.booking_status')
        ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            return $query->whereBetween('booking_payments.created_at', [$fromDate, $toDate]);
        }) 
        ->where(function ($query) {
            $query->where('consumer.consumer_name', 'like', '%' . $this->search . '%')
                ->orWhere('consumer.consumer_mobile_no', 'like', '%' . $this->search . '%');
        })
        ->when($PaymentServiceFiter == 'Success', function ($query) use ($PaymentServiceFiter) {
            return $query
                ->where('booking_payments.booking_payments_trans_status',0);
        })
        ->when($PaymentServiceFiter == 'Incomplete', function ($query) use ($PaymentServiceFiter) {
            return $query
                ->where('booking_payments.booking_payments_trans_status',1);
        })
        ->when($PaymentServiceFiter == 'Refund', function ($query) use ($PaymentServiceFiter) {
            return $query
                ->where('booking_payments.booking_payments_trans_status',2);
        })
        ->orderBy('booking_payments.id','desc')
        ->paginate(10);

        if($this->check_for == 'custom'){
            return view('livewire.admin.transaction.transaction-list-component',[
                'isCustom' => true
            ],compact('transitionList'));
        }
        return view('livewire.admin.transaction.transaction-list-component',[
            'isCustom' => false
        ],compact('transitionList'));

    }

    public function openModal()
    {
        $this->isOpen = true;
    }
    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function payDriverWithdraw($transitionId){
       $driverTransaction =  DB::table('driver_transection')
        ->leftJoin('driver', 'driver.driver_id', '=', 'driver_transection.driver_transection_by')
        ->leftJoin('driver_withdraw_payment_history', 'driver_withdraw_payment_history.dwph_driver_transection_id', '=', 'driver_transection.driver_transection_id')
        ->leftJoin('partner', 'partner.partner_id', '=', 'driver_transection.driver_transection_by_type_pid')
        ->leftJoin('driver_acc_dtl', 'driver_acc_dtl.driver_acc_dtl_d_id', '=', 'driver.driver_id')
        ->where('driver_transection.driver_transection_id',$transitionId)
        ->first();

        $this->driver_transection_id = $driverTransaction->driver_transection_id;
        $this->driver_id = $driverTransaction->driver_id;
        $this->driver_acc_dtl_acc_no = $driverTransaction->driver_acc_dtl_acc_no;
        $this->driver_acc_dtl_ifsc = $driverTransaction->driver_acc_dtl_ifsc;
        $this->driver_acc_dtl_acc_holder= $driverTransaction->driver_acc_dtl_acc_holder;
        $this->driver_transection_amount = $driverTransaction->driver_transection_amount;

        $this->openModal();

    }

    public function storeDriverTransactionData(){

        $validatedData = $this->validate([
            'driver_acc_dtl_acc_no' => 'required',
            'driver_acc_dtl_ifsc' => 'required',
            'driver_acc_dtl_acc_holder' => 'required',
            'cpt_transfer_image' => 'required',
            'cpt_mode_of_payment' => 'required', 
            'driver_transection_amount' => 'required',
            'cpt_time_transaction_id' => 'required', 
            'cpt_time_unix' => 'required', 
        ], [
            'driver_acc_dtl_acc_no.required' => 'Please Add The Driver Account Number',
            'driver_acc_dtl_ifsc.required' => 'Please Add The Driver IFSC Code',
            'driver_acc_dtl_acc_holder.required' => 'Please Add The Bank Account Holder Name ', // Corrected message
            'cpt_transfer_image.required' => 'Please Add The Transafer Image Slip',
            'cpt_mode_of_payment.required' => 'Please Select The Payment Mode Of Payment',
            'driver_transection_amount.required' => 'Please Fill The Transaction Amount',
            'cpt_time_transaction_id.required' => 'Please SeleFillct The Payment Transaction id',
            'cpt_time_unix.required' => 'Please Choose Payment Date From Transaction',
        ]);

        try {
            DB::beginTransaction();
        
            $path = ''; // Initialize variable for storing the file path
            if ($this->cpt_transfer_image) {
                $filename = $this->cpt_transfer_image->getClientOriginalName();
                $filename = strtolower(str_replace(' ', '-', $filename));
                $path = $this->cpt_transfer_image->storeAs('company_transction_slip', $filename); // Corrected typo here
                $path = 'assets/' . $path; // Prepend 'assets/' to the path
            }

            $transactionDateTime = str_replace('T', ' ', $this->cpt_time_unix);
            $unixTimestamp = strtotime($transactionDateTime);     

            $data = [
                       'cpt_to_id'=>$this->driver_id,
                        'cpt_type'=>'2',
                        'cpt_amounts'=> $this->driver_transection_amount,
                        'cpt_transfer_image'=>$path ?? null,
                        'cpt_status'=>'0',
                        'cpt_time_unix' =>$unixTimestamp,
                        'cpt_time_transaction_id'=>$this->cpt_time_transaction_id,
                        'cpt_account_no'=>$this->driver_acc_dtl_acc_no,
                        'cpt_account_holder'=>$this->driver_acc_dtl_acc_holder ?? 'N/A',
                        'cpt_ifsc_code'=>$this->driver_acc_dtl_ifsc,
                        'cpt_mode_of_payment'=>$this->cpt_mode_of_payment,
                        'cpt_created_at'=> Carbon::now()->timestamp,
                        'cpt_updated_at'=> Carbon::now()->timestamp,
            ];

               $storeCompanyData = DB::table('company_pay_transaction')->insertGetId($data);

                $updateStatus = DB::table('driver_transection')
                ->where('driver_transection.driver_transection_id',$this->driver_transection_id)
                ->update([
                    'driver_transection_amount'=>$this->driver_transection_amount,
                    'driver_transection_pay_id'=>$this->cpt_time_transaction_id,
                    'driver_transection_status'=>'0',
                    'driver_transection_time_unix'=>$unixTimestamp
                ]);

                
                $driverDetails = DB::table('driver_transection')
                ->leftJoin('driver', 'driver.driver_id', '=', 'driver_transection.driver_transection_by')
                ->where('driver_transection.driver_transection_id',$this->driver_transection_id)
                ->first();

                 //...............................notification..................................
    
                 $driver_id = $driverDetails->driver_id;
                 $driver_name = $driverDetails->driver_name; 
                 $driver_last_name = $driverDetails->driver_last_name; 
                 $driver_fcm_token = $driverDetails->driver_fcm_token;
    
                 $i =0;
                 $title='Hey, '.$driver_name.", Your Withdraw Request Amount.$this->driver_transection_amount.is Paid Successfully";
                 $sound="default";
                 $image="https://madmin.cabmed.in/site_img/title_icon.png";
                 $key='5';
                 $key2=''.$driver_id; // splash screen
                 $body=  "Hey ,".$driver_name." Your Request payment Withdraw Amounts has been sucessfully Transfer, now you can Check Please Your Wallet."; 
                 $result = $this->multiple_notification_msg($driver_fcm_token,$title,$body,$sound,$image,$key,$key2);
                 
             //.................................notification..................................
    
                $inserWithdrawHistory = DB::table('driver_withdraw_payment_history')
                ->insert([
                    'dwph_driver_id'=>$driver_id,
                    'dwph_driver_pay_id'=>$this->cpt_time_transaction_id,
                    'dwph_amounts'=> $this->driver_transection_amount,
                    'dwph_note'=>'Withdraw Request Transaction Amount',
                    'dwph_payment_status'=>'0',
                    'dwph_added'=>Carbon::now()->timestamp,
                    'dwph_driver_transection_id'=>$this->driver_transection_id
                ]);

            DB::commit();
            
            session()->flash('activeMessage', 'Company Withdraw Request Paid successfully !!' . $storeCompanyData);

        } catch (\Exception $e) {
            session()->flash('inactiveMessage', 'Something went wrong with the Ambulance Category operation: ' . $e->getMessage());
            DB::rollback();
            \Log::error('Error occurred while processing ambulance category operation: ' . $e->getMessage());
        }
    }

    public function multiple_notification_msg($id = NULL,$title,$body,$sound,$image=NULL,$key,$key2)
    {
       $Notification = new Notification();
       $data="";
       $payload['data_object'] = json_encode($data );
       $push_type = 'individual';
       $Notification->setTitle($title);
       $Notification->setMessage($body);
       $Notification->setSound($sound);
       $Notification->setKey($key);
       $Notification->setKey2($key2);
       if (!empty($image)) {
           $Notification->setImage('');
       } else {
           $Notification->setImage('');
       }
       $Notification->setPayload($payload);
       $json = '';
       $response = '';
       $json = $Notification->getPush();
       $response = $Notification->send($id, $json);
   }


}

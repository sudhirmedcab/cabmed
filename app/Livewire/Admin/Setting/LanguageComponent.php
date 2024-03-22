<?php

namespace App\Livewire\Admin\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class LanguageComponent extends Component
{
    public $selectedDate,$filterConditionl, 
    $selectedFromDate,$selectedToDate, $fromDate=null, 
    $toDate=null,$fromdate, $todate,$check_for,$verificationStatus,
    $language_icons,$language_id,$language_symbol,$language_name,
    $language_name_en,$language_country_id,$language_status;
    
    public $isOpen = 0;
    use WithPagination;
    use WithFileUploads;
    // use WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    // 
    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    
        public function render()
        {    
            $verificationStatus = $this->verificationStatus ? $this->verificationStatus : "Active";
        
            $languageList = DB::table('languages')
                        ->where(function ($query) {
                            $query->where('language_name_en', 'like', '%' . $this->search . '%');
                        }) 
                        ->when($verificationStatus == 'All', function ($query) use ($verificationStatus){
                            return $query->whereIn('language_status',[0,1]);
                                })
                         ->when($verificationStatus == 'Active', function ($query) use ($verificationStatus){
                            return $query->where('language_status',0);
                                })
                       ->when($verificationStatus == 'Inctive', function ($query) use ($verificationStatus){
                           return $query->where('language_status',1);
                                 }) 
                        ->orderByDesc('language_id')
                        ->paginate(10);
    
            if($this->check_for == 'custom'){
                return view('livewire.admin.setting.language-component',['isCustom'=>true],compact('languageList'));
                }else {
                   return view('livewire.admin.setting.language-component',['isCustom'=>false],compact('languageList'));
               } 
        }

        private function resetInputFields(){
            $this->name = '';
            $this->employee_id = '';
            $this->position = '';
            $this->email = '';
    
        }
        public function openModal()
        {
            $this->isOpen = true;
        }
        public function closeModal()
        {
            $this->isOpen = false;
        }

        public function createLanguage()
        {
            $this->resetInputFields();
            $this->openModal();
        }

        public function saveLanguagedata(){

            $validatedData = $this->validate([
                'language_symbol' => 'required',
                'language_icons' => 'required|image|mimes:jpeg,png,jpg',
                'language_name' => 'required',
                'language_name_en' => 'required',
            ], [
                 'language_symbol.required' => 'Please Add The Language Symbol',
                 'language_name.required' => 'Please Add The Language Name ',
                 'language_icons.required' => 'Please Add The Language Icon',
                 'language_icons.mimes' => 'Type must be : jpeg, png, jpg.',
                 'language_name_en.required' => 'Please Add The Language Name'
             ]);  


             try {
                DB::beginTransaction();
            
                $path = ''; // Initialize variable for storing the file path
                if ($this->language_icons) {
                    $filename = $this->language_icons->getClientOriginalName();
                    $filename = strtolower(str_replace(' ', '-', $filename));
                    $path = $this->language_icons->storeAs('app_icon', $filename); // Corrected typo here
                    $path = 'assets/' . $path; // Prepend 'assets/' to the path
                }
            
                $data = [
                    'language_symbol' => $this->language_symbol,
                    'language_name' => $this->language_name,
                    'language_name_en' => $this->language_name_en,
                    'language_icons' => $path
                ];
            
                if ($this->language_id) {
                    
                    DB::table('languages')->where('language_id', $this->language_id)->update($data);
                    session()->flash('activeMessage', 'Language updated successfully !!' . $this->language_id);
                } else {
                    $data['language_country_id'] = 0; 
                    $data['language_status'] = 0; 
                
                    $insertGetId = DB::table('languages')->insertGetId($data);
                    session()->flash('activeMessage', 'Language successfully added !!'.$insertGetId);
                }
            
                DB::commit();
            } catch (\Exception $e) {
                session()->flash('inactiveMessage', 'Something went wrong with the Language Add operation: ' . $e->getMessage());
                DB::rollback();
                \Log::error('Error occurred while processing Language Add operation: ' . $e->getMessage());
            }

            $this->closeModal();
        }
}

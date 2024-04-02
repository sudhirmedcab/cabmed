<?php

namespace App\Livewire\Admin\Pathology;
use Illuminate\Support\Facades\DB; 
use Illuminate\Contracts\Encryption\DecryptException;
use Livewire\Component;
use Carbon\Carbon;

class LabTestDetailComponent extends Component
{
    public $testId;

    public function render()
    {

        $testId = $this->testId;

        try {

         $decrypttestId = decrypt($testId);

         } catch (DecryptException $e) {
             abort(403, 'Unauthorized action.');
        }

        $data = DB::select("SELECT 
        lab_test_id AS testId, 
        lt_test_name AS testName, 
        lt_include_test AS countOfTestInclude,  
        lt_lab_test_type AS labTestType, 
        lt_overview AS packageShortDescription, 
        lt_test_description AS packageLongDescription, 
        lt_precautions AS precaution, 
        lab_test_prices_id AS priceId, 
        lt_offer_price AS currentPrice, 
        lt_price AS actualPrice, 
        lt_offer_percentage AS discountPercentage, 
        lab_test_sample_type AS sampleType, 
        lt_result_duration AS resultDuration, 
        lt_gender_type AS gender, 
        lab_test_img AS image, 
        IF((SELECT COUNT(*) 
            FROM add_to_cart_lab 
            WHERE atcl_test_id = lab_test_id), 1, 0) AS addedToCart, 
        lab_test_p_o_i AS testType 
    FROM 
        lab_test 
    LEFT JOIN 
        lab_test_prices ON lab_test_id = ltp_test_id 
    LEFT JOIN 
        city ON lab_test_prices.ltp_city_id = city.city_id 
    WHERE 
        lab_test_id = :decrypttestId 
        AND lt_status = 0", ['decrypttestId' => $decrypttestId]);

        if(count($data) > 0){
            $testId = $data[0]->testId;
            $reviewList = DB::select("SELECT * FROM `lab_review` WHERE `lr_test_id` = '$testId'");

            // $testList = DB::select("SELECT lt_packages_sample AS testName, IFNULL(it_test_package_description,'') AS testDescription FROM lab_test_package_maps WHERE it_package_status ='0' AND lt_package_test_id=$testId");
            $testList = [];
            if (count($data) == 1 && $data[0]->testType && $data[0]->testType == "2") {
                $rawData = DB::select("SELECT * FROM lab_test_package_mapper WHERE ltpm_status='0' AND ltpm_package_id=$testId");
                // print_r($rawData);exit();
                if ($rawData && count($rawData) != 0) {
                    foreach ($rawData as $list) {
                        if ($list->ltpm_type == "test") {
                            $info = DB::select("SELECT * FROM lab_test WHERE lab_test_id = $list->ltpm_include_data_id");
                            // print_r($info);exit();
                            if ($info && count($info) == 1 && $info[0]->lab_test_p_o_i == 1) {
                                $individualTestinfo = DB::select("SELECT lab_test_data_name FROM lab_test_data WHERE lab_test_rt_status = '0' AND lab_test_id=" . $info[0]->lab_test_id);
                                if ($individualTestinfo && count($individualTestinfo) != 0) {
                                    $count = [];
                                    foreach ($individualTestinfo as $key) {
                                        array_push($count, $key->lab_test_data_name);
                                    }
                                    array_push($testList, (object)['testName' => $info[0]->lt_test_name . ' (' . $info[0]->lt_include_test . ')', 'testDescription' => implode(", ", $count),'datatestId' => $info[0]->lab_test_id ]);
                                } else {
                                    array_push($testList, (object)['testName' => $info[0]->lt_test_name, 'testDescription' => '']);
                                }
                            }
                        } else {
                            $infoIndividaual = DB::select("SELECT * FROM lab_test_data WHERE lab_test_rt_status = '0' AND lab_test_data_id=$list->ltpm_include_data_id");
                            // print_r($infoIndividaual);exit();
                            if ($infoIndividaual && count($infoIndividaual) == 1) {
                                array_push($testList, (object)['testName' => $infoIndividaual[0]->lab_test_data_name, 'testDescription' => '']);
                            }
                        }
                    }
                }
                // $testList = DB::select("SELECT lab_test_data_name AS testName, '' AS testDescription FROM lab_test_data WHERE lab_test_rt_status = '0' AND lab_test_id=$testId");
            } else {
                $testList = DB::select("SELECT lab_test_data_name AS testName, '' AS testDescription FROM lab_test_data WHERE lab_test_rt_status = '0' AND lab_test_id=$testId");
            }

            $bannerList = DB::select("SELECT banner_image AS image, banner_title AS bannerTitle FROM `banner_images` WHERE `flow` = 'Lab' AND `banner_status` = '0'");

            $metaData = DB::table('lab_test')->select('lt_test_sku', 'lt_meta_description', 'lt_meta_title', 'lt_meta_keyword')->where('lab_test_id', $decrypttestId)->first();
            // dd($metaData);
            $var['testDetails'] = !empty($data) ? $data[0] : [];
            $var['testList'] = !empty($testList) ? $testList : [];
            $var['reviewList'] = !empty($reviewList) ? $reviewList : [];
            // $var['cart_data'] = $this->getMiniCartData($userId, $cityName);
            $var['bannerList'] = !empty($bannerList) ? $bannerList : [];
            $var['metaData'] = !empty($metaData) ? $metaData : null;

            // dd($var);

            return view('livewire.admin.pathology.lab-test-detail-component',compact('var'));
        } else {
            $var = [];
            return view('livewire.admin.pathology.lab-test-detail-component',compact('var'));
        }

    }
}

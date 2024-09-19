<?php

namespace Fintech\Tab\Seeders\Bangladesh;

use Fintech\Business\Facades\Business;
use Fintech\Core\Facades\Core;
use Fintech\MetaData\Facades\MetaData;
use Illuminate\Database\Seeder;
use stdClass;

class ElectricityBillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Core::packageExists('Business')) {

            $parent = Business::serviceType()->findWhere(['service_type_slug' => 'electricity']);

            $distCountries = MetaData::country()->servingIds(['iso2' => 'BD']);

            $vendor = Business::serviceVendor()->findWhere(['service_vendor_slug' => 'sslwireless']);

            foreach ($this->data() as $entry) {
                Business::serviceTypeManager($entry, $parent)
                    ->hasService()
                    ->vendor($vendor)
                    ->distCountries($distCountries)
                    ->enabled()
                    ->execute();
            }

            $this->addServiceFields();
        }
    }

    private function data(): array
    {
        $image_svg = base_path('vendor/fintech/tab/resources/img/service_type/logo_svg/');
        $image_png = base_path('vendor/fintech/tab/resources/img/service_type/logo_png/');

        return [
            //DESCO Postpaid
            [
                'service_type_name' => 'DESCO Postpaid',
                'service_type_slug' => 'desco_postpaid',
                'logo_svg' => $image_svg.'desco_postpaid.svg',
                'logo_png' => $image_png.'desco_postpaid.png',
                'service_type_is_parent' => 'no',
                'service_type_is_description' => 'no',
                'service_type_step' => '3',
                'enabled' => true,
                'service_stat_data' => [
                    'utility_auth_key' => 'DE151746006894272',
                    'utility_secret_key' => 'DE151746006894272',
                ],
            ],
            //DESCO Prepaid
            [
                'service_type_name' => 'DESCO Prepaid',
                'service_type_slug' => 'desco_prepaid',
                'logo_svg' => $image_svg.'desco_postpaid.svg',
                'logo_png' => $image_png.'desco_postpaid.png',
                'service_type_is_parent' => 'no',
                'service_type_is_description' => 'no',
                'service_type_step' => '3',
                'enabled' => true,
                'service_stat_data' => [
                    'utility_auth_key' => 'DE16997872503141',
                    'utility_secret_key' => 'WLNLw965LSr3qvSB',
                ],
            ],
            //DPDC Postpaid
            [
                'service_type_name' => 'DPDC Postpaid',
                'service_type_slug' => 'dpdc_postpaid',
                'logo_svg' => $image_svg.'dpdc_postpaid.svg',
                'logo_png' => $image_png.'dpdc_postpaid.png',
                'service_type_is_parent' => 'no',
                'service_type_is_description' => 'no',
                'service_type_step' => '3',
                'enabled' => true,
                'service_stat_data' => [
                    'utility_auth_key' => 'DP16030264222969',
                    'utility_secret_key' => 'wQXJaE6c5ydoxG3H',
                ],
            ],
            //DPDC Postpaid
            [
                'service_type_name' => 'DPDC Prepaid',
                'service_type_slug' => 'dpdc_prepaid',
                'logo_svg' => $image_svg.'dpdc_postpaid.svg',
                'logo_png' => $image_png.'dpdc_postpaid.png',
                'service_type_is_parent' => 'no',
                'service_type_is_description' => 'no',
                'service_type_step' => '3',
                'enabled' => true,
                'service_stat_data' => [
                    'utility_auth_key' => 'DP16775741409889',
                    'utility_secret_key' => 'bonm0/jgKnBAErRh',
                ],
            ],
            //NESCO Postpaid
            [
                'service_type_name' => 'NESCO Postpaid',
                'service_type_slug' => 'nesco_postpaid',
                'logo_svg' => $image_svg.'nesco_postpaid.svg',
                'logo_png' => $image_png.'nesco_postpaid.png',
                'service_type_is_parent' => 'no',
                'service_type_is_description' => 'no',
                'service_type_step' => '3',
                'enabled' => false,
                'service_stat_data' => [
                    'utility_auth_key' => 'NE15864276923960',
                    'utility_secret_key' => 'I4NvO4kH88BdW9XE',
                ],
            ],
            //NESCO Prepaid
            [
                'service_type_name' => 'NESCO Prepaid',
                'service_type_slug' => 'nesco_prepaid',
                'logo_svg' => $image_svg.'nesco_postpaid.svg',
                'logo_png' => $image_png.'nesco_postpaid.png',
                'service_type_is_parent' => 'no',
                'service_type_is_description' => 'no',
                'service_type_step' => '3',
                'enabled' => false,
                'service_stat_data' => [
                    'utility_auth_key' => 'NE16151186585379',
                    'utility_secret_key' => 'PsilgetRO/wYIkPg',
                ],
            ],
            //NESCO Prepaid
            [
                'service_type_name' => 'West Zone Postpaid',
                'service_type_slug' => 'west_zone_postpaid',
                'logo_svg' => $image_svg.'west_zone_postpaid.svg',
                'logo_png' => $image_png.'west_zone_postpaid.png',
                'service_type_is_parent' => 'no',
                'service_type_is_description' => 'no',
                'service_type_step' => '3',
                'enabled' => false,
                'service_stat_data' => [
                    'utility_auth_key' => 'DE151746006894272',
                    'utility_secret_key' => 'DE151746006894272',
                ],
            ],
            //West Zone Prepaid
            [
                'service_type_name' => 'West Zone Prepaid',
                'service_type_slug' => 'west_zone_prepaid',
                'logo_svg' => $image_svg.'west_zone_postpaid.svg',
                'logo_png' => $image_png.'west_zone_postpaid.png',
                'service_type_is_parent' => 'no',
                'service_type_is_description' => 'no',
                'service_type_step' => '3',
                'enabled' => false,
                'service_stat_data' => [
                    'utility_auth_key' => '',
                    'utility_secret_key' => '',
                ],
            ],
            //BPDB Prepaid
            [
                'service_type_name' => 'BPDB Prepaid',
                'service_type_slug' => 'bpdb_prepaid',
                'logo_svg' => $image_svg.'bpdb.svg',
                'logo_png' => $image_png.'bpdb.png',
                'service_type_is_parent' => 'no',
                'service_type_is_description' => 'no',
                'service_type_step' => '3',
                'enabled' => true,
                'service_stat_data' => [
                    'utility_auth_key' => 'BP17048618656604',
                    'utility_secret_key' => 'Tv05Xd4NEFref4S7',
                ],
            ],
            //BREB Postpaid
            [
                'service_type_name' => 'BREB Postpaid',
                'service_type_slug' => 'breb_postpaid',
                'logo_svg' => $image_svg.'breb.svg',
                'logo_png' => $image_png.'breb.png',
                'service_type_is_parent' => 'no',
                'service_type_is_description' => 'no',
                'service_type_step' => '3',
                'enabled' => true,
                'service_stat_data' => [
                    'utility_auth_key' => 'BR16713629651374',
                    'utility_secret_key' => 'A2BonKfvRke8J46M',
                ],
            ],
            //BREB Prepaid
            [
                'service_type_name' => 'BREB Prepaid',
                'service_type_slug' => 'breb_prepaid',
                'logo_svg' => $image_svg.'breb.svg',
                'logo_png' => $image_png.'breb.png',
                'service_type_is_parent' => 'no',
                'service_type_is_description' => 'no',
                'service_type_step' => '3',
                'enabled' => true,
                'service_stat_data' => [
                    'utility_auth_key' => 'BR16304874421274',
                    'utility_secret_key' => 'GIxlvxXb6wGqwaG1',
                ],
            ],
        ];
    }

    private function addServiceFields(): void
    {
        $service_fields = [
            //DESCO POSTPAID
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'desco_postpaid'])->id,
                'name' => 'billno',
                'label' => 'Bill Number',
                'type' => 'text',
                'options' => [],
                'value' => '',
                'hint' => 'Enter Bill Number',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:1|max:50|string|numeric',
                'service_field_data' => new stdClass,
            ],
            //DESCO PREPAID
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'desco_prepaid'])->id,
                'name' => 'account_no',
                'label' => 'Account No',
                'type' => 'text',
                'options' => [],
                'value' => '',
                'hint' => 'Enter Account No',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:1|max:50|string|numeric',
                'service_field_data' => new stdClass,
            ],
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'desco_prepaid'])->id,
                'name' => 'mobile_no',
                'label' => 'Mobile No',
                'type' => 'text',
                'options' => [],
                'value' => '',
                'hint' => 'Enter Mobile No',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|string|min:11|max:13|regex:/^01[3-9]{1}\d+{8}$/i',
                'service_field_data' => new stdClass,
            ],
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'desco_prepaid'])->id,
                'name' => 'amount',
                'label' => 'Amount',
                'type' => 'text',
                'options' => [],
                'value' => '',
                'hint' => 'Enter Recharge Amount',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|numeric|min:1',
                'service_field_data' => new stdClass,
            ],
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'desco_prepaid'])->id,
                'name' => 'bill_type',
                'label' => 'Bill Type',
                'type' => 'hidden',
                'options' => [],
                'value' => '',
                'hint' => 'Enter Bill Type',
                'required' => false,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'nullable|string',
                'service_field_data' => new stdClass,
            ],
            //DPDC POSTPAID
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'dpdc_postpaid'])->id,
                'name' => 'account_no',
                'label' => 'Account No',
                'type' => 'text',
                'options' => [],
                'value' => '',
                'hint' => 'Enter DPDC Customer No',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:1|max:50|integer',
                'service_field_data' => new stdClass,
            ],
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'dpdc_postpaid'])->id,
                'name' => 'bill_years',
                'label' => 'Bill Year',
                'type' => 'select-year',
                'options' => [],
                'value' => '',
                'hint' => 'Enter Bill Year',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|size:4|integer',
                'service_field_data' => [
                    'min' => '2020',
                ],
            ],
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'dpdc_postpaid'])->id,
                'name' => 'bill_months',
                'label' => 'Bill Month',
                'type' => 'select',
                'options' => [
                    ['attribute' => '01', 'label' => 'January'],
                    ['attribute' => '02', 'label' => 'February'],
                    ['attribute' => '03', 'label' => 'March'],
                    ['attribute' => '04', 'label' => 'April'],
                    ['attribute' => '05', 'label' => 'May'],
                    ['attribute' => '06', 'label' => 'June'],
                    ['attribute' => '07', 'label' => 'July'],
                    ['attribute' => '08', 'label' => 'August'],
                    ['attribute' => '09', 'label' => 'September'],
                    ['attribute' => '10', 'label' => 'October'],
                    ['attribute' => '11', 'label' => 'November'],
                    ['attribute' => '12', 'label' => 'December'],
                ],
                'value' => '',
                'hint' => 'Enter Bill Month',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|size:2|string|in:01,02,03,04,05,06,07,08,09,10,11,12',
                'service_field_data' => new stdClass,
            ],
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'dpdc_postpaid'])->id,
                'name' => 'pay_channel',
                'label' => 'Pay Channel',
                'type' => 'select',
                'options' => [
                    ['attribute' => '1', 'label' => 'Bank Branch'],
                    ['attribute' => '2', 'label' => 'Mobile Banking(USSD)'],
                    ['attribute' => '3', 'label' => 'Agent Banking'],
                    ['attribute' => '4', 'label' => 'Internet banking'],
                    ['attribute' => '5', 'label' => 'Mobile Apps'],
                    ['attribute' => '6', 'label' => 'Payment Gateway'],
                    ['attribute' => '7', 'label' => 'Others'],
                ],
                'value' => '',
                'hint' => 'Select Pay Channel',
                'required' => false,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|size:1|string|in:1,2,3,4,5,6,7',
                'service_field_data' => new stdClass,
            ],
            //DPDC PREPAID
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'dpdc_prepaid'])->id,
                'name' => 'customer_no',
                'label' => 'Account No',
                'type' => 'text',
                'options' => [],
                'value' => '',
                'hint' => 'Enter DPDC Customer No',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:1|max:50|integer',
                'service_field_data' => new stdClass,
            ],
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'dpdc_prepaid'])->id,
                'name' => 'mobile_no',
                'label' => 'Mobile No',
                'type' => 'text',
                'options' => [],
                'value' => '',
                'hint' => 'Enter Mobile No',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|string|min:11|max:13|regex:/^01[3-9]{1}\d+{8}$/i',
                'service_field_data' => new stdClass,
            ],
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'dpdc_prepaid'])->id,
                'name' => 'amount',
                'label' => 'Amount',
                'type' => 'text',
                'options' => [],
                'value' => '',
                'hint' => 'Enter Recharge Amount',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|numeric|min:1',
                'service_field_data' => new stdClass,
            ],
            //NESCO POSTPAID
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'nesco_postpaid'])->id,
                'name' => 'bill_number',
                'label' => 'Bill Number',
                'type' => 'text',
                'options' => [],
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => new stdClass,
            ],
            //NESCO PREPAID
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'nesco_prepaid'])->id,
                'name' => 'account_number',
                'label' => 'Customer Number',
                'type' => 'text',
                'options' => [],
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => new stdClass,
            ],
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'nesco_prepaid'])->id,
                'name' => 'amount',
                'label' => 'Recharge Amount',
                'type' => 'text',
                'options' => [],
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|numeric|min:1',
                'service_field_data' => new stdClass,
            ],
            //WEST ZONE POSTPAID
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'west_zone_postpaid'])->id,
                'name' => 'account_number',
                'label' => 'Account Number',
                'type' => 'text',
                'options' => [],
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => new stdClass,
            ],
            //WEST ZONE PREPAID
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'west_zone_prepaid'])->id,
                'name' => 'account_number',
                'label' => 'Account Number',
                'type' => 'text',
                'options' => [],
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => new stdClass,
            ],
            //BPDB PREPAID
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'bpdb_prepaid'])->id,
                'name' => 'meter_no',
                'label' => 'Meter Number',
                'type' => 'text',
                'options' => [],
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|max:20|min:11|string',
                'service_field_data' => new stdClass,
            ],
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'bpdb_prepaid'])->id,
                'name' => 'mobile_no',
                'label' => 'Mobile Number',
                'type' => 'text',
                'options' => [],
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|max:20|min:11|string',
                'service_field_data' => new stdClass,
            ],
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'bpdb_prepaid'])->id,
                'name' => 'amount',
                'label' => 'Amount',
                'type' => 'number',
                'options' => [],
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required',
                'service_field_data' => [
                    'min' => '2023',
                ],
            ],
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'bpdb_prepaid'])->id,
                'name' => 'bill_type',
                'label' => 'Bill Type',
                'type' => 'select',
                'options' => [
                    ['attribute' => 'PREPAID', 'label' => 'Prepaid'],
                    //                  ['attribute' => 'POSTPAID', 'label' => 'Postpaid'],
                ],
                'value' => 'PREPAID',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:1|max:20',
                'service_field_data' => new stdClass,
            ],
            //BREB POSTPAID
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'breb_postpaid'])->id,
                'name' => 'bill_type',
                'label' => 'Bill Type',
                'type' => 'text',
                'options' => [],
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:4|max:8',
                'service_field_data' => new stdClass,
            ],
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'breb_postpaid'])->id,
                'name' => 'account_no',
                'label' => 'Account No',
                'type' => 'text',
                'options' => [],
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:4|max:20',
                'service_field_data' => new stdClass,
            ],
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'breb_postpaid'])->id,
                'name' => 'type_of_bill',
                'label' => 'BREB Bill Type',
                'type' => 'select',
                'options' => [
                    ['attribute' => '50', 'label' => 'Electricity Bill'],
                    ['attribute' => '10', 'label' => 'Official Receipt'],
                    ['attribute' => '19', 'label' => 'Application Fee'],
                    ['attribute' => '20', 'label' => 'Demand Note/Consumer Deposit'],
                    ['attribute' => '30', 'label' => 'Advance Electricity Bill'],
                ],
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|size:2|string',
                'service_field_data' => new stdClass,
            ],
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'breb_postpaid'])->id,
                'name' => 'branchRoutingNo',
                'label' => 'Branch Routing No',
                'type' => 'hidden',
                'options' => [],
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => new stdClass,
            ],

            //BREB PREPAID
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'breb_prepaid'])->id,
                'name' => 'meter_no',
                'label' => 'Meter Number',
                'type' => 'text',
                'options' => [],
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|max:50|min:1|string',
                'service_field_data' => new stdClass,
            ],
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'breb_prepaid'])->id,
                'name' => 'mobile_no',
                'label' => 'Mobile Number',
                'type' => 'text',
                'options' => [],
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|max:15|min:10|string',
                'service_field_data' => new stdClass,
            ],
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'breb_prepaid'])->id,
                'name' => 'amount',
                'label' => 'Amount',
                'type' => 'number',
                'options' => [],
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required',
                'service_field_data' => [
                    'min' => '2023',
                ],
            ],
            [
                'service_id' => Business::service()->findWhere(['service_slug' => 'breb_prepaid'])->id,
                'name' => 'bill_type',
                'label' => 'Bill Type',
                'type' => 'select',
                'options' => [
                    ['attribute' => 'PREPAID', 'label' => 'Prepaid'],
                    //                  ['attribute' => 'POSTPAID', 'label' => 'Postpaid'],
                ],
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:1|max:20',
                'service_field_data' => new stdClass,
            ],
        ];

        foreach ($service_fields as $service_field) {
            Business::serviceField()->create($service_field);
        }
    }
}

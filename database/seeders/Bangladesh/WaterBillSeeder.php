<?php

namespace Fintech\Tab\Seeders\Bangladesh;

use Fintech\Auth\Facades\Auth;
use Fintech\Business\Facades\Business;
use Fintech\Core\Facades\Core;
use Fintech\MetaData\Facades\MetaData;
use Illuminate\Database\Seeder;
use stdClass;

class WaterBillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Core::packageExists('Business')) {

            foreach ($this->serviceTypes() as $entry) {
                $serviceTypeChildren = $entry['serviceTypeChildren'] ?? [];

                if (isset($entry['serviceTypeChildren'])) {
                    unset($entry['serviceTypeChildren']);
                }

                $findServiceTypeModel = Business::serviceType()->list(['service_type_slug' => $entry['service_type_slug']])->first();
                if ($findServiceTypeModel) {
                    $serviceTypeModel = Business::serviceType()->update($findServiceTypeModel->id, $entry);
                } else {
                    $serviceTypeModel = Business::serviceType()->create($entry);
                }

                if (! empty($serviceTypeChildren)) {
                    array_walk($serviceTypeChildren, function ($item) use (&$serviceTypeModel) {
                        $item['service_type_parent_id'] = $serviceTypeModel->id;
                        Business::serviceType()->create($item);
                    });
                }
            }

            $serviceData = $this->service();

            foreach (array_chunk($serviceData, 200) as $block) {
                set_time_limit(2100);
                foreach ($block as $entry) {
                    Business::service()->create($entry);
                }
            }

            $serviceStatData = $this->serviceStat();
            foreach (array_chunk($serviceStatData, 200) as $block) {
                set_time_limit(2100);
                foreach ($block as $entry) {
                    Business::serviceStat()->customStore($entry);
                }
            }
        }

        $data = $this->serviceField();

        foreach (array_chunk($data, 200) as $block) {
            set_time_limit(2100);
            foreach ($block as $entry) {
                Business::serviceField()->create($entry);
            }
        }
    }

    private function serviceTypes(): array
    {
        $image_svg = __DIR__.'/../../../resources/img/service_type/logo_svg/';
        $image_png = __DIR__.'/../../../resources/img/service_type/logo_png/';

        return [
            ['service_type_parent_id' => Business::serviceType()->list(['service_type_slug' => 'water'])->first()->id, 'service_type_name' => 'Dhaka WASA', 'service_type_slug' => 'dhaka_wasa', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'dhaka_wasa.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'dhaka_wasa.png')), 'service_type_is_parent' => 'no', 'service_type_is_description' => 'no', 'service_type_step' => '3', 'enabled' => true],
            ['service_type_parent_id' => Business::serviceType()->list(['service_type_slug' => 'water'])->first()->id, 'service_type_name' => 'Khulna WASA', 'service_type_slug' => 'khulna_wasa', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'khulna_wasa.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'khulna_wasa.png')), 'service_type_is_parent' => 'no', 'service_type_is_description' => 'no', 'service_type_step' => '3', 'enabled' => true],
            ['service_type_parent_id' => Business::serviceType()->list(['service_type_slug' => 'water'])->first()->id, 'service_type_name' => 'Chattogram WASA', 'service_type_slug' => 'chattogram_wasa', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'chattogram_wasa.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'chattogram_wasa.png')), 'service_type_is_parent' => 'no', 'service_type_is_description' => 'no', 'service_type_step' => '3', 'enabled' => true],
        ];
    }

    private function service(): array
    {
        $image_svg = __DIR__.'/../../../resources/img/service/logo_svg/';
        $image_png = __DIR__.'/../../../resources/img/service/logo_png/';

        $vendor_id = config('fintech.business.default_vendor', 1);

        return [
            ['utility_auth_key' => 'DE151746006894272', 'utility_secret_key' => 'DE151746006894272', 'service_type_id' => Business::serviceType()->list(['service_type_slug' => 'desco_postpaid'])->first()->id, 'service_vendor_id' => $vendor_id, 'service_name' => 'DESCO Postpaid', 'service_slug' => 'desco_postpaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'desco_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'desco_postpaid.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 1, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],
            ['utility_auth_key' => 'DE16997872503141', 'utility_secret_key' => 'WLNLw965LSr3qvSB', 'service_type_id' => Business::serviceType()->list(['service_type_slug' => 'desco_prepaid'])->first()->id, 'service_vendor_id' => $vendor_id, 'service_name' => 'DESCO Prepaid', 'service_slug' => 'desco_prepaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'desco_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'desco_postpaid.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 2, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],

            ['utility_auth_key' => 'DP16030264222969', 'utility_secret_key' => 'wQXJaE6c5ydoxG3H', 'service_type_id' => Business::serviceType()->list(['service_type_slug' => 'dpdc_postpaid'])->first()->id, 'service_vendor_id' => $vendor_id, 'service_name' => 'DPDC Postpaid', 'service_slug' => 'dpdc_postpaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'dpdc_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'dpdc_postpaid.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 3, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],
            ['utility_auth_key' => 'DP16775741409889', 'utility_secret_key' => 'bonm0/jgKnBAErRh', 'service_type_id' => Business::serviceType()->list(['service_type_slug' => 'dpdc_prepaid'])->first()->id, 'service_vendor_id' => $vendor_id, 'service_name' => 'DPDC Prepaid', 'service_slug' => 'dpdc_prepaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'desco_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'desco_postpaid.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 4, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],

            ['utility_auth_key' => 'NE15864276923960', 'utility_secret_key' => 'I4NvO4kH88BdW9XE', 'service_type_id' => Business::serviceType()->list(['service_type_slug' => 'nesco_postpaid'])->first()->id, 'service_vendor_id' => $vendor_id, 'service_name' => 'NESCO Postpaid', 'service_slug' => 'nesco_postpaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'nesco_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'nesco_postpaid.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => 'GP ST'], 'enabled' => true],
            ['utility_auth_key' => 'NE16151186585379', 'utility_secret_key' => 'PsilgetRO/wYIkPg', 'service_type_id' => Business::serviceType()->list(['service_type_slug' => 'nesco_prepaid'])->first()->id, 'service_vendor_id' => $vendor_id, 'service_name' => 'NESCO Prepaid', 'service_slug' => 'nesco_prepaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'nesco_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'nesco_postpaid.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],

            ['utility_auth_key' => '', 'utility_secret_key' => '', 'service_type_id' => Business::serviceType()->list(['service_type_slug' => 'west_zone_postpaid'])->first()->id, 'service_vendor_id' => $vendor_id, 'service_name' => 'West Zone Postpaid', 'service_slug' => 'west_zone_postpaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'west_zone_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'west_zone_postpaid.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => 'GP ST'], 'enabled' => true],
            ['utility_auth_key' => '', 'utility_secret_key' => '', 'service_type_id' => Business::serviceType()->list(['service_type_slug' => 'west_zone_prepaid'])->first()->id, 'service_vendor_id' => $vendor_id, 'service_name' => 'West Zone Prepaid', 'service_slug' => 'west_zone_prepaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'west_zone_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'west_zone_postpaid.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],

            ['utility_auth_key' => 'BP17048618656604', 'utility_secret_key' => 'Tv05Xd4NEFref4S7', 'service_type_id' => Business::serviceType()->list(['service_type_slug' => 'bpdb_prepaid'])->first()->id, 'service_vendor_id' => $vendor_id, 'service_name' => 'BPDB Prepaid', 'service_slug' => 'bpdb_prepaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'bpdb.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'bpdb.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],

            ['utility_auth_key' => 'BR16713629651374', 'utility_secret_key' => 'A2BonKfvRke8J46M', 'service_type_id' => Business::serviceType()->list(['service_type_slug' => 'breb_postpaid'])->first()->id, 'service_vendor_id' => $vendor_id, 'service_name' => 'BREB Postpaid', 'service_slug' => 'breb_postpaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'breb.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'breb.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],
            ['utility_auth_key' => 'BR16304874421274', 'utility_secret_key' => 'GIxlvxXb6wGqwaG1', 'service_type_id' => Business::serviceType()->list(['service_type_slug' => 'breb_prepaid'])->first()->id, 'service_vendor_id' => $vendor_id, 'service_name' => 'BREB Prepaid', 'service_slug' => 'breb_prepaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'breb.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'breb.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],

            ['utility_auth_key' => '', 'utility_secret_key' => '', 'service_type_id' => Business::serviceType()->list(['service_type_slug' => 'dhaka_wasa'])->first()->id, 'service_vendor_id' => $vendor_id, 'service_name' => 'Dhaka WASA', 'service_slug' => 'dhaka_wasa', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'dhaka_wasa.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'dhaka_wasa.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],

            ['utility_auth_key' => '', 'utility_secret_key' => '', 'service_type_id' => Business::serviceType()->list(['service_type_slug' => 'khulna_wasa'])->first()->id, 'service_vendor_id' => $vendor_id, 'service_name' => 'Khulna WASA', 'service_slug' => 'khulna_wasa', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'khulna_wasa.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'khulna_wasa.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],

            ['utility_auth_key' => '', 'utility_secret_key' => '', 'service_type_id' => Business::serviceType()->list(['service_type_slug' => 'chattogram_wasa'])->first()->id, 'service_vendor_id' => $vendor_id, 'service_name' => 'Chattogram WASA', 'service_slug' => 'chattogram_wasa', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'chattogram_wasa.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'chattogram_wasa.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],

            ['utility_auth_key' => 'JA17001081834302', 'utility_secret_key' => 'Q6aoOjmlUsRoQOHM', 'service_type_id' => Business::serviceType()->list(['service_type_slug' => 'jalalabad_gas'])->first()->id, 'service_vendor_id' => $vendor_id, 'service_name' => 'Jalalabad Gas', 'service_slug' => 'jalalabad_gas', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'jalalabad_gas.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'jalalabad_gas.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],

            ['utility_auth_key' => '', 'utility_secret_key' => '', 'service_type_id' => Business::serviceType()->list(['service_type_slug' => 'titas_gas'])->first()->id, 'service_vendor_id' => $vendor_id, 'service_name' => 'Titas Gas', 'service_slug' => 'titas_gas', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'titas_gas.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'titas_gas.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],

            ['utility_auth_key' => '', 'utility_secret_key' => '', 'service_type_id' => Business::serviceType()->list(['service_type_slug' => 'titas_gas_metered'])->first()->id, 'service_vendor_id' => $vendor_id, 'service_name' => 'Titas Gas Metered', 'service_slug' => 'titas_gas_metered', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'titas_gas.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'titas_gas.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],

            ['utility_auth_key' => '', 'utility_secret_key' => '', 'service_type_id' => Business::serviceType()->list(['service_type_slug' => 'bakhrabad_gas'])->first()->id, 'service_vendor_id' => $vendor_id, 'service_name' => 'Bakhrabad Gas', 'service_slug' => 'bakhrabad_gas', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'bakhrabad_gas.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'bakhrabad_gas.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],

            ['utility_auth_key' => '', 'utility_secret_key' => '', 'service_type_id' => Business::serviceType()->list(['service_type_slug' => 'paschimanchal_gas'])->first()->id, 'service_vendor_id' => $vendor_id, 'service_name' => 'Paschimanchal Gas', 'service_slug' => 'paschimanchal_gas', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'paschimanchal_gas.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'paschimanchal_gas.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],

            ['utility_auth_key' => 'KG15432366535191', 'utility_secret_key' => '5us6cXd9LJinse0J', 'service_type_id' => Business::serviceType()->list(['service_type_slug' => 'karnaphuli_gas_metered'])->first()->id, 'service_vendor_id' => $vendor_id, 'service_name' => 'Karnaphuli Gas Metered', 'service_slug' => 'karnaphuli_gas_metered', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'karnaphuli_gas.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'karnaphuli_gas.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],
            ['utility_auth_key' => 'KG15432366689162', 'utility_secret_key' => 'CUog7mD/SHWSgvf7', 'service_type_id' => Business::serviceType()->list(['service_type_slug' => 'karnaphuli_gas_non_metered'])->first()->id, 'service_vendor_id' => $vendor_id, 'service_name' => 'Karnaphuli Gas Non-Metered', 'service_slug' => 'karnaphuli_gas_non_metered', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'karnaphuli_gas.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'karnaphuli_gas.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],
        ];

    }

    private function serviceStat(): array
    {
        $serviceLists = $this->service();
        $serviceStats = [];
        $roles = Auth::role()->list(['id_not_in' => [1]])->pluck('id')->toArray();
        $source_countries = MetaData::country()->servingIds();;
        foreach ($serviceLists as $serviceList) {
            $service = Business::service()->list(['service_slug' => $serviceList['service_slug']])->first();
            $serviceStats[] = [
                'role_id' => $roles,
                'service_id' => $service->getKey(),
                'service_slug' => $service->service_slug,
                'source_country_id' => $source_countries,
                'destination_country_id' => [19],
                'service_vendor_id' => config('fintech.business.default_vendor', 1),
                'service_stat_data' => [
                    [
                        'lower_limit' => '10.00',
                        'higher_limit' => '5000.00',
                        'local_currency_higher_limit' => '25000.00',
                        'charge' => mt_rand(1, 7).'%',
                        'discount' => mt_rand(1, 7).'%',
                        'commission' => '0',
                        'cost' => '0.00',
                        'charge_refund' => 'yes',
                        'discount_refund' => 'yes',
                        'commission_refund' => 'yes',
                    ],
                ],
                'enabled' => true,
            ];
        }

        return $serviceStats;

    }

    /**
     * @return array[]
     */
    private function serviceField(): array
    {
        return [
            //DESCO POSTPAID
            [
                'service_id' => Business::service()->list(['service_slug' => 'desco_postpaid'])->first()->id,
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
            //DESCO PREPAID
            [
                'service_id' => Business::service()->list(['service_slug' => 'desco_prepaid'])->first()->id,
                'name' => 'ac_number',
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
            [
                'service_id' => Business::service()->list(['service_slug' => 'desco_prepaid'])->first()->id,
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
            [
                'service_id' => Business::service()->list(['service_slug' => 'desco_prepaid'])->first()->id,
                'name' => 'mobile_number',
                'label' => 'Mobile Number',
                'type' => 'text',
                'options' => [],
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|string|min:11|max:15',
                'service_field_data' => new stdClass,
            ],
            //DPDC POST PAID
            [
                'service_id' => Business::service()->list(['service_slug' => 'dpdc_postpaid'])->first()->id,
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
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|size:2|string|in:01,02,03,04,05,06,07,08,09,10,11,12',
                'service_field_data' => new stdClass,
            ],
            [
                'service_id' => Business::service()->list(['service_slug' => 'dpdc_postpaid'])->first()->id,
                'name' => 'bill_years',
                'label' => 'Bill Year',
                'type' => 'select-year',
                'options' => [],
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|size:4|string',
                'service_field_data' => [
                    'min' => '2020',
                ],
            ],
            [
                'service_id' => Business::service()->list(['service_slug' => 'dpdc_postpaid'])->first()->id,
                'name' => 'ac_number',
                'label' => 'Account code',
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
            //DPDC PRE PAID
            [
                'service_id' => Business::service()->list(['service_slug' => 'dpdc_prepaid'])->first()->id,
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
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|size:2|string|in:01,02,03,04,05,06,07,08,09,10,11,12',
                'service_field_data' => new stdClass,
            ],
            [
                'service_id' => Business::service()->list(['service_slug' => 'dpdc_prepaid'])->first()->id,
                'name' => 'bill_years',
                'label' => 'Bill Year',
                'type' => 'select-year',
                'options' => [],
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [
                    'min' => '2020',
                ],
            ],
            [
                'service_id' => Business::service()->list(['service_slug' => 'dpdc_prepaid'])->first()->id,
                'name' => 'account_number',
                'label' => 'Account code',
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
            //NESCO POSTPAID
            [
                'service_id' => Business::service()->list(['service_slug' => 'nesco_postpaid'])->first()->id,
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
                'service_id' => Business::service()->list(['service_slug' => 'nesco_prepaid'])->first()->id,
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
                'service_id' => Business::service()->list(['service_slug' => 'nesco_prepaid'])->first()->id,
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
                'service_id' => Business::service()->list(['service_slug' => 'west_zone_postpaid'])->first()->id,
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
                'service_id' => Business::service()->list(['service_slug' => 'west_zone_prepaid'])->first()->id,
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
                'service_id' => Business::service()->list(['service_slug' => 'bpdb_prepaid'])->first()->id,
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
                'service_id' => Business::service()->list(['service_slug' => 'bpdb_prepaid'])->first()->id,
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
                'service_id' => Business::service()->list(['service_slug' => 'bpdb_prepaid'])->first()->id,
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
                'service_id' => Business::service()->list(['service_slug' => 'bpdb_prepaid'])->first()->id,
                'name' => 'bill_type',
                'label' => 'Bill Type',
                'type' => 'hidden',
                'options' => [],
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
                'service_id' => Business::service()->list(['service_slug' => 'breb_postpaid'])->first()->id,
                'name' => 'type_of_bill',
                'label' => 'Bill Type',
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
                'service_id' => Business::service()->list(['service_slug' => 'breb_postpaid'])->first()->id,
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
            [
                'service_id' => Business::service()->list(['service_slug' => 'breb_postpaid'])->first()->id,
                'name' => 'account_no',
                'label' => 'Account code',
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
            //BREB PREPAID
            [
                'service_id' => Business::service()->list(['service_slug' => 'breb_prepaid'])->first()->id,
                'name' => 'meter_no',
                'label' => 'Meter Number',
                'type' => 'select',
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
                'service_id' => Business::service()->list(['service_slug' => 'breb_prepaid'])->first()->id,
                'name' => 'mobile_no',
                'label' => 'Mobile Number',
                'type' => 'select',
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
                'service_id' => Business::service()->list(['service_slug' => 'breb_prepaid'])->first()->id,
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
                'service_id' => Business::service()->list(['service_slug' => 'breb_prepaid'])->first()->id,
                'name' => 'bill_type',
                'label' => 'Bill Type',
                'type' => 'hidden',
                'options' => [],
                'value' => 'PREPAID',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:1|max:20',
                'service_field_data' => new stdClass,
            ],
            //DHAKA WASA
            [
                'service_id' => Business::service()->list(['service_slug' => 'dhaka_wasa'])->first()->id,
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
            //KHULNA WASA
            [
                'service_id' => Business::service()->list(['service_slug' => 'khulna_wasa'])->first()->id,
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
            [
                'service_id' => Business::service()->list(['service_slug' => 'khulna_wasa'])->first()->id,
                'name' => 'bll_typ',
                'label' => 'Bill Type',
                'type' => 'select',
                'options' => [
                    ['attribute' => 'NM', 'label' => 'Non-Meter'],
                    ['attribute' => 'M', 'label' => 'Meter'],
                ],
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:1|string|max:2',
                'service_field_data' => new stdClass,
            ],
            //CHATTOGRAM WASA
            [
                'service_id' => Business::service()->list(['service_slug' => 'chattogram_wasa'])->first()->id,
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
            //JALALABAD GAS
            [
                'service_id' => Business::service()->list(['service_slug' => 'jalalabad_gas'])->first()->id,
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
            [
                'service_id' => Business::service()->list(['service_slug' => 'jalalabad_gas'])->first()->id,
                'name' => 'mobile_number',
                'label' => 'Mobile Number',
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
            //TITAS GAS
            [
                'service_id' => Business::service()->list(['service_slug' => 'titas_gas'])->first()->id,
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
            [
                'service_id' => Business::service()->list(['service_slug' => 'titas_gas_metered'])->first()->id,
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
            //BAKHRABAD GAS
            [
                'service_id' => Business::service()->list(['service_slug' => 'bakhrabad_gas'])->first()->id,
                'name' => 'account_number',
                'label' => 'Customer ONLINE code',
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
                'service_id' => Business::service()->list(['service_slug' => 'bakhrabad_gas'])->first()->id,
                'name' => 'mobile_number',
                'label' => 'ONLINE REGISTERED Mobile Number',
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
                'service_id' => Business::service()->list(['service_slug' => 'bakhrabad_gas'])->first()->id,
                'name' => 'bll_typ',
                'label' => 'Biller\'s Type',
                'type' => 'select',
                'options' => [
                    ['attribute' => 'NM', 'label' => 'Non-Meter'],
                    ['attribute' => 'M', 'label' => 'Meter'],
                ],
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:1|string|max:2',
                'service_field_data' => new stdClass,
            ],
            //PASCHIMANCHAL GAS
            [
                'service_id' => Business::service()->list(['service_slug' => 'paschimanchal_gas'])->first()->id,
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
            [
                'service_id' => Business::service()->list(['service_slug' => 'paschimanchal_gas'])->first()->id,
                'name' => 'mobile_number',
                'label' => 'Mobile Number',
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
        ];
    }

    private function data()
    {
        return [];
    }
}

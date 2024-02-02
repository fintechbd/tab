<?php

namespace Fintech\Tab\Seeders;

use Fintech\Business\Facades\Business;
use Fintech\Core\Facades\Core;
use Illuminate\Database\Seeder;

class PayBillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Core::packageExists('Business')) {

            foreach ($this->serviceType() as $entry) {
                $serviceTypeChild = $entry['serviceTypeChild'] ?? [];

                if (isset($entry['serviceTypeChild'])) {
                    unset($entry['serviceTypeChild']);
                }

                $findServiceTypeModel = \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => $entry['service_type_slug']])->first();
                if ($findServiceTypeModel) {
                    $serviceTypeModel = \Fintech\Business\Facades\Business::serviceType()->update($findServiceTypeModel->id, $entry);
                } else {
                    $serviceTypeModel = \Fintech\Business\Facades\Business::serviceType()->create($entry);
                }

                if (! empty($serviceTypeChild)) {
                    array_walk($serviceTypeChild, function ($item) use (&$serviceTypeModel) {
                        $item['service_type_parent_id'] = $serviceTypeModel->id;
                        \Fintech\Business\Facades\Business::serviceType()->create($item);
                    });
                }
            }

            $serviceData = $this->service();

            foreach (array_chunk($serviceData, 200) as $block) {
                set_time_limit(2100);
                foreach ($block as $entry) {
                    \Fintech\Business\Facades\Business::service()->create($entry);
                }
            }

            $serviceStatData = $this->serviceStat();
            foreach (array_chunk($serviceStatData, 200) as $block) {
                set_time_limit(2100);
                foreach ($block as $entry) {
                    \Fintech\Business\Facades\Business::serviceStat()->customStore($entry);
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

    private function data()
    {
        return [];
    }

    private function serviceType(): array
    {
        $image_svg = __DIR__.'/../../resources/img/service_type/logo_svg/';
        $image_png = __DIR__.'/../../resources/img/service_type/logo_png/';

        return [
            ['service_type_parent_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'electricity'])->first()->id, 'service_type_name' => 'DESCO Postpaid', 'service_type_slug' => 'desco_postpaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'desco_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'desco_postpaid.png')), 'service_type_is_parent' => 'no', 'service_type_is_description' => 'no', 'service_type_step' => '3', 'enabled' => true],
            ['service_type_parent_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'electricity'])->first()->id, 'service_type_name' => 'DESCO Prepaid', 'service_type_slug' => 'desco_prepaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'desco_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'desco_postpaid.png')), 'service_type_is_parent' => 'no', 'service_type_is_description' => 'no', 'service_type_step' => '3', 'enabled' => true],
            ['service_type_parent_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'electricity'])->first()->id, 'service_type_name' => 'DPDC Postpaid', 'service_type_slug' => 'dpdc_postpaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'dpdc_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'dpdc_postpaid.png')), 'service_type_is_parent' => 'no', 'service_type_is_description' => 'no', 'service_type_step' => '3', 'enabled' => true],
            ['service_type_parent_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'electricity'])->first()->id, 'service_type_name' => 'DPDC Prepaid', 'service_type_slug' => 'dpdc_prepaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'dpdc_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'dpdc_postpaid.png')), 'service_type_is_parent' => 'no', 'service_type_is_description' => 'no', 'service_type_step' => '3', 'enabled' => true],
            ['service_type_parent_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'electricity'])->first()->id, 'service_type_name' => 'NESCO Postpaid', 'service_type_slug' => 'nesco_postpaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'nesco_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'nesco_postpaid.png')), 'service_type_is_parent' => 'no', 'service_type_is_description' => 'no', 'service_type_step' => '3', 'enabled' => true],
            ['service_type_parent_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'electricity'])->first()->id, 'service_type_name' => 'NESCO Prepaid', 'service_type_slug' => 'nesco_prepaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'nesco_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'nesco_postpaid.png')), 'service_type_is_parent' => 'no', 'service_type_is_description' => 'no', 'service_type_step' => '3', 'enabled' => true],
            ['service_type_parent_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'electricity'])->first()->id, 'service_type_name' => 'West Zone Postpaid', 'service_type_slug' => 'west_zone_postpaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'west_zone_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'west_zone_postpaid.png')), 'service_type_is_parent' => 'no', 'service_type_is_description' => 'no', 'service_type_step' => '3', 'enabled' => true],
            ['service_type_parent_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'electricity'])->first()->id, 'service_type_name' => 'West Zone Prepaid', 'service_type_slug' => 'west_zone_prepaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'west_zone_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'west_zone_postpaid.png')), 'service_type_is_parent' => 'no', 'service_type_is_description' => 'no', 'service_type_step' => '3', 'enabled' => true],
            ['service_type_parent_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'water'])->first()->id, 'service_type_name' => 'Dhaka WASA', 'service_type_slug' => 'dhaka_wasa', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'dhaka_wasa.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'dhaka_wasa.png')), 'service_type_is_parent' => 'no', 'service_type_is_description' => 'no', 'service_type_step' => '3', 'enabled' => true],
            ['service_type_parent_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'water'])->first()->id, 'service_type_name' => 'Khulna WASA', 'service_type_slug' => 'khulna_wasa', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'khulna_wasa.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'khulna_wasa.png')), 'service_type_is_parent' => 'no', 'service_type_is_description' => 'no', 'service_type_step' => '3', 'enabled' => true],
            ['service_type_parent_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'water'])->first()->id, 'service_type_name' => 'Chattogram WASA', 'service_type_slug' => 'chattogram_wasa', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'chattogram_wasa.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'chattogram_wasa.png')), 'service_type_is_parent' => 'no', 'service_type_is_description' => 'no', 'service_type_step' => '3', 'enabled' => true],
            ['service_type_parent_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'gas'])->first()->id, 'service_type_name' => 'Jalalabad Gas', 'service_type_slug' => 'jalalabad_gas', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'jalalabad_gas.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'jalalabad_gas.png')), 'service_type_is_parent' => 'no', 'service_type_is_description' => 'no', 'service_type_step' => '3', 'enabled' => true],
            ['service_type_parent_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'gas'])->first()->id, 'service_type_name' => 'Titas Gas', 'service_type_slug' => 'titas_gas', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'titas_gas.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'titas_gas.png')), 'service_type_is_parent' => 'no', 'service_type_is_description' => 'no', 'service_type_step' => '3', 'enabled' => true],
            ['service_type_parent_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'gas'])->first()->id, 'service_type_name' => 'Titas Gas Metered', 'service_type_slug' => 'titas_gas_metered', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'titas_gas.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'titas_gas.png')), 'service_type_is_parent' => 'no', 'service_type_is_description' => 'no', 'service_type_step' => '3', 'enabled' => true],
            ['service_type_parent_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'gas'])->first()->id, 'service_type_name' => 'Bakhrabad Gas', 'service_type_slug' => 'bakhrabad_gas', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'bakhrabad_gas.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'bakhrabad_gas.png')), 'service_type_is_parent' => 'no', 'service_type_is_description' => 'no', 'service_type_step' => '3', 'enabled' => true],
            ['service_type_parent_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'gas'])->first()->id, 'service_type_name' => 'Paschimanchal Gas', 'service_type_slug' => 'paschimanchal_gas', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'paschimanchal_gas.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'paschimanchal_gas.png')), 'service_type_is_parent' => 'no', 'service_type_is_description' => 'no', 'service_type_step' => '3', 'enabled' => true],
        ];
    }

    private function service(): array
    {
        $image_svg = __DIR__.'/../../resources/img/service/logo_svg/';
        $image_png = __DIR__.'/../../resources/img/service/logo_png/';

        return [
            ['service_type_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'desco_postpaid'])->first()->id, 'service_vendor_id' => 1, 'service_name' => 'DESCO Postpaid', 'service_slug' => 'desco_postpaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'desco_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'desco_postpaid.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 1, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],
            ['service_type_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'desco_prepaid'])->first()->id, 'service_vendor_id' => 1, 'service_name' => 'DESCO Prepaid', 'service_slug' => 'desco_prepaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'desco_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'desco_postpaid.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 2, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],
            ['service_type_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'dpdc_postpaid'])->first()->id, 'service_vendor_id' => 1, 'service_name' => 'DPDC Postpaid', 'service_slug' => 'dpdc_postpaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'dpdc_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'dpdc_postpaid.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 3, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],
            ['service_type_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'dpdc_prepaid'])->first()->id, 'service_vendor_id' => 1, 'service_name' => 'DPDC Prepaid', 'service_slug' => 'dpdc_prepaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'desco_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'desco_postpaid.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 4, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],
            ['service_type_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'nesco_postpaid'])->first()->id, 'service_vendor_id' => 1, 'service_name' => 'NESCO Postpaid', 'service_slug' => 'nesco_postpaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'nesco_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'nesco_postpaid.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => 'GP ST'], 'enabled' => true],
            ['service_type_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'nesco_prepaid'])->first()->id, 'service_vendor_id' => 1, 'service_name' => 'NESCO Prepaid', 'service_slug' => 'nesco_prepaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'nesco_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'nesco_postpaid.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],
            ['service_type_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'west_zone_postpaid'])->first()->id, 'service_vendor_id' => 1, 'service_name' => 'West Zone Postpaid', 'service_slug' => 'west_zone_postpaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'west_zone_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'west_zone_postpaid.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => 'GP ST'], 'enabled' => true],
            ['service_type_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'west_zone_prepaid'])->first()->id, 'service_vendor_id' => 1, 'service_name' => 'West Zone Prepaid', 'service_slug' => 'west_zone_prepaid', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'west_zone_postpaid.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'west_zone_postpaid.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],
            ['service_type_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'dhaka_wasa'])->first()->id, 'service_vendor_id' => 1, 'service_name' => 'Dhaka WASA', 'service_slug' => 'dhaka_wasa', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'dhaka_wasa.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'dhaka_wasa.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],
            ['service_type_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'khulna_wasa'])->first()->id, 'service_vendor_id' => 1, 'service_name' => 'Khulna WASA', 'service_slug' => 'khulna_wasa', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'khulna_wasa.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'khulna_wasa.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],
            ['service_type_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'chattogram_wasa'])->first()->id, 'service_vendor_id' => 1, 'service_name' => 'Chattogram WASA', 'service_slug' => 'chattogram_wasa', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'chattogram_wasa.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'chattogram_wasa.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],
            ['service_type_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'jalalabad_gas'])->first()->id, 'service_vendor_id' => 1, 'service_name' => 'Jalalabad Gas', 'service_slug' => 'jalalabad_gas', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'jalalabad_gas.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'jalalabad_gas.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],
            ['service_type_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'titas_gas'])->first()->id, 'service_vendor_id' => 1, 'service_name' => 'Titas Gas', 'service_slug' => 'titas_gas', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'titas_gas.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'titas_gas.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],
            ['service_type_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'titas_gas_metered'])->first()->id, 'service_vendor_id' => 1, 'service_name' => 'Titas Gas Metered', 'service_slug' => 'titas_gas_metered', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'titas_gas.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'titas_gas.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],
            ['service_type_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'bakhrabad_gas'])->first()->id, 'service_vendor_id' => 1, 'service_name' => 'Bakhrabad Gas', 'service_slug' => 'bakhrabad_gas', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'bakhrabad_gas.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'bakhrabad_gas.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],
            ['service_type_id' => \Fintech\Business\Facades\Business::serviceType()->list(['service_type_slug' => 'paschimanchal_gas'])->first()->id, 'service_vendor_id' => 1, 'service_name' => 'Paschimanchal Gas', 'service_slug' => 'paschimanchal_gas', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'paschimanchal_gas.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'paschimanchal_gas.png')), 'service_notification' => 'yes', 'service_delay' => 'yes', 'service_stat_policy' => 'yes', 'service_serial' => 5, 'service_data' => ['visible_website' => 'yes', 'visible_android_app' => 'yes', 'visible_ios_app' => 'yes', 'account_name' => '', 'account_number' => '', 'transactional_currency' => 'BDT', 'beneficiary_type_id' => null, 'operator_short_code' => null], 'enabled' => true],
        ];

    }

    private function serviceStat(): array
    {
        $serviceLists = $this->service();
        $serviceStats = [];
        foreach ($serviceLists as $serviceList) {
            $service = \Fintech\Business\Facades\Business::service()->list(['service_slug' => $serviceList['service_slug']])->first();
            $serviceStats[] = [
                'role_id' => [2, 3, 4, 5, 6, 7],
                'service_id' => $service->getKey(),
                'service_slug' => $service->service_slug,
                'source_country_id' => [39, 133, 192, 231],
                'destination_country_id' => [19],
                'service_vendor_id' => 1,
                'service_stat_data' => [
                    [
                        'lower_limit' => '10.00',
                        'higher_limit' => '5000.00',
                        'local_currency_higher_limit' => '25000.00',
                        'charge' => '5%',
                        'discount' => '5%',
                        'commission' => '5%',
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
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'desco_postpaid'])->first()->id,
                'name' => 'bll_no',
                'label' => 'Bill Number',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            //DESCO PREPAID
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'desco_prepaid'])->first()->id,
                'name' => 'bllr_accno',
                'label' => 'Account Number',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'desco_prepaid'])->first()->id,
                'name' => 'amount',
                'label' => 'Recharge Amount',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'desco_prepaid'])->first()->id,
                'name' => 'bill_mobno',
                'label' => 'Mobile Number',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            //DPDC POST PAID
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'dpdc_postpaid'])->first()->id,
                'name' => 'bill_monthh',
                'label' => 'Bill Month',
                'type' => 'select',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'dpdc_postpaid'])->first()->id,
                'name' => 'bill_year',
                'label' => 'Bill Year',
                'type' => 'select',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'dpdc_postpaid'])->first()->id,
                'name' => 'bllr_accno',
                'label' => 'Account code',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            //DPDC PRE PAID
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'dpdc_prepaid'])->first()->id,
                'name' => 'bill_monthh',
                'label' => 'Bill Month',
                'type' => 'select',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'dpdc_prepaid'])->first()->id,
                'name' => 'bill_year',
                'label' => 'Bill Year',
                'type' => 'select',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'dpdc_prepaid'])->first()->id,
                'name' => 'bllr_accno',
                'label' => 'Account code',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            //NESCO POSTPAID
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'nesco_postpaid'])->first()->id,
                'name' => 'bll_no',
                'label' => 'Bill Number',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            //NESCO PREPAID
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'nesco_prepaid'])->first()->id,
                'name' => 'bllr_accno',
                'label' => 'Customer Number',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'nesco_prepaid'])->first()->id,
                'name' => 'amount',
                'label' => 'Recharge Amount',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            //WEST ZONE POSTPAID
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'west_zone_postpaid'])->first()->id,
                'name' => 'bllr_accno',
                'label' => 'Account Number',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            //WEST ZONE PREPAID
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'west_zone_prepaid'])->first()->id,
                'name' => 'bllr_accno',
                'label' => 'Account Number',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            //DHAKA WASA
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'dhaka_wasa'])->first()->id,
                'name' => 'bll_no',
                'label' => 'Bill Number',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            //KHULNA WASA
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'khulna_wasa'])->first()->id,
                'name' => 'bll_no',
                'label' => 'Bill Number',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'khulna_wasa'])->first()->id,
                'name' => 'bll_typ',
                'label' => 'Bill Type',
                'type' => 'select',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            //CHATTOGRAM WASA
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'chattogram_wasa'])->first()->id,
                'name' => 'bll_no',
                'label' => 'Bill Number',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            //JALALABAD GAS
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'jalalabad_gas'])->first()->id,
                'name' => 'bllr_accno',
                'label' => 'Account Number',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'jalalabad_gas'])->first()->id,
                'name' => 'bill_mobno',
                'label' => 'Mobile Number',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            //TITAS GAS
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'titas_gas'])->first()->id,
                'name' => 'bll_no',
                'label' => 'Bill Number',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'titas_gas_metered'])->first()->id,
                'name' => 'bll_no',
                'label' => 'Bill Number',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            //BAKHRABAD GAS
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'bakhrabad_gas'])->first()->id,
                'name' => 'bllr_accno',
                'label' => 'Customer ONLINE code',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'bakhrabad_gas'])->first()->id,
                'name' => 'bill_mobno',
                'label' => 'ONLINE REGISTERED Mobile Number',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'bakhrabad_gas'])->first()->id,
                'name' => 'bll_typ',
                'label' => 'Biller\'s Type',
                'type' => 'select',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            //PASCHIMANCHAL GAS
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'paschimanchal_gas'])->first()->id,
                'name' => 'bllr_accno',
                'label' => 'Account Number',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
            [
                'service_id' => \Fintech\Business\Facades\Business::service()->list(['service_slug' => 'paschimanchal_gas'])->first()->id,
                'name' => 'bill_mobno',
                'label' => 'Mobile Number',
                'type' => 'text',
                'options' => '',
                'value' => '',
                'hint' => '',
                'required' => true,
                'reserved' => true,
                'enabled' => true,
                'validation' => 'required|min:5|max:20',
                'service_field_data' => [],
            ],
        ];
    }
}

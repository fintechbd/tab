<?php

namespace Fintech\Tab\Commands;

use Fintech\Business\Facades\Business;
use Fintech\Core\Facades\Core;
use Illuminate\Console\Command;
use Throwable;

class SSLWirelessSetupCommand extends Command
{
    const SERVICE_STAT_SETTINGS = [
        [
            'service_setting_type' => 'service_stat',
            'service_setting_name' => 'SSLVR Unique Auth Key',
            'service_setting_field_name' => 'utility_auth_key',
            'service_setting_type_field' => 'text',
            'service_setting_feature' => 'SSLVR Unique Auth Key',
            'service_setting_rule' => 'nullable|string|min:0|max:50',
            'service_setting_value' => null,
            'enabled' => true,
        ],
        [
            'service_setting_type' => 'service_stat',
            'service_setting_name' => 'SSLVR Unique Secret Key',
            'service_setting_field_name' => 'utility_secret_key',
            'service_setting_type_field' => 'text',
            'service_setting_feature' => 'SSLVR Unique Secret Key',
            'service_setting_rule' => 'nullable|string|min:0|max:50',
            'service_setting_value' => null,
            'enabled' => true,
        ],
    ];

    public $signature = 'tab:sslwireless-setup';

    public $description = 'install/update required fields for SSL Wireless utility api';

    public function handle(): int
    {
        try {
            if (Core::packageExists('Business')) {
                $this->addServiceStatSetting();
                $this->addServiceVendor();
            } else {
                $this->info('`fintech/business` is not installed. Skipped');
            }

            $this->info('SSLWireless Utility service vendor setup completed.');

            return self::SUCCESS;

        } catch (Throwable $th) {

            $this->error($th->getMessage());

            return self::FAILURE;
        }
    }

    private function addServiceStatSetting(): void
    {

        $bar = $this->output->createProgressBar(count(self::SERVICE_STAT_SETTINGS));

        $bar->start();

        foreach (self::SERVICE_STAT_SETTINGS as $setting) {

            $serviceSetting = Business::serviceSetting()
                ->list(['service_setting_field_name' => $setting['service_setting_field_name']])->first();

            if ($serviceSetting) {
                continue;
            }

            if ($serviceSetting = Business::serviceSetting()->create($setting)) {
                $this->line("Service Setting ID: {$serviceSetting->getKey()} created successful.");
            }

            $bar->advance();
        }

        $bar->finish();

        $this->info('Service Stat Setting field created successfully.');
    }

    private function addServiceVendor(): void
    {
        $dir = __DIR__.'/../../resources/img/service_vendor/';

        $vendor = [
            'service_vendor_name' => 'SSL Wireless',
            'service_vendor_slug' => 'sslwireless',
            'service_vendor_data' => [],
            'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents("{$dir}/logo_png/ssl-wireless.png")),
            'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents("{$dir}/logo_svg/ssl-wireless.svg")),
            'enabled' => false,
        ];

        if (Business::serviceVendor()->findWhere(['service_vendor_slug' => $vendor['service_vendor_slug']])) {
            $this->info('Service vendor already exists. Skipping');
        } else {
            Business::serviceVendor()->create($vendor);
            $this->info('Service vendor created successfully.');
        }
    }
}

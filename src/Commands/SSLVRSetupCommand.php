<?php

namespace Fintech\Tab\Commands;

use Fintech\Core\Facades\Core;
use Illuminate\Console\Command;

class SSLVRSetupCommand extends Command
{
    public $signature = 'tab:ssvr-setup';

    public $description = 'install/update required fields for SSL Wireless utility api';

    const SERVICE_STAT_SETTINGS = [
        [
            'service_setting_type' => 'service_stat',
            'service_setting_name' => 'SSLVR Unique Auth Key',
            'service_setting_field_name' => 'utility_auth_key',
            'service_setting_type_field' => 'text',
            'service_setting_feature' => 'SSLVR Unique Auth Key',
            'enabled' => true
        ],
        [
            'service_setting_type' => 'service_stat',
            'service_setting_name' => 'SSLVR Unique Secret Key',
            'service_setting_field_name' => 'utility_secret_key',
            'service_setting_type_field' => 'text',
            'service_setting_feature' => 'SSLVR Unique Secret Key',
            'enabled' => true
        ],
    ];

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

        } catch (\Throwable $th) {

            $this->error($th->getMessage());

            return self::FAILURE;
        }
    }

    private function addServiceStatSetting(): void
    {

        $bar = $this->output->createProgressBar(count(self::SERVICE_STAT_SETTINGS));

        $bar->start();


        foreach (self::SERVICE_STAT_SETTINGS as $setting) {

            $serviceSetting = \Fintech\Business\Facades\Business::serviceSetting()
                ->list(['service_setting_field_name' => $setting['service_setting_field_name']])->first();

            if ($serviceSetting) {
                continue;
            }

            if ($serviceSetting = \Fintech\Business\Facades\Business::serviceSetting()->create($setting)) {
                $this->line("Service Setting ID: {$serviceSetting->getKey()} created successful.");
            }

            $bar->advance();
        }

        $bar->finish();

        $this->info('Service Stat Setting field created successfully.');
    }

    private function addServiceVendor(): void
    {
        $dir = __DIR__ . '/../../resources/img/service_vendor/';

        $vendor = [
            'service_vendor_name' => 'SSL Wireless',
            'service_vendor_slug' => 'sslwireless',
            'service_vendor_data' => [],
            'logo_png' => 'data:image/png;base64,' . base64_encode(file_get_contents("{$dir}/logo_png/ssl-wireless.png")),
            'logo_svg' => 'data:image/svg+xml;base64,' . base64_encode(file_get_contents("{$dir}/logo_svg/ssl-wireless.svg")),
            'enabled' => false,
        ];

        if (\Fintech\Business\Facades\Business::serviceVendor()->list(['service_vendor_slug' => $vendor['service_vendor_slug']])->first()) {
            $this->info('Service vendor already exists. Skipping');
        } else {
            \Fintech\Business\Facades\Business::serviceVendor()->create($vendor);
            $this->info('Service vendor created successfully.');
        }
    }
}

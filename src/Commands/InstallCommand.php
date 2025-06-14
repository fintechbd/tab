<?php

namespace Fintech\Tab\Commands;

use Fintech\Core\Traits\HasCoreSetting;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    use HasCoreSetting;

    public $signature = 'tab:install';

    public $description = 'Configure the system for the `fintech/tab` module';

    private string $module = 'Tab';

    private string $image_svg = __DIR__.'/../../resources/img/service_type/logo_svg/';

    private string $image_png = __DIR__.'/../../resources/img/service_type/logo_png/';

    public function handle(): int
    {
        $this->infoMessage('Module Installation', 'RUNNING');

        $this->task('Module Installation', function () {
            $this->addDefaultServiceTypes();

            $this->addTabSubServices();

        });

        return self::SUCCESS;
    }

    private function addDefaultServiceTypes(): void
    {
        $this->task('Creating system default service types', function () {

            $entry = [
                'service_type_name' => 'Bill Payment',
                'service_type_slug' => 'bill_payment',
                'logo_svg' => $this->image_svg.'bill_payment.svg',
                'logo_png' => $this->image_png.'bill_payment.png',
                'service_type_is_parent' => 'yes',
                'service_type_is_description' => 'no',
                'service_type_step' => '1',
            ];
            business()->serviceTypeManager($entry)
                ->hasTransactionForm()
                ->disabled()
                ->execute();
        });
    }

    private function addTabSubServices(): void
    {
        $this->task('Populating Bill Payment Sub-Service Types', function () {
            $parentId = business()->serviceType()->findWhere(['service_type_slug' => 'bill_payment'])->id;
            $types = [
                [
                    'service_type_name' => 'Electricity',
                    'service_type_slug' => 'electricity',
                    'logo_svg' => $this->image_svg.'electricity.svg',
                    'logo_png' => $this->image_png.'electricity.png',
                    'service_type_is_parent' => 'yes',
                    'service_type_is_description' => 'no',
                    'service_type_step' => '2',
                    'enabled' => true,
                ],
                [
                    'service_type_name' => 'Water',
                    'service_type_slug' => 'water',
                    'logo_svg' => $this->image_svg.'water.svg',
                    'logo_png' => $this->image_png.'water.png',
                    'service_type_is_parent' => 'yes',
                    'service_type_is_description' => 'no',
                    'service_type_step' => '2',
                    'enabled' => true,
                ],
                [
                    'service_type_name' => 'GAS',
                    'service_type_slug' => 'gas',
                    'logo_svg' => $this->image_svg.'gas.svg',
                    'logo_png' => $this->image_png.'gas.png',
                    'service_type_is_parent' => 'yes',
                    'service_type_is_description' => 'no',
                    'service_type_step' => '2',
                    'enabled' => true,
                ],
                [
                    'service_type_name' => 'Education Fee',
                    'service_type_slug' => 'education_fee',
                    'logo_svg' => $this->image_svg.'education_fee.svg',
                    'logo_png' => $this->image_png.'education_fee.png',
                    'service_type_is_parent' => 'yes',
                    'service_type_is_description' => 'no',
                    'service_type_step' => '2',
                    'enabled' => true,
                ],
                [
                    'service_type_name' => 'E-service',
                    'service_type_slug' => 'e_service',
                    'logo_svg' => $this->image_svg.'e_service.svg',
                    'logo_png' => $this->image_png.'e_service.png',
                    'service_type_is_parent' => 'yes',
                    'service_type_is_description' => 'no',
                    'service_type_step' => '2',
                    'enabled' => true,
                ],
                [
                    'service_type_name' => 'Internet',
                    'service_type_slug' => 'internet',
                    'logo_svg' => $this->image_svg.'internet.svg',
                    'logo_png' => $this->image_png.'internet.png',
                    'service_type_is_parent' => 'yes',
                    'service_type_is_description' => 'no',
                    'service_type_step' => '2',
                    'enabled' => true,
                ],
                [
                    'service_type_name' => 'Ticketing',
                    'service_type_slug' => 'ticketing',
                    'logo_svg' => $this->image_svg.'ticketing.svg',
                    'logo_png' => $this->image_png.'ticketing.png',
                    'service_type_is_parent' => 'yes',
                    'service_type_is_description' => 'no',
                    'service_type_step' => '2',
                    'enabled' => true,
                ],

            ];
            foreach ($types as $entry) {
                business()->serviceTypeManager($entry, $parentId)->enabled()->execute();
            }
        });
    }
}

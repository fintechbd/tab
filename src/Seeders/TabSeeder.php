<?php

namespace Fintech\Tab\Seeders;

use Fintech\Business\Facades\Business;
use Fintech\Core\Facades\Core;
use Fintech\Transaction\Facades\Transaction;
use Illuminate\Database\Seeder;

class TabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Core::packageExists('Business')) {
            foreach ($this->serviceTypes() as $entry) {
                $serviceTypeChild = $entry['serviceTypeChild'] ?? [];

                if (isset($entry['serviceTypeChild'])) {
                    unset($entry['serviceTypeChild']);
                }

                $findServiceTypeModel = Business::serviceType()->list(['service_type_slug' => $entry['service_type_slug']])->first();
                if ($findServiceTypeModel) {
                    $serviceTypeModel = Business::serviceType()->update($findServiceTypeModel->id, $entry);
                } else {
                    $serviceTypeModel = Business::serviceType()->create($entry);
                }

                if (! empty($serviceTypeChild)) {
                    array_walk($serviceTypeChild, function ($item) use (&$serviceTypeModel) {
                        $item['service_type_parent_id'] = $serviceTypeModel->id;
                        Business::serviceType()->create($item);
                    });
                }
            }
        }

        $this->setupTransactionForm();
    }

    private function serviceTypes(): array
    {
        $image_svg = __DIR__.'/../../resources/img/service_type/logo_svg/';
        $image_png = __DIR__.'/../../resources/img/service_type/logo_png/';

        return [
            ['service_type_parent_id' => null, 'service_type_name' => 'Bill Payment', 'service_type_slug' => 'bill_payment', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'bill_payment.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'bill_payment.png')), 'service_type_is_parent' => 'yes', 'service_type_is_description' => 'no', 'service_type_step' => '1', 'enabled' => true,
                'serviceTypeChild' => [
                    ['service_type_name' => 'Electricity', 'service_type_slug' => 'electricity', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'electricity.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'electricity.png')), 'service_type_is_parent' => 'yes', 'service_type_is_description' => 'no', 'service_type_step' => '2', 'enabled' => true],
                    ['service_type_name' => 'Water', 'service_type_slug' => 'water', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'water.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'water.png')), 'service_type_is_parent' => 'yes', 'service_type_is_description' => 'no', 'service_type_step' => '2', 'enabled' => true],
                    ['service_type_name' => 'GAS', 'service_type_slug' => 'gas', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'gas.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'gas.png')), 'service_type_is_parent' => 'yes', 'service_type_is_description' => 'no', 'service_type_step' => '2', 'enabled' => true],
                    ['service_type_name' => 'Education Fee', 'service_type_slug' => 'education_fee', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'education_fee.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'education_fee.png')), 'service_type_is_parent' => 'yes', 'service_type_is_description' => 'no', 'service_type_step' => '2', 'enabled' => true],
                    ['service_type_name' => 'E-service', 'service_type_slug' => 'e_service', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'e_service.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'e_service.png')), 'service_type_is_parent' => 'yes', 'service_type_is_description' => 'no', 'service_type_step' => '2', 'enabled' => true],
                    ['service_type_name' => 'Internet', 'service_type_slug' => 'internet', 'logo_svg' => 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image_svg.'internet.svg')), 'logo_png' => 'data:image/png;base64,'.base64_encode(file_get_contents($image_png.'internet.png')), 'service_type_is_parent' => 'yes', 'service_type_is_description' => 'no', 'service_type_step' => '2', 'enabled' => true],
                ],
            ],
        ];
    }

    private function setupTransactionForm(): void
    {
        Transaction::transactionForm()->create([
            'name' => 'Bill Payment',
            'code' => 'bill_payment',
            'enabled' => true,
            'transaction_form_data' => [],
        ]);
    }
}

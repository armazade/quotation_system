<?php

namespace Domain\Quotation\Dtos;

use Domain\Company\Models\Company;
use Domain\Helper\Castables\BooleanTypeCast;
use Domain\Helper\Castables\CompanyCast;
use Domain\Product\Enums\DeliveryType;
use Domain\Product\Enums\TransferType;
use Domain\Product\Models\ProductTransferSize;
use Domain\Product\Models\Transfer;
use Domain\Quotation\Enums\QuotationPageType;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Validator;
use WendellAdriel\ValidatedDTO\Casting\EnumCast;
use WendellAdriel\ValidatedDTO\Casting\FloatCast;
use WendellAdriel\ValidatedDTO\Casting\IntegerCast;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class QuotationCreateDto extends ValidatedDTO
{
    public ?TransferType $transfer_type;

    public ?string $transfer_id;
    public ?string $transfer_size_id;

    public ?bool $has_custom_size;
    public ?float $print_height;
    public ?float $print_width;

    public ?DeliveryType $delivery_type;
    public ?bool $is_rush_order;

    public ?bool $has_blocker;
    public ?bool $needs_technical_drawing;

    public ?int $pms_color_amount;
    public ?int $quantity;

    public QuotationPageType $page;

    public ?Company $company;

    public ?Transfer $transfer;
    public ?ProductTransferSize $transferSize;

    public function getSurfaceArea(): float
    {
        return $this->quantity * $this->getAdjustedPrintHeight() * $this->getAdjustedPrintWidth();
    }

    public function getAdjustedPrintHeight(): float
    {
        return $this->print_height + 2;
    }

    public function getAdjustedPrintWidth(): float
    {
        return $this->print_width + 2;
    }

    protected function rules(): array
    {
        return static::rawRules();
    }

    public static function rawRules(): array
    {
        $rules = [];

        $rules['delivery_type'] = ['nullable', new Enum(DeliveryType::class)];

        $rules['quantity'] = ['nullable', 'int'];

        $rules['company'] = ['nullable', 'exists:companies,id'];

        return $rules;
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [
            'delivery_type' => new EnumCast(DeliveryType::class),
            'quantity' => new IntegerCast(),
            'company' => new CompanyCast(),
        ];
    }

    protected function after(Validator $validator): void
    {
        $this->page = $this->getPage((object)$this->validatedData());
    }

    private function getPage(object $data): QuotationPageType
    {
        if (!isset($data->transfer_type)) {
            return QuotationPageType::TRANSFER_TYPE;
        }

        if (!isset($data->transfer_id)) {
            return QuotationPageType::TRANSFER_ID;
        }

        $this->transfer = Transfer::find($data->transfer_id);

        if (!$this->transfer) {
            return QuotationPageType::TRANSFER_ID;
        }

        if (!isset($data->transfer_size_id)) {
            if ($this->transfer->transfer->has_custom_size && $this->transfer->customSizes->count() > 0) {
                if (!isset($data->has_custom_size)) {
                    return QuotationPageType::TRANSFER_HAS_CUSTOM_SIZE;
                }
            }

            return QuotationPageType::TRANSFER_SIZE_ID;
        }

        $this->transferSize = ProductTransferSize::find($data->transfer_size_id);

        if (!$this->transferSize) {
            return QuotationPageType::TRANSFER_SIZE_ID;
        }

        if (!isset($data->needs_technical_drawing)) {
            return QuotationPageType::EXTRA_COSTS;
        }

        if (!isset($data->is_rush_order)) {
            return QuotationPageType::EXTRA_COSTS;
        }

        if ($this->transfer->has_blocker && !isset($data->has_blocker)) {
            return QuotationPageType::EXTRA_COSTS;
        }

        if ($this->transfer->delivery_type && !isset($data->delivery_type)) {
            return QuotationPageType::EXTRA_COSTS;
        }

        if (!isset($data->quantity)) {
            return QuotationPageType::QUANTITIES;
        }

        if ($data->transfer_type === TransferType::PMS && !isset($data->pms_color_amount)) {
            return QuotationPageType::QUANTITIES;
        }

        return QuotationPageType::PRICING;
    }
}

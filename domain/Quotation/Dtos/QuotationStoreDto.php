<?php

namespace Domain\Quotation\Dtos;

use Domain\Company\Models\Company;
use Domain\Helper\Castables\BooleanTypeCast;
use Domain\Helper\Castables\CompanyCast;
use Domain\Product\Enums\BooleanType;
use Domain\Product\Enums\ColumnType;
use Domain\Product\Enums\DeliveryType;
use Domain\Product\Enums\TransferType;
use Domain\Product\Models\ProductTransferSize;
use Domain\Product\Models\Transfer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Validator;
use WendellAdriel\ValidatedDTO\Casting\EnumCast;
use WendellAdriel\ValidatedDTO\Casting\FloatCast;
use WendellAdriel\ValidatedDTO\Casting\IntegerCast;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class QuotationStoreDto extends ValidatedDTO
{
    public TransferType $transfer_type;

    public string $transfer_id;
    public string $transfer_size_id;

    public ?bool $has_custom_size;
    public ?float $print_height;
    public ?float $print_width;

    public ?DeliveryType $delivery_type;
    public ?bool $is_rush_order;

    public ?bool $has_blocker;
    public ?bool $needs_technical_drawing;

    public ?int $pms_color_amount;
    public int $quantity;

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
        $rules['transfer_type'] = ['required', new Enum(TransferType::class)];

        // TODO: active & exists
        $rules['transfer_id'] = ['required', 'exists:product_transfers,id'];
        $rules['transfer_size_id'] = ['required', 'exists:product_transfer_sizes,id'];

        $rules['has_custom_size'] = ['nullable'];
        $rules['print_height'] = ['nullable', 'numeric', 'max:58'];
        $rules['print_width'] = ['nullable', 'numeric', 'max:58'];

        $rules['delivery_type'] = ['required', new Enum(DeliveryType::class)];
        $rules['is_rush_order'] = ['required', new Enum(BooleanType::class)];

        $rules['has_blocker'] = ['nullable', new Enum(BooleanType::class)];
        $rules['needs_technical_drawing'] = ['required', new Enum(BooleanType::class)];

        // TODO: validate on moq
        $rules['quantity'] = ['required', 'int'];
        $rules['pms_color_amount'] = ['nullable', 'required_if:transfer_type,pms', 'int'];

        if (Auth::user()->isAdmin()) {
            $rules['company'] = ['required', 'exists:companies,id'];
        }

        return $rules;
    }

    protected function defaults(): array
    {
        return [
            'has_blocker' => false,
            'has_custom_size' => false,
        ];
    }

    protected function casts(): array
    {
        return [
            'transfer_type' => new EnumCast(TransferType::class),

            'has_custom_size' => new BooleanTypeCast(),
            'print_height' => new FloatCast(),
            'print_width' => new FloatCast(),

            'delivery_type' => new EnumCast(DeliveryType::class),
            'is_rush_order' => new BooleanTypeCast(),

            'has_blocker' => new BooleanTypeCast(),
            'needs_technical_drawing' => new BooleanTypeCast(),

            'quantity' => new IntegerCast(),
            'pms_color_amount' => new IntegerCast(),

            'company' => new CompanyCast(),
        ];
    }

    protected function after(Validator $validator): void
    {
        if (!isset($this->company)) {
            $this->company = Auth::user()->company;
        }

        if (isset($this->validatedData()['transfer_id'])) {
            $this->transfer = Transfer::find($this->validatedData()['transfer_id']);
        }

        if (isset($this->validatedData()['transfer_size_id'])) {
            $this->transferSize = ProductTransferSize::find($this->validatedData()['transfer_size_id']);
        }

        $this->price_column = $this->company->subscription_type ?? ColumnType::LAYER_1;
    }
}

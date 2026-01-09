<?php

namespace Database\Factories;

use Domain\Company\Models\Company;
use Domain\Quotation\Enums\QuotationStatusType;
use Domain\Quotation\Models\Quotation;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuotationFactory extends Factory
{
    protected $model = Quotation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement([
            QuotationStatusType::IN_REVIEW,
            QuotationStatusType::ACTIVE,
        ]);

        $createdAt = fake()->dateTimeBetween('-5 months', 'now');

        return [
            'user_id' => User::inRandomOrder()->first(),
            'reference' => fake()->randomNumber(8, true),
            'status' => $status->value,
            'quotation_sent_at' => $createdAt,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }

    public function forCompany(Company $company): QuotationFactory
    {
        return $this->state([
            'company_id' => $company->id,
        ]);
    }

    public function forUser(User $user): QuotationFactory
    {
        return $this->state([
            'user_id' => $user->id,
        ]);
    }
}

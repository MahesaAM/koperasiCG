<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengguna>
 */
class PenggunaFactory extends Factory
{
    protected static ?string $kataSandi;

    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_diverifikasi_pada' => now(),
            'kata_sandi' => static::$kataSandi ??= Hash::make('password'),
            'token_pengingat' => Str::random(10),
        ];
    }

    public function belumDiverifikasi(): static
    {
        return $this->state(fn (array $atribut) => [
            'email_diverifikasi_pada' => null,
        ]);
    }
}

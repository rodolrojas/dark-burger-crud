<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@dark-burger.local'],
            [
                'name' => 'Dark Burger Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'active' => true,
            ],
        );

        User::updateOrCreate(
            ['email' => 'kitchen@dark-burger.local'],
            [
                'name' => 'Kitchen Staff',
                'password' => Hash::make('password'),
                'role' => 'kitchen',
                'active' => true,
            ],
        );

        User::updateOrCreate(
            ['email' => 'payments@dark-burger.local'],
            [
                'name' => 'Payments Staff',
                'password' => Hash::make('password'),
                'role' => 'payments',
                'active' => true,
            ],
        );

        $classic = Product::updateOrCreate(
            ['slug' => 'classic-burger'],
            [
                'name' => 'Classic Burger',
                'description' => 'Beef patty, cheese, pickles, onion, and house sauce.',
                'active' => true,
            ],
        );

        $classic->variants()->updateOrCreate(
            ['sku' => 'CLASSIC-SINGLE'],
            ['name' => 'Single', 'price' => '8.50', 'active' => true],
        );
        $classic->variants()->updateOrCreate(
            ['sku' => 'CLASSIC-DOUBLE'],
            ['name' => 'Double', 'price' => '11.50', 'active' => true],
        );

        $bacon = Product::updateOrCreate(
            ['slug' => 'bacon-burger'],
            [
                'name' => 'Bacon Burger',
                'description' => 'Beef patty, crispy bacon, cheddar, pickles, and smoky sauce.',
                'active' => true,
            ],
        );

        $bacon->variants()->updateOrCreate(
            ['sku' => 'BACON-SINGLE'],
            ['name' => 'Single', 'price' => '9.50', 'active' => true],
        );
        $bacon->variants()->updateOrCreate(
            ['sku' => 'BACON-DOUBLE'],
            ['name' => 'Double', 'price' => '12.50', 'active' => true],
        );

        PaymentMethod::updateOrCreate(
            ['code' => 'cash_on_delivery'],
            ['name' => 'Cash on Delivery', 'type' => 'cash', 'active' => true, 'configuration' => []],
        );
        PaymentMethod::updateOrCreate(
            ['code' => 'demo_card'],
            ['name' => 'Demo Card', 'type' => 'card', 'active' => true, 'configuration' => ['tokens' => ['tok_success', 'tok_fail']]],
        );
        PaymentMethod::updateOrCreate(
            ['code' => 'bank_transfer_demo'],
            ['name' => 'Demo Bank Transfer', 'type' => 'bank_transfer', 'active' => true, 'configuration' => []],
        );
    }
}

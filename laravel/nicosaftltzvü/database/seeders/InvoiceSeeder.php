<?php

namespace Database\Seeders;

use App\Models\Invoice; // Import the Invoice Model
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. You must import the model first.
        // 2. Use the factory method on the model.
        // 3. Chain the count() method to specify how many invoices to create (e.g., 50).
        // 4. Call create() to persist them to the database.
        Invoice::factory()
            ->count(50)
            ->create();
    }
}
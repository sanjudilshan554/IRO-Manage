<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->String('name')->nullable();
            $table->String('company_code')->nullable();
            $table->String('slbfe_reg_code')->nullable();
            $table->String('address')->nullable();
            $table->String('postal_code')->nullable();
            $table->String('city')->nullable();
            $table->String('dispatch_countries')->nullable();
            $table->String('email')->nullable();
            $table->String('phone')->nullable();
            $table->String('website')->nullable();
            $table->String('tax_id')->nullable();
            $table->String('registration_number')->nullable();
            $table->String('industry')->nullable();
            $table->String('business_type')->nullable();
            $table->String('currency')->nullable();
            $table->text('bank_account_details')->nullable();
            $table->enum('status', ['Active', 'Inactive', 'Pending'])->default('Pending');
            $table->String('category')->nullable();
            $table->String('logo')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};

<?php

declare(strict_types=1);

use App\Enums\PropertyStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->integer('flat_number');
            $table->integer('floor');
            $table->float('terrace_area',  2)->nullable();
            $table->float('balcony_area',  2)->nullable();
            $table->float('flat_area',  2);
            $table->float('total_area', 2);
            $table->integer('price');
            $table->enum('status', PropertyStatusEnum::cases())->default(PropertyStatusEnum::AVAILABLE->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};

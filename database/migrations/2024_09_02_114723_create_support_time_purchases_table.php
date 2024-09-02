<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('support_time_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->string('support_type');
            $table->text('details')->nullable();
            $table->string('payment_id');
            $table->decimal('amount', 8, 2);
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });
    }
};

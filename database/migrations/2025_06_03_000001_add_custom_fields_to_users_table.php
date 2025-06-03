<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('birthday')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('accept_marketing')->default(false);
            $table->string('indirizzo')->nullable();
            $table->string('nciv')->nullable();
            $table->string('doorbell')->nullable();
            $table->string('floor')->nullable();
            $table->string('cap')->nullable();
            $table->string('country')->nullable();
            $table->string('gender')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'birthday',
                'city',
                'province',
                'phone',
                'accept_marketing',
                'indirizzo',
                'nciv',
                'doorbell',
                'floor',
                'cap',
                'country',
                'gender',
            ]);
        });
    }
};

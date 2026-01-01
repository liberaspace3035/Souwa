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
        Schema::table('users', function (Blueprint $table) {
            $table->string('region')->nullable()->after('email'); // 區域
            $table->text('address')->nullable()->after('region'); // 地址
            $table->string('phone_number')->nullable()->after('address'); // 電話號碼
            $table->string('person_in_charge')->nullable()->after('phone_number'); // 負責人
            $table->string('position')->nullable()->after('person_in_charge'); // 職位
            $table->string('company_size')->nullable()->after('position'); // 企業規模
            $table->string('company_website')->nullable()->after('company_size'); // 企業網址
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'region',
                'address',
                'phone_number',
                'person_in_charge',
                'position',
                'company_size',
                'company_website',
            ]);
        });
    }
};

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
        Schema::table('site_contents', function (Blueprint $table) {
            $table->boolean('about_active')->default(true)->after('hero_poster_active');
            $table->string('about_title')->default('Sobre a D2L')->after('about_active');
            $table->text('about_description')->nullable()->after('about_title');
            $table->smallInteger('about_founded_year')->nullable()->after('about_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_contents', function (Blueprint $table) {
            $table->dropColumn(['about_active', 'about_title', 'about_description', 'about_founded_year']);
        });
    }
};

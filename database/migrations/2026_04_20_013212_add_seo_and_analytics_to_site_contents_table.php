<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('site_contents', function (Blueprint $table) {
            $table->string('seo_title')->nullable()->after('instagram_url');
            $table->string('seo_description', 320)->nullable()->after('seo_title');
            $table->string('seo_keywords', 500)->nullable()->after('seo_description');
            $table->string('google_analytics_id', 50)->nullable()->after('seo_keywords');
            $table->string('google_tag_manager_id', 50)->nullable()->after('google_analytics_id');
            $table->string('google_search_console_meta', 100)->nullable()->after('google_tag_manager_id');
            $table->boolean('robots_index')->default(true)->after('google_search_console_meta');
        });
    }

    public function down(): void
    {
        Schema::table('site_contents', function (Blueprint $table) {
            $table->dropColumn([
                'seo_title',
                'seo_description',
                'seo_keywords',
                'google_analytics_id',
                'google_tag_manager_id',
                'google_search_console_meta',
                'robots_index',
            ]);
        });
    }
};

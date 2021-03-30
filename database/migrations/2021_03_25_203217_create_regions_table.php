<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->smallInteger('active')->default(0);
            $table->timestamps();
        });

        $this->fillRegionTable();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
    }

    protected function fillRegionTable() : void
    {
        DB::statement("INSERT INTO regions (name, active, created_at, updated_at) VALUES ('Africa', 0, now(), now());");
        DB::statement("INSERT INTO regions (name, active, created_at, updated_at) VALUES ('Americas', 0, now(), now());");
        DB::statement("INSERT INTO regions (name, active, created_at, updated_at) VALUES ('Asia', 0, now(), now());");
        DB::statement("INSERT INTO regions (name, active, created_at, updated_at) VALUES ('Europe', 1, now(), now());");
        DB::statement("INSERT INTO regions (name, active, created_at, updated_at) VALUES ('Oceania', 0, now(), now());");
    }
}

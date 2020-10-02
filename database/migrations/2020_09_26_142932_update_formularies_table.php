<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Formulary;

class UpdateFormulariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Formulary::truncate();
        Schema::table('formularies', function (Blueprint $table) {
            $table->dropColumn([
                'drug_name',
                'strength',
                'form',
                'qty',
                'premium',
                'non_premium',
                'category',
            ]);

            $table->string('eta')->nullable()->after('disease_state');
            $table->string('available_with_insurance')->nullable()->after('disease_state');
            $table->string('stock_status')->nullable()->after('disease_state');
            $table->string('drx_club')->nullable()->after('disease_state');
            $table->string('insurance')->nullable()->after('disease_state');
            $table->string('brand')->nullable()->after('disease_state');
            $table->string('size')->nullable()->after('disease_state');
            $table->string('product_name')->nullable()->after('disease_state');
            $table->string('product_type')->nullable()->after('disease_state');

            $table->string('disease_state')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

<?php

use App\Models\Account;
use App\Models\Asset;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionAggregatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('position_aggregates', function (Blueprint $table) {
            $table->id();
            $table->decimal('quantity', 27, 18)->comment('The amount of tokens held.');
            $table->decimal('asset_unitary_price');
            $table->decimal('profit');
            $table->string('type');
            $table->dateTime('date');
            $table->foreignIdFor(Account::class);
            $table->foreignIdFor(Asset::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('position_aggregates');
    }
}

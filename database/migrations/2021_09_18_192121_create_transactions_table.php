<?php

use App\Models\Account;
use App\Models\Asset;
use App\Models\Team;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->decimal('amount');
            $table->decimal('quantity', 27, 18);
            $table->decimal('avg_price_then')->nullable();
            $table->decimal('profit')->nullable();
            $table->timestamp('date');
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
        Schema::dropIfExists('transactions');
    }
}

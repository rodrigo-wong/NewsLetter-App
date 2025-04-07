<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsletterSubscribersTable extends Migration
{
    public function up()
    {
        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->enum('frequency', ['minute', 'hour', 'daily']);
            $table->decimal('percentage_alert', 5, 2);
            $table->boolean('btc')->default(false);
            $table->boolean('eth')->default(false);
            $table->boolean('doge')->default(false);
            $table->boolean('ltc')->default(false);
            $table->boolean('xrp')->default(false);
            $table->boolean('bch')->default(false);
            $table->boolean('bnb')->default(false);
            $table->boolean('eos')->default(false);
            $table->boolean('ada')->default(false);
            $table->boolean('dot')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('newsletter_subscribers');
    }
}

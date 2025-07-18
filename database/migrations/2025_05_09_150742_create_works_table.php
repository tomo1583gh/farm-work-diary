<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // 作業を記録したユーザーID
            $table->string('title');               // 作業タイトル
            $table->text('content')->nullable();   // 詳細内容
            $table->date('work_date');             // 作業日
            $table->timestamps();

            // 外部キー制約
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('works');

        Schema::table(
            'works',
            function (Blueprint $table) {
                $table->dropColumn(['category_name', 'work_time']);
        });
    }
}
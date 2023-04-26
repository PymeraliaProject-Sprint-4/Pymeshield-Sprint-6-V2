<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Redis;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Set JSON value in Redis key 'logs'
        Redis::set('logs', json_encode([]));
        Redis::flushDB();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove Redis key 'logs'
        Redis::del('logs');
        Redis::flushDB();
    }
}

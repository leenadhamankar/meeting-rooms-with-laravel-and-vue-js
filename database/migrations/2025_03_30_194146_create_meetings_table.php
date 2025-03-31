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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('meeting_name');
            $table->unsignedBigInteger('user_id'); // Foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->integer('duration')->comments('in minutes. eg - 30, 60, 90');
            $table->integer('members')->comments('max members');
            $table->unsignedBigInteger('meeting_room_id'); // Foreign key
            $table->foreign('meeting_room_id')->references('id')->on('meeting_rooms')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};

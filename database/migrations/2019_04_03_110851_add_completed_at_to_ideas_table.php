<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;
use App\Models\Categories\Status;
use App\Models\Idea;

class AddCompletedAtToIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ideas', function (Blueprint $table) {
            $table->timestamp('completed_at')->nullable();
        });

        $date = Carbon::now()->subMonths(3);
        $ideas = Status::getCompletedStatus() ? Status::getCompletedStatus()->ideas->where('updated_at', '>=', $date) : [];
        foreach ($ideas as $idea) {
            Idea::where('id', $idea->id)->update(['completed_at' => $idea->updated_at]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ideas', function (Blueprint $table) {
            $table->dropColumn('completed_at');
        });
    }
}

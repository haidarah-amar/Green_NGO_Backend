<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ApplyToActivityJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $beneficiaryId;
    protected $activityId;

    public function __construct($beneficiaryId, $activityId)
    {
        $this->beneficiaryId = $beneficiaryId;
        $this->activityId = $activityId;
    }

    public function handle()
    {
        DB::transaction(function () {
            $activity = DB::table('activities')->where('id', $this->activityId)->lockForUpdate()->first();

            if (!$activity) {
                return;
            }

            $count = DB::table('activity_beneficiaries')
                ->where('activity_id', $this->activityId)
                ->count();

            if ($count >= $activity->planned_attendees) {
                return;
            }

            $exists = DB::table('activity_beneficiaries')
                ->where('activity_id', $this->activityId)
                ->where('beneficiary_id', $this->beneficiaryId)
                ->exists();

            if ($exists) {
                return;
            }

            DB::table('activity_beneficiaries')->insert([
                'activity_id' => $this->activityId,
                'beneficiary_id' => $this->beneficiaryId,
            ]);
        });
    }
}
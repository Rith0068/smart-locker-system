<?php

namespace Database\Seeders;

use App\Models\History;
use App\Models\Locker;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HistoryData extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * The Locker model writes these rows itself on create/update, but every
     * seeder suppresses model events, so finished sessions are seeded here to
     * give the history and dashboard pages something to show.
     */
    public function run(): void
    {
        $user = User::where('role', 1)->orderBy('id')->first();

        if (! $user) {
            return;
        }

        $lockers = Locker::where('status', Locker::STATUS_AVAILABLE)
            ->orderBy('id')
            ->take(4)
            ->get();

        // Each session is a "use" entry closed by a matching "release" entry.
        $sessions = [
            ['offset_days' => 5, 'hours' => [8, 12]],
            ['offset_days' => 3, 'hours' => [9, 16]],
            ['offset_days' => 1, 'hours' => [10, 14]],
        ];

        foreach ($lockers as $index => $locker) {
            $session = $sessions[$index % count($sessions)];

            $usedAt = now()->subDays($session['offset_days'])->setTime(
                $session['hours'][0],
                0
            );

            $releasedAt = now()->subDays($session['offset_days'])->setTime(
                $session['hours'][1],
                30
            );

            $this->record($user->id, $locker->id, 'use', $usedAt);
            $this->record($user->id, $locker->id, 'release', $releasedAt);
        }

        // One session still open, matching the locker left in use by LockerData.
        $inUse = Locker::where('status', Locker::STATUS_IN_USE)
            ->where('user_id', $user->id)
            ->orderBy('id')
            ->first();

        if ($inUse) {
            $this->record($user->id, $inUse->id, 'use', now()->subHours(2));
        }
    }

    private function record(int $userId, int $lockerId, string $action, $at): void
    {
        $exists = History::where('user_id', $userId)
            ->where('locker_id', $lockerId)
            ->where('action', $action)
            ->exists();

        if ($exists) {
            return;
        }

        History::create([
            'user_id' => $userId,
            'locker_id' => $lockerId,
            'action' => $action,
        ])->forceFill(['created_at' => $at, 'updated_at' => $at])->save();
    }
}

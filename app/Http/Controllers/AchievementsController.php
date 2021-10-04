<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AchievementsController extends Controller
{
    /**
     * @param User $user
     * @return JsonResponse
     */
    public function index(User $user): JsonResponse
    {
        $currentBadge = $this->currentBadge($user);
        return response()->json([
            'unlocked_achievements' => $this->getUnlockedAchievement($user),
            'next_available_achievements' => $this->nextAvailableAchievements($user),
            'current_badge' => $currentBadge ? $currentBadge->title : null,
            'next_badge' => $this->nextBadge($currentBadge),
            'remaining_to_unlock_next_badge' => $this->reamingToUnblockNextBadge($user)
        ]);
    }


    /**
     * @param $user
     * @return array
     */
    public function nextAvailableAchievements($user): array
    {
        $allAchievementsId = $user->achievements->pluck('achievement_id')->toArray();
        return DB::table('achievements_rules as ar')
            ->select('ar.title')
            ->whereNotIn('id', $allAchievementsId)
            ->get()
            ->map(function ($badge) {
                return $badge->title;
            })
            ->toArray();
    }


    /**
     * @param $user
     * @return array
     */
    public function getUnlockedAchievement($user): array
    {
        return $user->achievements->pluck('achievementRules.title')->toArray();
    }


    /**
     * @param $user
     * @return null
     */
    public function currentBadge($user)
    {
        return $user->currentBadge() ? $user->currentBadge()->badgeRules : null;
    }

    /**
     * @param $currentBadge
     * @return string
     */
    public function nextBadge($currentBadge): string
    {

        $badge = DB::table('badge_rules')
            ->select('title')
            ->where('id', '!=', $currentBadge->id ?? null)
            ->where('sequence', '>', $currentBadge->sequence ?? '0')
            ->orderBy('sequence')
            ->first();
        return $badge->title ?? '';

    }


    /**
     * @param $user
     * @return mixed
     */
    public function reamingToUnblockNextBadge($user)
    {
        $totalAchievements = $user->achievements()->count();
        $nextRules = DB::table('badge_rules')
            ->when($totalAchievements == 0, function ($q) {
                $q->where('rule', '=', 0);
            })->when($totalAchievements > 0, function ($q) use ($totalAchievements) {
                $q->where('rule', '>', $totalAchievements);
            })
            ->orderBy('sequence')
            ->limit(1)
            ->first();
        return $nextRules->rule - $totalAchievements;
    }
}

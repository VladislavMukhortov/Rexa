<?php


namespace App\Services;


class FriendService
{
    public static function checkExistsFriend(int $applyClientId): bool
    {
        return (bool) auth()
            ->user()
            ->profile
            ->friends()
            ->where('apply_client_id', $applyClientId)
            ->first();
    }
}

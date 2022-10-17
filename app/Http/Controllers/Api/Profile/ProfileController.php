<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Media\AvatarRequest;
use App\Http\Requests\Api\Media\DefaultAvatarRequest;
use App\Http\Requests\Api\Profile\AddToFriendsRequest;
use App\Http\Requests\Api\Profile\RemoveFromFriendsRequest;
use App\Http\Requests\Api\Profile\UpdateProfileRequest;
use App\Http\Resources\MediaCollection;
use App\Http\Resources\MediaResource;
use App\Http\Resources\ProfileCollection;
use App\Http\Resources\ProfileResource;
use App\Models\Client;
use App\Models\DefaultAvatars;
use App\Models\Friend;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    /**
     * Взять профиль пользователя, по id из auth database
     *
     * @return ProfileResource
     */
    public function getInfo(): ProfileResource
    {
        return new ProfileResource(auth()->user());
    }

    /**
     * Обновить профиль пользователя
     *
     * @param UpdateProfileRequest $profileRequest
     * @return ProfileResource
     */
    public function update(UpdateProfileRequest $profileRequest): ProfileResource
    {
        $data = $profileRequest->validated();
        if (!auth()->user()->profile()->count()) {
            $data['main_avatar_id'] = MediaService::setFirstAvatar();
        }

        auth()->user()->profile()->updateOrCreate([
            'client_id' => auth()->user()->id
        ], $data);

        return new ProfileResource(auth()->user()->fresh());
    }

    /**
     * Загрузить и сохранить загруженную аватарку
     *
     * @param AvatarRequest $avatarRequest
     * @return MediaResource
     */
    public function uploadAvatar(AvatarRequest $avatarRequest): MediaResource
    {
        $avatarPath = MediaService::uploadMedia($avatarRequest->validated()['avatar'], 'avatar');
        return new MediaResource(MediaService::storeMedia($avatarPath, auth()->user()->id, 'avatar'));
    }

    /**
     * Получить все медиа залогиненого пользователя
     *
     * @return MediaCollection
     */
    public function getAllProfileMedia(): MediaCollection
    {
        return new MediaCollection(auth()->user()->media()->get());
    }

    /**
     * Выбор дефолтного аватара
     *
     * @param DefaultAvatarRequest $defaultAvatarRequest
     * @return MediaResource
     */
    public function chooseDefaultAvatar(DefaultAvatarRequest $defaultAvatarRequest): MediaResource
    {
        $defaultAvatar = DefaultAvatars::find($defaultAvatarRequest->get('id'));

        return new MediaResource(MediaService::storeMedia($defaultAvatar->path, auth()->user()->id, 'avatar'));
    }

    /**
     * Получить всех друзей пользователя
     *
     * @return ProfileCollection
     */
    public function getAllFriends(): ProfileCollection
    {
        return new ProfileCollection(auth()->user()->profile->friends);
    }

    /**
     * Получить всех друзей пользователя
     *
     * @param Client $client
     * @param AddToFriendsRequest $addToFriendsRequest
     * @return ProfileResource|JsonResponse
     */
    public function addToFriends(Client $client, AddToFriendsRequest $addToFriendsRequest): ProfileResource|JsonResponse
    {
        Friend::query()->updateOrCreate([
            'accept_client_id' => auth()->user()->id,
            'apply_client_id' => $client->id,
        ], [
            'accept_client_id' => auth()->user()->id,
            'apply_client_id' => $client->id,
        ]);

        return new ProfileResource($client);
    }

    /**
     * @param Client $client
     * @param RemoveFromFriendsRequest $removeFromFriendsRequest
     * @return JsonResponse
     */
    public function removeFromFriends(Client $client, RemoveFromFriendsRequest $removeFromFriendsRequest): JsonResponse
    {
        Friend::query()
            ->where('accept_client_id', auth()->user()->id)
            ->where('apply_client_id', $client->id)
            ->delete();

        return response()->json([
            'status' => true,
            'message' => __('profile.friends.remove.success'),
            'data' => [],
        ], 200);
    }
}

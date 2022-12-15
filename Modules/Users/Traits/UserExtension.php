<?php

namespace Modules\Users\Traits;

use Carbon\Carbon;
use Modules\Users\Entities\User;
use App\Services\MongoDB\DocumentService;
use Modules\Services\Entities\Attachment;

trait UserExtension
{
    /**
     * Generates the user ID based on the year the user was created
     *
     * @return string
     */
    public function generateID(): string
    {
        $lastCreatedUser = User::whereYear('created_at', Carbon::now()->year)
            ->orderBy('created_at', 'DESC')
            ->limit(1)
            ->first();

        $carbon = Carbon::now();

        if (!$lastCreatedUser)
            return "$carbon->year-$carbon->month-001";

        return ++$lastCreatedUser->user_id;
    }

    /**
     * Save Image to MongoDB
     *
     * @param array $images
     * @param User $user
     * @return void
     */
    public function saveImage(array $images, User $user): void
    {
        if (!empty($images)) {
            $addedImages = collect($images);
            $addedImages->each(function ($image) use ($user) {
                $userImage = (new DocumentService())->save(['file' => $image['file']]);
                Attachment::create([
                    'documentable_id' => $user->id,
                    'documentable_type' => 'User',
                    'document_id' => $userImage->_id,
                    'user_id' => $user->id
                ]);
            });
        }
    }

    /**
     * Soft delete image from MongoDB
     *
     * @param array $images
     * @param User $user
     * @return void
     */
    public function deleteImage(array $images, User $user): void
    {
        if (!empty($images)) {
            $removedImages = collect($images);
            $removedImages->each(function ($imageId) use ($user) {
                $attachments = Attachment::where('document_id', $imageId)->pluck('id')->toArray();
                if (!empty($attachments)) {
                    print_r($attachments);
                    Attachment::destroy($attachments);
                    (new DocumentService())->destroy($imageId);
                }
            });
        }
    }
}

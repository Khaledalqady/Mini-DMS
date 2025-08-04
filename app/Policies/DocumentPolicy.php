<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Document;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Document $document){
        return $user->id === $document->user_id;
        }

        public function delete(User $user, Document $document){
            return $user->id === $document->user_id;
                }
}

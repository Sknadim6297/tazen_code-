<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_type_1',
        'participant_id_1',
        'participant_type_2',
        'participant_id_2',
        'last_message_at',
        'last_message_by',
        'last_message_by_type'
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    /**
     * Get the first participant
     */
    public function participant1()
    {
        return $this->morphTo('participant1', 'participant_type_1', 'participant_id_1');
    }

    /**
     * Get the second participant
     */
    public function participant2()
    {
        return $this->morphTo('participant2', 'participant_type_2', 'participant_id_2');
    }

    /**
     * Get all messages for this chat
     */
    public function messages()
    {
        return $this->hasMany(ChatMessage::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get the latest message
     */
    public function latestMessage()
    {
        return $this->hasOne(ChatMessage::class)->latest();
    }

    /**
     * Get unread messages count for a specific user
     */
    public function getUnreadCountForUser($userType, $userId)
    {
        return $this->messages()
            ->where(function($query) use ($userType, $userId) {
                $query->where('sender_type', '!=', $userType)
                      ->orWhere('sender_id', '!=', $userId);
            })
            ->where('is_read', false)
            ->count();
    }

    /**
     * Find or create a chat between two participants
     */
    public static function findOrCreateChat($type1, $id1, $type2, $id2)
    {
        // Try to find existing chat (check both participant orders)
        $chat = self::where(function($query) use ($type1, $id1, $type2, $id2) {
            $query->where('participant_type_1', $type1)
                  ->where('participant_id_1', $id1)
                  ->where('participant_type_2', $type2)
                  ->where('participant_id_2', $id2);
        })->orWhere(function($query) use ($type1, $id1, $type2, $id2) {
            $query->where('participant_type_1', $type2)
                  ->where('participant_id_1', $id2)
                  ->where('participant_type_2', $type1)
                  ->where('participant_id_2', $id1);
        })->first();

        if (!$chat) {
            $chat = self::create([
                'participant_type_1' => $type1,
                'participant_id_1' => $id1,
                'participant_type_2' => $type2,
                'participant_id_2' => $id2,
            ]);
        }

        return $chat;
    }

    /**
     * Get the other participant details for the current user
     */
    public function getOtherParticipant($currentUserType, $currentUserId)
    {
        if ($this->participant_type_1 == $currentUserType && $this->participant_id_1 == $currentUserId) {
            return [
                'type' => $this->participant_type_2,
                'id' => $this->participant_id_2,
                'model' => $this->participant2
            ];
        } else {
            return [
                'type' => $this->participant_type_1,
                'id' => $this->participant_id_1,
                'model' => $this->participant1
            ];
        }
    }
}

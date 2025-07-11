<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail; // For sending emails if needed

class ContactUs extends Model
{
    use HasFactory;

    // Define the properties that are fillable
    protected $fillable = ['name', 'email', 'message'];

    // Optional: Define relationships if any (e.g., if you have a Reply model)
    // public function replies()
    // {
    //     return $this->hasMany(Reply::class);
    // }

    /**
     * Delete a contact message by its ID.
     *
     * @param int $id
     * @return bool|null
     */
    public static function deleteMessage($id)
    {
        $contact = self::find($id);

        if ($contact) {
            return $contact->delete();  // Delete the contact message if found
        }

        return false;  // Return false if contact message was not found
    }

    /**
     * Reply to a contact message.
     * This can include sending an email to the user or storing the reply in a database.
     *
     * @param int $id
     * @param string $replyMessage
     * @return bool
     */
    public static function replyToMessage($id, $replyMessage)
    {
        $contact = self::find($id);

        if ($contact) {
            // Here you can either send an email or store the reply in the database
            // Example: Sending an email response
            // Mail::to($contact->email)->send(new ContactReply($replyMessage));

            // Optionally: You can also save the reply in a "replies" table if you want to track replies.
            // Reply::create([
            //     'contact_id' => $contact->id,
            //     'reply_message' => $replyMessage,
            //     'admin_reply' => true,
            // ]);

            return true;  // Return true to indicate a successful reply action
        }

        return false;  // Return false if the contact message was not found
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TicketMessage
 *
 * @property int $id
 * @property \Carbon\Carbon $date
 * @property int $ticket_id
 * @property int $user_id
 * @property string $message
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TicketMessage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TicketMessage whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TicketMessage whereTicketId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TicketMessage whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TicketMessage whereMessage($value)
 * @mixin \Eloquent
 */
class TicketMessage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ticket_message';

    protected $dates = ['date'];

    protected $fillable = ['date', 'ticket_id', 'user_id', 'message'];

    public $timestamps = false;

    public function getUser()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}

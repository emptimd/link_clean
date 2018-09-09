<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Ticket
 *
 * @property int $id
 * @property \Carbon\Carbon $date
 * @property string $status
 * @property int $user_id
 * @property string $subject
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ticket whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ticket whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ticket whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ticket whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ticket whereSubject($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User $author
 */
class Ticket extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ticket';

    protected $dates = ['date'];

    protected $fillable = ['date', 'status', 'user_id', 'subject'];

    public $timestamps = false;


    public function author()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function getMessages()
    {
        return $this->hasMany('App\Models\TicketMessage', 'ticket_id', 'id');
    }

    public function status()
    {
        $label = '<span class="label label-';
        if ($this->status == 'open')    $label .= 'success';
        if ($this->status == 'replied') $label .= 'inverse';
        if ($this->status == 'closed')  $label .= 'default';
        $label .= '">'.ucfirst($this->status).'</span>';

        return $label;
    }
}

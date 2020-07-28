<?php

namespace App\Models;

use App\Events\TransactionCreated;
use App\Events\TransactionDeleted;
use App\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spending extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'space_id',
        'import_id',
        'recurring_id',
        'tag_id',
        'happened_on',
        'description',
        'amount'
    ];

    protected $visible = [
        'id',
        'type',
        'description',
        'happened_on',
        'amount'
    ];

    protected $appends = [
        'type'
    ];

    protected $dispatchesEvents = [
        'created' => TransactionCreated::class,
        'deleted' => TransactionDeleted::class
    ];

    // Accessors
    public function getTypeAttribute()
    {
        return 'spending';
    }

    public function getFormattedAmountAttribute()
    {
        return Helper::formatNumber($this->amount / 100);
    }

    public function getFormattedHappenedOnAttribute()
    {
        $secondsDifference = strtotime(date('Y-m-d')) - strtotime($this->happened_on);

        return ($secondsDifference / 60 / 60 / 24) . ' days ago';
    }

    // Relations
    public function import()
    {
        return $this->belongsTo(Import::class);
    }

    public function recurring()
    {
        return $this->belongsTo(Recurring::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'transaction_id')
            ->where('transaction_type', 'spending');
    }

    // Scopes
    public function scopeOfSpace($query, $spaceId)
    {
        return $query->where('space_id', $spaceId);
    }
}

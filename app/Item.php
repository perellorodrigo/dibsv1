<?php

namespace Dibs;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    public function owner()
    {
        return $this->belongsTo('Dibs\User','owner_id');
    }
    
    public function dibscaller()
    {
        return $this->belongsTo('Dibs\User','dibs_caller_id');
    }


}

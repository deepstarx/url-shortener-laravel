<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use App\Models\Company;

class ShortUrl extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'user_id',
        'short_url',
        'original_url',
    ];
    public function company(): BelongsTo
     { 
        return $this->belongsTo(Company::class);
     }

     public function user(): BelongsTo
     {
        return $this->belongsTo(User::class); 
     }

     public function scopeVisibleTo(Builder $query, User $user): Builder
      {
        if($user->isSuperAdmin())
            {
            return $query;
        }

        if($user->isAdmin())
            {
                return $query->where('company_id', $user->company_id);
            }

        if($user->isMember())
            {
                return $query->where('user_id', $user->id);
            }
            return $query->whereRaw('1 = 0');
        }
      }
  


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Company extends Model
{
    use HasFactory;

    /**
     * @mixin Builder
     * @property string $title
     * @property string $phone
     * @property string $description
     */
    protected $fillable = [
        'title', 'phone', 'description'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    

}

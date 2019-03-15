<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'name',
        'description',
        'color',
        'faq_category_id',
        'user_id'
    ];

    protected $hidden = [
        'faq_category_id',
        'operand_id',
        'user_id'
    ];

    public function faqCategory()
    {
        return $this->belongsTo(FaqCategory::class);
    }

    public function operand()
    {
        return $this->belongsTo(Operand::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

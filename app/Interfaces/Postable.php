<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

interface Postable {
    public function posts():MorphMany;
}
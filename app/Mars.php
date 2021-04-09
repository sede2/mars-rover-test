<?php
namespace App;

use App\Map\MapPlain;

class Mars extends MapPlain
{
    public static function generate(int $x, int $y ): MapPlain
    {
        $self = parent::generate($x, $y);
        return $self;
    }
}

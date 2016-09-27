<?php

namespace App\CORE;

class Range
{
    protected $numbers = null;

    public function valid($expression, $number)
    {
        $ranges = $this->getRanges($expression);

        $fits = false;
        foreach($ranges as $range)
        {
            list($min, $max) = explode('-', $range);
            
            $fits |= (intval($min) <= intval($number)) && (intval($number) <= intval($max));
        }
        return $fits;
    }

    public function create($expression)
    {
        $ranges = $this->getRanges($expression);

        $ranges = array_map(function($item){
            list($min, $max) = explode('-', $item);

            return range($min, $max);
        }, $ranges);

        $collection = collect(array_flatten($ranges));

        $this->numbers = $collection->unique();

        return $this;
    }

    public function exclude(array $numbers)
    {
        $this->numbers = $this->numbers->diff($numbers);

        return $this;
    }

    public function get()
    {
        return $this->numbers->values()->all();
    }

    protected function getRanges($expression)
    {
        return explode(',', $expression);
    }
}

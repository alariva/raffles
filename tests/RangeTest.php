<?php

use App\CORE\Range;

class RangeTest extends TestCase
{
    protected $range;

    public function setUp()
    {
        parent::__construct();

        $this->range = new Range();
    }

    public function test_generates_a_range_of_numbers()
    {
        $range = $this->range->create('0-10')->get();

        $this->assertEquals($range, [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
    }

    public function test_generates_a_single_range_of_numbers_out_of_chunks()
    {
        $range = $this->range->create('0-10,15-20')->get();

        $this->assertEquals($range, [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 15, 16, 17, 18, 19, 20]);
    }

    public function test_generates_a_single_number_when_overlapping()
    {
        $range = $this->range->create('0-5,4-10')->get();

        $this->assertEquals($range, [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
    }

    public function test_generates_a_single_number_on_repetition()
    {
        $range = $this->range->create('7-7')->get();

        $this->assertEquals($range, [7]);
    }
}

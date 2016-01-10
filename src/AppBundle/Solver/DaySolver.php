<?php

namespace AppBundle\Solver;

class DaySolver
{
    protected $input;

    public function __construct($dayNo)
    {
        $this->input = $this->getInput($dayNo);
    }

    private function getInput($dayNo)
    {
        $input_path = __DIR__ . "/../../../app/Resources/input/day{$dayNo}_input.txt";

        if (file_exists($input_path)) {
            return file($input_path);
        } else {
            return '';
        }
    }
}

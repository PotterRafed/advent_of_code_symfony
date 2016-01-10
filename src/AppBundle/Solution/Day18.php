<?php

namespace AppBundle\Solution;

use AppBundle\Solver\AdventSolverInterface;
use AppBundle\Solver\DaySolver;

class Day18 extends DaySolver implements AdventSolverInterface
{
    private $lights = [];

    public function getSolution1()
    {
        $row = 0;
        foreach ($this->input as $line) {
            $this->parseLine($line, $row);
            $row++;
        }

        $animation_times = 100;
        $new_lights = $this->changeLights($this->lights);
        for ($i=1; $i < $animation_times; $i++) {
            $new_lights = $this->changeLights($new_lights);
        }

        $result = $this->countOn($new_lights);

        echo "{$result} lights are on after animating the lights {$animation_times} times<Br>";
    }

    public function getSolution2()
    {
        if (empty($this->lights)) {
            $row = 0;
            foreach ($this->input as $line) {
                $this->parseLine($line, $row);
                $row++;
            }
        }

        $this->turnOnCorners($this->lights);
    
        $animation_times = 100;
        $new_lights = $this->changeLights($this->lights, true);
        for ($i=1; $i < $animation_times; $i++) {
            $new_lights = $this->changeLights($new_lights, true);
        }

        $result = $this->countOn($new_lights);

        echo "If corner lights are broken and always stay on {$result} lights are ON after animating the lights {$animation_times} times";
    }

    private function turnOnCorners(&$lights)
    {
        //Every corner's light always stay ON
        $max_rows = count($lights) - 1;
        $max_cols = count($lights[0]) - 1;

        $lights[0][0] = true;
        $lights[0][$max_cols] = true;
        $lights[$max_rows][$max_cols] = true;
        $lights[$max_rows][0] = true;
    }


    private function countOn($lights)
    {
        $on = 0;
        foreach ($lights as $row => $row_lights) {
            foreach ($row_lights as $col => $signal) {
                if ($signal == true) {
                    $on++;
                }
            }
        }
        return $on;
    }

    private function changeLights($prev_lights, $sol2 = false)
    {
        $new_lights = [];

        foreach ($prev_lights as $row => $row_lights) {
            foreach ($row_lights as $col => $signal) {
                $new_lights[$row][$col] = $this->getNextSignal($row, $col, $signal, $prev_lights, $sol2);
            }
        }
        return $new_lights;
    }

    private function getNextSignal($row, $col, $current_signal, $prev_lights, $sol2)
    {
        if ($sol2 == true) {
            //Every corner's light alway stay ON
            $max_rows = count($prev_lights) - 1;
            $max_cols = count($prev_lights[0]) - 1;

            if (($row == 0 && $col == 0)
                || ($row == 0 && $col == $max_cols)
                || ($row == $max_rows && $col == $max_cols)
                || ($row == $max_rows && $col == 0)
            ) {
                return true;
            }

        }
        $neighs_on = $this->getNeighboursOn($row, $col, $prev_lights);

        $next_signal = '';
        if ($current_signal == true) {
            if ($neighs_on == 2 || $neighs_on == 3) {
                $next_signal = true;
            } else {
                $next_signal = false;
            }
        } else {
            if ($neighs_on == 3) {
                $next_signal = true;
            } else {
                $next_signal = false;
            }
        }
        return $next_signal;
    }

    private function getNeighboursOn($row, $col, $prev_lights)
    {
        $neghs_on = 0;
        $neighs = $this->getNeighbours($row, $col);

        foreach ($neighs as $neigh) {
            $n_row = $neigh['row'];
            $n_col = $neigh['col'];
            if (isset($prev_lights[$n_row][$n_col]) && $prev_lights[$n_row][$n_col] == true) {
                $neghs_on++;
            }
        }
        return $neghs_on;
    }

    private function getNeighbours($row, $col)
    {
        return [
            ['row' => $row-1, 'col' => $col -1],
            ['row' => $row-1, 'col' => $col],
            ['row' => $row-1, 'col' => $col + 1],
            ['row' => $row, 'col' => $col - 1],
            ['row' => $row, 'col' => $col + 1],
            ['row' => $row+1, 'col' => $col - 1],
            ['row' => $row+1, 'col' => $col],
            ['row' => $row+1, 'col' => $col + 1]
        ];
    }

    private function parseLine($line, $row)
    {
        $col = 0;
        for ($i = 0; $i < strlen($line); $i++) {
            if ($line[$i] == "#") {
                $this->lights[$row][$col] = true;
            } elseif ($line[$i] == ".") {
                $this->lights[$row][$col] = false;
            }
            $col++;
        }
    }

}
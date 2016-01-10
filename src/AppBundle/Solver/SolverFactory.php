<?php

namespace AppBundle\Solver;

class SolverFactory
{
    protected $entity;

    public function create($dayNo)
    {
        $class = "\\AppBundle\\Solution\\Day". $dayNo;
        if (class_exists($class)) {
            $this->entity = new $class($dayNo);
        } else {
            throw new \Exception("No class found called {$class}");
        }
        return $this->entity;
    }
}

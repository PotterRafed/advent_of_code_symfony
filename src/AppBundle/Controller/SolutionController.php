<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Solver\SolverFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SolutionController
 * @package AppBundle\Controller
 */
class SolutionController extends Controller
{
    /**
     * @Route("/day/{day}", name="day_number")
     *
     * @param $day int - the day for the solution
     */
    public function dayAction($day)
    {
        $factory = new SolverFactory();
        $daySolver = $factory->create($day);

        $daySolver->getSolution1();
        $daySolver->getSolution2();

        exit();
    }
}

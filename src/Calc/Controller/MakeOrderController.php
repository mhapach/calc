<?php namespace Calc\Controller;

use Calc\Core\Controllers\BaseController;
use Calc\Repo\CalculationRepo;

class MakeOrderController extends BaseController
{
    protected $repositoryClassName = 'Calc\Repo\CalculationRepo';

    /**
     * @var CalculationRepo
     */
    protected $repository;

    public function show($id)
    {
        $data = $this->repository->calculateForClient($id);

        return view('calc::orders.order', $data);
    }
}

<?php namespace Calc\Controller;

use Calc\Model\Calculation;
use Calc\Core\Controllers\BaseController;

class OrdersController extends BaseController
{
    /**
     * @var string
     */
    protected $repositoryClassName = 'Calc\Repo\OrderRepo';
    /**
     * @var \Calc\Repo\OrderRepo
     */
    protected $repository;

    /**
     * Список заказов / подрядов
     */
    public function index()
    {
        $this->title->prepend(trans('calc::titles.orders'));
        $this->layout->content = view('calc::orders.index');
    }

    /**
     * Вывод информации о заказе / подряде
     *
     * @param int $id ID Заказа
     */
    public function show($id)
    {
        $obj = $this->repository->findWithAllRelations($id);

        $this->title->prepend(trans('calc::titles.orders'));
        $this->title->prepend($obj->title);
        $this->layout->content = view('calc::orders.show')->with('obj', $obj);
    }

    /**
     * Вывод информации о заказе / подряде
     *
     * @param int $id ID Заказа
     */
    public function edit($id)
    {
        /** @var \Calc\Model\Calculation $obj */
        $obj = Calculation::with([
            'client',
            'incomes' => function ($q) { $q->orderBy('date', 'asc'); },
            'orders.contractor',
            'orders.subject',
            'orders.files',
            'orders.contractorOutlay' => function ($q) { $q->orderBy('date', 'asc'); },
            'orders.constructorOutlay' => function ($q) { $q->orderBy('date', 'asc'); },
        ])->findOrFail($id);

        $this->title->prepend(trans('calc::titles.orders'));
        $this->title->prepend($obj->title);
        $this->layout->content = view('calc::orders.edit')->with('obj', $obj);
    }
}

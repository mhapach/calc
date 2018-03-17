<?php namespace Calc\Controller\Api;

use Input;
use Response;
use Validator;
use Calc\Model\Order;
use Calc\Validators\OrderValidator;
use Calc\Model\ContractorOutlay;
use Calc\Model\ConstructorOutlay;

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
     *
     * @return Response
     */
    public function index()
    {
        /** @var \Illuminate\Database\Query\Builder $q */
        $q = Order::whereHas('calculation', function ($q) {
            $q->own();
        })->with([
            'calculation.incomes' => function ($q) { $q->orderBy('date', 'desc'); },
            'calculation.manager',
            'calculation.client',
            'contractor',
            'subject',
            'contractorOutlay' => function ($q) { $q->orderBy('date', 'desc'); },
            'constructorOutlay' => function ($q) { $q->orderBy('date', 'desc'); },
        ]);

        $q->sort(Input::get('sort', 'calculation_id'), Input::get('order'));
        $q->status(Input::get('status'));

        $paginator = $q->paginate((int) Input::get('rows', 10));

        $orders = $paginator->getItems();

        // Для объединения ячеек по индексам
        $indexes = [];
        foreach ($orders as $i => $o)
        {
            $indexes[$o->calculation_id][] = $i;
        }

        foreach ($indexes as $i => $k)
        {
            sort($k);

            if ( ! isRange($k)) unset($indexes[$i]);
        }

        return $this->response->data([
            'total'   => $paginator->getTotal(),
            'rows'    => $orders,
            'indexes' => array_values($indexes)
        ]);
    }

    /**
     * Получение заказа
     * GET /api/orders/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Сохранение заказа
     * PUT /api/orders/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $data = Input::all();

        /** @var Order $obj */
        $obj = $this->repository->find($id);

        if ($data['status'] > 4 && $obj->status < $data['status'])
        {
            $obj->status = $data['status'];
        }

        $validator = new OrderValidator($data, 'update');

        if ( ! $validator->passes())
        {
            return $this->response->error(trans('calc::messages.fix_errors'))->data([
                'errors'  => $validator->getErrors()
            ]);
        }

        $obj->fill($data);

        if ( ! $obj->save())
        {
            return $this->response->message(
                trans('calc::order.update_error', ['name' => $obj->title])
            );
        }

        return $this->response->message(trans('calc::order.updated'))->data([
            'redirect' => action('OrdersController@edit', ['id' => $obj->id])
        ]);
    }

    /**
     * Удаление заказа / подряда
     * DELETE /api/orders/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Order $obj */
        $obj = $this->repository->find($id);

        if ( ! $obj->delete())
        {
            return $this->response->message(
                trans('calc::order.delete_error', ['name' => $obj->title])
            );
        }

        return $this->response->message(
            trans('calc::order.deleted', ['name' => $obj->title])
        );
    }

    /**
     * Создание оплаты
     *
     * @return \Calc\Helpers\Response
     */
    public function createOutlay($id, $type)
    {
        /** @var array $data */
        $data = Input::all();

        $validator = Validator::make($data, [
            'date'  => 'required|date_format:d.m.Y',
            'value' => 'required|numeric',
        ]);

        if ( ! $validator->passes())
        {
            return $this->response->error(trans('calc::payment.date_or_value_invalid'));
        }

        /** @var \Calc\Model\Outlay $obj */
        switch ($type)
        {
            case 'contractor_outlay': $obj = new ContractorOutlay;
                break;
            case 'constructor_outlay': $obj = new ConstructorOutlay;
                break;
        }

        $obj->date = $data['date'];
        $obj->value = $data['value'];
        $obj->order = $id;

        $obj->save();

        return $this->response->message(trans('calc::payment.created'))->data([
            'outlay' => $obj
        ]);
    }

    /**
     * @param  int  $id
     * @return Response
     */
    public function destroyOutlay($id, $type)
    {
        /** @var \Calc\Model\Outlay $obj */
        switch ($type)
        {
            case 'contractor_outlay': $obj = ContractorOutlay::findOrFail($id);
                break;
            case 'constructor_outlay': $obj = ConstructorOutlay::findOrFail($id);
                break;
        }

        if ( ! $obj->delete())
        {
            return $this->response->error(trans('calc::payment.delete_error'));
        }

        return $this->response->message(trans('calc::payment.deleted'));
    }

    public function updateFromOrders($id)
    {
        /** @var Order $obj */
        $obj = Order::findOrFail($id);

        $data = Input::all();

        $validator = new OrderValidator($data, 'update');

        if ( ! $validator->passes())
        {
            return $this->response->error(trans('calc::order.update_error'))
                ->errors($validator->getErrors(':message<br>'));
        }

        $obj->called_at = array_get($data, 'called_at');
        $obj->next_call_at = array_get($data, 'next_call_at');
        $obj->status = array_get($data, 'status');
        $obj->contractor = array_get($data, 'contractor');
        $obj->description = array_get($data, 'description');
        $obj->constructor_name = array_get($data, 'constructor_name');
        $obj->designer_name = array_get($data, 'designer_name');
        $obj->installer_name = array_get($data, 'installer_name');

        if ( ! $obj->save())
        {
            return $this->response->error(trans('calc::order.update_error'));
        }

        return $this->response->message(trans('calc::order.updated'));
    }
}

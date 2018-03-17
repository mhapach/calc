<?php namespace Calc\Controller\Api;

use App;
use Calc\Model\Calculation;
use Calc\Model\CalculationSubject;
use Calc\Model\Income;
use Calc\Model\SubjectElement;
use Illuminate\Support\MessageBag;
use Input;
use Response;
use Validator;

class CalculationsController extends BaseController
{
    const MODAL_ID = '#calculation_modal';
    const FORM_ID = '#calculation_form';

    protected $repositoryClassName = 'Calc\Repo\CalculationRepo';
    /**
     * @var \Calc\Repo\CalculationSubjectRepo;
     */
    protected $subjectsRepo;
    /**
     * @var \Calc\Repo\SubjectElementRepo;
     */
    protected $elementsRepo;
    /**
     * @var \Calc\Repo\CalculationRepo
     */
    protected $repository;

    function __construct()
    {
        parent::__construct();

        $this->subjectsRepo = App::make('Calc\Repo\CalculationSubjectRepo');
        $this->elementsRepo = App::make('Calc\Repo\SubjectElementRepo');
    }

    /**
     * Список расчетов
     *
     * @return Response
     */
    public function index()
    {
        $paginator = $this->repository->paginate(Input::all());

        return $this->response->data([
            'total' => $paginator->getTotal(),
            'rows' => $paginator->getItems(),
        ]);
    }

    /**
     * Получение расчета по ID
     *
     * @param int $id
     *
     * @return null|string
     */
    public function show($id)
    {
        /** @var Calculation $obj */
        $obj = $this->repository->query()->with([
            'client', 'manager', 'subjects.elements.parts', 'files',
        ])->own()->find($id);

        if ($obj && ! $obj->canEdit())
        {
            return '{}';
        }

        return $obj ?: '{}';
    }

    /**
     * Создание расчета
     *
     * @return \Calc\Helpers\Response
     */
    public function create()
    {
        /** @var array $data */
        $data = Input::all();

        if (empty($data['additional_coefficient']))
        {
            return $this->response->error('Выберите поправочный коэффициент');
        }

        if ( ! isset($data['subjects']) || ! is_array($data['subjects']) || ! $data['subjects'])
        {
            return $this->response->error('Добавьте хотя бы 1 предмет');
        }

        $errors = new MessageBag();

        foreach ($data['subjects'] as $v)
        {
            if ( ! isset($v['elements']) || ! is_array($v['elements']) || ! $v['elements'])
            {
                $errors->add('elements', "Добавьте хотя бы 1 элемент к Предмету № {$v['i']}");
            }
            else
            {
                if (isset($v['elements']) && is_array($v['elements']))
                {
                    foreach ($v['elements'] as $e)
                    {
                        if ( ! isset($e['i']))
                        {
                            continue;
                        }

                        if ( ! isset($e['character']))
                        {
                            $errors->add('elements', 'Укажите признак элемента № ' . $e['i'] . ' у Предмета № ' . $v['i']);
                        }

                        if ( ! isset($e['part']['id']))
                        {
                            $errors->add('elements', 'Выберите материал элемента № ' . $e['i'] . ' у Предмета № ' . $v['i']);
                        }

                        if ( ! isset($e['total']) || $e['total'] < 1)
                        {
                            $errors->add('elements', 'Укажите кол-во у элемента № ' . $e['i'] . ' у Предмета № ' . $v['i']);
                        }
                    }
                }
            }

            if ( ! isset($v['num']) || $v['num'] < 1)
            {
                $errors->add('num', "Укажите кол-во у Предмета № {$v['i']}");
            }
        }

        if ( ! $errors->isEmpty())
        {
            return $this->response->error($errors->all(':message<br>'));
        }

        /** @var Calculation $obj */
        if ( ! $obj = $this->repository->create($data))
        {
            return $this->response->error('Ошибка сохранения расчета');
        }

        foreach ($data['subjects'] as $s)
        {
            $subject = $this->subjectsRepo->createForParent($obj, $s);

            foreach ($s['elements'] as $e)
            {
                $this->elementsRepo->createForParent($subject, $e);
            }
        }

        return $this->response->message('Расчет успешно сохранен')->data([
            'redirect' => action('CalculationController@edit', ['id' => $obj->id]),
        ]);
    }

    /**
     * Обновление расчета
     *
     * @param int $id ID расчета
     *
     * @return \Calc\Helpers\Response
     *
     * @throws \Exception
     */
    public function update($id)
    {
        /** @var Calculation $obj */
        $obj = $this->repository->findOwn($id);

        /** @var array $data */
        $data = Input::all();

        if ( ! $obj->canEdit())
        {
            if (isset($data['status']) && $data['status'] > 5 && $obj->status < $data['status'])
            {
                $obj->status = $data['status'];
            }

            if ( ! empty($data['description']))
            {
                $obj->description = $data['description'];
            }

            if ($obj->isDirty())
            {
                $obj->save();

                return $this->response->message(trans('calc::calc.updated'))->data([
                    'redirect' => action('CalculationController@edit', ['id' => $obj->id]),
                ]);
            }

            return $this->response->error(trans('calc::calc.not_editable'));
        }

        if ( ! isset($data['subjects']) || ! is_array($data['subjects']) || ! $data['subjects'])
        {
            return $this->response->error('Добавьте хотя бы 1 предмет');
        }

        $errors = new MessageBag();

        foreach ($data['subjects'] as $v)
        {
            if ( ! isset($v['i']))
            {
                continue;
            }

            if ( ! isset($v['elements']) || ! is_array($v['elements']) || ! $v['elements'])
            {
                $errors->add('elements', "Добавьте хотя бы 1 элемент к Предмету № {$v['i']}");
            }
            else
            {
                if (isset($v['elements']) && is_array($v['elements']))
                {
                    foreach ($v['elements'] as $e)
                    {
                        if ( ! isset($e['i']))
                        {
                            continue;
                        }

                        if ( ! isset($e['character']))
                        {
                            $errors->add('elements', 'Укажите признак элемента № ' . $e['i'] . ' у Предмета № ' . $v['i']);
                        }

                        if ( ! isset($e['part']['id']))
                        {
                            $errors->add('elements', 'Выберите материал элемента № ' . $e['i'] . ' у Предмета № ' . $v['i']);
                        }

                        if ( ! isset($e['total']) || $e['total'] < 1)
                        {
                            $errors->add('elements', 'Укажите кол-во у элемента № ' . $e['i'] . ' у Предмета № ' . $v['i']);
                        }
                    }
                }
            }

            if ( ! isset($v['num']) || ! $v['num'] < 1)
            {
                $errors->add('num', "Укажите кол-во у Предмета № {$v['i']}");
            }
        }

        if ( ! $obj = $this->repository->updateWithRelations($id, $data))
        {
            return $this->response->error(trans('calc::calc.update_error'));
        }

        list($subjectsMap, $elementsMap) = $this->repository->generateSubjectsMap($data['subjects']);

        /** @var CalculationSubject $s */
        foreach ($obj->subjects as $s)
        {
            // Если предмета нет в карте предметов на обновление удаляем его
            if ( ! isset($subjectsMap['update'][$s->id]))
            {
                $s->delete();
            }
            else
            {
                $s->fill($subjectsMap['update'][$s->id]);
                $s->save();

                /** @var SubjectElement $e */
                foreach ($s->elements as $e)
                {
                    // Если элемента предмета нет в карте элементов на обновление удаляем его
                    if ( ! isset($elementsMap['update'][$s->id][$e->id]))
                    {
                        $e->delete();
                    }
                    else
                    {
                        $e->fill($elementsMap['update'][$s->id][$e->id]);
                        $e->save();
                    }
                }

                if (isset($elementsMap['create'][$s->id]))
                {
                    foreach ($elementsMap['create'][$s->id] as $e)
                    {
                        $this->elementsRepo->createForParent($s, $e);
                    }
                }
            }
        }

        foreach ($subjectsMap['create'] as $s)
        {
            $subject = $this->subjectsRepo->createForParent($obj, $s);

            foreach ($s['elements'] as $e)
            {
                $this->elementsRepo->createForParent($subject, $e);
            }
        }

        if ($obj::MAKE_ORDERS_STATUS == $obj->status)
        {
            $this->repository->makeOrders($obj->id);
        }

        return $this->response->message(trans('calc::calc.updated'))->data([
            'redirect' => action('CalculationController@edit', ['id' => $obj->id]),
        ]);
    }

    /**
     * Клонирование расчета со всеми предметами и элементами
     *
     * @param int $id ID исходного расчета
     *
     * @return \Calc\Helpers\Response
     */
    public function duplicate($id)
    {
        if ( ! $obj = $this->repository->duplicate($id))
        {
            return $this->response->error(trans('calc::calc.duplicate_error'));
        }

        return $this->response->message(trans('calc::calc.duplicated'))->data([
            'redirect' => action('CalculationController@edit', ['id' => $obj->id]),
        ]);
    }

    /**
     * Удаление расчета
     * DELETE /api/calculation/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Calculation $obj */
        $obj = Calculation::findOrFail($id);

        if ($obj->orders()->count())
        {
            return $this->response->error('Нельзя удалить расчет т.к. с ним связаны заказы');
        }

        if ( ! $obj->delete())
        {
            return $this->response->error("Ошибка удаления расчета \"{$obj->title}\"");
        }

        return $this->response->message("Расчет \"{$obj->title}\" успешно удален");
    }

    /**
     * Создание оплаты
     *
     * @return \Calc\Helpers\Response
     */
    public function createIncome($id)
    {
        /** @var array $data */
        $data = Input::all();

        $validator = Validator::make($data, [
            'date' => 'required|date_format:d.m.Y',
            'value' => 'required|numeric',
        ]);

        if ( ! $validator->passes())
        {
            return $this->response->error('Неверный формат даты и/или суммы');
        }

        $obj = new Income;
        $obj->date = $data['date'];
        $obj->value = $data['value'];
        $obj->calculation = $id;

        $obj->save();

        return $this->response->message('Оплата добавлена')->data([
            'income' => $obj,
        ]);
    }

    /**
     * @param  int $id
     *
     * @return Response
     */
    public function destroyIncome($id)
    {
        /** @var Income $obj */
        $obj = Income::findOrFail($id);

        if ( ! $obj->delete())
        {
            return $this->response->error("Ошибка удаления оплаты");
        }

        return $this->response->message("Оплата удалена");
    }

    public function updateFromOrders($id)
    {
        /** @var Calculation $obj */
        $obj = $this->repository->find($id);

        $data = Input::all();

        $validator = Validator::make($data, [
            'delivery_at' => 'date_format:d.m.Y',
            'install_at' => 'date_format:d.m.Y',
        ]);

        if ( ! $validator->passes())
        {
            return $this->response->error('Неверный формат даты доставки или установки');
        }

        $obj->delivery_at = array_get($data, 'delivery_at');
        $obj->delivery_address = array_get($data, 'delivery_address');
        $obj->install_at = array_get($data, 'install_at');
        $obj->install_address = array_get($data, 'install_address');
        $obj->description = array_get($data, 'description');

        if ( ! $obj->save())
        {
            return $this->response->error('Ошибка сохранения заказа');
        }

        return $this->response->message('Заказ сохранен');
    }
}

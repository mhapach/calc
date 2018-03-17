<?php namespace Calc\Controller;

use Response;
use Calc\Helpers\Elements;
use Calc\Model\Calculation;
use Calc\Model\Variable;
use Calc\Core\Controllers\BaseController;

class CalculationController extends BaseController
{
    public function index()
    {
        $this->title->prepend(trans('calc::titles.calculations'));
        $this->layout->content = view('calc::calculations.index')->with([
            'discount' => Variable::find('discount')
        ]);
    }

    public function create()
    {
        $this->title->prepend(trans('calc::titles.calculation_create'));
        $this->layout->content = view('calc::calculations.create')
            ->with('obj', new Calculation)
            ->with('elements', new Elements);
    }

    public function edit($id)
    {
        /** @var Calculation $obj */
        $obj = Calculation::with([
            'client',
            'subjects.elements.part',
            'subjects.constructorRate',
            'files'
        ])->findOrFail($id);

        $this->title->prepend(trans('calc::titles.calculation_edit'));
        $this->layout->content = view('calc::calculations.create')
            ->with('obj', $obj)
            ->with('elements', new Elements);

        return Response::make($this->layout, 200, [
            'Pragma'        => 'no-cache',
            'Expires'       => 'Thu, 19 Nov 1981 08:52:00 GMT',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0'
        ]);
    }

    public function show($id)
    {
        $obj = Calculation::findOrFail($id);

        $this->title->prepend(trans('calc::titles.calculation'));
        $this->title->prepend($obj->title);
        $this->layout->content = view('calc::calculations.show')->with('obj', $obj);
    }
}

<?php namespace Calc\Controller;

use Calc\Model\Client;
use Calc\Core\Controllers\BaseController;

class ClientsController extends BaseController
{
    function __construct()
    {
        parent::__construct();
        $this->title->prepend(trans('calc::titles.clients'));
    }

    public function index()
    {
        $this->layout->content = view('calc::clients.index');
    }

    public function show($id)
    {
        /** @var Client $obj */
        $obj = Client::findOrFail($id);
        $this->title->prepend($obj->present()->fullName);
        $this->layout->content = view('calc::clients.show')->with('obj', $obj);
    }
}

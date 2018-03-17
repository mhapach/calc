@section('content')
<h1>
    <span class="glyphicon glyphicon-th-large"></span> @lang('calc::titles.parts')
    @if ($user->isAdmin())
    <button type="button" class="btn btn-success pull-right" onclick="App.part.create()"><span class="glyphicon glyphicon-plus"></span> Добавить материал или комплектующее</button>
    @endif
</h1>

<div class="row">
    @if ($user->isAdmin())
    <div class="col-md-12">
        {{ HTML::variable('margin') }}
    </div>
    @endif
</div>

<div id="toolbar" class="toolbar">
    Группа <input id="group" type="text" />
    <input id="search" type="text" style="width:250px"/>
</div>
<table id="parts"></table>
@stop
@section('scripts')
<script src="/static/js/src/parts.js"></script>
@stop

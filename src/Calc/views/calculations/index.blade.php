@section('content')
<h1>
    <span class="glyphicon glyphicon-list-alt"></span> @lang('calc::titles.calculations')
    <a href="/calculation/create" class="btn btn-success pull-right"><span class="glyphicon glyphicon-plus"></span> Создать новый расчет</a>
</h1>

@if ($user->isAdmin())
<div class="row">
    <div class="col-md-12">
        {{ HTML::variable('discount') }}
    </div>
</div>
@endif
<div id="toolbar" class="toolbar">
    Статус <input type="text" id="status"/>
    Менеджер <input type="text" id="manager"/>
    <input type="text" id="search" style="width: 250px"/>
</div>

<table id="calculations"></table>
@stop
@section('scripts')
<script src="/static/js/src/calculations.js"></script>
@stop

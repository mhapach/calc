@section('content')
<h1>
    <span class="glyphicon glyphicon-tower"></span> @lang('calc::titles.contractors')
    <button type="button" class="btn btn-success pull-right" onclick="App.contractor.create()"><span class="glyphicon glyphicon-plus"></span> Добавить подрядчика</button>
</h1>

<div id="toolbar" class="toolbar">
    Статус <input type="text" id="status"/>
    <input type="text" id="search" style="width: 250px"/>
</div>

<table id="contractors"></table>
@stop
@section('scripts')
<script src="/static/js/src/contractors.js"></script>
@stop

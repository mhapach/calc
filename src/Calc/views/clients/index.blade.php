@section('content')
<h1>
    <span class="glyphicon glyphicon-user"></span> @lang('calc::titles.clients')
    <button type="button" class="btn btn-success pull-right" onclick="App.client.create()"><span class="glyphicon glyphicon-plus"></span> Добавить заказчика</button>
</h1>
<div id="toolbar" class="toolbar">
    Статус <input type="text" id="status"/>
    Тип <input type="text" id="type"/>
    Менеджер <input type="text" id="manager"/>
    <input type="text" id="search" style="width: 250px"/>
</div>
<table id="clients"></table>
@stop
@section('scripts')
<script src="/static/js/src/clients.js"></script>
@stop

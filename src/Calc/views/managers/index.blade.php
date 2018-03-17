@section('content')
<h1>
    <span class="glyphicon glyphicon-user"></span> @lang('calc::titles.managers')
    <button type="button" class="btn btn-success pull-right" onclick="App.user.create()"><span class="glyphicon glyphicon-plus"></span> Добавить менеджера</button>
</h1>
<div id="toolbar" class="toolbar">
    Роль <input type="text" id="role"/>
    Статус <input type="text" id="status"/>
</div>
<table id="managers"></table>
@stop
@section('scripts')
<script src="/static/js/src/managers.js"></script>
@stop

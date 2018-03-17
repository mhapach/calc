@section('content')
<h1><span class="glyphicon glyphicon-briefcase"></span> @lang('calc::titles.orders')</h1>

<div id="toolbar" class="toolbar">
    <span>
        Статус <input type="text" value="" name="status" id="status"/>
    </span>
</div>

<table id="orders"></table>
@stop
@section('scripts')
<script src="/static/js/src/orders.js"></script>
<style>
.datagrid-row-over, .datagrid-row-selected {
    background-color: #fff;
    color: #000;
}
</style>
@stop

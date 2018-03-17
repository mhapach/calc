@section('content')
<h1>Редактирование заказа / подряда</h1>

<div id="calculation" ng-app="Calc">
    <div ng-controller="OrdersCtrl as calc">
    <div class="calc">
    <h3 class="title">
        <span>Заказ # <span ng-bind="::calc.model.id"></span>: <span ng-bind="::calc.model.title"></span></span>
    </h3>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-6">
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Заказчик</label>
                    <div class="col-sm-8">
                        <input disabled type="text" class="form-control" ng-value="calc.model.client.last_name + ' ' + calc.model.client.first_name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"></label>
                    <div class="col-sm-8">
                        <input disabled type="text" class="form-control" ng-value="calc.model.client.email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"></label>
                    <div class="col-sm-8">
                        <input disabled type="text" class="form-control" ng-value="calc.model.client.phone">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Краткое описание</label>
                    <div class="col-sm-8">
                        <textarea rows="4" class="form-control" ng-model="calc.model.description"></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
        </div>
        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
            <div class="table-title"><span>Оплаты от заказчика</span></div>
            <table class="table table-striped table-hover table-condensed">
                <thead>
                    <tr>
                        <th>Дата</th> <th>Сумма</th> <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="inc in calc.model.incomes">
                        <td ng-bind="::inc.date"></td>
                        <td ng-bind="::inc.value | roundPrice"></td>
                        <td><button type="button" class="btn btn-link btn-xs" ng-click="calc.removeIncome(inc)"><span class="glyphicon glyphicon-remove"></span></button></td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-sm-6">
                    <input type="text" class="form-control datepicker input-sm" placeholder="Дата" ng-model="calc.income.date"/>
                </div>
                <div class="col-sm-3">
                    <input type="text" class="form-control text-center input-sm" placeholder="Сумма" ng-model="calc.income.value"/>
                </div>
                <div class="col-sm-3">
                    <button ng-click="calc.addIncome()" class="btn btn-primary btn-sm">Добавить</button>
                </div>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Дата доставка</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control datepicker" ng-model="calc.model.delivery_at">
                    </div>
                </div>
                <div class="form-group">
                <label class="col-sm-4 control-label">Адрес доставки</label>
                    <div class="col-sm-8">
                        <textarea rows="4" class="form-control" ng-model="calc.model.delivery_address"></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Дата установки</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control datepicker" ng-model="calc.model.install_at">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Адрес установки</label>
                    <div class="col-sm-8">
                        <textarea rows="4" class="form-control" ng-model="calc.model.install_address"></textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <button ng-click="calc.saveCalculation()" class="btn btn-success btn-lg">Сохранить</button>
        </div>
    </div>
    </div>

    <div class="orders">
        @include('calc::orders.parts.order')
    </div>
    </div>
</div>
@stop
@section('scripts')
<script src="/static/vendor/angular/angular.min.js"></script>
<script src="/static/vendor/select2/select2.min.js"></script>
<script src="/static/vendor/select2/select2_locale_ru.js"></script>
<script src="/static/vendor/select2/select2-ng.js"></script>
<script src="/static/vendor/angular/angular-file-upload.min.js"></script>
<script type="text/javascript">
    var obj = {{ $obj }};
    var helpers = {};

    $(document).ready(function() {
        $('.datepicker').datetimepicker();
    })
</script>
<script src="/static/js/app/app.js"></script>
<script src="/static/js/app/controllers/OrderController.js"></script>
<script src="/static/js/app/filters/MainFilters.js"></script>
<script src="/static/js/app/services/NotifyService.js"></script>
<style>
    .dimension_cell {
        text-align: center;
        display: inline-block;
        width: 31%;
    }
    .order, .calc {
        margin-bottom: 40px;
        padding: 20px 10px;
        box-shadow: 0 1px 5px #BBB;
    }
    h3.title {
        margin-bottom: 40px;
        margin-top: 10px;
        padding: 0 20px;
    }
    h3.title > span:first-child {
        display: inline-block;
        max-width: 60%;
    }
    h3.title > span {
        border-bottom: 1px solid #AAA;
        padding: 0 2px 5px;
    }
    h3.title > span.price {
        font-size: 0.6em;
        padding: 0;
        line-height: 1.6em;
    }
    .table-title > span {
        border-bottom: 1px solid #aaa;
        padding-bottom: 2px;
    }
    .table-title {
        text-align: center;
        font-weight: bold;
        margin-bottom: 10px;
    }
</style>
@stop

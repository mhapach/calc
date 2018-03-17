(function () {
  'use strict';
  /**
   * @class OrdersController
   * @classdesc Order Controller
   * @ngInject
   */
  function OrdersController($scope, $http, FileUploader, Notify) {
    var self = this;

    this.CONSTRUCTOR = 'constructor_outlay';
    this.CONTRACTOR = 'contractor_outlay';

    this.$scope = $scope;
    this.$http = $http;
    this.notify = Notify;
    // Загрузка файлов
    this.uploader = new FileUploader({
      url: '/api/files/upload/order/',
      removeAfterUpload: true,
      autoUpload: true,
      onBeforeUploadItem: function (item) {
        item.url += item.order.id;
      },
      onCompleteItem: function (file, response) {
        self.notify.notice(response.message, false, response.error ? 'error' : 'success');

        if (!response.error && response.file) {
          self.addFile(file.order, response.file)
        }
      }
    });

    this.select2 = {
      default: {},
      status: {},
      contractor: {
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
          url: '/api/contractors-list',
          dataType: 'json',
          cache: true,
          quietMillis: 200,
          data: function (term) {
            return {term: term}
          },
          results: function (data) {
            return {results: data}
          }
        },
        formatResult: formatContractorName,
        formatSelection: formatContractorName,
        initSelection: function () {
        }
      }
    };

    function formatContractorName(state) {
      return state.title + ' (' + state.last_name + ' ' + state.first_name + ')'
    }

    // Расчет
    this.model = {};
    this.outlay = {};
    this.outlay[this.CONTRACTOR] = {};
    this.outlay[this.CONSTRUCTOR] = {};

    this.fillModel(obj);

    this.income = {
      data: '',
      value: ''
    };
  }

  OrdersController.prototype.getModelId = function () {
    return this.model.id
  };

  /**
   * Заполнение модели данными
   *
   * @param data
   */
  OrdersController.prototype.fillModel = function (data) {
    var self = this;
    var model = this.model;

    angular.extend(model, data);

    angular.forEach(model.orders, function (value, key) {
      self.outlay[self.CONTRACTOR][value.id] = {
        date: '',
        value: ''
      };

      self.outlay[self.CONSTRUCTOR][value.id] = {
        date: '',
        value: ''
      }
    });
  };

  /**
   * Отправка заказа на сервер
   *
   * @returns {boolean}
   */
  OrdersController.prototype.saveModel = function () {
    var self = this;
    var model = this.model;

    if (!this.validateModel()) {
      return false;
    }

    this.$http({
      method: 'PUT',
      data: model,
      url: '/api/orders/' + model.id
    }).success(function (response) {
      self.notify.notice(response.message, false, response.error ? 'error' : 'success');

      if (response.redirect) {
        window.location = response.redirect;
      }
    });
  };

  /**
   * Удаление файла
   */
  OrdersController.prototype.removeFile = function (order, file) {
    var self = this;

    if (!confirm('Удалить файл "' + file.name + '" навсегда?')) {
      return false;
    }

    this.$http({url: '/api/files/' + file.id, method: 'DELETE'})
      .success(function (response) {
        if (!response.error) {
          order.files.splice(order.files.indexOf(file), 1);
        }

        self.notify.notice(response.message, false, response.error ? 'error' : 'success');
      });

    return true;
  };

  OrdersController.prototype.addIncome = function () {
    var self = this;
    var model = this.model;
    var income = this.income;

    if (!income.date || !income.value) return false;

    this.$http({url: '/api/calculations/' + model.id + '/income', method: 'POST', data: income})
      .success(function (response) {
        if (!response.error && response.income) {
          model.incomes.push(response.income);
          income.date = '';
          income.value = '';
        }

        self.notify.notice(response.message, false, response.error ? 'error' : 'success');
      });
  };

  OrdersController.prototype.removeIncome = function (inc) {
    var self = this;
    var model = this.model;

    if (!confirm('Удалить оплату?')) return false;

    this.$http({url: '/api/calculations/income/' + inc.id, method: 'DELETE'})
      .success(function (response) {
        if (!response.error) {
          model.incomes.splice(model.incomes.indexOf(inc), 1);
        }

        self.notify.notice(response.message, false, response.error ? 'error' : 'success');
      });
  };

  OrdersController.prototype.addFile = function (order, file) {
    order.files.push({
      id: file.id,
      src: file.src,
      name: file.name
    });
  };

  OrdersController.prototype.saveCalculation = function () {
    var self = this;
    var model = this.model;

    this.$http({url: '/api/calculations/order/' + model.id, method: 'PUT', data: model})
      .success(function (response) {
        self.notify.notice(response.message, false, response.error ? 'error' : 'success');
      });
  };

  OrdersController.prototype.valudateOrder = function (order) {
    var errors = [];

    if (!order.contractor || !order.contractor.id) {
      errors.push('Выберите подрядчика')
    }

    if (!order.called_at) {
      errors.push('Укажите дату последнего звонка')
    }

    if (errors.length > 0) {
      this.notify.error(errors.join('\n'), 'Ошибка сохранения заказа / подряда');
      errors = [];
      return false;
    }

    return true;
  };

  OrdersController.prototype.saveOrder = function (order) {
    var self = this;

    if (!this.valudateOrder(order)) {
      return false;
    }

    this.$http({url: '/api/orders/' + order.id, method: 'PUT', data: order})
      .success(function (response) {
        if (response.error && response.errors) {
          self.notify.notice(response.errors.join(''), response.message, response.error ? 'error' : 'success');
        } else {
          self.notify.notice(response.message, false, response.error ? 'error' : 'success');
        }
      });
  };

  OrdersController.prototype.addOutlay = function (order, type) {
    var self = this;
    var outlay = this.outlay[type][order.id];

    if (!outlay.date || !outlay.value) return false;

    this.$http({url: '/api/orders/' + order.id + '/outlay/' + type, method: 'POST', data: outlay})
      .success(function (response) {
        if (!response.error && response.outlay) {
          order[type].push(response.outlay);
          outlay.date = '';
          outlay.value = '';
        }

        self.notify.notice(response.message, false, response.error ? 'error' : 'success');
      });
  };

  OrdersController.prototype.removeOutlay = function (order, outlay, type) {
    var self = this;

    if (!confirm('Удалить оплату?')) return false;

    this.$http({url: '/api/orders/outlay/' + outlay.id + '/' + type, method: 'DELETE'})
      .success(function (response) {
        if (!response.error) {
          order[type].splice(order[type].indexOf(outlay), 1);
        }

        self.notify.notice(response.message, false, response.error ? 'error' : 'success');
      });
  };

  OrdersController.$inject = ['$scope', '$http', 'FileUploader', 'Notify'];

  angular
    .module('Calc')
    .controller('OrdersCtrl', OrdersController);
})();

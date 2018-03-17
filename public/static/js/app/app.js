(function () {
  function config($httpProvider, $interpolateProvider) {
    $httpProvider
      .defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    $interpolateProvider
      .startSymbol('[[').endSymbol(']]');
  }

  config.$inject = ['$httpProvider', '$interpolateProvider'];

  angular
    .module('Calc', ['ui.select2', 'angularFileUpload', 'notifyService'])
    .config(config);
})();

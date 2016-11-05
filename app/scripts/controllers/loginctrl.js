'use strict';

/**
 * @ngdoc function
 * @name thecorrespondentApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the thecorrespondentApp
 */
angular.module('thebarraudsApp')
  .controller('LoginCtrl', ['$scope','$location','serverFactory', function($scope,$location,serverFactory) {
    $scope.invalid_user_cred = false;

    $scope.validateuser = function(){
      serverFactory.checkusercredentials($scope);
    };

    $scope.manageuserlogin = function(user_login_data){
      if (user_login_data.Length == 1){
        $scope.invalid_user_cred = false;
        $location.path('/fragments')

      }
      else{ //invalid user
        $scope.invalid_user_cred = true;
      }
    };


  }]);

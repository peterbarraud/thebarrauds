'use strict';

/**
 * @ngdoc function
 * @name thecorrespondentApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the thecorrespondentApp
 */
angular.module('thebarraudsApp')
  .controller('FragmentCtrl', ['$scope','serverFactory', function($scope,serverFactory) {
    $scope.pagepropertiesdata = null;
    $scope.listitemdata = null;

    $scope.pageavailable = function(){
      if ($scope.pagepropertiesdata === null){
        return false;
      }
      else {
        if ($scope.pagepropertiesdata.id > 0){
          return true;
        }
        else {
          return false;
        }
      }
    };
    $scope.deletepage = function(){
      $("#deletePagePrompt").modal('show');
    };
    $scope.deletepageconfirmed = function(){
      serverFactory.deletepage($scope.pagepropertiesdata.id,$scope,'pagedeleted');
    };
    $scope.pagedeleted = function(){
      $("#deletePagePrompt").modal('hide');
      $scope.pagelistdirective.pagelistupdated();
    };
    // this function is called after the page properties are changed in the page properties dialog
    $scope.pagepropertychanged = function(){
      $scope.pagelistdirective.pagelistupdated();
    };
    $scope.$watch('listitemdata', function(newValue) {
      if (newValue !== null){
        serverFactory.getitem(newValue.id,'page',$scope,'manageitemobject');
      }
    });
    $scope.manageitemobject = function(data){
      $scope.pagepropertiesdata = data;
    };
    $scope.newfragment = function(){
      // this will be used to position the fragement in the page
      $scope.fragementplace = {
        currentfragmentid: -1,
        // a: after
        // b: before
        relatedplacement: 'a',
      };
      $scope.addfragmentsdir.newfragment();
    };
    $scope.addfragmenttopage = function(selectedpagefragment){
      $scope.pagepropertiesdata.pagefragment.push(selectedpagefragment);
      // then save
      serverFactory.saveitemdetails($scope,$scope.pagepropertiesdata,"page","itemDetailsSaved");
    };
    $scope.itemDetailsSaved = function(data){
      console.log(data);
    };

  }]);

'use strict';

/**
 * @ngdoc directive
 * @name peterbdotin.directive:eventPod
 * @description
 * # eventPod
 */
angular.module('thebarraudsApp')
  .directive('pagepropertiesModal', function (serverFactory,util) {
    return {
      restrict: 'E',
      scope: {
        pagedata: '=',
        pagepropertiesdir: '=',
      },
      replace:true,
      templateUrl: 'views/pagepropertiesModal.html',
      // uncomment next line and remove following if you need the args
      // link: function(scope, elem, attrs) {
      link: function(scope) {
        serverFactory.getitems('pagetemplate',scope,'managepagetemplates');
        scope.managepagetemplates = function(data){
          scope.pagetemplates = data;
        };

        scope.pagepropertiesdir = {
          openpagepropertiesmodal: function(){
            scope.newpage();
          },
        };
        scope.newpage = function(){
          serverFactory.getitem(-1,'page',scope,'managenewitemobject');
        };
        scope.managenewitemobject = function(data){
          scope.pagedata = data;
          $("#newpageModal").modal('show');
        };

        scope.destroypagedata = function(){
          scope.pagedata = null;
        };
        scope.savepageproperties = function(){
          var allgood = true;
          if (util.isEmptyString(scope.pagedata.title)){
            scope.err_msg = "Page title cannot be empty";
            allgood = false;
          }
          if (scope.pagedata.pagetemplate.length !== 1){
            scope.err_msg = "You must select a Page template";
            allgood = false;
          }
          if (allgood){
            serverFactory.saveitemdetails(scope,scope.pagedata,"page","itemDetailsSaved");
          }
        };
        scope.itemDetailsSaved = function(data){
          console.log(data);
          $("#newpageModal").modal('hide');
        };
        scope.selectpagetemplate = function(pagetemplate){
          scope.pagedata.pagetemplate = [];
          scope.pagedata.pagetemplate.push(pagetemplate);
        };

      }
    };
  });

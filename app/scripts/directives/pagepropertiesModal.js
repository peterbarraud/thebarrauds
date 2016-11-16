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
        pagepropertiesdata: '=',
        pagepropertiesdir: '=',
        pagepropertychanged: '&',
      },
      replace:true,
      templateUrl: 'views/pagepropertiesModal.html',
      // uncomment next line and remove following if you need the args
      // link: function(scope, elem, attrs) {
      link: function(scope) {
        serverFactory.getitems('pagetemplate',scope,'managepagetemplates');
        scope.managepagetemplates = function(data){
          scope.pagetemplates = data.Items;
        };

        scope.pagepropertiesdir = {
          newpage: function(){
            serverFactory.getitem(-1,'page',scope,'managenewitemobject');
          },
          editpage: function(){
            $("#newpageModal").modal('show');
          }
        };
        scope.managenewitemobject = function(data){
          scope.pagepropertiesdata = data;
          $("#newpageModal").modal('show');
        };

        scope.destroypagedata = function(){
          scope.pagepropertiesdata = null;
        };
        scope.savepageproperties = function(){
          var allgood = true;
          if (util.isEmptyString(scope.pagepropertiesdata.title)){
            scope.err_msg = "Page title cannot be empty";
            allgood = false;
          }
          if (scope.pagepropertiesdata.pagetemplate.length !== 1){
            scope.err_msg = "You must select a Page template";
            allgood = false;
          }
          if (allgood){
            serverFactory.saveitemdetails(scope,scope.pagepropertiesdata,"page","itemDetailsSaved");
          }
        };
        scope.itemDetailsSaved = function(data){
          console.log(data);
          scope.pagepropertiesdata = data;
          $("#newpageModal").modal('hide');
          // call this controller event to handle when page property was changed
          scope.pagepropertychanged();
        };
        scope.selectpagetemplate = function(pagetemplate){
          scope.pagepropertiesdata.pagetemplate = [];
          scope.pagepropertiesdata.pagetemplate.push(pagetemplate);
        };

      }
    };
  });

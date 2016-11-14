/*global $:false */
'use strict';

/**
 * @ngdoc service
 * @name peterbdotin.serverFactory
 * @description
 * # serverFactory
 * Factory in the peterbdotin.
 */
angular.module('thebarraudsApp')
  .factory('serverFactory', function ($http,util,$location) {
	  var m_userObject = null;
    return {
		getUserObject : function () {
			return m_userObject;
		},
		destroyUserObject : function () {
			m_userObject = null;
		},
		isBadUser : function(sectionname) {
			var ret_val = true;
			if (m_userObject !== null) {
			  m_userObject.appsection.forEach (function(appSec) {
				  if (appSec.sectionname === sectionname) {
					  ret_val = false;
				  }
			  });
			}
			return ret_val;
		},


    checkusercredentials: function(scope) {
      $http.get(util.restAPIURL($location) + 'validateuser/' + scope.login_user + '/' + scope.login_pwd).
        success(function(data) {
          scope.manageuserlogin(data);
        }).
        error(function(data) {
          scope.invalid_user_cred = data.error;
        });
    },

    getpagelist: function(scope,callback){
      $http.get(util.restAPIURL($location) + 'getpagelist/').
      success(function(data) {
        scope[callback](data);
        }).
      error(function(data) {
        console.log(data);
        });

    },

    //we are going to use scope callbacks to handle multiple directive calls to identical factory methods
    //the specific directive functionality should be handled in the directive itselt. not in the factory. (mostly thanks to Ed Seckler)
    getitem : function(itemid,itemtype,scope,callback) {
      $http.get(util.restAPIURL($location) + 'getitem/' + itemtype + '/' + itemid).
      success(function(data) {
        scope[callback](data);
        }).
      error(function(data) {
        console.log(data);
        });
    },

    getitems : function(itemtype,scope,callback) {
      $http.get(util.restAPIURL($location) + 'getitems/' + itemtype).
        success(function(data) {
          scope[callback](data);
        }).
        error(function(data) {
          console.log(data);
        });
    },
    getitemsorderbyattr : function(itemtype,orderby,sortorder,scope,callback) {
      $http.get(util.restAPIURL($location) + 'getsorteditems/' + itemtype + '/' + orderby + '/' + sortorder + '/').
        success(function(data) {
          scope[callback](data);
        }).
        error(function(data) {
          console.log(data);
        });
    },

    getmenu : function(scope,callback) {
      $http.get(util.restAPIURL($location) + 'getmenu/').
        success(function(data) {
          scope[callback](data);
        }).
        error(function(data) {
          console.log(data);
        });
    },

    getemptylayoutcolumns : function(scope,callback) {
      $http.get(util.restAPIURL($location) + 'getemptylayoutcolumns/' + scope.layoutcolcount).
        success(function(data) {
          scope[callback](data);
        }).
        error(function(data) {
          console.log(data);
        });
    },

    getpageitemdetailsdata : function(scope,callback) {
      $http.get(util.restAPIURL($location) + 'getpageitemdetailsdata/' + scope.pagetemplate.pagetype + '/' + scope.pageitemdata[scope.pagetemplate.pagetype][0].id + '/').
      success(function(data) {
        scope[callback](data);
        }).
      error(function(data) {
        console.log(data);
        });
    },

    fileupload : function (scope,file_data,callback){
      if (angular.isDefined(file_data)){
        var form_data = new FormData();
        form_data.append('file', file_data);
        $.ajax({
          url: util.restAPIURL($location) + 'fileupload/',
          dataType: 'json',  // what to expect back from the PHP script, if anything
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: 'post',
          success: function(data){
            scope[callback](data);
          }
         });
      }
    },

    saveitemdetails : function(scope,itemDetails,itemtype,callback) {
      var paramsObject = {itemObject:JSON.stringify(itemDetails)};
      var httpPostParams = [];
      for (var key in paramsObject) {
        httpPostParams.push(key + '=' + encodeURIComponent(paramsObject[key]));
      }
      httpPostParams = httpPostParams.join('&');
      $http({
        method: 'POST',
        url: util.restAPIURL($location) + 'saveitem/' + itemtype + '/',
        data: httpPostParams,
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).
      success(function(data) {
        // actually the callback should not be predefined. but we're keeping this hack here for legacy
        if (angular.isDefined(callback)) {
          scope[callback](data);
        }
        else {
          scope.managesaveitem (data);
        }
      }).
      error(function(data) {
        console.log(data);
      });
    },

    insertafter : function(scope,itemDetails,insertafterposition,itemtype,callback) {
      var paramsObject = {itemObject:JSON.stringify(itemDetails)};
      var httpPostParams = [];
      for (var key in paramsObject) {
        httpPostParams.push(key + '=' + encodeURIComponent(paramsObject[key]));
      }
      httpPostParams = httpPostParams.join('&');
      $http({
        method: 'POST',
        url: util.restAPIURL($location) + 'insertafter/' + itemtype + '/' + insertafterposition +  '/',
        data: httpPostParams,
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).
      success(function(data) {
        // actually the callback should not be predefined. but we're keeping this hack here for legacy
        if (angular.isDefined(callback)) {
          scope[callback](data);
        }
        else {
          scope.managesaveitem (data);
        }
      }).
      error(function(data) {
        console.log(data);
      });
    },

    deleteitem : function(itemid,itemtype,scope,callback) {
      $http.get(util.restAPIURL($location) + 'deleteitem/' + itemtype + '/' + itemid).
      success(function(data) {
        scope[callback](data);
        }).
      error(function(data) {
        console.log(data);
        });
    },



    executesqlquery : function(scope) {
      var paramsObject = {sqlquery:JSON.stringify(scope.dbquery.query)};
      var httpPostParams = [];
      for (var key in paramsObject) {
        httpPostParams.push(key + '=' + encodeURIComponent(paramsObject[key]));
      }
      httpPostParams = httpPostParams.join('&');
      $http({
        method: 'POST',
        url: util.restAPIURL($location) + 'executesqlquery/',
        data: httpPostParams,
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      }).
      success(function(data) {
        scope.handlequeryresult (data);
      }).
      error(function(data) {
        console.log(data);
      });
    },

    };
  });

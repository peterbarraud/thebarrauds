<?php
	//file_put_contents('getstarted.log',1);
  //VERY IMPORTANT
  //these services will NEVER error out.
  //at the service we will stop any errors and send back a good json but packaged with error information
	require_once 'Slim/Slim.php';
	require_once 'dataobjectserver/common/logger.php';
	use Slim\Slim;
	Slim::registerAutoloader();
	$app = new Slim();
	//a single rest API is self-sufficient - so how about the db connection is made at the API level
	//this connection object - held inside a global variable or something of that sort is then available to every method, object that is invokved from the API
	//this ensures that a single connection is opened for the entire duration of the API but no more
	//we can then also (brilliant, this one) make full use of db transactions - we can do a full commit / rollback of everything that happened for the duration of the API


	$app->get('/validateuser/:username/:password/',function($username,$password) {
		require_once 'dataobjectserver/application.php';
		$application = Application::getinstance();
		$array = array();
		$array['user_name'] = $username;
		$array['password'] = $password;
		$loginuser = $application->GetObjectsByClassNameAndAttributes('loginuser',$array);
		allow_cross_domain_calls();
		echo json_encode($loginuser);
	});

	$app->get('/getitem/:itemtype/:itemid/',function($itemtype,$itemid) {
		require_once 'dataobjectserver/application.php';
		$application = Application::getinstance();
		$itemdetails = $application->GetObjectById($itemtype,$itemid,1);
		allow_cross_domain_calls();
		echo json_encode($itemdetails);
	});

	$app->get('/getpagelist/',function(){
		require_once 'dataobjectserver/application.php';
		$application = Application::getinstance();
		$sortby['createdate'] = 'desc';
		$items = $application->GetObjectsByClassName('page',$sortby);
		allow_cross_domain_calls();
		echo json_encode($items);

	});

	$app->get('/getitems/:itemtype/',function($itemtype) {
		require_once 'dataobjectserver/application.php';
		$application = Application::getinstance();
		$items = $application->GetObjectsByClassName($itemtype);
		allow_cross_domain_calls();
		echo json_encode($items);
	});

	$app->get('/getsorteditems/:itemtype/:orderby/:sortorder/',function($itemtype,$orderby,$sortorder) {
		require_once 'dataobjectserver/application.php';
		$application = Application::getinstance();
		$sortby[$orderby] = $sortorder;
		$items = $application->GetObjectsByClassName($itemtype,$sortby);
		allow_cross_domain_calls();
		echo json_encode($items);
	});

	$app->get('/getmenu/',function() {
		require_once 'dataobjectserver/application.php';
		$application = Application::getinstance();
		$sortby['position'] = 'asc';
		$menudetails = array();
		$menu = $application->GetObjectsByClassName('menu',$sortby,1);
		for ($i=0;$i<sizeof($menu->Items);$i++){
			$menutitle = $menu->Items[$i];
			for ($j=0;$j<sizeof($menutitle->menuitem);$j++){
				$menuitem = $menutitle->menuitem[$j];
				$menutitle->menuitem[$j] = $application->GetObjectById('menuitem',$menuitem->id,1);
			}
			$menudetails[$i] = $menutitle;
		}

		allow_cross_domain_calls();
		echo json_encode($menudetails);
	});

	$app->get('/getemptylayoutcolumns/:colcount/',function($colcount) {
		require_once 'dataobjectserver/application.php';
		$application = Application::getinstance();
		$emptylayoutcolumns = array();
		for ($i=0;$i<$colcount;$i++){
			$emptylayoutcolumn = $application->GetObjectById('aggregatecolumn',-1,1);
			$emptylayoutcolumn->position = $i+1;
			array_push($emptylayoutcolumns,$emptylayoutcolumn);
		}
		allow_cross_domain_calls();
		echo json_encode($emptylayoutcolumns);
	});
	$app->get('/getpageitemdetailsdata/:itemtype/:itemid/',function($itemtype,$itemid) {
		require_once 'dataobjectserver/application.php';
		$application = Application::getinstance();
		$itemdetails = $application->GetObjectById($itemtype,$itemid,1);
		if ($itemtype == 'piaggregate'){
			for($i=0;$i<sizeof($itemdetails->aggregatecolumn);$i++){
				$aggregatecolumn = $application->GetObjectById('aggregatecolumn',$itemdetails->aggregatecolumn[$i]->id,1);
				for($j=0;$j<sizeof($aggregatecolumn->aggregateitem);$j++){
					$aggregateitem = $application->GetObjectById('aggregateitem',$aggregatecolumn->aggregateitem[$j]->id,1);
					$aggregatecolumn->aggregateitem[$j] = $aggregateitem;
				}
				$itemdetails->aggregatecolumn[$i] = $aggregatecolumn;
			}
		}
		allow_cross_domain_calls();
		echo json_encode($itemdetails);
	});


	$app->get('/publish/:pageid/:itemtype/',function($pageid,$itemtype) {
		require_once 'dataobjectserver/application.php';
		$application = Application::getinstance();
		$page = $application->GetObjectById($itemtype,$pageid,1);
		$page->Publish();
		allow_cross_domain_calls();
		echo json_encode($page);
	});
	$app->get('/unpublish/:pageid/',function($pageid) {
		require_once 'dataobjectserver/application.php';
		$application = Application::getinstance();
		$pageitem = $application->GetObjectById('pageitem',$pageid);
		$pageitem->Unpublish();
		allow_cross_domain_calls();
		echo json_encode($pageitem);
	});
	$app->get('/publishall/',function() {
		require_once 'dataobjectserver/application.php';
		$application = Application::getinstance();
		$pageitemcollection = $application->GetObjectsByClassName('pageitem');
		$pageitemcollection->PublishAll();
		allow_cross_domain_calls();
		echo json_encode($pageitemcollection);
	});
	$app->get('/deleteitem/:itemtype/:itemid/',function($itemtype,$itemid) {
		require_once 'dataobjectserver/application.php';
		$application = Application::getinstance();
		$item = $application->GetObjectById($itemtype,$itemid);
		$item->Delete();
		allow_cross_domain_calls();
		echo json_encode($item);
	});

	$app->post('/saveitem/:itemtype/',function($itemtype) use ($app) {
		require_once 'dataobjectserver/application.php';
		$application = Application::getinstance();
		//cast the json object to a well formed php object based on the data object model
		$itemdetails = $application->GetObjectForJSON(json_decode($app->request->post('itemObject')),$itemtype);
		$itemdetails->Save();
		allow_cross_domain_calls();
		echo json_encode($itemdetails);
	});
	$app->get('/testsave/',function() {
		$saveitemdetails = '{"ServerErr":"","ServerErrNo":0,"ServerErrType":"","id":null,"title":"style","position":2}';
		$itemtype = 'menu';
		require_once 'dataobjectserver/application.php';
		$application = Application::getinstance();
		$itemdetails = $application->GetObjectForJSON(json_decode($saveitemdetails),$itemtype);
		$itemdetails->Save();
	});

	$app->post('/insertafter/:itemtype/:insertafterposition/',function($itemtype,$insertafterposition) use ($app) {
		require_once 'dataobjectserver/application.php';
		$application = Application::getinstance();
		$logger = new Logger('insertafter');
		$logger->Write($app->request->post('itemObject'));
		//cast the json object to a well formed php object based on the data object model
		$itemdetails = $application->GetObjectForJSON(json_decode($app->request->post('itemObject')),$itemtype);
		$itemdetails->InsertAfter($insertafterposition);
		allow_cross_domain_calls();
		echo json_encode($itemdetails);
	});

	$app->get('/testinsertafter/',function() use ($app) {
		$saveitemdetails = '{"ServerErr":"","ServerErrNo":0,"ServerErrType":"","id":null,"title":"","position":null,"menu":{"ServerErr":"","ServerErrNo":0,"ServerErrType":"","id":"29","title":"b11","position":"3","menuitem":[],"$$hashKey":"object:187"},"pageitem":[{"ServerErr":"","ServerErrNo":0,"ServerErrType":"","id":"16","title":"another story","publishdate":null,"pagename":"another-story.php","createdate":"2016-01-10 22:23:58","modifieddate":"2016-01-10 22:23:58","readonly":null,"$$hashKey":"object:41"}]}';
		require_once 'dataobjectserver/application.php';
		$application = Application::getinstance();
		//cast the json object to a well formed php object based on the data object model
		$itemdetails = $application->GetObjectForJSON(json_decode($saveitemdetails),'menuitem');
		// $itemdetails->InsertAfter(0);
		allow_cross_domain_calls();
		echo json_encode($itemdetails);
	});

	$app->post('/executesqlquery/',function() use ($app) {
		require_once 'dataobjectserver/application.php';
		$application = Application::getinstance();
		//cast the json object to a well formed php object based on the data object model
		$sqlquery = $app->request->post('sqlquery');
		$object = $application->GetObjectById('menuitem',-1,0);
		$result = $object->ExecuteSQLQuery($sqlquery);
		allow_cross_domain_calls();
		echo json_encode($result);
	});

	$app->post('/fileupload/',function() use ($app) {
		require_once 'dataobjectserver/application.php';
		$application = Application::getinstance();
		// the reason why fileupload is not part of the saveitemdetails method is that:
		// the GetObjectForJSON messes up in the file data bytes
		$itemdetails = $application->GetObjectById('asset',-1);
		$itemdetails->Save();
		allow_cross_domain_calls();
		echo json_encode($itemdetails);
	});

	$app->run();


function allow_cross_domain_calls() {

    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

    //echo "You have CORS!";
}
?>

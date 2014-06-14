  var amazonApp = angular.module('amazonApp', [], function($locationProvider){
        $locationProvider.html5Mode(true);
  });

  amazonApp.controller("amazonCtrl", ['$scope', '$http', '$location', function($scope, $http, $location) {


  	$scope.selectedLocation = null;
 	$scope.locations = [];  
    $http.get('getLocation.php').success(function(data){
    	$scope.locations = angular.fromJson(data);
      	if($location.search()['location'])
			$scope.selectedLocation=$location.search()['location'];
      	else if($scope.locations.length>0)
			$scope.selectedLocation = $scope.locations[0].value;
      	else // default value
		$scope.selectedLocation = 'com'; // U.S.
    });
  
	$scope.selectedCategory = null;
	$scope.categories = [];
    $http.get('getCategory.php').success(function(data){
		$scope.categories = angular.fromJson(data);
      	if($location.search()['category'])
			$scope.selectedCategory=$location.search()['category'];
      	else if($scope.categories.length>0)
			$scope.selectedCategory = $scope.categories[0].name;
      	else // default value
        	$scope.selectedCategory = 'All';
    });
    

  	$scope.products = [];
    $http.get('getProduct.php').success(function(data){
    	$scope.products = angular.fromJson(data.result);
    });

  	$scope.keyword = null ;
  	if($location.search()['keyword'])
		$scope.keyword=$location.search()['keyword'];
		
    $scope.processForm = function(){
    
	var postData = $.param({location: $scope.selectedLocation, category: $scope.selectedCategory, keyword: $scope.keyword});
	$http({
		method  : 'POST',
		url     : 'getProduct.php',
		data    : postData,
		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
	}).success(function(data) {
            console.log(data);
			$scope.errorMsg = null; // clean previous result
            if (!data.success) {
            	// if not successful, bind errors to error variables
                $scope.errorMsg = data.errors.msg;
				$scope.errorKeyword = data.errors.keyword;
            } 
            else {
            	// if successful, bind success message to message
                $scope.message = data.message;
				$scope.products = angular.fromJson(data.result);
            }
        });
    
    }
    
  }]);
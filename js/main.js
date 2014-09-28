"use strict";

var app = angular.module("pdinst", []);

app.controller = app.controller("ctrl", function ($scope, $http) {
	$scope.dbHost = "localhost";
	$scope.dbPort = "3306";


	$scope.startInstall = function() {
		var newObj = {
				DBHost: $scope.dbHost,
				DBPort: $scope.dbPort,
				DBName: $scope.dbName,
				DBUser: $scope.dbUser,
				DBPassword: $scope.dbPwd
		};

			console.log(newObj);

		$http
			.post("startInstallation", newObj).then(function () {
				alert("Installation complete!");
			}, function () {
				alert("ERROR: Installation could not be completed. Wrong MySQL credentials?");
			});
	};
});
var xtrasApp = angular.module('xtrasApp', [], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
});

function CommentsController($scope, $http, $window) {

	$http.get($window.url + '/comments/' + $window.itemId).success(function(comments)
	{
		$scope.comments = comments.data;
	});

	$scope.countComments = function()
	{
		var count = 0;

		angular.forEach($scope.comments, function(comment)
		{
			count += 1;
		});

		return count;
	}

	$scope.addComment = function()
	{
		var comment = {
			user_id: $window.userId,
			item_id: $window.itemId,
			content: $scope.newCommentContent
		};

		console.log($scope.comments);

		// Push the content onto the comments
		$scope.comments.unshift(comment);

		// Post the data
		$http.post($window.url + '/comments/' + $window.itemId, comment);

		// Hide the panel
		$('#commentPanel').addClass('hide');
	}
}
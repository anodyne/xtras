<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<style>
			body {
				font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
				font-size: 14px;
				line-height: 20px;
				color: #333333;
				background-color: #ffffff;
			}
		</style>
	</head>
	<body>
		<h2>Abuse Report</h2>
		
		<ul>
			<li>Item Name: {{ $xtraName }}</li>
			<li>Item Type: {{ $xtraType }}</li>
			<li>Item URL: {{ $xtraUrl}}</li>
			<li>Reported By: {{ $userName }} ({{ $userEmail }})</li>
		</ul>

		{{ Markdown::parse($content) }}
	</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<title></title>

	<script src="js/jquery-3.5.1.min.js"></script>
	<script src="js/jquery-ui/jquery-ui.min.js"></script>
	<link rel="stylesheet" type="text/css" href="js/jquery-ui/jquery-ui.min.css">
	<script type="text/javascript">
		jQuery(document).ready(function()
		{
			displayAll();
		})

		function displayAll()
		{
			var data;
			data+="&event_action=displayAll";

			$.ajax({
				data:data,
				dataType :"json",
				method:"post",
				url:"index_ajax.php",
			    success: function(data) {
			    	$("body").html(data);
				}
			  });
		}

		function addNode(curNode)
		{
			var data;
			data+="&event_action=addNode";
			data+="&curNode="+curNode;

			$.ajax({
				data:data,
				method:"post",
				url:"index_ajax.php",
			    success: function(data) {
			      displayAll();
				}
			  });
		}

		function deleteNode(curNode)
		{
			var data;
			data+="&event_action=deleteNode";
			data+="&curNode="+curNode;

			$.ajax({
				data:data,
				method:"post",
				url:"index_ajax.php",
			    success: function(data) {
			      displayAll();
				}
			  });
		}
	</script>
</head>
<body>
</body>
</html>
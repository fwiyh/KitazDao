<html>
<head>
	<title>メニュー</title>
	<script type="text/javascript" src="./js/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="./js/SessionControl.prot.js"></script>
	<script type="text/javascript" src="./js/index.js"></script>
	<script>
	$(document).ready(
		function(){
			SetEvents();
		}
	);
	</script>
</head>
<body>
	対象DB:{$selectDatabase}<br>
	{html_options id="SelectableDatabase" name="selectableDatabase" options=$selectableDatabase selected=$selectDatabase}
	<input type="button" id="ChangeDatabase" value="選択" />
</body>
</html>
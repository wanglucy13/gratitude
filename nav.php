<!DOCTYPE html>
<html>
<head>
<style>
	body {
		font-family: "Helvetica";
	}

	.sidenav {
		height: 100%;
		width: 0;
		position: fixed;
		z-index: 1;
		top: 0;
		left: 0;
		background-color: salmon;
		overflow-x: hidden;
		transition: 1.0s;
		padding-top: 50px;
	}

	.sidenav a {
		padding-left: 50px;
		font-size: 30px;
		color: white;
		display: block;
		text-decoration: none;		
	}

	.sidenav a:hover {
		color: lightgray;
	}

	.sidenav .closebtn {
		position: absolute;
		top: 0;
		right: 25px;
		font-size: 36px;
		margin-left: 50px;
	}
</style>
</head>
<body>

<div id="menu" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="entry.php">Entry</a>
  <a href="journal.php">Journal</a>
  <a href="account.php">Account</a>
  <a href="about.php">About</a>
  <a href="logout.php">Logout</a>
</div>

<span style="padding-left:10px;font-size:30px;cursor:pointer;color:gray" onclick="openNav()">&#9776;</span>
<h4 style="color:salmon;position:fixed;right:10px;bottom:10px;">Gratitude</h3>

<script>
function openNav() {
	if (window.innerWidth < 767) {
		document.getElementById("menu").style.width = "100%";
		var tags = document.getElementsByTagName("a");
		for(var i = 0; i < tags.length; i++) {
			tags[i].style.textAlign = "center";
			tags[i].style.fontSize = "40px";
		}	      
    }
	else {
		var tags = document.getElementsByTagName("a");		
		for(var i = 0; i < tags.length; i++) {
			tags[i].style.textAlign = "left";
			tags[i].style.fontSize = "25px";
		}	  
		document.getElementById("menu").style.width = "250px";
		document.getElementById("main").style.marginLeft = "300px";
		document.getElementById("main").style.paddingRight = "100px";	
	}
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0, and the background color of body to white */
function closeNav() {
    document.getElementById("menu").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
    document.getElementById("main").style.paddingRight = "0";	
	
}
</script>
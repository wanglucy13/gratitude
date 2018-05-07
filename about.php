<?php

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>About | Gratitude</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">    	
</head>
<body>

    <?php include 'nav.php'; ?>
    <div id="main">
        <div class="container">
            <div class="row">
                <h1 class="col-12 mt-4">About</h1>
            </div> <!-- .row -->
        </div> <!-- .container -->

        <div class="container">

            <form action="gratitude.php" method="POST">

                <div class="row mb-3">
                    <div class="font-italic text-danger col-sm-9 ml-sm-auto">
                        <?php 
                            if(isset($error) && !empty($error)) {
                                echo $error;
                            }
                        ?>
                    </div>
                </div> <!-- .row -->
                
                <div class="form-group row">
                    <h4>
                        Gratitude is an easy way for you to write down the things that you feel grateful for every day. The simple act of writing
                        (or typing) the things that you felt grateful for can have an immense impact on your overall happiness. This journal allows
                        you to create entries into your gratitude journal as well as view the things that you were grateful for in the past. The things
                        you list do not have to be life changing events. Even the smallest things can make a huge impact on your well being and happiness
                        in the long run. 
                    </h4>
                    <!-- <div class="col-sm-6"> -->
                    <!-- </div> -->
			    </div> <!-- .form-group -->
            </form>

        </div> <!-- .container -->
    </div>
</body>
</html>
<?php if(defined('__ERROR__')):?>
<!DOCTYPE html>
<html>

<head>

    <link rel="stylesheet" href="css/bootstrap-4.0.0-beta.2/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
        crossorigin="anonymous"></script>
    <script src="js/jquery-3.2.1/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-4.0.0-beta.2/bootstrap.min.js"></script>

    <title>Error</title>
</head>

<body>
    <div class="alert alert-warning">
    <h2>Error Details</h2>
    <p><strong>Error:</strong><?php echo $error_level; ?></p>
    <p><strong>Message:</strong><?php echo $error_message; ?></p>
    <p><strong>File:</strong><?php echo $error_file.':'.$error_line; ?></p>
    </div>    
</body>

</html>
<?php endif ?>
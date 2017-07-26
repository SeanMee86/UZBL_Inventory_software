<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.16.2/axios.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.0.js"></script>
    <script src="js/main.js"></script>
</head>
<body>

<form>
    <input id="upc" type="text" name="upc">
    <br><br>
    <input id="qty" type="text" name="qty">
    <br><br>
    <input id="inventory_shipped" type="button" value="Send"><input id="inventory_received" type="button" value="Receive">
</form>
<div id="form_response"></div>

</body>
</html>
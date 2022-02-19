<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Salon</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="build/css/app.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="contenedor-app md:grid md:grid-cols-2 md:min-h-screen">
        <div class="imagen bg-cover bg-center h-80 md:h-auto">
            
        </div>
        <div class="app my-0 mx-auto py-12 px-0">
            <?php echo $contenido; ?>
        </div>
    </div>
    <?= $script ?? "" ; ?>
</body>
</html>
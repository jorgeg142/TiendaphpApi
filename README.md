# TiendaphpApi
tienda hecho en php, con bootstrap y conectado con la api de adamspay
como ejecutar esta pagina:
//datos importantes a tener encuenta
no olvidar cambiar la conexión de la base de datos en crud/conexión.php
no olvidar cambiar la api key en "pagar_ordenes.php"
no olvidar cambiar el api secret en serverwebhook.php
no olvidar poner el link del webhook en Adamspay

importar la base de datos "tienda2.sql"
ejecutar el server webhoop
php -s localhost:
yo uso ngrok, la guía de como usar esta en su pagina
y poner el link del host en adamspay
la parte del index.php uso XAMPP entonces manejo el webhook en un server
aparte del de XAMPP
entrar en el index
si te creaste una cuenta y no podes entrar al crud es porque no tenes admin entra en
la base de datos y ponete admin en la tabla "roles" columna "tipo_rol_id" admin=1

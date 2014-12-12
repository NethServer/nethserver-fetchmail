==========================================
Direcciones de correo electrónico externas
==========================================

Direcciones de correo electrónico externas son buzones que se comprueban a intervalos regulares utilizando el protocolo **POP3** o **IMAP4**. 
Los mensajes contenidos en el buzón de correo se descargan y se entregan a los usuarios o grupos locales, como por configuración en este formulario. 

Direcciones externas
====================

Configure la lista de direcciones externas y la asociación con el usuario del sistema.

Crear / Modificar
-----------------

Crear o editar una dirección externa.

Email
    La dirección de correo electrónico externa para comprobar.

Protocolo
    El protocolo utilizado para acceder al servidor remoto. Puede ser *POP3* o *IMAP4* (recomendado).

Dirección del servidor
    Nombre de host o dirección IP del servidor remoto.

Nombre de usuario
    Nombre de usuario utilizado para autenticarse en el sistema remoto.

Contraseña
    La contraseña utilizada para autenticar.

Cuenta
    Seleccione el usuario o grupo que recibirá los mensajes descargados.

Habilitar SSL
    Habilitar el cifrado de la conexión con el servidor remoto.

Eliminación de los mensajes descargados
    Si está activado, los mensajes descargados se eliminan del servidor remoto (recomendado). Deje desactivado para mantener una copia en el servidor remoto.

Eliminar
--------

Eliminar una cuenta *no* eliminar los mensajes ya entregados. 

Descargar ahora
---------------

Inmediatamente se inicia la descarga de todas las direcciones externas.


General
=======

Permitir
    Le  permite activar o desactivar el demonio de Fetchmail que descarga correos electrónicos de direcciones externas.

Compruebe cada
    Frecuencia de comprobación de nuevos mensajes en las direcciones externas. Se recomienda un intervalo de al menos 15 minutos.

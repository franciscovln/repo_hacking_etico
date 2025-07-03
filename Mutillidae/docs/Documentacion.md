## Instrucciones
Simular un escenario de filtración de datos sensibles de una aplicación web vulnerable (Mutillidae) y su almacenamiento en una base de datos externa (Alwaysdata). Donde un atacante logra inyectar una webshell para capturar credenciales y otra información, enviándola a un servidor controlado.

### Objetivos
1. Crear un archivo PHP para simular una webshell. Este archivo contiene un formulario HTML para que el usuario ingrese información y código PHP para capturar los datos del formulario (usuario y contraseña), además del user-agent del navegador y la geolocalización basada en la IP.
2. Crear una base de datos en Alwaysdata para almacenar los datos que extraigamos del formulario.
3. Crear un segundo archivo PHP para visualizar los datos extraidos. Este archivo se conectará a la misma base de datos y mostrará el contenido de la tabla donde se almacenaron los datos, en formato de texto plano.

## Evidencia
1. Subir el login falso a Mutillidae ![[1_subir_archivo.png]]
2. Crear una base de datos en Alwaysdata donde almacenemos la información del formulario![[3_base_de_datos.png]]
3. Esperar a que alguien coloque sus datos de usuario en el formulario y se refleje en la base de datos![[4_formulario_phishing.png]]![[5_captura_datos.png]]
4. Mostrar los datos con un archivo PHP que consulte a la base de datos de Alwaysdata![[6_mostrar_datos.png]]

![Mi repositorio GitHub](https://github.com/alfonsochb/metereologia/blob/master/public/img/screen.png)

# Práctica: consumir API metereológica desde PHP
#### Esta es una práctica de conocimientos PHP para obtener datos desde una [API OpenWeather](https://openweathermap.org/)
<br>


## Instalación
Puedes clonar este repositorio desde <b>GitHub: </b>[<b>alfonsochb/metereologia</b>](https://github.com/alfonsochb/metereologia)

1. Debes abrir una terminal cmd o GitBach y ubicarte en el directorio raíz de tu servidor local de PHP.

2. Realizar la clonación del proyecto de ejemplo
    ```bash
    git clone https://github.com/alfonsochb/metereologia.git
    ```

3. Desplazar, ubicar la terminal dentro del proyecto descargado
    ```bash
    cd metereologia
    ```

4. Ejecutar composer para la instalación de las dependencias
    ```bash
    composer dump-autoload
    composer update
    ```
5. Crear la base de datos MySql con el script ubicado en:
    ```txt
    metereologia\app_docs\test_meteorology.sql
    ```

6. Configurar las constantes de conexión de base de datos en el archivo:
    ```php
    metereologia\app\ModelClass.php
    ```
	
7. Visualice el resultado en un navegador web ejemplo:
    ```txt
    http://mi-servidor-web/metereologia/
    ```

## Reconocimiento
Autor: [Alfonso Chávez Baquero](https://github.com/alfonsochb?target=_blank)
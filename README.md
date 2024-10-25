# PROYECTO FINAL 

Este proyecto es una aplicación web desarrollada en **CakePHP 5** para una empresa dedicada a la **venta de insumos médicos**. La tienda en línea permite a los usuarios navegar y comprar productos especializados en las áreas de **Ortopedia**, **Traumatología**, **Neurocirugía**, y **Bucomaxilofacial**. Los clientes pueden registrarse, realizar pedidos, y hacer seguimiento de sus pedidos. Además, se cuenta con un sistema de autenticación basado en roles (RBAC) para gestionar permisos y accesos, y un diseño moderno utilizando **AdminLTE**.

## Integrantes del Proyecto

### Sebastián Bustelo
### Facundo Ramírez
### Florencia Tigani

# Proyecto final con Framework CakePHP 5

## Instalación
1. Clona el repositorio.
2. Instala las dependencias con Composer:
    ```
    cd public
    composer install
    ```
3. Configura tu base de datos en `config/app_local.php` con las credenciales correctas:

    ```php
    return [
        // Configuración de base de datos
        'Datasources' => [
            'default' => [
                'className' => Connection::class,
                'driver' => Mysql::class,
                'port' => '3306',
                'host' => 'localhost',
                'username' => 'mi_usuario',
                'password' => 'mi_contraseña',
                'database' => 'mi_base_de_datos',
                'encoding' => 'utf8',
                'timezone' => 'UTC',
                'className' => Connection::class,
                'driver' => Mysql::class,
                'persistent' => false,
                'timezone' => 'UTC',
            ]
        ],

        // Configuración de correo electrónico
        'EmailTransport' => [
            'default' => [
                'className' => 'Smtp',
                'host' => 'smtp.gmail.com',
                'port' => 587,
                'timeout' => 30,
                'username' => 'example@gmail.com',
                'password' => 'example_pass',
                'client' => null,
                'tls' => true,
            ],
        ],
    ];
    ```

4. Ejecuta las migraciones o importa el script SQL inicial para configurar las tablas:

    ```bash
    mysql -u mi_usuario -p mi_base_de_datos < script/db.sql
    ```

    El archivo SQL inicial se encuentra en `script/db.sql`.

5. Ejecutar el sitio en apache/nginx/docker, este manual no explica a fondo esto pero puede verlo en manual oficial de cakephp https://book.cakephp.org/5/es/installation.html   


## Estructura del Proyecto

- **src/Controller/**: Controladores de la aplicación que manejan las peticiones HTTP y la lógica de negocio, respondiendo a las acciones del usuario y coordinando las interacciones entre el modelo y la vista.
- **src/Model/**: Modelos que representan las entidades y las interacciones con la base de datos, incluyendo la validación de datos y la lógica de negocio relacionada.
- **src/Template/**: Vistas que contienen el HTML y los datos que se muestran al usuario, definiendo cómo se presenta la información en el navegador.
- **src/Config/**: Archivos de configuración que definen ajustes globales de la aplicación, como las rutas, la conexión a la base de datos y las configuraciones de seguridad.
- **src/Entity/**: Clases que representan las entidades del dominio, facilitando la manipulación de datos y la interacción con el modelo.
- **src/Table/**: Clases de tabla que proporcionan métodos para interactuar con la base de datos y realizar operaciones CRUD en las entidades.
- **plugins/**: Contiene los plugins adicionales utilizados en el proyecto, que añaden funcionalidades específicas y extienden las capacidades de la aplicación.
- **webroot/**: Directorio de archivos públicos accesibles desde el navegador. Contiene recursos como CSS, JavaScript, imágenes y otros archivos estáticos utilizados en la aplicación.


## Plugins Utilizados

### RBAC (Role-Based Access Control)

Este plugin se utiliza para controlar los accesos dentro de la aplicación basados en roles y permisos. Permite definir roles como "Administrador", "Cliente", etc., y gestionar quién puede realizar ciertas acciones.


### AdminLTE (Role-Based Access Control)

Este plugin se utiliza Plantilla de panel de administración de Bootstrap de AdminLTE.
El mejor tema de panel de control y panel de administración de código abierto. AdminLTE, desarrollado sobre Bootstrap, ofrece una variedad de componentes adaptables, reutilizables y de uso común.


**Instalación**:
https://github.com/maiconpinto/cakephp-adminlte-theme

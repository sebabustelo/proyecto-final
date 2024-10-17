# PROYECTO FINAL 

Este proyecto es una aplicación web desarrollada en **CakePHP 5** para una empresa dedicada a la **venta de insumos médicos**. La tienda en línea permite a los usuarios navegar y comprar productos especializados en las áreas de **Ortopedia**, **Traumatología**, **Neurocirugía**, y **Bucomaxilofacial**. Los clientes pueden registrarse, realizar pedidos, y hacer seguimiento de sus pedidos. Además, se cuenta con un sistema de autenticación basado en roles (RBAC) para gestionar permisos y accesos, y un diseño moderno utilizando **AdminLTE**.

## Integrantes del Proyecto

### Sebastian Bustelo
Desarrollador Backend especializado en **CakePHP** y **PHP**, encargado de la lógica del sistema y la integración de la base de datos, asegurando que las funcionalidades de pedidos y usuarios se implementen correctamente.

### Facundo Ramirez
Desarrollador Frontend responsable del diseño e integración de **AdminLTE**, encargado de que la experiencia de usuario sea fluida y atractiva, creando interfaces responsive y fáciles de usar.

### Florencia Tigani
Analista y tester, encargada de verificar el correcto funcionamiento de la aplicación, realizar pruebas en todas las funcionalidades, y asegurar que se cumplan los requisitos del cliente en términos de calidad y usabilidad.
1. Verificación del Funcionamiento: Asegura que todas las funcionalidades de la aplicación operen de manera adecuada y conforme a las especificaciones establecidas.
2. Realización de Pruebas: Ejecuta pruebas exhaustivas para identificar posibles errores y asegurar que la aplicación cumpla con los estándares de calidad.
3. Aseguramiento de Calidad y Usabilidad: Garantiza que se cumplan todos los requisitos del cliente en términos de calidad y experiencia de usuario, proporcionando una aplicación confiable y fácil de usar.


# Documentación del Proyecto IPMagna con Framework CakePHP 5

## Instalación
1. Clona el repositorio.
2. Instala las dependencias con Composer:
    ```
    composer install
    ```
3. Configura tu base de datos en `config/app_local.php` con las credenciales correctas:

    ```php
    return [
        // Configuración de base de datos
        'Datasources' => [
            'default' => [
                'host' => 'localhost',
                'username' => 'mi_usuario',
                'password' => 'mi_contraseña',
                'database' => 'mi_base_de_datos',
                // Comentarios adicionales sobre la configuración de la conexión...
            ]
        ],

        // Configuración de correo electrónico
        'EmailTransport' => [
            'default' => [
                'host' => 'smtp.example.com',
                'port' => 587,
                // Configuración SMTP usada para enviar correos electrónicos
            ],
        ],
    ];
    ```

4. Ejecuta las migraciones o importa el script SQL inicial para configurar las tablas:

    ```bash
    mysql -u mi_usuario -p mi_base_de_datos < script/initial.sql
    ```

    El archivo SQL inicial se encuentra en `script/initial.sql`.


## Estructura del Proyecto

- **src/Controller/**: Controladores de la aplicación que manejan las peticiones HTTP.
- **src/Model/**: Modelos que representan las entidades y las interacciones con la base de datos.
- **src/Template/**: Vistas que contienen el HTML y los datos que se muestran al usuario.
- **plugins/**: Contiene los plugins adicionales utilizados en el proyecto.

## Plugins Utilizados

### RBAC (Role-Based Access Control)

Este plugin se utiliza para controlar los accesos dentro de la aplicación basados en roles y permisos. Permite definir roles como "Administrador", "Cliente", etc., y gestionar quién puede realizar ciertas acciones.

**Instalación**:

### AdminLTE (Role-Based Access Control)

Este plugin se utiliza Plantilla de panel de administración de Bootstrap de AdminLTE.
El mejor tema de panel de control y panel de administración de código abierto. AdminLTE, desarrollado sobre Bootstrap, ofrece una variedad de componentes adaptables, reutilizables y de uso común.


**Instalación**:
https://github.com/maiconpinto/cakephp-adminlte-theme

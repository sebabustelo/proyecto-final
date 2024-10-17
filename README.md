# PROYECTO FINAL 

Este proyecto es una aplicación web desarrollada en **CakePHP 5** para una empresa dedicada a la **venta de insumos médicos**. La tienda en línea permite a los usuarios navegar y comprar productos especializados en las áreas de **Ortopedia**, **Traumatología**, **Neurocirugía**, y **Bucomaxilofacial**. Los clientes pueden registrarse, realizar pedidos, y hacer seguimiento de sus pedidos. Además, se cuenta con un sistema de autenticación basado en roles (RBAC) para gestionar permisos y accesos, y un diseño moderno utilizando **AdminLTE**.

## Integrantes del Proyecto

### Sebastián Bustelo

**Arquitecto**  
Desarrollador Backend especializado en CakePHP y PHP, encargado de la lógica del sistema y la integración de la base de datos. Sus responsabilidades incluyen:

- **Diseño de Arquitectura**: Definir la estructura general del sistema, eligiendo patrones de diseño adecuados y asegurando que todos los componentes interactúen de manera eficiente y coherente.
- **Gestión de Base de Datos**: Diseñar y optimizar esquemas de base de datos, asegurando que las consultas sean rápidas y que se mantenga la integridad de los datos. 
- **Desarrollo de Funcionalidades**: Implementar y asegurar el correcto funcionamiento de funcionalidades clave como la gestión de pedidos y usuarios, utilizando CakePHP para mantener una base de código limpia y modular.
- **Optimización del Rendimiento**: Monitorear y analizar el rendimiento del sistema, realizando ajustes y optimizaciones necesarias para mejorar la velocidad de respuesta y la escalabilidad.
- **Colaboración en Metodologías Ágiles**: Trabajar en sprints dentro de un marco ágil, colaborando estrechamente con otros desarrolladores, testers y analistas para iterar rápidamente sobre las funcionalidades y responder a los cambios en los requisitos.
- **Documentación Técnica**: Crear y mantener documentación técnica clara y accesible, incluyendo diagramas de arquitectura, guías de implementación y documentación para facilitar el trabajo de desarrollo.


### Facundo Ramírez

**Desarrollador Frontend y Project Manager**  
Desarrollador Frontend responsable del diseño e integración de AdminLTE, encargado de que la experiencia de usuario sea fluida y atractiva, creando interfaces responsive y fáciles de usar. Sus responsabilidades incluyen:

- **Diseño de Interfaz de Usuario**: Crear y mantener interfaces intuitivas y atractivas, asegurando que los elementos visuales sean coherentes con la identidad del proyecto y fáciles de navegar.
- **Gestión de Base de Datos**: Diseñar y optimizar esquemas de base de datos, asegurando que las consultas sean rápidas y que se mantenga la integridad de los datos. 
- **Integración de AdminLTE**: Implementar y personalizar el tema de AdminLTE para adaptarlo a los requisitos del proyecto, garantizando que todas las funcionalidades estén correctamente implementadas en la interfaz.
- **Colaboración en Metodologías Ágiles**: Participar activamente en reuniones de planificación, retrospectivas y revisiones, facilitando la comunicación entre el equipo y ayudando a mantener un flujo de trabajo ágil y eficiente.
- **Gestión de Proyectos**: Coordinar tareas y cronogramas, asegurando que los hitos del proyecto se cumplan en tiempo y forma. Monitorear el progreso del equipo y hacer ajustes según sea necesario para cumplir con los objetivos del proyecto.
- **Pruebas de Usabilidad**: Realizar pruebas de usabilidad y recoger feedback de los usuarios para mejorar continuamente la experiencia de usuario, asegurando que la aplicación cumpla con los estándares de calidad.

### Florencia Tigani
Analista y tester, encargada de verificar el correcto funcionamiento de la aplicación, realizar pruebas en todas las funcionalidades, y asegurar que se cumplan los requisitos del cliente en términos de calidad y usabilidad.
- **Verificación del Funcionamiento**: Asegura que todas las funcionalidades de la aplicación operen de manera adecuada y conforme a las especificaciones establecidas.
- **Gestión de Base de Datos**: Diseñar y optimizar esquemas de base de datos, asegurando que las consultas sean rápidas y que se mantenga la integridad de los datos. 
- **Realización de Pruebas**: Ejecuta pruebas exhaustivas para identificar posibles errores y asegurar que la aplicación cumpla con los estándares de calidad.
- **Aseguramiento de Calidad y Usabilidad**: Garantiza que se cumplan todos los requisitos del cliente en términos de calidad y experiencia de usuario, proporcionando una aplicación confiable y fácil de usar.
- **Colaboración en Metodologías Ágiles**: Trabajar en sprints dentro de un marco ágil, colaborando estrechamente con otros desarrolladores, testers y analistas para iterar rápidamente sobre las funcionalidades y responder a los cambios en los requisitos.


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

- **src/Controller/**: Controladores de la aplicación que manejan las peticiones HTTP y la lógica de negocio, respondiendo a las acciones del usuario y coordinando las interacciones entre el modelo y la vista.
- **src/Model/**: Modelos que representan las entidades y las interacciones con la base de datos, incluyendo la validación de datos y la lógica de negocio relacionada.
- **src/Template/**: Vistas que contienen el HTML y los datos que se muestran al usuario, definiendo cómo se presenta la información en el navegador.
- **src/Config/**: Archivos de configuración que definen ajustes globales de la aplicación, como las rutas, la conexión a la base de datos y las configuraciones de seguridad.
- **src/Entity/**: Clases que representan las entidades del dominio, facilitando la manipulación de datos y la interacción con el modelo.
- **src/Table/**: Clases de tabla que proporcionan métodos para interactuar con la base de datos y realizar operaciones CRUD en las entidades.
- **src/Middleware/**: Middleware que permite filtrar y procesar las solicitudes y respuestas de la aplicación, implementando funcionalidades como autenticación y autorización.
- **plugins/**: Contiene los plugins adicionales utilizados en el proyecto, que añaden funcionalidades específicas y extienden las capacidades de la aplicación.


## Plugins Utilizados

### RBAC (Role-Based Access Control)

Este plugin se utiliza para controlar los accesos dentro de la aplicación basados en roles y permisos. Permite definir roles como "Administrador", "Cliente", etc., y gestionar quién puede realizar ciertas acciones.

**Instalación**:

### AdminLTE (Role-Based Access Control)

Este plugin se utiliza Plantilla de panel de administración de Bootstrap de AdminLTE.
El mejor tema de panel de control y panel de administración de código abierto. AdminLTE, desarrollado sobre Bootstrap, ofrece una variedad de componentes adaptables, reutilizables y de uso común.


**Instalación**:
https://github.com/maiconpinto/cakephp-adminlte-theme

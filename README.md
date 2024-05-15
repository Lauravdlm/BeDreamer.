# BeDreamer. [![GitHub](https://img.shields.io/badge/GitHub-000000?style=flat-square&logo=GitHub)](https://github.com/Lauravdlm/BeDreamer.)
Este documento detalla los pasos necesarios para desplegar el proyecto BeDreamer en un servidor local utilizando XAMPP.

## Pasos a ejecutar:

1. **Extraer carpeta del proyecto en xampp/htdocs**.

2. **Iniciar servicios en Apache y MySQL en XAMPP**.

3. **Crear base de datos**: 
   - Accede al navegador y dirígete a `localhost` -> `phpMyAdmin` -> `Nueva base de datos`.
   - Nombre de la base de datos: `bedreamer`.
   - Cotejamiento: `utf8mb4_general_ci`.
   - Dirígete a la pestaña SQL y ejecuta el script de creación de usuarios y roles: `../Bedreamer/scripts/script_creacion_usuarios_roles_privilegios.sql`.
   - 
4. **Configurar archivo .env con los datos del host y de la base de datos y generar clave única de cifrado de datos de sesión:** `php artisan key:generate`

5. **Ejecutar migraciones y seeders**: Ejecuta dentro de la carpeta del proyecto desde terminal -> `php artisan migrate:fresh --seed`

6. **Instalación de dependencias**: Ejecuta desde terminal -> `composer install`
Ejecuta desde terminal -> `npm install`

7. **Crear enlace simbólico para el almacenamiento**: Ejecuta desde terminal -> `php artisan storage:link`

8. **Compilar assets**: Ejecuta desde terminal -> `npm run dev`

9. **Iniciar servidor local**: Ejecuta desde terminal -> `php artisan serve`

10. **Acceder al proyecto**:
 - Abre la URL que te proporciona el comando anterior

11. **Acceso a usuarios de prueba**:
 - Administrador: 
     - Email: admin_user@example.com 
     - Contraseña: password123
 - Usuario registrado:
     - Email: basic_user@example.com 
     - Contraseña: password123

## Guía de acceso desde hosting web

Para acceder al proyecto en el hosting web, sigue estos pasos:

1. Ingresa en [http://bedreamer.divli.fr/](http://bedreamer.divli.fr/) para ver el contenido de la página a través del servidor web.

2. **Usuarios para el acceso**:
 - Administrador: 
     - Email: admin_user@example.com 
     - Contraseña: password123
 - Usuario registrado:
     - Email: basic_user@example.com 
     - Contraseña: password123
  

[![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=PHP&logoColor=white)](https://www.php.net/)
[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=flat-square&logo=Laravel&logoColor=white)](https://laravel.com/)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=MySQL&logoColor=white)](https://www.mysql.com/)

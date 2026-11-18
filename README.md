# ExpenseFlow

Sistema web de administración de finanzas personales desarrollado
con Laravel.

## Funcionalidades

- Registro e inicio de sesión de usuarios.
- Panel de control financiero.
- Registro, edición y eliminación de movimientos.
- Administración de categorías.
- Cálculo de ingresos, gastos y saldo disponible.
- API REST propia protegida con Laravel Sanctum.
- Conversión de divisas mediante Frankfurter API.
- Pruebas automatizadas de funcionalidad y seguridad.

## Tecnologías

- Laravel 12
- PHP 8.4
- Laravel Breeze
- Laravel Sanctum
- SQLite
- Blade
- Tailwind CSS
- Vite
- PHPUnit
- Git y GitHub

## Arquitectura

El proyecto utiliza la arquitectura Modelo-Vista-Controlador (MVC)
y el patrón Active Record mediante Eloquent ORM.

## Instalación

Clonar el repositorio e ingresar a la carpeta del proyecto.

Ejecutar:

```bash
composer install
npm ci
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
npm run build
php artisan serve
```

Abrir http://127.0.0.1:8000 en el navegador.

## Seguridad

- Autenticación de usuarios.
- Protección CSRF.
- Contraseñas almacenadas mediante hash.
- Validación de datos del lado del servidor.
- Autorización y aislamiento de registros por usuario.
- Tokens de autenticación mediante Laravel Sanctum.
- Limitación de solicitudes.

## Servicios web

### API propia

| Método | Endpoint | Función |
|---|---|---|
| POST | /api/login | Autenticación |
| POST | /api/logout | Cerrar sesión API |
| GET | /api/movimientos | Consultar movimientos |
| POST | /api/movimientos | Registrar movimiento |
| GET | /api/movimientos/{id} | Consultar movimiento |
| PUT | /api/movimientos/{id} | Actualizar movimiento |
| DELETE | /api/movimientos/{id} | Eliminar movimiento |
| GET | /api/categorias | Consultar categorías |

### API externa

Frankfurter API permite consultar tipos de cambio y realizar
conversiones entre diferentes divisas.

## Pruebas automatizadas

```bash
php artisan test
```

Resultados obtenidos durante la V1.5.0:

- 32 pruebas aprobadas.
- 76 verificaciones exitosas.
- 0 pruebas fallidas.

## Autor

Juan Andrés Sánchez Puente

Universidad Tecnológica de Coahuila

Ingeniería en Desarrollo y Gestión de Software

Desarrollo Web Profesional - Unidad 3
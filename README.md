## Levantar Proyecto Laravel

```bash
# 1. Clonar el Repositorio
git clone https://github.com/tu-usuario/tu-proyecto-laravel.git
cd tu-proyecto-laravel

# 2. Configurar PHP con Extensiones Necesarias
Si estás utilizando PHP 7.x, asegúrate de habilitar las siguientes extensiones en tu archivo `php.ini`:
```ini
extension=xsl
extension=zip
extension=fileinfo
extension=gd

# 3. Instalar Dependencias
composer install

# 4. Copiar el archivo de configuración
cp .env.example .env

# 5. Generar la Clave de la Aplicación
php artisan key:generate

# 6. Configurar la Base de Datos para PostgreSQL
## Abre el archivo .env y configura las siguientes líneas con la información de tu base de datos PostgreSQL:
## DB_CONNECTION=pgsql
## DB_HOST=127.0.0.1
## DB_PORT=5432
## DB_DATABASE=simuladorvrproduccion
## DB_USERNAME=postgres
## DB_PASSWORD=admin@c3rv

# 7. Migrar la Base de Datos para PostgreSQL
php artisan migrate

# 8. Iniciar el Servidor
php artisan serve

# Esto iniciará un servidor de desarrollo en http://localhost:8000.

# 9. Acceder a la Aplicación
## Abre tu navegador y visita http://localhost:8000. Deberías ver la página de inicio de Laravel.

# 10. Importar Datos a PostgreSQL (sin ejecutar migraciones)
## Asegúrate de tener PostgreSQL instalado y configurado correctamente.
## Ejecuta el siguiente comando para importar tus datos a PostgreSQL:
psql -U postgres -d simuladorvrproduccion -h 127.0.0.1 -p 5432 -a -f simuladorvrproduccion.sql

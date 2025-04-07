# 📦 Laravel API Backend

Este proyecto es una API RESTful construida con Laravel 12, con autenticación mediante Sanctum, documentación Swagger (L5 Swagger), y arquitectura moderna basada en Form Requests, Resources, Seeders y controladores RESTful.

---

## 🚀 Requisitos

- PHP >= 8.2
- Composer
- MySQL o PostgreSQL
- Node.js (solo si usas frontend integrado)
- Laravel CLI (`composer global require laravel/installer`)
- (Opcional) Docker & Laradock

---

## ⚙️ Instalación

```bash
# Clonar el repositorio
git clone https://github.com/chavewain/prueba-backend.git

cd pruebabackend

# Instalar dependencias
composer install

# Copiar archivo de entorno
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate

# Crear base de datos y configurar credenciales en .env
# DB_DATABASE, DB_USERNAME, DB_PASSWORD
```

---

## 🛠️ Publicar archivos necesarios

Este proyecto usa **Sanctum** para autenticación y **L5 Swagger** para documentación. Es necesario publicar sus archivos:

```bash
# Publicar configuración de Sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

# Publicar configuración de L5 Swagger
php artisan vendor:publish --provider="L5Swagger\L5SwaggerServiceProvider"
```

---

## 🔄 Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

---

## 🔑 Autenticación

Este proyecto usa **Laravel Sanctum** para proteger rutas de API.

### 🟢 Iniciar sesión

```http
POST /api/login
Content-Type: application/json

{
  "email": "admin@demo.com",
  "password": "password"
}
```

### 🔐 Usar token

En las peticiones protegidas debes agregar el encabezado:

```
Authorization: Bearer TU_TOKEN
```

---

## 📘 Documentación Swagger

```bash
php artisan l5-swagger:generate
```

Accede desde el navegador en:

[http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

---

## ⚙️ Deploy en producción

1. Subir el proyecto al servidor
2. Instalar dependencias:

```bash
composer install --optimize-autoloader --no-dev
```

3. Configurar variables de entorno `.env`:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tudominio.com
```

4. Permisos:

```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

5. Ejecutar migraciones:

```bash
php artisan migrate --force
```

6. Cache de configuración:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🐳 Usar con Docker + Laradock

1. Clona Laradock al mismo nivel del proyecto
2. Copia y configura `.env` y `.env.laradock`
3. Levanta los servicios necesarios:

```bash
docker-compose up -d nginx mysql workspace
```

4. Ingresa al contenedor workspace:

```bash
docker-compose exec workspace bash
```

5. Dentro del contenedor:

```bash
composer install
php artisan migrate --seed
```

---

## 👤 Autor

Desarrollado por **David Chávez**  
📧 dionisio.chavez@gmail.com  
🔗 [linkedin.com/in/chavewain](https://linkedin.com/in/chavewain)

---

## 📄 Licencia

Este proyecto está bajo la licencia MIT.

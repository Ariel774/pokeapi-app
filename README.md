<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Requisitos:

<ul>
  <li>Composer version 2.7.6</li>
  <li>PHP version 8.2.12</li>
  <li>Laravel: 10.48.10</li>
  <li>NPM: 10.8.</li>
  <li>Node Version: v20.13.1</li>
  <li>S.O: Windows 11 </li>
  <li>Vue: 3.2.37</li>
</ul>

Aplicación desarrollada con la última versión de XAMPP x64-8.2.12

- INDICACIONES SETUP

1. Clonamos el repositorio desde Github mediante el comando clone
`git clone https://github.com/Ariel774/pokeapi-app`
Luego nos dirigimos hacia la carpeta creada.
`cd pokeapi-app`

2. Instalamos las dependencias de Composer:
`composer install`

3. Instalamos las dependencias de Node.js:
`npm install`

4. Renombramos el archivo env_example:
`cp env_example .env`

5. Generamos la clave de la aplicación
`php artisan key:generate`

6. Migramos la base de datos (Importante actualizar el usuario y contraseña para que se asigne a la base de datos, en mi caso utilize la que viene por defecto en PHPMyAdmin)
`php artisan migrate`

7. Compilamos el front-end
`npm run dev`

8. Iniciamos el proyecto
`php artisan serv`

## Otros ##
- Se instaló Boostrap
- Instalamos autenticación UI de Laravel: composer require laravel/ui
- Instalé el módulo Axios: npm install axios
- Se instaló el vite como plugin para Vue: npm install @vitejs/plugin-vue
- E instalé el popper para Boostrap: npm install bootstrap@5 popper.js

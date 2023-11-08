# Simuladores VR

Simuladores VR es una plataforma para brindar informes a las diferentes empresas que tenemos.

## Arquitectura

La arquitectura de Simuladores VR se basa en un enfoque de tres capas, que consta de las siguientes partes:

1. **Capa de Presentación**: En esta capa, manejamos la interfaz de usuario y la interacción del usuario. Utilizamos tecnologías de vanguardia para crear experiencias de realidad virtual atractivas y fáciles de usar.

2. **Capa de Lógica de Negocio**: Aquí reside la lógica principal de la plataforma. Procesamos los datos, generamos informes y facilitamos la comunicación entre las diferentes empresas y sus datos.

3. **Capa de Datos**: En esta capa, gestionamos el almacenamiento y acceso a los datos. Utilizamos una base de datos confiable para almacenar y recuperar información crítica para generar informes precisos.

Utilizamos tecnologías específicas en cada una de estas capas para garantizar un rendimiento óptimo y escalabilidad. Nuestra arquitectura está diseñada para manejar grandes volúmenes de datos y proporcionar una experiencia de usuario fluida.

## Roles y Funcionalidades

### Administrador

- Funcionalidades:
  - Crear y gestionar cuentas de empresas.
  - Supervisar y aprobar informes generados por las empresas.
  - Administrar usuarios y permisos.
  
### Empresa

- Funcionalidades:
  - Generar informes de datos específicos de la empresa.
  - Enviar informes al administrador para su aprobación.
  - Gestionar usuarios de la empresa y sus permisos.

### Usuario

- Funcionalidades:
  - Acceder a los informes generados por su empresa.
  - Interactuar con los informes en entornos de realidad virtual.

## Setear base de datos

Para crear el proyecto Simuladores VR en tu entorno de desarrollo, sigue estos pasos:

1. Setear base de datos:

```
php artisan migrate:refresh --seed

```
SPOTYBITS
Descripción del proyecto

SPOTYBITS es una aplicación web sencilla desarrollada en PHP. El proyecto simula una plataforma donde los usuarios pueden registrarse, iniciar sesión, ver productos, añadirlos a un carrito y realizar pedidos.

También cuenta con una zona de administración para gestionar algunas funcionalidades internas. Los datos se guardan en una base de datos MySQL.

Este proyecto se ha realizado con fines educativos para practicar el desarrollo de aplicaciones web.

Tecnologías utilizadas

PHP

HTML, CSS y JavaScript

MySQL

Apache

Docker

Git

Estructura del proyecto
SPOTYBITS/
│
├── bbdd_spotybits.sql      # Base de datos
├── Dockerfile              # Configuración de Docker
│
├── css/                    # Estilos de la web
├── includes/               # Archivos reutilizables (navbar, footer)
├── js/                     # Archivos JavaScript
├── paginas/                # Páginas principales del proyecto
└── .git/                   # Control de versiones

Funcionamiento

El usuario puede registrarse e iniciar sesión.

Puede ver los productos disponibles.

Los productos se pueden añadir al carrito.

El usuario puede consultar sus pedidos.

La información se guarda en una base de datos MySQL.

Instalación y uso
Opción 1: Usando Docker

Tener Docker instalado.

Ejecutar los siguientes comandos:

docker build -t spotybits .
docker run -p 8080:80 spotybits


Abrir el navegador y acceder a:

http://localhost:8080

Opción 2: Servidor local (XAMPP)

Copiar la carpeta del proyecto dentro de htdocs.

Importar el archivo bbdd_spotybits.sql en phpMyAdmin.

Abrir el navegador y acceder a:

http://localhost/SPOTYBITS

Base de datos

La base de datos está definida en el archivo:

bbdd_spotybits.sql


Contiene las tablas necesarias para usuarios, productos y pedidos.

Autor

Proyecto realizado con fines educativos.

Observaciones

El proyecto está pensado para ejecutarse en local.

El código es simple y puede mejorarse o ampliarse.

Ideal para prácticas de PHP y bases de datos.
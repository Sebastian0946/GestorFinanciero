# 💰 Proyecto Gestor de Finanzas 💼

## Descripción
El **Gestor de Finanzas** es una aplicación web desarrollada para ayudar a los usuarios a gestionar eficientemente sus **ingresos** y **gastos**. La aplicación ofrece una interfaz intuitiva que permite visualizar y analizar datos financieros, brindando a los usuarios herramientas para tomar mejores decisiones económicas.

## 🚀 Funcionalidades
- 📊 **Registro de Ingresos**: Los usuarios pueden agregar y gestionar sus ingresos fácilmente.
- 🛒 **Registro de Gastos**: Los gastos se pueden registrar para obtener un mejor control financiero.
- 📈 **Visualización de Datos**: Gráficos interactivos para analizar ingresos y gastos.
- 🔮 **Predicción de Gastos**: Basado en los datos históricos, la aplicación ayuda a predecir futuros gastos.
- 🔐 **Autenticación de Usuarios**: Sistema seguro de inicio de sesión para proteger los datos financieros de cada usuario.

---

## 🛠️ Requisitos Previos
> ⚠️ **Importante**: Antes de comenzar, asegúrate de tener las siguientes herramientas instaladas en tu sistema.

- **[XAMPP](https://www.apachefriends.org/index.html)** (que incluye Apache y MySQL).
- **PHP** 7.4 o superior (incluido con XAMPP).
- **[Composer](https://getcomposer.org/)** para gestionar dependencias de PHP.

---

## 📂 Estructura del Proyecto

El proyecto sigue una estructura clara y organizada para facilitar su comprensión y mantenimiento:

```
/GestorFinanciero
│
├── /app
│   ├── /controllers  # Controladores de la aplicación
│   ├── /models       # Modelos que gestionan la base de datos
│   ├── /views        # Vistas de la aplicación
│   └── /routes       # Rutas de la API
│
├── /assets
│   ├── /css          # Archivos CSS personalizados
│   ├── /js           # Archivos JavaScript personalizados
│   ├── /img          # Imágenes estáticas
│   └── /librerias    # Librerías externas, donde se debe ejecutar Composer
│
├── /BD               # Carpeta que contiene el script SQL para la base de datos
│
├── index.php         # Punto de entrada de la aplicación
│
└── README.md         # Documentación del proyecto
```

---

## ⚙️ Instalación y Configuración

### 1️⃣ Clona el repositorio:
```bash
git clone https://github.com/Sebastian0946/GestorFinanciero.git
cd GestorFinanciero
```

### 2️⃣ Configura la base de datos:
- 📂 **Crea una base de datos en MySQL**.
- 📥 **Importa** el archivo SQL que se encuentra en la carpeta `BD/` usando PhpMyAdmin o cualquier otra herramienta de administración de bases de datos.
  > El archivo SQL contiene las tablas necesarias para ejecutar la aplicación.

### 3️⃣ Instala las dependencias necesarias:
Dentro de la carpeta `assets/librerias/`, ejecuta el siguiente comando para instalar la librería **filp/whoops**, que es utilizada para el manejo de errores:

```bash
cd assets/librerias
composer require filp/whoops
composer require phpmailer/phpmailer
```

### 4️⃣ Configura el entorno:
- Asegúrate de que tu servidor web (Apache) esté configurado para ejecutar PHP y que tenga acceso a la base de datos.
- Verifica que los servicios de Apache y MySQL estén **activos** en **XAMPP**.

> ⚠️ **Nota**: Si estás utilizando XAMPP, asegúrate de iniciar ambos servicios desde el panel de control.

### 5️⃣ Ejecuta la aplicación:
Abre tu navegador favorito y dirígete a:
```
http://localhost/GestorFinanciero/index.php
```

---

## 🔧 Herramientas Utilizadas
- **PHP**: Para la lógica del servidor y manejo de peticiones.
- **MySQL**: Base de datos para almacenar los registros financieros.
- **Composer**: Para gestionar dependencias de PHP, como la librería **filp/whoops** para manejo de errores.
- **Bootstrap**: Para diseñar una interfaz moderna y responsive.

> 💡 **Sugerencia**: Si encuentras errores durante la instalación, revisa los logs de Apache y MySQL en el panel de control de XAMPP.

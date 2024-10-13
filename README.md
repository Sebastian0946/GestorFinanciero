# Proyecto Gestor de Finanzas

## Descripción
El **Gestor de Finanzas** es una aplicación web diseñada para ayudar a los usuarios a gestionar sus ingresos y gastos de manera efectiva. A través de una interfaz intuitiva, los usuarios pueden registrar, visualizar y analizar sus finanzas, lo que les permite tomar decisiones informadas sobre su economía personal.

## Funcionalidades
- **Registro de Ingresos**: Los usuarios pueden agregar sus ingresos, especificando el monto y la fecha, lo que les permite llevar un control de su flujo de dinero.
- **Registro de Gastos**: Similar al registro de ingresos, los usuarios pueden registrar sus gastos, lo que les ayuda a identificar patrones de gasto y áreas de mejora.
- **Visualización de Datos**: La aplicación genera gráficos para mostrar de manera clara la distribución de los ingresos y gastos, permitiendo a los usuarios analizar sus finanzas a lo largo del tiempo.
- **Predicción de Gastos**: Utiliza algoritmos para predecir los gastos futuros basados en los datos históricos, ayudando a los usuarios a planificar mejor su presupuesto.
- **Autenticación de Usuarios**: Implementa un sistema de inicio de sesión para garantizar que cada usuario pueda acceder únicamente a su propia información financiera.

## Estructura del Proyecto
El proyecto está organizado de la siguiente manera:

```
/proyecto-gestor-finanzas
│
├── /app
│   ├── /controllers  # Controladores de la aplicación
│   ├── /models       # Modelos que gestionan la base de datos
│   ├── /views        # Vistas de la aplicación
│   └── /routes       # Rutas de la API
│
├── /assets
│   └── /librerias    # Librerías externas, donde se debe ejecutar Composer
│
├── index.php         # Punto de entrada de la aplicación
│
└── README.md         # Documentación del proyecto
```

## Instalación

### Requisitos
Antes de iniciar, asegúrate de tener los siguientes requisitos instalados:
- **PHP** 7.4 o superior
- **MySQL** o **MariaDB**
- **Composer**

### 1. Clona el repositorio:
```bash
git clone https://github.com/tu_usuario/proyecto-gestor-finanzas.git
cd proyecto-gestor-finanzas
```

### 2. Configura la base de datos:
- Crea una base de datos en MySQL y ejecuta los scripts de creación de tablas que se encuentran en la carpeta `database/`.

### 3. Instala las dependencias necesarias:
Dentro de la carpeta `assets/librerias/`, ejecuta el siguiente comando para instalar la librería **filp/whoops**, que es utilizada para el manejo de errores en el proyecto:

```bash
cd assets/librerias
composer require filp/whoops
```

### 4. Configura el entorno:
Asegúrate de que tu servidor web esté configurado para ejecutar PHP y que tenga acceso a la base de datos.

### 5. Ejecuta la aplicación:
Abre tu navegador y dirígete a `http://localhost/proyecto-gestor-finanzas/index.php`.

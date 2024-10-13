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

/proyecto-gestor-finanzas │ ├── /app │ ├── /controllers # Controladores de la aplicación │ ├── /models # Modelos que gestionan la base de datos │ ├── /views # Vistas de la aplicación │ └── /routes # Rutas de la API │ ├── /assets # Archivos estáticos (CSS, JS, imágenes) │ ├── index.php # Punto de entrada de la aplicación │ └── README.md # Documentación del proyecto

## Tecnologías Utilizadas
- **PHP**: Lenguaje de programación utilizado para la lógica del servidor y el manejo de la base de datos.
- **MySQL**: Sistema de gestión de bases de datos utilizado para almacenar la información de usuarios, ingresos y gastos.
- **JavaScript**: Utilizado para la interacción en el lado del cliente y para generar gráficos mediante bibliotecas como ApexCharts.
- **HTML/CSS**: Tecnologías fundamentales para la estructura y el diseño de la interfaz de usuario.
- **jQuery**: Biblioteca de JavaScript que facilita la manipulación del DOM y las solicitudes AJAX.

## Instalación
1. **Clona el repositorio**:
   ```bash
   git clone https://github.com/tu_usuario/proyecto-gestor-finanzas.git
   cd proyecto-gestor-finanzas

   Configura la base de datos:

Crea una base de datos en MySQL y ejecuta los scripts de creación de tablas que se encuentran en la carpeta database/.
Configura el entorno:

Asegúrate de que tu servidor web esté configurado para ejecutar PHP y que tenga acceso a la base de datos.
Ejecuta la aplicación:

Abre tu navegador y dirígete a http://localhost/proyecto-gestor-finanzas/index.php.

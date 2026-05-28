# 🛒 RASPAFROST - Plataforma e-Commerce & Backoffice Administrativo

**Institución:** Tecnológico Nacional de México — Campus Pachuca  
**Materia:** Negocios Electrónicos II  
**Docente:** Tania Ofelia López Zeron  
**Equipo de Desarrollo:** * Cortés Jason — B25200466  
* Esparza Lares Nicole Dayana — 22200208  
* Guzmán Sánchez David Fidel — 21200255  

---

## 📝 Descripción del Proyecto

**RASPAFROST** es una plataforma integral de comercio electrónico diseñada bajo una arquitectura modular y limpia en PHP nativo. El sistema está dividido en dos grandes ecosistemas operativos controlados dinámicamente mediante autenticación basada en roles:

1. **E-Commerce (Frontoffice):** Interfaz pública destinada a los clientes para la navegación del catálogo de productos, gestión del carrito de compras y simulación de procesamiento de pedidos y pagos.
2. **Panel de Almacén y Control (Backoffice):** Módulo administrativo restringido exclusivamente al personal autorizado (`admin`) para regular la lógica del negocio mediante la gestión de inventarios, atención al cliente y análisis de operaciones financieras.

---

## 🛠️ Stack Tecnológico Utilizado

* **Backend:** PHP (Estructurado con consultas preparadas mediante PDO).
* **Base de Datos:** MySQL (Diseño Entidad-Relación relacional estricto con motores InnoDB).
* **Frontend:** HTML5, CSS3, JavaScript (ES6) y Framework Bootstrap 5 para el diseño adaptativo (*Responsive Design*).
* **Servidor Local:** Entorno de desarrollo XAMPP (Apache v3.x+).

---

## ⚙️ Arquitectura y Funcionamiento del Sistema

### 1. Sistema de Autenticación y Seguridad de Roles
El sistema evalúa las credenciales encriptadas mediante `password_hash()` en la base de datos. Dependiendo de la columna `rol` (`ENUM('cliente', 'admin')`), el enrutador redirige de manera absoluta:
* Los **Clientes** acceden al flujo de compras (`catalogo.php`, `carrito.php`).
* Los **Administradores** rompen el flujo ordinario y ganan acceso a las vistas dentro de `/views/admin/` mediante políticas restrictivas de sesión (`session_start()`).

### 2. Gestión de Clientes e Historial de Compras
El panel administrativo ejecuta una consulta relacional optimizada mediante agregaciones (`COUNT` y `SUM`) acopladas a un `LEFT JOIN` con la tabla `pedidos`. Esto permite calcular dinámicamente:
* El total de órdenes levantadas por cada usuario único.
* El volumen monetario exacto acumulado de compras por cuenta.
* Filtrado automático de usuarios con rol exclusivo de `cliente`.

### 3. Control de Almacén e Inventarios
El núcleo logístico opera enlazando la tabla analítica de `productos` con una tabla operativa llamada `almacen`. El inventario implementa:
* **Entradas de Mercancía:** Actualizaciones aditivas (`UPDATE stock_actual = stock_actual + X`) al abastecerse con proveedores.
* **Salidas Automáticas:** Descuentos automatizados gatillados inmediatamente tras la confirmación exitosa de un pedido por parte del cliente.
* **Alertas de Stock Bajo:** Algoritmo de control relacional que evalúa si un producto se encuentra en un estado crítico mediante la regla condicional: `stock_actual <= stock_minimo`.

### 4. Atención al Cliente (Módulo de Mensajería)
Flujo regulado de comunicación asíncrona mediante la tabla `mensajes_contacto`. El cliente remite dudas desde el frontoffice y el administrador las procesa, audita su estado (`nuevo`, `leído`, `respondido`) y redacta soluciones desde su bandeja exclusiva del Backoffice.

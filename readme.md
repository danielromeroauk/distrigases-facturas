# Sistema de facturación

Desarrollado con laravel 4.1.24.

![Captura de pantalla](http://fc04.deviantart.net/fs70/i/2014/221/1/4/distrigases_facturacion_by_danielromeroauk-d7ufgpw.png)

## ¿Qué hace esta aplicación?

1. Registrar usuarios
  - Nombre
  - Email
  - Password
  - Rol (facturador, administrador)
  - Notas (Dirección, teléfono, Cédula, Cargo, etc.)

2. Permitir al usuario loguearse y cerrar sesión

3. Permitir al usuario cambiar su password

4. Permitir al usuario cambiar sus datos de perfil

5. Permitir al administrador cambiar el perfil de cualquier usuario, reseteando a su vez el password del usuario.

6. Registrar artículos
  - Nombre del artículo
  - Notas (código de barras, unidad de medida, etc.)
  - Precio
  - IVA (%)
  - Indicar el usuario que lo registra/actualiza

7. Registrar clientes
  - NIT
  - Nombre
  - Dirección
  - Teléfono
  - Email (opcional)
  - Notas (Web, persona de contacto, etc.)
  - Indicar el usuario que lo registra/actualiza

8. Registrar facturas
  - Fecha (created_at)
  - Crédito (boolean)
  - Fecha de vencimiento (si crédito es true, de lo contrario este campo de ser igual al campo fecha)
  - Cliente
  - Número de pedido
  - Estado (finalizado si el cliente ha pagado, pendiente si no)
  - Items
    * Artículo
    * Cantidad
    * Precio unitario
    * IVA (%)
  - Indicar el usuario que lo registra/actualiza
  - Notas (Número legal de factura, etc.)

9. Registrar abonos
  - Factura
  - Fecha (created_at)
  - Monto abonado
  - Notas (efectivo, cheque, consigación, transferencia, etc.)
  - Indicar el usuario que lo registra/actualiza

10. Registrar cotizaciones
  - Fecha (created_at)
  - Cliente
  - Concepto
  - Notas (caducidad de la cotización, etc.)
  - Items
    * Artículo
    * Cantidad
    * Precio unitario
    * IVA (%)
  - Indicar el usuario que lo registra/actualiza

11. Usar los datos de una cotización para iniciar la creación de una factura

12. Mostrar/imprimir la factura para la hoja membreteada física

13. Mostrar/imprimir factura (datos de membrete incluidos) con las mismas medidas de la hoja membreteada física

14. Mostrar/imprimir cotización para la hoja membreteada

15. Mostrar/imprimir cotización (datos de membrete incluidos) con las mismas medidas de la hoja membreteada física

16. Generar pdf de factura con membrete incluido

17. Generar pdf con cotización con membrete incluido

18. Filtros en informe de facturas
  - Rango de fechas de creación
  - Rango de fechas de vencimiento no pagas en su totalidad
  - Cliente
  - Cliente y rango de fechas de creación
  - Estado
  - Notas

19. Filtros de informe de cotizaciones
  - Rango de fechas de creación
  - Cliente
  - Cliente y rango de fechas de creación

20. Filtros de informe de artículos
  - Código
  - Nombre del artículo
  - Notas

21. Filtros de informe de clientes
  - NIT
  - Nombre
  - Notas

22. Filtros de informe de abonos
  - Factura
  - Notas
  - Rango de fechas de creación

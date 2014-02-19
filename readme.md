## Sistema de facturación

Registrar usuarios
    -Nombre
    -Email
    -Password
    -Rol (facturador, administrador)
    -Notas (Dirección, teléfono, Cédula, Cargo, etc.)

Permitir al usuario loguearse y cerrar sesión

Permitir al usuario cambiar su password

Permitir al usuario cambiar sus datos de perfil

Permitir al administrador cambiar el perfil de cualquier usuario, reseteando a su vez el password del usuario.

Registrar artículos
    -Nombre del artículo
    -Notas (código de barras, unidad de medida, etc.)
    -Precio
    -IVA (%)
    -Indicar el usuario que lo registra/actualiza

Registrar clientes
    -NIT
    -Nombre
    -Dirección
    -Teléfono
    -Email (opcional)
    -Notas (Web, persona de contacto, etc.)
    -Indicar el usuario que lo registra/actualiza

Registrar facturas
    -Fecha (created_at)
    -Crédito (boolean)
    -Fecha de vencimiento (si crédito es true, de lo contrario este campo de ser igual al campo fecha)
    -Cliente
    -Número de pedido
    -Estado (finalizado si el cliente ha pagado, pendiente si no)
    -Items
        -Artículo
        -Cantidad
        -Precio unitario
        -IVA (%)
    -Indicar el usuario que lo registra/actualiza
    -Notas (Número legal de factura, etc.)

Registrar abonos
    -Factura
    -Fecha (created_at)
    -Monto abonado
    -Notas (efectivo, cheque, consigación, transferencia, etc.)
    -Indicar el usuario que lo registra/actualiza

Registrar cotizaciones
    -Fecha (created_at)
    -Cliente
    -Concepto
    -Notas (caducidad de la cotización, etc.)
    -Items
        -Artículo
        -Cantidad
        -Precio unitario
        -IVA (%)
    -Indicar el usuario que lo registra/actualiza

Usar los datos de una cotización para iniciar la creación de una factura

Mostrar/imprimir la factura para la hoja membreteada física

Mostrar/imprimir factura (datos de membrete incluidos) con las mismas medidas de la hoja membreteada física

Mostrar/imprimir cotización para la hoja membreteada

Mostrar/imprimir cotización (datos de membrete incluidos) con las mismas medidas de la hoja membreteada física

Generar pdf de factura con membrete incluido

Generar pdf con cotización con membrete incluido

Filtros en informe de facturas
    -Rango de fechas de creación
    -Rango de fechas de vencimiento no pagas en su totalidad
    -Cliente
    -Cliente y rango de fechas de creación
    -Estado
    -Notas

Filtros de informe de cotizaciones
    -Rango de fechas de creación
    -Cliente
    -Cliente y rango de fechas de creación

Filtros de informe de artículos
    -Código
    -Nombre del artículo
    -Notas

Filtros de informe de clientes
    -NIT
    -Nombre
    -Notas

Filtros de informe de abonos
    -Factura
    -Notas
    -Rango de fechas de creación
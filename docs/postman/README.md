# Flavisur: login y envío de reporte

Importar colección y environment. Revisar base_url y DNI; los valores 4060 y 1 son ejemplos de cabecera e intento, sustituir por los del login.

1. Login Unity devuelve cabecera_id, intento e intentos (máximo).
2. Enviar reporte con cabecera_id, intento, entrenamiento=false y json_data. El servidor crea el detalle y guarda el reporte en la BD en una transacción. No llamar a /workshops.
3. Abrir pdf_url con sesión web.

No se necesita detail_induction_worker_id. El flujo anterior con ese campo sigue disponible para otros clientes; no mezclar ambos IDs.

Cada intento guarda su reporte por separado; reenvío de uno completado devuelve HTTP 400. Evaluación valida el máximo configurado. Entrenamiento usa entrenamiento=true y su propio número de intento.

La nota va opcionalmente en json_data.nota (o note); si falta se usa 20 y si llega 0 se conserva. El ejemplo no manda nota.

Desplegar los cambios antes de probar en producción. No se insertaron datos en producción.

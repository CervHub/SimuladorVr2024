# Propuesta de datos de giros para Unity

Agregar este objeto opcional dentro del JSON de resultados (`json_data`), junto a `trucks`, `collisions` y `times`:

```json
{
  "rotations": {
    "truck": {
      "totalTurns": 8,
      "over180Turns": 1
    },
    "shovel": {
      "totalTurns": 12,
      "over180Turns": 0
    }
  }
}
```

Los valores son ejemplos. `truck` corresponde al camión y `shovel` a la pala. `totalTurns` indica la cantidad de giros; `over180Turns`, cuántos de esos giros superaron 180 grados respecto al eje de referencia. Exactamente 180 grados no supera el límite. Unity debe definir el inicio y fin de cada maniobra y contar una sola vez cada giro que exceda el límite, no una vez por frame. Acordar el eje de referencia con el equipo del simulador antes de integrar esta propuesta.

Enviar cantidades enteras no negativas; `over180Turns` no debe superar `totalTurns`. Si un equipo no se mide, omitir sus datos: el PDF mostrará «No informado». Un cero significa que se midió y no hubo eventos.

La sección aparece al final del reporte como observación y no modifica la nota. El JSON completo se conserva en el campo existente de resultados; no se necesita una columna nueva en la base de datos.

En Camiones, el objetivo mostrado es 5 camiones cargados y 20 puntos para la nota. El cálculo conserva el máximo de 20 para 5 o más camiones.

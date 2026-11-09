# Giros de la pala con contacto con el cable

Agregar dentro de json_data, junto a trucks, collisions y times:

```json
{
  "rotations": {
    "shovel": {
      "cableContactTurns": 2
    }
  }
}
```

cableContactTurns cuenta los giros de la pala durante los cuales pisó el cable. Enviar un entero no negativo y contar una sola vez cada giro con contacto, no por frame. El valor 2 es ilustrativo.

El reporte muestra este único valor al final, sin objetivo ni efecto en la nota. Si no llega, muestra «No informado»; cero significa que se midió y no hubo contactos.

Reemplaza la propuesta anterior de totalTurns y over180Turns: esas mediciones no indican contactos con el cable y no se reutilizan como tales. Se guarda dentro del JSON existente, sin columnas nuevas.

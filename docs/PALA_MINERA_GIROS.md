# Datos de camiones y contacto con el cable

Fragmento que se agrega al objeto json_data existente:

```json
{
  "collisions": {
    "shovelTracks": 2,
    "truck": 1,
    "bucketDoor": 0,
    "supplyCable": true
  },
  "trucks": {
    "overloadedTrucks": 1,
    "underloadedTrucks": 2,
    "correctLoads": 6,
    "totalTrucks": 9
  }
}
```

supplyCable es booleano: true = pisó el cable, false = no lo pisó. Si no llega, el PDF muestra «No informado». Es informativo y no afecta la nota. No indica cantidad de giros ni permite comprobar que el ángulo fue mayor de 180°. Reemplaza la propuesta rotations.shovel.cableContactTurns para los nuevos envíos.

correctLoads es la cantidad de camiones cargados correctamente y determina la nota: mínimo(20, correctLoads × 20 / 5). Si falta el campo, los reportes antiguos conservan el cálculo sobre totalTrucks. Cero cargas correctas es nota cero aunque el total sea mayor.

La nota de colisiones suma solo shovelTracks, truck y bucketDoor y descuenta un punto por evento desde 20, con mínimo cero. La nota final es el promedio de camiones y colisiones. El ejemplo da 20 y 17 respectivamente: nota final 18.5.

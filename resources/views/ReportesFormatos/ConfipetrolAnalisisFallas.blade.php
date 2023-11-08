<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
    <style>
        /*
! tailwindcss v3.3.5 | MIT License | https://tailwindcss.com
*//*
1. Prevent padding and border from affecting element width. (https://github.com/mozdevs/cssremedy/issues/4)
2. Allow adding a border to an element by just adding a border-width. (https://github.com/tailwindcss/tailwindcss/pull/116)
*/

*,
::before,
::after {
  box-sizing: border-box; /* 1 */
  border-width: 0; /* 2 */
  border-style: solid; /* 2 */
  border-color: #e5e7eb; /* 2 */
}

::before,
::after {
  --tw-content: '';
}

/*
1. Use a consistent sensible line-height in all browsers.
2. Prevent adjustments of font size after orientation changes in iOS.
3. Use a more readable tab size.
4. Use the user's configured `sans` font-family by default.
5. Use the user's configured `sans` font-feature-settings by default.
6. Use the user's configured `sans` font-variation-settings by default.
*/

html {
  line-height: 1.5; /* 1 */
  -webkit-text-size-adjust: 100%; /* 2 */
  -moz-tab-size: 4; /* 3 */
  -o-tab-size: 4;
     tab-size: 4; /* 3 */
  font-family: ui-sans-serif, system-ui; /* 4 */
  font-feature-settings: normal; /* 5 */
  font-variation-settings: normal; /* 6 */
}

/*
1. Remove the margin in all browsers.
2. Inherit line-height from `html` so users can set them as a class directly on the `html` element.
*/

body {
  margin: 0; /* 1 */
  line-height: inherit; /* 2 */
}

/*
1. Add the correct height in Firefox.
2. Correct the inheritance of border color in Firefox. (https://bugzilla.mozilla.org/show_bug.cgi?id=190655)
3. Ensure horizontal rules are visible by default.
*/

hr {
  height: 0; /* 1 */
  color: inherit; /* 2 */
  border-top-width: 1px; /* 3 */
}

/*
Add the correct text decoration in Chrome, Edge, and Safari.
*/

abbr:where([title]) {
  -webkit-text-decoration: underline dotted;
          text-decoration: underline dotted;
}

/*
Remove the default font size and weight for headings.
*/

h1,
h2,
h3,
h4,
h5,
h6 {
  font-size: inherit;
  font-weight: inherit;
}

/*
Reset links to optimize for opt-in styling instead of opt-out.
*/

a {
  color: inherit;
  text-decoration: inherit;
}

/*
Add the correct font weight in Edge and Safari.
*/

b,
strong {
  font-weight: bolder;
}

/*
1. Use the user's configured `mono` font family by default.
2. Correct the odd `em` font sizing in all browsers.
*/

code,
kbd,
samp,
pre {
  font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; /* 1 */
  font-size: 1em; /* 2 */
}

/*
Add the correct font size in all browsers.
*/

small {
  font-size: 80%;
}

/*
Prevent `sub` and `sup` elements from affecting the line height in all browsers.
*/

sub,
sup {
  font-size: 75%;
  line-height: 0;
  position: relative;
  vertical-align: baseline;
}

sub {
  bottom: -0.25em;
}

sup {
  top: -0.5em;
}

/*
1. Remove text indentation from table contents in Chrome and Safari. (https://bugs.chromium.org/p/chromium/issues/detail?id=999088, https://bugs.webkit.org/show_bug.cgi?id=201297)
2. Correct table border color inheritance in all Chrome and Safari. (https://bugs.chromium.org/p/chromium/issues/detail?id=935729, https://bugs.webkit.org/show_bug.cgi?id=195016)
3. Remove gaps between table borders by default.
*/

table {
  text-indent: 0; /* 1 */
  border-color: inherit; /* 2 */
  border-collapse: collapse; /* 3 */
}

/*
1. Change the font styles in all browsers.
2. Remove the margin in Firefox and Safari.
3. Remove default padding in all browsers.
*/

button,
input,
optgroup,
select,
textarea {
  font-family: inherit; /* 1 */
  font-feature-settings: inherit; /* 1 */
  font-variation-settings: inherit; /* 1 */
  font-size: 100%; /* 1 */
  font-weight: inherit; /* 1 */
  line-height: inherit; /* 1 */
  color: inherit; /* 1 */
  margin: 0; /* 2 */
  padding: 0; /* 3 */
}

/*
Remove the inheritance of text transform in Edge and Firefox.
*/

button,
select {
  text-transform: none;
}

/*
1. Correct the inability to style clickable types in iOS and Safari.
2. Remove default button styles.
*/

button,
[type='button'],
[type='reset'],
[type='submit'] {
  -webkit-appearance: button; /* 1 */
  background-color: transparent; /* 2 */
  background-image: none; /* 2 */
}

/*
Use the modern Firefox focus style for all focusable elements.
*/

:-moz-focusring {
  outline: auto;
}

/*
Remove the additional `:invalid` styles in Firefox. (https://github.com/mozilla/gecko-dev/blob/2f9eacd9d3d995c937b4251a5557d95d494c9be1/layout/style/res/forms.css#L728-L737)
*/

:-moz-ui-invalid {
  box-shadow: none;
}

/*
Add the correct vertical alignment in Chrome and Firefox.
*/

progress {
  vertical-align: baseline;
}

/*
Correct the cursor style of increment and decrement buttons in Safari.
*/

::-webkit-inner-spin-button,
::-webkit-outer-spin-button {
  height: auto;
}

/*
1. Correct the odd appearance in Chrome and Safari.
2. Correct the outline style in Safari.
*/

[type='search'] {
  -webkit-appearance: textfield; /* 1 */
  outline-offset: -2px; /* 2 */
}

/*
Remove the inner padding in Chrome and Safari on macOS.
*/

::-webkit-search-decoration {
  -webkit-appearance: none;
}

/*
1. Correct the inability to style clickable types in iOS and Safari.
2. Change font properties to `inherit` in Safari.
*/

::-webkit-file-upload-button {
  -webkit-appearance: button; /* 1 */
  font: inherit; /* 2 */
}

/*
Add the correct display in Chrome and Safari.
*/

summary {
  display: list-item;
}

/*
Removes the default spacing and border for appropriate elements.
*/

blockquote,
dl,
dd,
h1,
h2,
h3,
h4,
h5,
h6,
hr,
figure,
p,
pre {
  margin: 0;
}

fieldset {
  margin: 0;
  padding: 0;
}

legend {
  padding: 0;
}

ol,
ul,
menu {
  list-style: none;
  margin: 0;
  padding: 0;
}

/*
Reset default styling for dialogs.
*/
dialog {
  padding: 0;
}

/*
Prevent resizing textareas horizontally by default.
*/

textarea {
  resize: vertical;
}

/*
1. Reset the default placeholder opacity in Firefox. (https://github.com/tailwindlabs/tailwindcss/issues/3300)
2. Set the default placeholder color to the user's configured gray 400 color.
*/

input::-moz-placeholder, textarea::-moz-placeholder {
  opacity: 1; /* 1 */
  color: #9ca3af; /* 2 */
}

input::placeholder,
textarea::placeholder {
  opacity: 1; /* 1 */
  color: #9ca3af; /* 2 */
}

/*
Set the default cursor for buttons.
*/

button,
[role="button"] {
  cursor: pointer;
}

/*
Make sure disabled buttons don't get the pointer cursor.
*/
:disabled {
  cursor: default;
}

/*
1. Make replaced elements `display: block` by default. (https://github.com/mozdevs/cssremedy/issues/14)
2. Add `vertical-align: middle` to align replaced elements more sensibly by default. (https://github.com/jensimmons/cssremedy/issues/14#issuecomment-634934210)
   This can trigger a poorly considered lint error in some tools but is included by design.
*/

img,
svg,
video,
canvas,
audio,
iframe,
embed,
object {
  display: block; /* 1 */
  vertical-align: middle; /* 2 */
}

/*
Constrain images and videos to the parent width and preserve their intrinsic aspect ratio. (https://github.com/mozdevs/cssremedy/issues/14)
*/

img,
video {
  max-width: 100%;
  height: auto;
}

/* Make elements with the HTML hidden attribute stay hidden by default */
[hidden] {
  display: none;
}

*, ::before, ::after {
  --tw-border-spacing-x: 0;
  --tw-border-spacing-y: 0;
  --tw-translate-x: 0;
  --tw-translate-y: 0;
  --tw-rotate: 0;
  --tw-skew-x: 0;
  --tw-skew-y: 0;
  --tw-scale-x: 1;
  --tw-scale-y: 1;
  --tw-pan-x:  ;
  --tw-pan-y:  ;
  --tw-pinch-zoom:  ;
  --tw-scroll-snap-strictness: proximity;
  --tw-gradient-from-position:  ;
  --tw-gradient-via-position:  ;
  --tw-gradient-to-position:  ;
  --tw-ordinal:  ;
  --tw-slashed-zero:  ;
  --tw-numeric-figure:  ;
  --tw-numeric-spacing:  ;
  --tw-numeric-fraction:  ;
  --tw-ring-inset:  ;
  --tw-ring-offset-width: 0px;
  --tw-ring-offset-color: #fff;
  --tw-ring-color: rgb(59 130 246 / 0.5);
  --tw-ring-offset-shadow: 0 0 #0000;
  --tw-ring-shadow: 0 0 #0000;
  --tw-shadow: 0 0 #0000;
  --tw-shadow-colored: 0 0 #0000;
  --tw-blur:  ;
  --tw-brightness:  ;
  --tw-contrast:  ;
  --tw-grayscale:  ;
  --tw-hue-rotate:  ;
  --tw-invert:  ;
  --tw-saturate:  ;
  --tw-sepia:  ;
  --tw-drop-shadow:  ;
  --tw-backdrop-blur:  ;
  --tw-backdrop-brightness:  ;
  --tw-backdrop-contrast:  ;
  --tw-backdrop-grayscale:  ;
  --tw-backdrop-hue-rotate:  ;
  --tw-backdrop-invert:  ;
  --tw-backdrop-opacity:  ;
  --tw-backdrop-saturate:  ;
  --tw-backdrop-sepia:  ;
}

::backdrop {
  --tw-border-spacing-x: 0;
  --tw-border-spacing-y: 0;
  --tw-translate-x: 0;
  --tw-translate-y: 0;
  --tw-rotate: 0;
  --tw-skew-x: 0;
  --tw-skew-y: 0;
  --tw-scale-x: 1;
  --tw-scale-y: 1;
  --tw-pan-x:  ;
  --tw-pan-y:  ;
  --tw-pinch-zoom:  ;
  --tw-scroll-snap-strictness: proximity;
  --tw-gradient-from-position:  ;
  --tw-gradient-via-position:  ;
  --tw-gradient-to-position:  ;
  --tw-ordinal:  ;
  --tw-slashed-zero:  ;
  --tw-numeric-figure:  ;
  --tw-numeric-spacing:  ;
  --tw-numeric-fraction:  ;
  --tw-ring-inset:  ;
  --tw-ring-offset-width: 0px;
  --tw-ring-offset-color: #fff;
  --tw-ring-color: rgb(59 130 246 / 0.5);
  --tw-ring-offset-shadow: 0 0 #0000;
  --tw-ring-shadow: 0 0 #0000;
  --tw-shadow: 0 0 #0000;
  --tw-shadow-colored: 0 0 #0000;
  --tw-blur:  ;
  --tw-brightness:  ;
  --tw-contrast:  ;
  --tw-grayscale:  ;
  --tw-hue-rotate:  ;
  --tw-invert:  ;
  --tw-saturate:  ;
  --tw-sepia:  ;
  --tw-drop-shadow:  ;
  --tw-backdrop-blur:  ;
  --tw-backdrop-brightness:  ;
  --tw-backdrop-contrast:  ;
  --tw-backdrop-grayscale:  ;
  --tw-backdrop-hue-rotate:  ;
  --tw-backdrop-invert:  ;
  --tw-backdrop-opacity:  ;
  --tw-backdrop-saturate:  ;
  --tw-backdrop-sepia:  ;
}
.col-span-2 {
  grid-column: span 2 / span 2;
}
.col-span-3 {
  grid-column: span 3 / span 3;
}
.col-span-5 {
  grid-column: span 5 / span 5;
}
.col-span-6 {
  grid-column: span 6 / span 6;
}
.col-start-1 {
  grid-column-start: 1;
}
.col-start-2 {
  grid-column-start: 2;
}
.col-start-7 {
  grid-column-start: 7;
}
.row-span-2 {
  grid-row: span 2 / span 2;
}
.row-span-5 {
  grid-row: span 5 / span 5;
}
.row-start-1 {
  grid-row-start: 1;
}
.row-start-2 {
  grid-row-start: 2;
}
.row-start-3 {
  grid-row-start: 3;
}
.mt-10 {
  margin-top: 2.5rem;
}
.flex {
  display: flex;
}
.grid {
  display: grid;
}
.h-full {
  height: 100%;
}
.w-1\/2 {
  width: 50%;
}
.w-1\/4 {
  width: 25%;
}
.w-1\/5 {
  width: 20%;
}
.w-2\/4 {
  width: 50%;
}
.w-3\/4 {
  width: 75%;
}
.w-4\/5 {
  width: 80%;
}
.w-full {
  width: 100%;
}
.grid-cols-11 {
  grid-template-columns: repeat(11, minmax(0, 1fr));
}
.grid-cols-3 {
  grid-template-columns: repeat(3, minmax(0, 1fr));
}
.grid-cols-6 {
  grid-template-columns: repeat(6, minmax(0, 1fr));
}
.flex-col {
  flex-direction: column;
}
.items-center {
  align-items: center;
}
.justify-center {
  justify-content: center;
}
.justify-between {
  justify-content: space-between;
}
.gap-5 {
  gap: 1.25rem;
}
.border-2 {
  border-width: 2px;
}
.border-x-2 {
  border-left-width: 2px;
  border-right-width: 2px;
}
.border-y-2 {
  border-top-width: 2px;
  border-bottom-width: 2px;
}
.border-b-2 {
  border-bottom-width: 2px;
}
.border-l-2 {
  border-left-width: 2px;
}
.border-r-2 {
  border-right-width: 2px;
}
.border-t-2 {
  border-top-width: 2px;
}
.bg-red-900 {
  --tw-bg-opacity: 1;
  background-color: rgb(127 29 29 / var(--tw-bg-opacity));
}
.bg-green-500 {
  --tw-bg-opacity: 1;
  background-color: rgb(34 197 94 / var(--tw-bg-opacity));
}
.bg-orange-500 {
  --tw-bg-opacity: 1;
  background-color: rgb(249 115 22 / var(--tw-bg-opacity));
}
.bg-red-500 {
  --tw-bg-opacity: 1;
  background-color: rgb(239 68 68 / var(--tw-bg-opacity));
}
.bg-yellow-500 {
  --tw-bg-opacity: 1;
  background-color: rgb(234 179 8 / var(--tw-bg-opacity));
}
.p-20 {
  padding: 5rem;
}
.text-center {
  text-align: center;
}
.font-sans {
  font-family: ui-sans-serif, system-ui;
}
.font-bold {
  font-weight: 700;
}
    </style>
</head>
<body>
  <div class="p-20 font-sans">
        <div class="flex">
          <div class="w-1/4 flex justify-center items-center border-2">
            LOGO
          </div>
          <div class="w-2/4 flex flex-col justify-center items-center">
            <div class="border-t-2 w-full text-center h-full font-bold">
              CONFIPETROL
            </div>
            <div class="border-y-2 w-full text-center h-full font-bold">
              REPORTE DE FALLA
            </div>
          </div>
          <div class="w-1/4 flex flex-col  justify-center items-center border-2">
            <div class="font-bold">Código: O&M-IMC1-F-3</div>
            <div class="font-bold">Versión: 2</div>
            <div class="font-bold">Fecha: 15-11-2019</div>
            <div class="font-bold">Página 1 de 5</div>
          </div>
        </div>
  
        <div class="mt-10">
          <div class="flex border-2">
            <div class="w-1/4 text-center border-r-2 font-bold">CONTRATO / CLIENTE</div>
            <div class="w-1/4 text-center"></div>
            <div class="w-1/4 text-center border-x-2 font-bold">FECHA DEL REPORTE</div>
            <div class="w-1/4 text-center"></div>
          </div>
  
          <div class="flex border-b-2">
            <div class="w-1/4 text-center border-x-2 font-bold">
              PERSONA QUE REPORTA
            </div>
            <div class="w-1/4 text-center"></div>
            <div class="w-1/4 text-center border-x-2 font-bold">
              CARGO DE QUIEN REPORTA
            </div>
            <div class="w-1/4 text-center border-r-2"></div>
          </div>
          <div class="flex border-b-2">
            <div class="w-1/4 text-center border-x-2 font-bold">NOMBRE EVENTO</div>
            <div class="w-1/4 text-center"></div>
            <div class="w-1/4 text-center border-x-2 font-bold">FINALIZADO</div>
            <div class="w-1/4 text-center border-r-2"></div>
          </div>
        </div>
  
        <h1 class="font-bold mt-10">1. INFORMACIÓN GENERAL:</h1>
        <h3 class="font-bold">1.1 Ubicación</h3>
        <div class="">
          <div class="flex border-2">
            <div class="w-1/4 text-center border-r-2 font-bold">CAMPO</div>
            <div class="w-1/4 text-center border-r-2 font-bold">SISTEMA</div>
            <div class="w-1/4 text-center border-r-2 font-bold">EQUIPO</div>
            <div class="w-1/4 text-center font-bold">COMPONENTE QUE FALLA</div>
          </div>
          <div class="flex border-b-2">
            <div class="w-1/4 text-center border-x-2">&nbsp; </div>
            <div class="w-1/4 text-center border-r-2">&nbsp; </div>
            <div class="w-1/4 text-center border-r-2">&nbsp; </div>
            <div class="w-1/4 text-center border-r-2">&nbsp; </div>
          </div>
          <div class="flex border-b-2">
            <div class="w-1/4 text-center border-x-2 font-bold">
              Ubicación Técnica CMMS
            </div>
            <div class="w-3/4 text-center border-r-2">
              Jerarquía en niveles según CMMS (SAP, ELLIPSE, MP9, Etc) Ej:
              CC-MSE-JUYS-CART-CFGT
            </div>
          </div>
        </div>
        <h3 class="font-bold mt-10">1.2 Fechas</h3>
        <div class=" flex">
          <div class="flex flex-col  w-1/4 border-2">
            <div class="text-center border-b-2 font-bold">FECHA Y HORA DEL EVENTO</div>
            <div class="flex">
              <div class="flex w-full flex-col text-center border-r-2">
                <div class="text-center border-b-2 font-bold">(DD/MM/AAAA)</div>
                <div class="text-cente">&nbsp;</div>
              </div>
              <div class="flex w-full flex-col text-center">
                <div class="text-center border-b-2 font-bold">(HH:MM)</div>
                <div class="text-cente">&nbsp;</div>
              </div>
            </div>
          </div>
          <div class="flex flex-col  w-1/4 border-y-2">
            <div class="text-center border-b-2 font-bold">
              FECHA Y HORA DE RE-ESTABLECIMIENTO{" "}
            </div>
            <div class="flex">
              <div class="flex w-full flex-col text-center border-r-2">
                <div class="text-center border-b-2 font-bold">(DD/MM/AAAA)</div>
                <div class="text-cente">&nbsp;</div>
              </div>
              <div class="flex w-full flex-col text-center">
                <div class="text-center border-b-2 font-bold">(HH:MM)</div>
                <div class="text-cente">&nbsp;</div>
              </div>
            </div>
          </div>
          <div class="flex flex-col justify-between w-1/4 border-t-2 border-b-2 border-l-2">
            <div class="text-center border-b-2 font-bold">HOROMETRO</div>
            <div class="text-center">&nbsp;</div>
          </div>
          <div class="flex flex-col justify-between w-1/4 border-2">
            <div class="text-center border-b-2 font-bold">No. AVISO/OT EN CMMS</div>
            <div class="text-center">&nbsp;</div>
          </div>
        </div>
        <h3 class="font-bold mt-10">1.3 Valoración*</h3>
        <div class=" grid grid-cols-11 border-2">
          <div class="border-r-2 border-b-2 text-center">&nbsp;</div>
          <div class=" font-bold border-r-2 border-b-2 text-center col-start-2 col-span-5">
            Severidad
          </div>
          <div class=" font-bold border-b-2 text-center col-start-7 col-span-5">
            Frecuencia ocurrencia
          </div>
  
          <div class="border-r-2 border-b-2 text-center font-bold ">No.</div>
          <div class="border-r-2 border-b-2 text-center font-bold ">Personas</div>
          <div class="border-r-2 border-b-2 text-center font-bold ">Económica</div>
          <div class="border-r-2 border-b-2 text-center font-bold ">Ambiental</div>
          <div class="border-r-2 border-b-2 text-center font-bold ">
            Pérdidas de Producción
          </div>
          <div class="border-r-2 border-b-2 text-center font-bold">
            Imagen de la empresa
          </div>
          <div class="border-r-2 border-b-2 text-center font-bold">
            1 Vez cada 5 años o más
          </div>
          <div class="border-r-2 border-b-2 text-center font-bold">
            1 Vez cada 3 años
          </div>
          <div class="border-r-2 border-b-2 text-center font-bold">1 Vez al Año</div>
          <div class="border-r-2 border-b-2 text-center font-bold">
            1 Vez cada 3 meses
          </div>
          <div class="border-b-2 text-center font-bold">1 Vez al mes</div>
  
          <div class="border-r-2 border-b-2 text-center">1</div>
          <div class="border-r-2 border-b-2 text-center">Fatabilidad</div>
          <div class="border-r-2 border-b-2 text-center">
            Mayor a 50.000USD
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Mayor(Fuga mayor a 199 BIs)
          </div>
          <div class="border-r-2 border-b-2 text-center">Mayor a 10%</div>
          <div class="border-r-2 border-b-2 text-center">Internacional</div>
          <div class="border-r-2 border-b-2 text-center bg-yellow-500">
            Media
          </div>
          <div class="border-r-2 border-b-2 text-center bg-yellow-500">
            Media
          </div>
          <div class="border-r-2 border-b-2 text-center bg-orange-500">
            Alta
          </div>
          <div class="border-r-2 border-b-2 text-center bg-orange-500">
            Alta
          </div>
          <div class="border-b-2 text-center bg-red-500">Muy Alta</div>
  
          <div class="border-r-2 border-b-2 text-center">2</div>
          <div class="border-r-2 border-b-2 text-center">
            Incapacidad Permanente (Total o Parcial)
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Entre 25.0001 a 50.000 USD
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Importante (Fuga entre 10 a 100Bis)
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Entre 7% y 10% Prod. Diaria
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Nacionaol con afectaciones
          </div>
          <div class="border-r-2 border-b-2 text-center ">Baja</div>
          <div class="border-r-2 border-b-2 text-center bg-yellow-500">
            Media
          </div>
          <div class="border-r-2 border-b-2 text-center bg-yellow-500">
            Media
          </div>
          <div class="border-r-2 border-b-2 text-center bg-orange-500">
            Alta
          </div>
          <div class=" border-b-2 text-center bg-orange-500">Alta</div>
  
          <div class="border-r-2 border-b-2 text-center">3</div>
          <div class="border-r-2 border-b-2 text-center">
            Incapacidad Temporal (Total o Parcial)
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Entre 10.0001 a 25.000USD
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Importante (Fuga entre 1 A 100BIs)
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Entre 3% y 7% Prod. Dairia
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Nacionaol sin afectaciones
          </div>
          <div class="border-r-2 border-b-2 text-center ">Baja</div>
          <div class="border-r-2 border-b-2 text-center ">Baja</div>
          <div class="border-r-2 border-b-2 text-center ">Baja</div>
          <div class="border-r-2 border-b-2 text-center bg-yellow-500">
            Media
          </div>
          <div class="border-b-2 text-center bg-orange-500">Alta</div>
  
          <div class="border-r-2 border-b-2 text-center">4</div>
          <div class="border-r-2 border-b-2 text-center">
            Lesión Menor (Sin Incapacidad)
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Entre 2001 a 10.000 USD
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Menor (Fuga Entre 0,1 a1 Bis)
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Entre 1% y 3% Prod. Dairia
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Nacionaol y baja importancia
          </div>
          <div class="border-r-2 border-b-2 text-center bg-green-500">
            Nula
          </div>
          <div class="border-r-2 border-b-2 text-center ">Baja</div>
          <div class="border-r-2 border-b-2 text-center ">Baja</div>
          <div class="border-r-2 border-b-2 text-center ">Baja</div>
          <div class="border-b-2 text-center bg-yellow-500">Media</div>
  
          <div class="border-r-2 border-b-2 text-center">5</div>
          <div class="border-r-2 border-b-2 text-center">Lesión Leve</div>
          <div class="border-r-2 border-b-2 text-center">
            Menor a 2000 USD
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Leve (Fuga Menor 0,1 BIs)
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Menor a 1% Prod. Diaria
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Local o baja importancia
          </div>
          <div class="border-r-2 border-b-2 text-center bg-green-500">
            Nula
          </div>
          <div class="border-r-2 border-b-2 text-center bg-green-500">
            Nula
          </div>
          <div class="border-r-2 border-b-2 text-center bg-green-500">
            Nula
          </div>
          <div class="border-r-2 border-b-2 text-center ">Baja</div>
          <div class="border-b-2 text-center ">Baja</div>
  
          <div class="border-r-2 border-b-2 text-center">6</div>
          <div class="border-r-2 border-b-2 text-center">Sin Lesión</div>
          <div class="border-r-2 border-b-2 text-center">Ninguna</div>
          <div class="border-r-2 border-b-2 text-center">Ninguna</div>
          <div class="border-r-2 border-b-2 text-center">Ninguna</div>
          <div class="border-r-2 border-b-2 text-center">Ninguna</div>
          <div class="border-r-2 text-center bg-green-500">Nula</div>
          <div class="border-r-2 text-center bg-green-500">Nula</div>
          <div class="border-r-2 text-center bg-green-500">Nula</div>
          <div class="border-r-2 text-center bg-green-500">Nula</div>
          <div class="text-center bg-green-500">Nula</div>
  
          <div class="border-r-2 text-center col-start-1 col-span-6">
            &nbsp;
          </div>
          <div class="border-r-2 text-center">A</div>
          <div class="border-r-2 text-center">B</div>
          <div class="border-r-2 text-center">C</div>
          <div class="border-r-2 text-center">D</div>
          <div class=" text-center">E</div>
        </div>
  
        <div class="mt-10 flex gap-5">
          <div class="w-1/2 grid grid-cols-3 border-2">
            <div class="col-start-1 col-span-3 border-b-2 text-center font-bold">
              Valoración de Riesgo Real
            </div>
  
            <div class="text-center border-b-2 border-r-2 font-bold">Descripción</div>
            <div class="text-center border-b-2 border-r-2 font-bold">Afectación</div>
            <div class="text-center border-b-2 font-bold">Clasificación</div>
  
            <div class="border-b-2 border-r-2 row-start-3 col-start-1">
              Personas
            </div>
            <div class="border-b-2 border-r-2  row-start-3">&nbsp;</div>
            <div class="row-start-3 row-span-5"></div>
  
            <div class="border-b-2 border-r-2">Económica</div>
            <div class="border-b-2 border-r-2"></div>
  
            <div class="border-b-2 border-r-2">Ambiental</div>
            <div class="border-b-2 border-r-2"></div>
  
            <div class="border-b-2 border-r-2">Pérdidas de Producción</div>
            <div class="border-b-2 border-r-2"></div>
  
            <div class="border-r-2">Imagen de la Empresa</div>
            <div class="border-r-2"></div>
          </div>
          <div class="w-1/2 grid grid-cols-3 border-2">
            <div class="col-start-1 col-span-3 border-b-2 text-center font-bold">
              Valoración de Riesgo Potencial
            </div>
  
            <div class="text-center border-b-2 border-r-2 font-bold">Descripción</div>
            <div class="text-center border-b-2 border-r-2 font-bold">Afectación</div>
            <div class="text-center border-b-2 font-bold">Clasificación</div>
  
            <div class="border-b-2 border-r-2 row-start-3 col-start-1">
              Personas
            </div>
            <div class="border-b-2 border-r-2  row-start-3">&nbsp;</div>
            <div class="row-start-3 row-span-5"></div>
  
            <div class="border-b-2 border-r-2">Económica</div>
            <div class="border-b-2 border-r-2"></div>
  
            <div class="border-b-2 border-r-2">Ambiental</div>
            <div class="border-b-2 border-r-2"></div>
  
            <div class="border-b-2 border-r-2">Pérdidas de Producción</div>
            <div class="border-b-2 border-r-2"></div>
  
            <div class="border-r-2">Imagen de la Empresa</div>
            <div class="border-r-2"></div>
          </div>
        </div>
  
        <div class="flex mt-10">
          <div class="w-1/4 flex justify-center items-center border-2">
            LOGO
          </div>
          <div class="w-2/4 flex flex-col justify-center items-center">
            <div class="border-t-2 w-full text-center h-full font-bold">
              CONFIPETROL
            </div>
            <div class="border-y-2 w-full text-center h-full font-bold">
              REPORTE DE FALLA
            </div>
          </div>
          <div class="w-1/4 flex flex-col  justify-center items-center border-2">
            <div class=" font-bold">Código: O&M-IMC1-F-3</div>
            <div class=" font-bold">Versión: 2</div>
            <div class=" font-bold">Fecha: 15-11-2019</div>
            <div class=" font-bold">Página 1 de 5</div>
          </div>
        </div>
        <h1 class="mt-10 font-bold">2. CONTEXTO OPERACIONAL</h1>
        <div>
          (Descripción de Contexto operacional incluyendo parámetros de
          Funcionamiento (presión, Temperatura, potencia, Horas de funcionamiento,
          etc), Ventana operacional (parámetros de diseño), Ubicación geográfica,
          Ubicación Funcional y toda la información relacionada al contexto en
          donde ocurrió el evento para ayudar al grupo investigador a entender el
          proceso y encontrar la causa raíz del evento.)
        </div>
  
        <h1 class="mt-10 font-bold">3. DESCRIPCIÓN DE LA FALLA Y SECUENCIA DE EVENTOS</h1>
        <div>
          (Describir la falla y Listar la secuencia cronológica desde el inicio
          identificado de la falla hasta la normalización o acciones en curso)
        </div>
  
        <h3 class="mt-10 font-bold">Descripción Falla:</h3>
        <h3 class="mt-10 font-bold">Secuencia Eventos:</h3>
  
        <div class="grid grid-cols-3  border-2">
          <div class="text-center border-b-2 border-r-2 font-bold">Fecha</div>
          <div class="text-center border-b-2 border-r-2 font-bold">Hora</div>
          <div class="text-center border-b-2 border-r-2 font-bold">
            Descripción Actividad, Suceso, Evento
          </div>
  
          <div class="text-center border-b-2 border-r-2">&nbsp;</div>
          <div class="text-center border-b-2 border-r-2">&nbsp;</div>
          <div class="text-center border-b-2">&nbsp;</div>
  
          <div class="text-center border-b-2 border-r-2">&nbsp;</div>
          <div class="text-center border-b-2 border-r-2">&nbsp;</div>
          <div class="text-center border-b-2">&nbsp;</div>
  
          <div class="text-center border-b-2 border-r-2">&nbsp;</div>
          <div class="text-center border-b-2 border-r-2">&nbsp;</div>
          <div class="text-center border-b-2">&nbsp;</div>
  
          <div class="text-center border-b-2 border-r-2">&nbsp;</div>
          <div class="text-center border-b-2 border-r-2">&nbsp;</div>
          <div class="text-center border-b-2">&nbsp;</div>
  
          <div class="text-center border-b-2 border-r-2">&nbsp;</div>
          <div class="text-center border-b-2 border-r-2">&nbsp;</div>
          <div class="text-center border-b-2">&nbsp;</div>
  
          <div class="text-center border-b-2 border-r-2">&nbsp;</div>
          <div class="text-center border-b-2 border-r-2">&nbsp;</div>
          <div class="text-center border-b-2">&nbsp;</div>
  
          <div class="text-center border-r-2">&nbsp;</div>
          <div class="text-center border-r-2">&nbsp;</div>
          <div class="text-center">&nbsp;</div>
        </div>
  
        <h1 class="mt-10 font-bold">4. ANTECEDENTES Y EVIDENCIAS:</h1>
  
        <div>
          (Describir la falla y Listar la secuencia cronológica desde el inicio
          identificado de la falla hasta la normalización o acciones en curso)
        </div>
  
        <div class="flex">
          <div class="w-1/4 flex justify-center items-center border-2">
            LOGO
          </div>
          <div class="w-2/4 flex flex-col justify-center items-center">
            <div class="border-t-2 w-full text-center h-full font-bold">
              CONFIPETROL
            </div>
            <div class="border-y-2 w-full text-center h-full font-bold">
              REPORTE DE FALLA
            </div>
          </div>
          <div class="w-1/4 flex flex-col  justify-center items-center border-2">
            <div class=" font-bold">Código: O&M-IMC1-F-3</div>
            <div class=" font-bold">Versión: 2</div>
            <div class=" font-bold">Fecha: 15-11-2019</div>
            <div class=" font-bold">Página 1 de 5</div>
          </div>
        </div>
  
        <h1 class="mt-10 font-bold">5. ANÁLISIS DE LA FALLA Y DETERMINACIÓN DE CAUSA RAÍZ</h1>
        <p>(Anexar el árbol causal de falla)</p>
  
        <div class="mt-10 font-bold">IMG</div>
  
        <h3 class="mt-10 font-bold">Definición de causas raíces:</h3>
  
        <div class=" flex flex-col border-2">
          <div class="flex">
            <div class="border-r-2 border-b-2 w-1/5 text-center font-bold">Causa Raíz física:</div>
            <div class="w-4/5 border-b-2">&nbsp;</div>
          </div>
          <div class="flex">
            <div class="border-r-2 border-b-2 w-1/5 text-center font-bold">Causa Raíz Humana:</div>
            <div class="w-4/5 border-b-2">&nbsp;</div>
          </div>
          <div class="flex">
            <div class="border-r-2 w-1/5 text-center font-bold">Causa Raíz Sistema/Latente:</div>
            <div class="w-4/5">&nbsp;</div>
          </div>
        </div>
  
        <div class="flex mt-10">
          <div class="w-1/4 flex justify-center items-center border-2">
            LOGO
          </div>
          <div class="w-2/4 flex flex-col justify-center items-center">
            <div class="border-t-2 w-full text-center h-full font-bold">
              CONFIPETROL
            </div>
            <div class="border-y-2 w-full text-center h-full font-bold">
              REPORTE DE FALLA
            </div>
          </div>
          <div class="w-1/4 flex flex-col  justify-center items-center border-2">
            <div class=" font-bold">Código: O&M-IMC1-F-3</div>
            <div class=" font-bold">Versión: 2</div>
            <div class=" font-bold">Fecha: 15-11-2019</div>
            <div class=" font-bold">Página 1 de 5</div>
          </div>
        </div>
  
        <div class="mt-10 border-2 grid grid-col-7">
          <div class="font-bold row-start-1 row-span-2  text-center border-r-2 border-b-2">
            Modo de falla
          </div>
          <div class="font-bold row-start-1 row-span-2  text-center border-r-2 border-b-2">
            Hipótesis de la falla
          </div>
          <div class="font-bold row-start-1 row-span-2  text-center border-r-2 border-b-2">
            Acción de Verificación
          </div>
          <div class="font-bold row-start-1 row-span-2  text-center border-r-2 border-b-2">
            Responsable
          </div>
          <div class="font-bold row-start-1 row-span-2  text-center border-r-2 border-b-2">
            Fecha
          </div>
          <div class="font-bold row-start-1 text-center col-span-2 border-b-2">
            Resultado
          </div>
  
          <div class="font-bold row-start-2 text-center border-r-2 border-b-2">
            Descripción
          </div>
          <div class="font-bold row-start-2 text-center border-b-2">Status</div>
  
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-b-2">&nbsp;</div>
  
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-b-2">&nbsp;</div>
  
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-b-2">&nbsp;</div>
  
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-b-2">&nbsp;</div>
  
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-r-2 border-b-2">&nbsp;</div>
          <div class="text-center border-b-2">&nbsp;</div>
  
          <div class="text-center border-r-2">&nbsp;</div>
          <div class="text-center border-r-2">&nbsp;</div>
          <div class="text-center border-r-2">&nbsp;</div>
          <div class="text-center border-r-2">&nbsp;</div>
          <div class="text-center border-r-2">&nbsp;</div>
          <div class="text-center border-r-2">&nbsp;</div>
          <div class="text-center">&nbsp;</div>
        </div>
  
        <h1 class="mt-10 font-bold">7. RECOMENDACIONES PARA ELIMINACIÓN DE CAUSA RAÍCES</h1>
        <p>
          (Documente las recomendaciones para eliminar la recurrencia del evento
          de falla)
        </p>
        <div class="grid grid-cols-11 border-2">
          <div class="border-r-2 border-b-2 text-center">&nbsp;</div>
          <div class="font-bold border-r-2 border-b-2 text-center col-start-2 col-span-5">
            Severidad
          </div>
          <div class="font-bold border-b-2 text-center col-start-7 col-span-5">
            Frecuencia ocurrencia
          </div>
  
          <div class="border-r-2 border-b-2 text-center font-bold">No.</div>
          <div class="border-r-2 border-b-2 text-center font-bold">Personas</div>
          <div class="border-r-2 border-b-2 text-center font-bold">Económica</div>
          <div class="border-r-2 border-b-2 text-center font-bold">Ambiental</div>
          <div class="border-r-2 border-b-2 text-center font-bold">
            Pérdidas de Producción
          </div>
          <div class="font-bold border-r-2 border-b-2 text-center">
            Imagen de la empresa
          </div>
          <div class="font-bold border-r-2 border-b-2 text-center">
            1 Vez cada 5 años o más
          </div>
          <div class="font-bold border-r-2 border-b-2 text-center">
            1 Vez cada 3 años
          </div>
          <div class="font-bold border-r-2 border-b-2 text-center">1 Vez al Año</div>
          <div class="font-bold border-r-2 border-b-2 text-center">
            1 Vez cada 3 meses
          </div>
          <div class="border-b-2 text-center font-bold">1 Vez al mes</div>
  
          <div class="border-r-2 border-b-2 text-center">1</div>
          <div class="border-r-2 border-b-2 text-center">Fatabilidad</div>
          <div class="border-r-2 border-b-2 text-center">
            Mayor a 50.000USD
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Mayor(Fuga mayor a 199 BIs)
          </div>
          <div class="border-r-2 border-b-2 text-center">Mayor a 10%</div>
          <div class="border-r-2 border-b-2 text-center">Internacional</div>
          <div class="border-r-2 border-b-2 text-center bg-yellow-500">
            Media
          </div>
          <div class="border-r-2 border-b-2 text-center bg-yellow-500">
            Media
          </div>
          <div class="border-r-2 border-b-2 text-center bg-orange-500">
            Alta
          </div>
          <div class="border-r-2 border-b-2 text-center bg-orange-500">
            Alta
          </div>
          <div class="border-b-2 text-center bg-red-500">Muy Alta</div>
  
          <div class="border-r-2 border-b-2 text-center">2</div>
          <div class="border-r-2 border-b-2 text-center">
            Incapacidad Permanente (Total o Parcial)
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Entre 25.0001 a 50.000 USD
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Importante (Fuga entre 10 a 100Bis)
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Entre 7% y 10% Prod. Diaria
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Nacionaol con afectaciones
          </div>
          <div class="border-r-2 border-b-2 text-center ">Baja</div>
          <div class="border-r-2 border-b-2 text-center bg-yellow-500">
            Media
          </div>
          <div class="border-r-2 border-b-2 text-center bg-yellow-500">
            Media
          </div>
          <div class="border-r-2 border-b-2 text-center bg-orange-500">
            Alta
          </div>
          <div class=" border-b-2 text-center bg-orange-500">Alta</div>
  
          <div class="border-r-2 border-b-2 text-center">3</div>
          <div class="border-r-2 border-b-2 text-center">
            Incapacidad Temporal (Total o Parcial)
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Entre 10.0001 a 25.000USD
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Importante (Fuga entre 1 A 100BIs)
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Entre 3% y 7% Prod. Dairia
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Nacionaol sin afectaciones
          </div>
          <div class="border-r-2 border-b-2 text-center ">Baja</div>
          <div class="border-r-2 border-b-2 text-center ">Baja</div>
          <div class="border-r-2 border-b-2 text-center ">Baja</div>
          <div class="border-r-2 border-b-2 text-center bg-yellow-500">
            Media
          </div>
          <div class="border-b-2 text-center bg-orange-500">Alta</div>
  
          <div class="border-r-2 border-b-2 text-center">4</div>
          <div class="border-r-2 border-b-2 text-center">
            Lesión Menor (Sin Incapacidad)
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Entre 2001 a 10.000 USD
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Menor (Fuga Entre 0,1 a1 Bis)
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Entre 1% y 3% Prod. Dairia
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Nacionaol y baja importancia
          </div>
          <div class="border-r-2 border-b-2 text-center bg-green-500">
            Nula
          </div>
          <div class="border-r-2 border-b-2 text-center ">Baja</div>
          <div class="border-r-2 border-b-2 text-center ">Baja</div>
          <div class="border-r-2 border-b-2 text-center ">Baja</div>
          <div class="border-b-2 text-center bg-yellow-500">Media</div>
  
          <div class="border-r-2 border-b-2 text-center">5</div>
          <div class="border-r-2 border-b-2 text-center">Lesión Leve</div>
          <div class="border-r-2 border-b-2 text-center">
            Menor a 2000 USD
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Leve (Fuga Menor 0,1 BIs)
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Menor a 1% Prod. Diaria
          </div>
          <div class="border-r-2 border-b-2 text-center">
            Local o baja importancia
          </div>
          <div class="border-r-2 border-b-2 text-center bg-green-500">
            Nula
          </div>
          <div class="border-r-2 border-b-2 text-center bg-green-500">
            Nula
          </div>
          <div class="border-r-2 border-b-2 text-center bg-green-500">
            Nula
          </div>
          <div class="border-r-2 border-b-2 text-center ">Baja</div>
          <div class="border-b-2 text-center ">Baja</div>
  
          <div class="border-r-2 border-b-2 text-center">6</div>
          <div class="border-r-2 border-b-2 text-center">Sin Lesión</div>
          <div class="border-r-2 border-b-2 text-center">Ninguna</div>
          <div class="border-r-2 border-b-2 text-center">Ninguna</div>
          <div class="border-r-2 border-b-2 text-center">Ninguna</div>
          <div class="border-r-2 border-b-2 text-center">Ninguna</div>
          <div class="border-r-2 text-center bg-green-500">Nula</div>
          <div class="border-r-2 text-center bg-green-500">Nula</div>
          <div class="border-r-2 text-center bg-green-500">Nula</div>
          <div class="border-r-2 text-center bg-green-500">Nula</div>
          <div class="text-center bg-green-500">Nula</div>
  
          <div class="border-r-2 text-center col-start-1 col-span-6">
            &nbsp;
          </div>
          <div class="border-r-2 text-center">A</div>
          <div class="border-r-2 text-center">B</div>
          <div class="border-r-2 text-center">C</div>
          <div class="border-r-2 text-center">D</div>
          <div class=" text-center">E</div>
        </div>
  
        <div class="flex mt-10">
          <div class="w-1/4 flex justify-center items-center border-2">
            LOGO
          </div>
          <div class="w-2/4 flex flex-col justify-center items-center">
            <div class="font-bold border-t-2 w-full text-center h-full">
              CONFIPETROL
            </div>
            <div class="font-bold border-y-2 w-full text-center h-full">
              REPORTE DE FALLA
            </div>
          </div>
          <div class="w-1/4 flex flex-col  justify-center items-center border-2">
            <div class="font-bold ">Código: O&M-IMC1-F-3</div>
            <div class="font-bold ">Versión: 2</div>
            <div class="font-bold ">Fecha: 15-11-2019</div>
            <div class="font-bold ">Página 1 de 5</div>
          </div>
        </div>
  
        <h3 class="mt-10 font-bold">Acciones Correctivas</h3>
        <div class="grid grid-cols-6 border-2">
          <div class="border-b-2 border-r-2 text-center font-bold">Prioridad</div>
          <div class="border-b-2 border-r-2 text-center font-bold">Causa Raíz</div>
          <div class="border-b-2 border-r-2 text-center font-bold">Recomendación</div>
          <div class="border-b-2 border-r-2 text-center font-bold">Responsable</div>
          <div class="border-b-2 border-r-2 text-center font-bold">Empresa</div>
          <div class="border-b-2 text-center font-bold">Fecha</div>
  
          <div class="border-b-2 border-r-2">&nbsp;</div>
          <div class="border-b-2 border-r-2">&nbsp; </div>
          <div class="border-b-2 border-r-2">&nbsp;</div>
          <div class="border-b-2 border-r-2">&nbsp;</div>
          <div class="border-b-2 border-r-2">&nbsp;</div>
          <div class="border-b-2">&nbsp;</div>
  
          <div class="border-b-2 border-r-2">&nbsp;</div>
          <div class="border-b-2 border-r-2">&nbsp; </div>
          <div class="border-b-2 border-r-2">&nbsp;</div>
          <div class="border-b-2 border-r-2">&nbsp;</div>
          <div class="border-b-2 border-r-2">&nbsp;</div>
          <div class="border-b-2">&nbsp;</div>
          
          <div class=" border-r-2">&nbsp;</div>
          <div class=" border-r-2">&nbsp; </div>
          <div class=" border-r-2">&nbsp;</div>
          <div class=" border-r-2">&nbsp;</div>
          <div class=" border-r-2">&nbsp;</div>
          <div class="">&nbsp;</div>
        </div>
        <h3 class="mt-10 font-bold">Acciones de Mejora</h3>
        <div class="grid grid-cols-6 border-2">
          <div class="border-b-2 border-r-2 text-center font-bold">Prioridad</div>
          <div class="border-b-2 border-r-2 text-center font-bold">Causa Raíz</div>
          <div class="border-b-2 border-r-2 text-center font-bold">Recomendación</div>
          <div class="border-b-2 border-r-2 text-center font-bold">Responsable</div>
          <div class="border-b-2 border-r-2 text-center font-bold">Empresa</div>
          <div class="border-b-2 text-center font-bold">Fecha</div>
  
          <div class="border-b-2 border-r-2">&nbsp;</div>
          <div class="border-b-2 border-r-2">&nbsp; </div>
          <div class="border-b-2 border-r-2">&nbsp;</div>
          <div class="border-b-2 border-r-2">&nbsp;</div>
          <div class="border-b-2 border-r-2">&nbsp;</div>
          <div class="border-b-2">&nbsp;</div>
  
          <div class="border-b-2 border-r-2">&nbsp;</div>
          <div class="border-b-2 border-r-2">&nbsp; </div>
          <div class="border-b-2 border-r-2">&nbsp;</div>
          <div class="border-b-2 border-r-2">&nbsp;</div>
          <div class="border-b-2 border-r-2">&nbsp;</div>
          <div class="border-b-2">&nbsp;</div>
  
          <div class=" border-r-2">&nbsp;</div>
          <div class=" border-r-2">&nbsp;</div>
          <div class=" border-r-2">&nbsp;</div>
          <div class=" border-r-2">&nbsp;</div>
          <div class=" border-r-2">&nbsp;</div>
          <div class="">&nbsp;</div>
        </div>
        <p class="mt-10">
         <span class="font-bold">Nota:</span>  Se debe tener en cuenta el procedimiento de manejo del cambio de
          cada cliente.
        </p>
      </div>>
</body>
</html>
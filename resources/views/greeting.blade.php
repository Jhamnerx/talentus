Here is the HTML code using TailwindCSS for the screenshot you provided. This code aims to replicate the layout and
visual details as closely as possible.

```html
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="max-w-screen-xl mx-auto p-5">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center border-b pb-4">
                <div>
                    <img src="https://placehold.co/150x50" alt="Logo">
                </div>
                <div class="text-right">
                    <h2 class="text-xl font-semibold">TAI HENG S A</h2>
                    <p>sistema@cpafacil.com</p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6 py-4">
                <div>
                    <label class="text-sm">Tipo comprobante</label>
                    <select
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option>BOLETA DE VENTA ELECTRÓNICA</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm">Serie</label>
                    <select
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option>B001</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm">Tipo Operación</label>
                    <select
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option>Venta interna</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-4 gap-6 py-2">
                <div>
                    <label class="text-sm">Fecha. Emisión</label>
                    <input type="date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        value="2024-05-11">
                </div>
                <div>
                    <label class="text-sm">Fec. Vencimiento</label>
                    <input type="date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        value="2024-05-11">
                </div>
                <div>
                    <label class="text-sm">Moneda</label>
                    <select
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option>Soles</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm">Tipo de cambio</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        placeholder="3.708">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 py-2">
                <div>
                    <label class="text-sm">Cliente [+ Nuevo]</label>
                    <input type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        placeholder="Escriba el nombre o número de documento del cliente">
                </div>
                <div>
                    <label class="text-sm">Dirección</label>
                    <select class="mt-1 block w-full rounded-md border-gray-300 shadow

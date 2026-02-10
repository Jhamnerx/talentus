-- ================================================
-- FIX: Actualizar type_movement en payments existentes
-- ================================================
-- Muchos payments no tienen type_movement asignado (creados antes del fix)
-- Esto causa que se muestren en rojo como egresos cuando son ingresos

-- 1️⃣ VER cuántos payments NO tienen type_movement
SELECT 
    COUNT(*) as total_sin_type_movement,
    paymentable_type,
    COUNT(*) as cantidad
FROM payments 
WHERE type_movement IS NULL OR type_movement = ''
GROUP BY paymentable_type;

-- 2️⃣ ACTUALIZAR Ventas y Recibos como INGRESO
UPDATE payments 
SET type_movement = 'INGRESO'
WHERE (type_movement IS NULL OR type_movement = '')
  AND paymentable_type IN (
      'App\\Models\\Ventas',
      'App\\Models\\Recibos',
      'App\\Models\\Factura'
  );

-- 3️⃣ ACTUALIZAR Compras y RecibosPagosVarios como EGRESO
UPDATE payments 
SET type_movement = 'EGRESO'
WHERE (type_movement IS NULL OR type_movement = '')
  AND paymentable_type IN (
      'App\\Models\\Compras',
      'App\\Models\\RecibosPagosVarios'
  );

-- 4️⃣ VERIFICAR resultados
SELECT 
    type_movement,
    paymentable_type,
    COUNT(*) as cantidad,
    SUM(monto) as total_monto
FROM payments 
GROUP BY type_movement, paymentable_type
ORDER BY type_movement, paymentable_type;

-- 5️⃣ VER los últimos movimientos para verificar
SELECT 
    numero,
    fecha,
    type_movement,
    paymentable_type,
    divisa,
    monto,
    destination_type,
    destination_id
FROM payments 
ORDER BY id DESC 
LIMIT 20;

<?php 
// Views/Layout/table-asistencias.php
if (!empty($lista_asistencias) && is_array($lista_asistencias)):
    foreach ($lista_asistencias as $fila): ?>
<tr>
    <td><?= htmlspecialchars($fila['dni'], ENT_QUOTES, 'UTF-8') ?></td>
    <td><?= htmlspecialchars($fila['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
    <td><?= htmlspecialchars($fila['apellido'], ENT_QUOTES, 'UTF-8') ?></td>
    <td><?= htmlspecialchars($fila['carrera'], ENT_QUOTES, 'UTF-8') ?></td>
    <td><?= htmlspecialchars($fila['desayuno'], ENT_QUOTES, 'UTF-8') ?></td>
    <td><?= htmlspecialchars($fila['almuerzo'], ENT_QUOTES, 'UTF-8') ?></td>
    <td><?= htmlspecialchars($fila['refrigerio'], ENT_QUOTES, 'UTF-8') ?></td>
</tr>
<?php 
    endforeach;
else: ?>
<tr>
    <td colspan="7">No hay registros de asistencia.</td>
</tr>
<?php endif; ?>

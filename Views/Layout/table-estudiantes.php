<?php
// Views/Layout/table-estudiantes.php
foreach ($estudiantes as $est): ?>
<tr>
    <td><?= htmlspecialchars($est['id']) ?></td>
    <td><?= htmlspecialchars($est['dni']) ?></td>
    <td><?= htmlspecialchars($est['nombre'] . ' ' . $est['apellido']) ?></td>
    <td><?= htmlspecialchars($est['carrera'] ?? 'No asignada') ?></td>
    <td><?= htmlspecialchars($est['condicion'] ?? 'No asignada') ?></td>
    <td class="user-actions">
    <button 
            class="btn <?= htmlspecialchars($est['btnClass'] ?? 'btn-secondary') ?> btn-sm btn-info-est" 
            title="Faltas: <?= (int)($est['total_faltas'] ?? 0) ?>"
            data-id="<?= htmlspecialchars($est['id']) ?>"
        >
            <i class="fas fa-plus"></i>
        </button>
        <span style="display:none;"><?= htmlspecialchars($est['btnClass'] ?? '') ?></span>
    </td>
</tr>
<?php endforeach; ?>

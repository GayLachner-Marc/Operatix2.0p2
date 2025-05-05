<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<h2>Reservas del Hotel</h2>

<?php if (!empty($reservas)): ?>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Precio</th>
            <th>Origen</th>
            <th>Destino</th>
        </tr>
        <?php foreach ($reservas as $reserva): ?>
            <tr>
                <td><?= $reserva['id_reserva'] ?></td>
                <td><?= $reserva['fecha_reserva'] ?></td>
                <td><?= $reserva['precio'] ?? 'N/A' ?></td>
                <td><?= $reserva['origen_nombre'] ?></td>
                <td><?= $reserva['destino_nombre'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No hay reservas registradas para este hotel.</p>
<?php endif; ?>

<p><a href="/hotel/home">← Volver al Panel del Hotel</a></p>

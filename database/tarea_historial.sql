use caballos_db;
DELIMITER //
CREATE EVENT mover_reservas
ON SCHEDULE EVERY 1 DAY
STARTS (CURRENT_DATE() + INTERVAL 1 DAY + INTERVAL 1 HOUR)
DO
BEGIN
    INSERT INTO historials (id_user, id_caballo, fecha_reserva, turno, comentario)
    SELECT id_user, id_caballo, fecha_reserva, turno, comentario
    FROM reservas
    WHERE fecha_reserva = CURRENT_DATE() - INTERVAL 1 DAY;

    DELETE FROM reservas
    WHERE fecha_reserva = CURRENT_DATE() - INTERVAL 1 DAY;

END //
DELIMITER ;

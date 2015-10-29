-- Nuevos campos para los totales de votos de las fichas
ALTER TABLE  `ficha` ADD  `votos_positivos` int(11) NOT NULL DEFAULT  '0';
ALTER TABLE  `ficha` ADD  `votos_negativos` int(11) NOT NULL DEFAULT  '0';

-- Se actualizan las ficha con las evaluaciones anteriores
UPDATE ficha ficha_update SET
ficha_update.votos_positivos = (
    SELECT COUNT(e.id) AS positivos
    FROM evaluacion AS e
    WHERE e.rating >= 4 AND e.ficha_id = ficha_update.id
    GROUP BY e.ficha_id
),
ficha_update.votos_negativos = (
    SELECT COUNT(e.id) AS negativos
    FROM evaluacion AS e
    WHERE e.rating <= 2 AND e.ficha_id = ficha_update.id
    GROUP BY e.ficha_id
)
WHERE ficha_update.maestro = 1
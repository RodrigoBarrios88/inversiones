Madre
2490138860101
Katherine Lissethe 	Carrera Flores

Notificación
(Reporte de Pañal) Cambios y Observaciones:
Cambio por pipi: 1.
Cambio por popo: 0.
Consistencia: Normal.
2018-06-14 10:49:39
2018-06-18 09:03:49

Sobre quien
3682950600101
Katia Marina Giron Carrera
2 años de edad

------------------------------------------


UPDATE push_notification 
SET type_id = type_id * 10
WHERE `message` LIKE '(Reporte de %';

UPDATE app_panial
SET pan_codigo = pan_codigo*10
WHERE 1 = 1;

UPDATE app_golpe
SET gol_codigo = gol_codigo*10
WHERE 1 = 1;

UPDATE app_enfermedad
SET enf_codigo = enf_codigo*10
WHERE 1 = 1;


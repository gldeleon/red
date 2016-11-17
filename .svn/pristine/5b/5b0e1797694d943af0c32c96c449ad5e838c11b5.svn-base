/*ACTUALIZA TABLA company*/
DELETE FROM kobemxco_red.company;
INSERT INTO kobemxco_red.company(
	SELECT com.com_id, com.usr_id, com.com_name, com.com_rfc,
	CONCAT_WS(' ',a.calle,a.no_exterior,a.no_interior,z.zpc_colonia,CONCAT('C.P. ',LPAD(z.zpc_code,5,0)),z.zpc_local,s.stt_name) AS com_address, NULL AS com_tel,
	cct.comcontact_name AS com_contact, cct.comcontact_phone AS com_conttel, 0 AS com_agrstage,
	(CASE com_active WHEN 1 THEN 1 WHEN 2 THEN 0 ELSE 0 END) AS com_active
	FROM dentalia.company com
	LEFT JOIN dentalia.address a ON a.com_id = com.com_id
	LEFT JOIN dentalia.zipcode z ON z.zpc_id = a.zpc_id
	LEFT JOIN dentalia.state s ON s.stt_id = z.stt_id
	LEFT JOIN dentalia.comcontact cct ON cct.com_id = com.com_id
)
;

/*ACTUALIZA TABLA agreement*/
DELETE FROM kobemxco_red.agreement;
INSERT INTO kobemxco_red.agreement(
	SELECT 
	agr.agr_id,
	ca.com_id,
	agr.usr_id,
	agr.agreetype_id AS atp_id,
	agr.agrcov_id AS agl_id,
	agr.agr_name,
	agr.agr_desc,
	agr.agr_req AS agr_reqs,
	agr.agr_validity_ini AS agr_ini,
	agr.agr_validity_end AS agr_end,
	agr.emp_id,
	(CASE agr_active WHEN 1 THEN 1 WHEN 2 THEN 0 ELSE 0 END) AS agr_active,
	(CASE agr.validity_type WHEN 'INDIVIDUAL' THEN 1 WHEN 'GRUPAL' THEN 0 ELSE 0 END) AS tipo_vigencia,
	0 AS agr_pago,
	al.legend AS agr_reclegend,
	0 AS comgrp_id
	FROM dentalia.agreement agr
	LEFT JOIN dentalia.comagree ca ON ca.agr_id = agr.agr_id
	LEFT JOIN dentalia.agreelegend al ON al.agr_id = agr.agr_id
	WHERE ca.com_id IS NOT NULL
	group by agr_id
);

/*ACTUALIZA TABLA agreetreat*/
DELETE FROM kobemxco_red.agreetreat;
INSERT INTO kobemxco_red.agreetreat (
	SELECT null, atr.agr_id, atr.trt_id, atr.trt_discount, atr.spc_price, IF(atc.agrtrt_times IS NULL,0,atc.agrtrt_times),
		   IF(atc.agrtrt_discount IS NULL, 0, atc.agrtrt_discount), 0, CURDATE()
	FROM dentalia.agreetreat atr
	LEFT JOIN dentalia.agrtrtcount atc
	ON atc.agrtreat_id = atr.agrtreat_id
	-- WHERE atr.agr_id = 347
);

/*ACTUALIZA TABLA agreetype*/
DELETE FROM kobemxco_red.agreetype;
INSERT INTO kobemxco_red.agreetype(
	SELECT agreetype_id AS atp_id, 1 AS usr_id,agreetype_name AS atp_name FROM dentalia.agreetype WHERE active = 1
);
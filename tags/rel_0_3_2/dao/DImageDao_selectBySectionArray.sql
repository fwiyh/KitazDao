SELECT
	*
FROM
	D_IMAGE
/*BEGIN*/
WHERE
/*IF secid != null*/SECID = /*secid*/2/*END*/
/*IF attr != null*/AND ATTR = /*attr*/0/*END*/
/*END*/
ORDER BY
	UPDT DESC
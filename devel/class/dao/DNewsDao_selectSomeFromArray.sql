SELECT
    *
FROM
    D_NEWS
/*BEGIN*/
WHERE
/*IF nids != null*/
    NID IN /*nids*/(10,100,1000)
/*END*/
/*END*/
ORDER BY
    PUBDT DESC,
    ISMORNING DESC
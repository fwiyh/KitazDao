select * from table1
/*BEGIN*/
where
/*if dto.attribute != null*/
attribute = /*dto.attribute*/0
/*end*/
/*if dto.tid != null*/
and
tid = /*dto.tid*/1
/*end*/
/*if dto.tname != null*/
and
tname like /*dto.tname*/'%猫%'
/*end*/
/*END*/
order by tid asc
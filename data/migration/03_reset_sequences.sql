--Quelle: http://wiki.postgresql.org/wiki/Fixing_Sequences
--Benutzung: psql -U jobapp3 -W fut1 -Atq -f reset_sequences.sql -o temp.sql
--   anschließend: psql -U jobapp3 -W fut1 -f temp.sql

SELECT  'SELECT SETVAL(' ||quote_literal(quote_ident(S.relname))|| ', MAX(' ||quote_ident(C.attname)|| ') ) FROM ' ||quote_ident(T.relname)|| ';'
FROM pg_class AS S, pg_depend AS D, pg_class AS T, pg_attribute AS C
WHERE S.relkind = 'S'
    AND S.oid = D.objid
    AND D.refobjid = T.oid
    AND D.refobjid = C.attrelid
    AND D.refobjsubid = C.attnum
ORDER BY S.relname;

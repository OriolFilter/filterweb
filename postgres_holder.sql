-- Testing

insert into users (username,password,email) values ('pau','a','mail.mail.mail');
insert into users (username, password, email) values ('test','test','email');
-- insert into users (username, password, email) values ('test2',crypt('johnspassword', gen_salt('bf')),'email');
insert into users (username, password, email) values ('test',crypt('test', gen_salt('bf')),'email');
delete from users where username='test';
-- https://x-team.com/blog/storing-secure-passwords-with-postgresql/

CREATE EXTENSION pgcrypto;
select crypt('test', gen_salt('bf'));
select crypt('johnspassword', gen_salt('bf'));
select * from users;

CREATE PROCEDURE test (INOUT x int)
    LANGUAGE sql
AS $$
SELECT x;
$$;
call test (1);

-- drop procedure check_login(uname varchar, passwd varchar);
drop function check_login(uname varchar, passwd varchar);
drop table test;

-- call check_user('test2','$2a$06$SPbehnRawRT8wRukc.Fsuuwk39G.QbNuV53QMksTWITJLQQDfKZby');
call check_login('test2','$2a$06$SPbehnRawRT8wRukc.Fsuuwk39G.QbNuV53QMksTWITJLQQDfKZss');
select * from check_login('test2','$2a$06$SPbehnRawRT8wRukc.Fsuuwk39G.QbNuV53QMksTWITJLQQDfKZby');

select * from test('test2','$2a$06$SPbehnRawRT8wRukc.Fsuuwk39G.QbNuV53QMksTWITJLQQDfKZby');
select * from check_login('test2','$2a$06$SPbehnRawRT8wRukc.Fsuuwk39G.QbNuV53QMksTWITJLQQDfKZby');

select * from test(1);
-- select into user_found (case when exists (select from users where username=p_uname and password=crypt(p_passwd,password))
--                                      then 1
--                                  else 0
--         end) as found;
select (case when exists (select regexp_matches('emnail@mailail.mail','^[a-zA-Z0-9.!#$%&''*+=?^_`{z|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$'))then 1 else 0 end );
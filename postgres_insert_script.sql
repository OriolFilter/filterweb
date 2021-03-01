-- Testing

insert into users (username,password,email) values ('pau','a','mail.mail.mail');
insert into users (username, password, email) values ('test','test','email');
insert into users (username, password, email) values ('test2',crypt('johnspassword', gen_salt('bf')),'email');

-- https://x-team.com/blog/storing-secure-passwords-with-postgresql/

CREATE EXTENSION pgcrypto;
select crypt('johnspassword', gen_salt('bf'));
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

-- select * from test(1);
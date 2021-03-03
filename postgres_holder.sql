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
-- drop table test;

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

-- select validate_mail('mail123@as')
call is_alphanumeric('casa123asdas');
-- drop function is_alphanumeric(p_string varchar)


call create_user('test','test','mail.mail@mailm.ai');
-- insert into users(username, password, email) values ('test',crypt('test', gen_salt('bf',8)),to_hex('mail.mail@mailm.ai'));
select encode('mail.mail@mailm.ai','hex');
select * from users;
drop function validate_mail(p_mail varchar);
call validate_username('antoniorivera2 3');
-- call validate_mail('antoniorivera23@sads.a');
call validate_password('test');
drop table users;
select crypt('test', gen_salt('bf',8));
-- select 'test',crypt('test', gen_salt('bf',8)),encode('mail.mail@mailm.ai','hex');

-- insert into users(username, password, email) values ('test',crypt('test', gen_salt('bf',8)),encode('mail.mail@mailm.ai','hex'));
-- select 'test',crypt('test', gen_salt('bf',8)),pg_typeof(encode('mail.mail@mailm.ai','hex'));
-- select 'test',crypt('test', gen_salt('bf',8)),pg_typeof(decode('mail.mail@mailm.ai','utf8string'));
select 'test',crypt('test', gen_salt('bf',8)),pg_typeof(cast(encode('mail.mail@mailm.ai','hex') as bytea));
select 'test',crypt('test', gen_salt('bf',8)),cast(encode('mail.mail@mailm.ai','hex') as bytea);
-- select 'test',crypt('test', gen_salt('bf',8)),pg_typeof(decode(encode('mail.mail@mailm.ai','hex'),'bytea'));

select cast(encode('email','hex') as bytea);

-- insert into users(username, password, email) values ('test',crypt('test', gen_salt('bf',8)),cast(encode('mail.mail@mailm.ai','hex') as bytea));
select * from users;
delete from users where username='test';
select encode(cast('test' as bytea),'hex');
select pg_typeof(encode(cast('test' as bytea),'hex'));
call create_user('test2','test','mail.mail@mailm.ai');

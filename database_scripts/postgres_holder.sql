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
-- drop table activate_account_tokens;
drop table activation_account_tokens;
drop table users;
drop table enabled_users;
-- drop table activated_users;

select user_id from users where username='test2';
-- insert into activated_users(user_id) values (v_uid);
-- select * from activated_users;
select * from users;
select * from enabled_users;
insert into enabled_users (user_id) values (7);
select * from activation_account_tokens;
insert into activation_account_tokens(user_id,activation_account_token) values(32,random_string(60));
select true from users where username='test2';
select random_string(60);
select * from users;
call proc_generate_activation_code(2);
select * from activation_account_tokens where user_id=2;
-- select * ge
-- drop procedure create_activation_code(p_uid integer);
-- drop procedure generate_activation_code(p_uid integer);
-- call generate_activation_code(58);
select random_string(60) as generated_string, user_id from activation_account_tokens;
SELECT * FROM users;
-- select generate_act
call proc_generate_activation_code(2);
call proc_generate_activation_code(2);

-- select * from activate_account_tokens;
select * from func_generate_activation_code(2);
-- select * from activate_account_tokens;
select * from activation_account_tokens;
select * from users;
-- drop procedure create_user(p_user varchar, p_passwd varchar, p_email varchar);
-- drop procedure create_user(p_user varchar, p_passwd varchar, p_email varchar);
-- select true from users where username=p_user;
-- drop procedure register_user(p_user varchar, p_passwd varchar, p_email varchar);
call register_user('user','pass','myemail@abada.asas');
drop table activation_account_tokens;
-- drop table enabled_users;
drop table activation_account_tokens;
drop table login_tokens;
drop table password_recovery_tokens;
drop table activated_accounts;
drop table activate_account_tokens;
drop table users;

select * from users;
select * from activate_account_tokens;
select u.user_id,u.username,a.activated_bool from users u,activated_accounts a where a.user_id=u.user_id and u.username='testing3';
select u.user_id,u.username,a.activation_account_token,a.expires_on as expiration_date from users u,activate_account_tokens a where a.user_id=u.user_id and u.username='test';
select true from activated_accounts a, users u where u.username='test' and a.activated_bool=true and a.user_id=u.user_id;
select true from users where username='testing2';
select func_return_activation_code_from_username('test');
select func_return_generate_activation_code_from_id(2);

call proc_generate_activation_code_from_id(2);
call proc_generate_activation_code_from_username('testing3');
select func_return_activation_code_from_username('testing4');

-- select u.username , aa.activated_bool from users u,activate_account_tokens at, activated_accounts aa where at.activation_account_token='UUYV5cuxX9a3g7p6WAL2JFcRHnXNSl5RQnJCULmjutmfut2xKZsrqZaDt9L9' and aa.user_id=at.user_id and aa.user_id=u.user_id;
-- call proc_activate_account('VPokLaWTgdQvbEdFs9WcXIofVRvgfM8cMQPonqA7wx1l7yssmaCr7k66rmR0');
-- call proc_activate_account('b331fHxo5YM86cC9WbdmgIuHOdiSEmCsPPl1P5EoUKNW5b1UuWLe2FtokfqR');
call proc_activate_account('hDpwsu74fJgFuFr3rXNhgAKg196R37fGnr7qjvgUwBYiJqCWpUpsTMmv0RXc');

-- select username,convert_from(cast(email as bytea),'utf-8') as email_g,email from users;
-- select username, encode(decode(cast(email::bytea as varchar), 'hex'), 'escape') as email_g,email from users;
-- select username, decode(email::varchar, 'hex') as email_g,email from users;
select username, decode(encode(email,'escape'),'hex') as email_g,email from users;
select * from users;
call register_user('te2stlong','longanissa','mymai2l@maimailoso.moil');
select true from users where email='mymail@maimailoso.moil';
insert into users(username, password, email) values('testlong',crypt('longanissa', gen_salt('bf',8)),'mymail@maimailoso.moil');
select * from activate_account_tokens;
select * from activated_accounts;
select * from change_password_tokens order by expires_on desc ;
select count(*) from change_password_tokens;
select * from users;

select func_return_change_password_code_from_email('oriol.filter.7e3@itb.cat');
select func_return_change_password_code_from_email('oriol.filter.7e3@itb.cat');
select func_return_change_password_code(1);
select func_check_email_exists('oriol.filter.7e3@itb.cat');
select func_return_change_password_code('test1234');
select * from change_password_tokens order by created_on desc ;
select func_return_activation_code(10);
-- update activate_account_tokens  set used_bool=false  where user_id=1;
update activated_accounts  set activated_bool=false  where user_id=1;

call proc_check_password_token_is_valid('LjF8cVPr8ZIClgcxTNVZfYs3dkbLq7L3bPN34VJ4lsb5IfyfdmdUv2yKx2sT');

select check_login('test1234','test1234');
call proc_change_password_user('WrnWGp3HLJEBjx7P7pw4bhZx6OuD2UUXAB2Lc7Tqh7dhpWqj5vv4EqYcl6xT','test1235');
select check_login('test1234','test1235');
delete from users where user_id=9;
call proc_check_password_token_is_valid('3L7d7LQ9njacYZkTcmf0Av2O7Rh4XW6FHH1OpUSwr1iUBYpTl9K4RsDMtvx1');
select * from change_password_tokens;
call proc_check_login('test1234','test12345');
select func_return_change_password_code(10);

select func_return_session_code_from_email('oriol.filter.7e3@itb.cat');
select func_return_session_code('test1234');
select * from session_tokens;
drop table session_tokens;
call proc_check_user_is_activated(10);

call proc_login_session_token('iFMXN8t6dWoAiTuSbGrnEDB3DpmQP5LdDLe5Rx83zVlskq4IFegmGkSgDBni');

select func_check_login('test123456','test123456');
call proc_credentials_user('test123456','test123456');
select func_return_session_token_from_credentials('test123456','test123456');
select * from activate_account_tokens;
call proc_activate_account('vIGriatpephpabejcumidUGFY1CYtjulJh6AqRz6LlD22TEbuAPaSGVjeZEi');
select user_id from users where lower('test123456')=lower(username);
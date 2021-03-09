-- create database contact_forms_db;

-- Forms
CREATE TABLE if not exists forms_table (
   form_id serial,
   name varchar(40) not null,
   email varchar(254) not null,
   text text not null ,
   creation_date timestamp DEFAULT now() not null check (now() = creation_date)
);

create or replace procedure insert_form(p_name forms_table.name%type, p_email forms_table.email%type, p_message forms_table.text%type)
as $$
begin

    case when not exists (
            select regexp_matches(p_name,'^[\w0-9 ]{4,40}$')) then
        raise exception
            using errcode = 'P3400',
                message = 'The name given does not meet the requirements.',
                hint = 'Name must be from 4 to 40 characters from the english alphabet or numbers, (spaces allowed)';
        else null;
    end case ;

--     insert_form
        case when not exists (
            select regexp_matches(p_email,'^[a-zA-Z0-9.!#$%&''*+=?^_`{|}~-]+@[a-zA-Z10-9-]+\.[a-zA-Z0-9-]+$')) then
        raise exception
            using errcode = 'P3300',
                message = 'The email given does not meet the requirements.',
                hint = 'Email seems to be invalid';
        else null;
    end case ;

    case when not exists (
            select regexp_matches(p_message,'^[\w\\W]{20,255}$')) then
        raise exception
            using errcode = 'P3500',
                message = 'The text given does not meet the requirements.',
                hint = 'Text message must be from 20 to 255 characters';
        else null;
        end case ;

    insert into forms_table(name, email,text) values (p_name,p_email,p_message);
end;
$$ language plpgsql;
-- drop procedure insert_form;
/* Users */

-- CREATE USER form_user with password 'form_pass';
CREATE ROLE form_user with password 'form_pass' NOLOGIN ;
REVOKE ALL ON DATABASE contact_forms_db FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM PUBLIC;
GRANT CONNECT on database contact_forms_db to form_user;
GRANT ALL on database contact_forms_db to form_user;
-- -- CREATE ROLE form_role nologin;
-- -- GRANT SELECT ON ALL SEQUENCES IN SCHEMA contact_forms_db.public to form_user;
--
-- -- GRANT CONNECT on database contact_forms_db to form_user;
-- GRANT CONNECT on database contact_forms_db to form_user;
-- GRANT ALL on table forms_table to form_user;
-- GRANT ALL ON SEQUENCE forms_table_form_id_seq to form_user;
-- -- GRANT EXECUTE on procedure insert_form to form_user;
-- GRANT ALL on procedure insert_form to form_user;
-- REVOKE ALL ON DATABASE contact_forms_db FROM PUBLIC;
-- REVOKE ALL ON SCHEMA public FROM PUBLIC;
-- GRANT CONNECT on database contact_forms_db to form_user;
-- GRANT USAGE ON SEQUENCE forms_table_form_id_seq to form_user;
-- GRANT INSERT on table forms_table to form_user;
-- GRANT EXECUTE on procedure insert_form to form_user;


/* Delete user
REVOKE ALL on database contact_forms_db to form_user;
REVOKE ALL PRIVILEGES ON SCHEMA PUBLIC ON SCHEMA public to form_user;
REVOKE ALL PRIVILEGES ON ALL TABLES IN SCHEMA public FROM form_user;
REVOKE ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public FROM form_user;
REVOKE ALL PRIVILEGES ON ALL FUNCTIONS IN SCHEMA public FROM form_user;
REVOKE ALL PRIVILEGES ON ALL TABLES IN SCHEMA public FROM form_user;
REVOKE ALL PRIVILEGES ON procedure insert_form FROM form_user;
REVOKE ALL PRIVILEGES ON DATABASE contact_forms_db FROM form_user;
drop user form_user;
-- drop ROLE form_user;
*/
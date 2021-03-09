create database contact_forms_db;

-- drop user form_user;
-- Forms
CREATE TABLE if not exists forms_table (
   form_id serial,
   name varchar(40) not null,
   email varchar(254) not null,
   text text not null ,
   creation_date timestamp DEFAULT now() not null check (now() = creation_date)
);

create or replace procedure insert_form(name forms_table.name%type, email forms_table.email%type, message forms_table.text%type)
as $$
begin

    case when not exists (
            select regexp_matches(name,'^[\w]{4,40}$')) then
        raise exception
            using errcode = 'P3401',
                message = 'The email given does not meet the requirements.',
                hint = 'Name must be from 4 to 40 caracters from the english alphabet';
        else null;
    end case ;

--     insert_form
        case when not exists (
            select regexp_matches(email,'^[a-zA-Z0-9.!#$%&''*+=?^_`{|}~-]+@[a-zA-Z10-9-]+\.[a-zA-Z0-9-]+$')) then
        raise exception
            using errcode = 'P3300',
                message = 'The email given does not meet the requirements.',
                hint = 'Email seems to be invalid';
        else null;
    end case ;

    case when not exists (
            select regexp_matches(message,'^[\w\\W]{20,255}$')) then
        raise exception
            using errcode = 'P3402',
                message = 'The email given does not meet the requirements.',
                hint = 'Text message must be from 20 to 255 characters';
        else null;
        end case ;

--     case when not exists ( /* Nidea, falla */
--             select regexp_matches(text,'^[\w]{4,40}$')) then
--         raise exception
--             using errcode = 'P3402',
--                 message = 'The text given does not meet the requirements.',
--                 hint =
--         else null;
--         end case ;


    insert into forms_table(name, email,text) values (name,email,message);
end;
$$ language plpgsql;

-- drop procedure insert_form;

/* Users */

CREATE USER form_users with password 'form_pass';
REVOKE ALL ON DATABASE contact_forms_db FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM PUBLIC;
GRANT CONNECT on database contact_forms_db to form_user;
GRANT USAGE ON SEQUENCE forms_table_form_id_seq to form_user;
GRANT INSERT on table forms_table to form_user;
GRANT EXECUTE on procedure insert_form to form_user;
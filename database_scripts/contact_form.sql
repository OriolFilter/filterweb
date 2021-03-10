-- create database contact_forms_db;
-- Forms
CREATE TABLE if not exists forms_table (
   form_id serial,
   name varchar(40) not null,
   email varchar(254) not null,
   text text not null,
   creation_date timestamp DEFAULT now() not null check (now() = creation_date)
);

create or replace procedure insert_form(p_name varchar, p_email varchar, p_text text)
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
    case when not exists (
        select regexp_matches(p_email,'^[a-zA-Z0-9.!#$%&''*+=?^_`{|}~-]+@[a-zA-Z10-9-]+\.[a-zA-Z0-9-]+$')) then
    raise exception
        using errcode = 'P3300',
            message = 'The email given does not meet the requirements.',
            hint = 'Email seems to be invalid';
    else null;
    end case ;
    if (length(p_text) < 20 or length(p_text) > 400) then
        raise exception
            using errcode = 'P3500',
                message = 'The text given does not meet the requirements.',
                hint = 'Text message must be from 20 to 400 characters';
    end if;
    insert into forms_table(name, email,text) values (p_name,p_email,p_text);
end;
$$ language plpgsql;

REVOKE ALL ON DATABASE contact_forms_db FROM PUBLIC;
CREATE USER form_user with password 'form_pass';
GRANT CONNECT ON DATABASE contact_forms_db to form_user;
GRANT EXECUTE on procedure insert_form to form_user;
GRANT USAGE on SEQUENCE contact_forms_db.public.forms_table_form_id_seq to form_user;
GRANT INSERT on TABLE forms_table to form_user;

/*
select * from forms_table;
*/
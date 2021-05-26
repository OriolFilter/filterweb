REVOKE ALL ON DATABASE contact_form FROM PUBLIC;
CREATE USER form_user with password 'form_pass';
GRANT CONNECT ON DATABASE contact_form to form_user;
GRANT EXECUTE on procedure insert_form to form_user;
GRANT USAGE on SEQUENCE contact_form.public.forms_table_form_id_seq to form_user;
GRANT INSERT on TABLE forms_table to form_user;
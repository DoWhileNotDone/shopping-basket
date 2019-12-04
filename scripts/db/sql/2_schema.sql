CREATE SCHEMA shoppingbasket AUTHORIZATION shoppingbasketuser;

SET search_path TO shoppingbasket;

GRANT SELECT, INSERT, UPDATE, DELETE ON ALL TABLES IN SCHEMA shoppingbasket TO shoppingbasketuser;
GRANT USAGE, SELECT ON ALL SEQUENCES IN SCHEMA shoppingbasket TO shoppingbasketuser;

SET client_min_messages TO WARNING;

DROP TABLE IF EXISTS player CASCADE;
CREATE TABLE player (
	id         serial primary key,
	name       varchar(32),
	date_added timestamp with time zone default date_trunc('minute', now()),
	active     boolean default true
);

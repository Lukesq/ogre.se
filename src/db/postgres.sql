SET client_min_messages TO WARNING;

DROP TABLE IF EXISTS player CASCADE;
CREATE TABLE player (
	id         serial primary key,
	name       varchar(32),
	date_added timestamp with time zone default date_trunc('minute', now()),
	active     boolean default true
);

DROP TABLE IF EXISTS highscore CASCADE;
CREATE TABLE highscore (
	id        serial primary key,
	player_id int references player(id),
	time      timestamp with time zone default date_trunc('minute', now())
);

DROP TABLE IF EXISTS highscore_stats;
CREATE TABLE highscore_stats (
	id           serial primary key,
	highscore_id int references highscore(id),
	skill        varchar(32),
	rank         int,
	level        int,
	xp           int
);
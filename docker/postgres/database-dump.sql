--
-- PostgreSQL database dump
--

-- Dumped from database version 15.1 (Debian 15.1-1.pgdg110+1)
-- Dumped by pg_dump version 15.1

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: uuid-ossp; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS "uuid-ossp" WITH SCHEMA public;


--
-- Name: EXTENSION "uuid-ossp"; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION "uuid-ossp" IS 'generate universally unique identifiers (UUIDs)';


--
-- Name: delete_expired_sessions(); Type: FUNCTION; Schema: public; Owner: dbuser
--

CREATE FUNCTION public.delete_expired_sessions() RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    DELETE FROM session WHERE expire < now();
END; $$;


ALTER FUNCTION public.delete_expired_sessions() OWNER TO dbuser;

--
-- Name: end_finished_challenges(); Type: FUNCTION; Schema: public; Owner: dbuser
--

CREATE FUNCTION public.end_finished_challenges() RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    UPDATE challenge c
    SET id_status = (SELECT id_status FROM challenge_status WHERE name = 'completed')
    FROM challenge_type ct
    WHERE c.id_status = (SELECT id_status FROM challenge_status WHERE name = 'ongoing')
      AND c.start_date + ct.duration * INTERVAL '1 day' < NOW()
      AND c.id_type = ct.id_type;
END;
$$;


ALTER FUNCTION public.end_finished_challenges() OWNER TO dbuser;

--
-- Name: get_user_entries(integer); Type: FUNCTION; Schema: public; Owner: dbuser
--

CREATE FUNCTION public.get_user_entries(id integer) RETURNS TABLE(id_challenge integer, image character varying)
    LANGUAGE plpgsql
    AS $$
BEGIN
    RETURN QUERY SELECT c.id_challenge, entry.image FROM entry
    RIGHT JOIN challenge c on c.id_challenge = entry.id_challenge
    WHERE id_owner IS NULL OR id_owner = id;
END;
$$;


ALTER FUNCTION public.get_user_entries(id integer) OWNER TO dbuser;

--
-- Name: start_ready_challenge(integer); Type: FUNCTION; Schema: public; Owner: dbuser
--

CREATE FUNCTION public.start_ready_challenge(type integer) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
    UPDATE challenge
    SET id_status  = (SELECT id_status FROM challenge_status WHERE name = 'ongoing'),
        start_date = current_date
    WHERE id_challenge = (SELECT id_challenge FROM challenges_ready WHERE id_type = type LIMIT 1);
END;
$$;


ALTER FUNCTION public.start_ready_challenge(type integer) OWNER TO dbuser;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: challenge; Type: TABLE; Schema: public; Owner: dbuser
--

CREATE TABLE public.challenge (
    id_challenge integer NOT NULL,
    id_type integer NOT NULL,
    topic character varying(255) NOT NULL,
    start_date date,
    id_status integer DEFAULT 1 NOT NULL
);


ALTER TABLE public.challenge OWNER TO dbuser;

--
-- Name: entry; Type: TABLE; Schema: public; Owner: dbuser
--

CREATE TABLE public.entry (
    id_entry integer NOT NULL,
    id_owner integer NOT NULL,
    id_challenge integer NOT NULL,
    image character varying(255) NOT NULL
);


ALTER TABLE public.entry OWNER TO dbuser;

--
-- Name: user; Type: TABLE; Schema: public; Owner: dbuser
--

CREATE TABLE public."user" (
    id_user integer NOT NULL,
    username character varying(64) NOT NULL,
    email character varying(64) NOT NULL,
    password character varying(64) NOT NULL,
    id_role integer NOT NULL
);


ALTER TABLE public."user" OWNER TO dbuser;

--
-- Name: challenge_entries; Type: VIEW; Schema: public; Owner: dbuser
--

CREATE VIEW public.challenge_entries AS
 SELECT c.topic,
    e.image,
    u.username
   FROM ((public.challenge c
     LEFT JOIN public.entry e ON ((c.id_challenge = e.id_challenge)))
     LEFT JOIN public."user" u ON ((u.id_user = e.id_owner)))
  ORDER BY c.topic;


ALTER TABLE public.challenge_entries OWNER TO dbuser;

--
-- Name: challenge_id_seq; Type: SEQUENCE; Schema: public; Owner: dbuser
--

CREATE SEQUENCE public.challenge_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.challenge_id_seq OWNER TO dbuser;

--
-- Name: challenge_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbuser
--

ALTER SEQUENCE public.challenge_id_seq OWNED BY public.challenge.id_challenge;


--
-- Name: challenge_status; Type: TABLE; Schema: public; Owner: dbuser
--

CREATE TABLE public.challenge_status (
    id_status integer NOT NULL,
    name character varying(64) NOT NULL
);


ALTER TABLE public.challenge_status OWNER TO dbuser;

--
-- Name: challenge_status_id_seq; Type: SEQUENCE; Schema: public; Owner: dbuser
--

CREATE SEQUENCE public.challenge_status_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.challenge_status_id_seq OWNER TO dbuser;

--
-- Name: challenge_status_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbuser
--

ALTER SEQUENCE public.challenge_status_id_seq OWNED BY public.challenge_status.id_status;


--
-- Name: challenge_type; Type: TABLE; Schema: public; Owner: dbuser
--

CREATE TABLE public.challenge_type (
    id_type integer NOT NULL,
    name character varying(64) NOT NULL,
    duration integer NOT NULL
);


ALTER TABLE public.challenge_type OWNER TO dbuser;

--
-- Name: challenge_type_id_seq; Type: SEQUENCE; Schema: public; Owner: dbuser
--

CREATE SEQUENCE public.challenge_type_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.challenge_type_id_seq OWNER TO dbuser;

--
-- Name: challenge_type_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbuser
--

ALTER SEQUENCE public.challenge_type_id_seq OWNED BY public.challenge_type.id_type;


--
-- Name: challenges_expired; Type: VIEW; Schema: public; Owner: dbuser
--

CREATE VIEW public.challenges_expired AS
 SELECT c.id_challenge,
    c.id_type
   FROM ((public.challenge c
     JOIN public.challenge_status cs ON ((c.id_status = cs.id_status)))
     JOIN public.challenge_type ct ON ((ct.id_type = c.id_type)))
  WHERE (((cs.name)::text = 'ongoing'::text) AND ((c.start_date + ((ct.duration)::double precision * '1 day'::interval)) < now()));


ALTER TABLE public.challenges_expired OWNER TO dbuser;

--
-- Name: challenges_ready; Type: VIEW; Schema: public; Owner: dbuser
--

CREATE VIEW public.challenges_ready AS
 SELECT c.id_challenge,
    c.id_type
   FROM (public.challenge c
     JOIN public.challenge_status cs ON ((c.id_status = cs.id_status)))
  WHERE ((cs.name)::text = 'ready'::text);


ALTER TABLE public.challenges_ready OWNER TO dbuser;

--
-- Name: entry_id_seq; Type: SEQUENCE; Schema: public; Owner: dbuser
--

CREATE SEQUENCE public.entry_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.entry_id_seq OWNER TO dbuser;

--
-- Name: entry_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbuser
--

ALTER SEQUENCE public.entry_id_seq OWNED BY public.entry.id_entry;


--
-- Name: entry_votes; Type: TABLE; Schema: public; Owner: dbuser
--

CREATE TABLE public.entry_votes (
    id_entry integer NOT NULL,
    votes_count integer
);


ALTER TABLE public.entry_votes OWNER TO dbuser;

--
-- Name: role; Type: TABLE; Schema: public; Owner: dbuser
--

CREATE TABLE public.role (
    id_role integer NOT NULL,
    name character varying(64) NOT NULL
);


ALTER TABLE public.role OWNER TO dbuser;

--
-- Name: role_id_seq; Type: SEQUENCE; Schema: public; Owner: dbuser
--

CREATE SEQUENCE public.role_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.role_id_seq OWNER TO dbuser;

--
-- Name: role_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbuser
--

ALTER SEQUENCE public.role_id_seq OWNED BY public.role.id_role;


--
-- Name: session; Type: TABLE; Schema: public; Owner: dbuser
--

CREATE TABLE public.session (
    id_user integer NOT NULL,
    token character varying(255) NOT NULL,
    expire timestamp without time zone NOT NULL
);


ALTER TABLE public.session OWNER TO dbuser;

--
-- Name: user_id_role_seq; Type: SEQUENCE; Schema: public; Owner: dbuser
--

CREATE SEQUENCE public.user_id_role_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_id_role_seq OWNER TO dbuser;

--
-- Name: user_id_role_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbuser
--

ALTER SEQUENCE public.user_id_role_seq OWNED BY public."user".id_role;


--
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: dbuser
--

CREATE SEQUENCE public.user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_id_seq OWNER TO dbuser;

--
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbuser
--

ALTER SEQUENCE public.user_id_seq OWNED BY public."user".id_user;


--
-- Name: vote; Type: TABLE; Schema: public; Owner: dbuser
--

CREATE TABLE public.vote (
    id_user integer NOT NULL,
    id_challenge integer NOT NULL,
    id_entry integer NOT NULL
);


ALTER TABLE public.vote OWNER TO dbuser;

--
-- Name: challenge id_challenge; Type: DEFAULT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.challenge ALTER COLUMN id_challenge SET DEFAULT nextval('public.challenge_id_seq'::regclass);


--
-- Name: challenge_status id_status; Type: DEFAULT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.challenge_status ALTER COLUMN id_status SET DEFAULT nextval('public.challenge_status_id_seq'::regclass);


--
-- Name: challenge_type id_type; Type: DEFAULT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.challenge_type ALTER COLUMN id_type SET DEFAULT nextval('public.challenge_type_id_seq'::regclass);


--
-- Name: entry id_entry; Type: DEFAULT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.entry ALTER COLUMN id_entry SET DEFAULT nextval('public.entry_id_seq'::regclass);


--
-- Name: role id_role; Type: DEFAULT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.role ALTER COLUMN id_role SET DEFAULT nextval('public.role_id_seq'::regclass);


--
-- Name: user id_user; Type: DEFAULT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public."user" ALTER COLUMN id_user SET DEFAULT nextval('public.user_id_seq'::regclass);


--
-- Data for Name: challenge; Type: TABLE DATA; Schema: public; Owner: dbuser
--

COPY public.challenge (id_challenge, id_type, topic, start_date, id_status) FROM stdin;
4	2	River running through a city	2023-01-08	3
7	1	Apples	2023-01-02	3
3	2	Beach scene with palm trees	\N	1
8	2	Landscape with a mountain and a lake	\N	1
6	1	Bird on a branch	\N	1
1	1	Cat	2023-01-17	2
5	1	Face	2023-01-01	3
2	2	Cityscape at sunset	2023-01-15	2
\.


--
-- Data for Name: challenge_status; Type: TABLE DATA; Schema: public; Owner: dbuser
--

COPY public.challenge_status (id_status, name) FROM stdin;
1	ready
2	ongoing
3	completed
\.


--
-- Data for Name: challenge_type; Type: TABLE DATA; Schema: public; Owner: dbuser
--

COPY public.challenge_type (id_type, name, duration) FROM stdin;
1	daily	1
2	weekly	7
\.


--
-- Data for Name: entry; Type: TABLE DATA; Schema: public; Owner: dbuser
--

COPY public.entry (id_entry, id_owner, id_challenge, image) FROM stdin;
28	23	4	uploads/63c523f4ac87d.png
30	23	5	uploads/63c5245e2a539.png
31	23	7	uploads/63c5247814299.png
32	24	7	uploads/63c525de567b4.png
33	24	4	uploads/63c525ee462f6.png
35	25	5	uploads/63c52d2f2d0a9.jpg
36	25	4	uploads/63c52d501bebe.jpg
37	25	7	uploads/63c52dabe2861.png
57	1	2	uploads/63c6b6550ae64.jpg
59	1	1	uploads/63c6bd0a05c58.jpg
60	1	5	uploads/63c6bd1347e25.jpg
\.


--
-- Data for Name: entry_votes; Type: TABLE DATA; Schema: public; Owner: dbuser
--

COPY public.entry_votes (id_entry, votes_count) FROM stdin;
\.


--
-- Data for Name: role; Type: TABLE DATA; Schema: public; Owner: dbuser
--

COPY public.role (id_role, name) FROM stdin;
1	user
2	admin
\.


--
-- Data for Name: session; Type: TABLE DATA; Schema: public; Owner: dbuser
--

COPY public.session (id_user, token, expire) FROM stdin;
1	9fb2d4babb3cb7bdf0331d23774b80e5f8a9b7cd2a0184d4cfe54f6e81f7ad92	2023-01-18 14:35:56
\.


--
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: dbuser
--

COPY public."user" (id_user, username, email, password, id_role) FROM stdin;
1	a	a	$2y$10$wtNBrgIQGTWZEQWf77gIBe6VsUUxURO9sdGWNHOcuUpsk/veaj7Pa	2
23	Jan	jan@email.com	$2y$10$KF73OqML9jduGTu6QZgG2ujvU2YuR1qC.8z3zlJ.kEFjcIaPPtQZC	1
24	Adam	adam@email.com	$2y$10$gjx0PINsfzrMm1BIqtRPvuHOZf8Imxcf2PiECD94BUB9tQxDNpJBu	1
25	username	username@email.com	$2y$10$AOhkjiNsgbVWuzi0swMKV.t5xQJhEgMqYWYne8kyX9M5SWCgZdWKS	1
\.


--
-- Data for Name: vote; Type: TABLE DATA; Schema: public; Owner: dbuser
--

COPY public.vote (id_user, id_challenge, id_entry) FROM stdin;
\.


--
-- Name: challenge_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbuser
--

SELECT pg_catalog.setval('public.challenge_id_seq', 23, true);


--
-- Name: challenge_status_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbuser
--

SELECT pg_catalog.setval('public.challenge_status_id_seq', 3, true);


--
-- Name: challenge_type_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbuser
--

SELECT pg_catalog.setval('public.challenge_type_id_seq', 3, true);


--
-- Name: entry_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbuser
--

SELECT pg_catalog.setval('public.entry_id_seq', 60, true);


--
-- Name: role_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbuser
--

SELECT pg_catalog.setval('public.role_id_seq', 2, true);


--
-- Name: user_id_role_seq; Type: SEQUENCE SET; Schema: public; Owner: dbuser
--

SELECT pg_catalog.setval('public.user_id_role_seq', 2, true);


--
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbuser
--

SELECT pg_catalog.setval('public.user_id_seq', 33, true);


--
-- Name: challenge challenge_pk; Type: CONSTRAINT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.challenge
    ADD CONSTRAINT challenge_pk PRIMARY KEY (id_challenge);


--
-- Name: challenge_status challenge_status_pk; Type: CONSTRAINT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.challenge_status
    ADD CONSTRAINT challenge_status_pk PRIMARY KEY (id_status);


--
-- Name: challenge_type challenge_type_pk; Type: CONSTRAINT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.challenge_type
    ADD CONSTRAINT challenge_type_pk PRIMARY KEY (id_type);


--
-- Name: entry entry_pk; Type: CONSTRAINT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.entry
    ADD CONSTRAINT entry_pk PRIMARY KEY (id_entry);


--
-- Name: entry_votes entry_votes_pk; Type: CONSTRAINT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.entry_votes
    ADD CONSTRAINT entry_votes_pk PRIMARY KEY (id_entry);


--
-- Name: role role_pk; Type: CONSTRAINT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.role
    ADD CONSTRAINT role_pk PRIMARY KEY (id_role);


--
-- Name: session session_pk; Type: CONSTRAINT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.session
    ADD CONSTRAINT session_pk PRIMARY KEY (id_user);


--
-- Name: user user_pk; Type: CONSTRAINT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pk PRIMARY KEY (id_user);


--
-- Name: vote vote_pk; Type: CONSTRAINT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.vote
    ADD CONSTRAINT vote_pk PRIMARY KEY (id_user, id_challenge);


--
-- Name: challenge challenge_challenge_status_id_status_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.challenge
    ADD CONSTRAINT challenge_challenge_status_id_status_fk FOREIGN KEY (id_status) REFERENCES public.challenge_status(id_status) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: challenge challenge_challenge_type_id_type_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.challenge
    ADD CONSTRAINT challenge_challenge_type_id_type_fk FOREIGN KEY (id_type) REFERENCES public.challenge_type(id_type) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: entry entry_challenge_id_challenge_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.entry
    ADD CONSTRAINT entry_challenge_id_challenge_fk FOREIGN KEY (id_challenge) REFERENCES public.challenge(id_challenge) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: entry entry_user_id_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.entry
    ADD CONSTRAINT entry_user_id_user_fk FOREIGN KEY (id_owner) REFERENCES public."user"(id_user) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: entry_votes entry_votes_entry_id_entry_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.entry_votes
    ADD CONSTRAINT entry_votes_entry_id_entry_fk FOREIGN KEY (id_entry) REFERENCES public.entry(id_entry) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: session session_user_id_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.session
    ADD CONSTRAINT session_user_id_user_fk FOREIGN KEY (id_user) REFERENCES public."user"(id_user);


--
-- Name: user user_role_id_role_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_role_id_role_fk FOREIGN KEY (id_role) REFERENCES public.role(id_role) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: vote vote_challenge_id_challenge_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.vote
    ADD CONSTRAINT vote_challenge_id_challenge_fk FOREIGN KEY (id_challenge) REFERENCES public.challenge(id_challenge) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: vote vote_entry_id_entry_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.vote
    ADD CONSTRAINT vote_entry_id_entry_fk FOREIGN KEY (id_entry) REFERENCES public.entry(id_entry) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: vote vote_user_id_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbuser
--

ALTER TABLE ONLY public.vote
    ADD CONSTRAINT vote_user_id_user_fk FOREIGN KEY (id_user) REFERENCES public."user"(id_user) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--


--
-- PostgreSQL database dump
--

-- Dumped from database version 16.3
-- Dumped by pg_dump version 16.3

-- Started on 2024-11-07 17:07:31

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
-- TOC entry 2 (class 3079 OID 49260)
-- Name: pgcrypto; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA public;


--
-- TOC entry 4974 (class 0 OID 0)
-- Dependencies: 2
-- Name: EXTENSION pgcrypto; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION pgcrypto IS 'cryptographic functions';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 223 (class 1259 OID 49227)
-- Name: avaliacoes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.avaliacoes (
    id integer NOT NULL,
    id_setor integer,
    id_pergunta integer,
    id_dispositivo integer,
    resposta integer NOT NULL,
    feedback_textual text,
    data_hora timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT avaliacoes_resposta_check CHECK (((resposta >= 0) AND (resposta <= 10)))
);


ALTER TABLE public.avaliacoes OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 49226)
-- Name: avaliacoes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.avaliacoes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.avaliacoes_id_seq OWNER TO postgres;

--
-- TOC entry 4975 (class 0 OID 0)
-- Dependencies: 222
-- Name: avaliacoes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.avaliacoes_id_seq OWNED BY public.avaliacoes.id;


--
-- TOC entry 219 (class 1259 OID 49177)
-- Name: dispositivos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.dispositivos (
    id_dispositivos integer NOT NULL,
    nome_dispositivo character varying(255) NOT NULL,
    status character varying(10),
    CONSTRAINT dispositivos_status_check CHECK (((status)::text = ANY ((ARRAY['ativo'::character varying, 'inativo'::character varying])::text[])))
);


ALTER TABLE public.dispositivos OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 49176)
-- Name: dispositivos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.dispositivos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.dispositivos_id_seq OWNER TO postgres;

--
-- TOC entry 4976 (class 0 OID 0)
-- Dependencies: 218
-- Name: dispositivos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.dispositivos_id_seq OWNED BY public.dispositivos.id_dispositivos;


--
-- TOC entry 217 (class 1259 OID 49167)
-- Name: perguntas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.perguntas (
    id_perguntas integer NOT NULL,
    pergunta text NOT NULL,
    status character varying(10),
    tipo text NOT NULL,
    CONSTRAINT perguntas_status_check CHECK (((status)::text = ANY ((ARRAY['ativa'::character varying, 'inativa'::character varying])::text[])))
);


ALTER TABLE public.perguntas OWNER TO postgres;

--
-- TOC entry 216 (class 1259 OID 49166)
-- Name: perguntas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.perguntas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.perguntas_id_seq OWNER TO postgres;

--
-- TOC entry 4977 (class 0 OID 0)
-- Dependencies: 216
-- Name: perguntas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.perguntas_id_seq OWNED BY public.perguntas.id_perguntas;


--
-- TOC entry 221 (class 1259 OID 49185)
-- Name: setores; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.setores (
    id_setor integer NOT NULL,
    nome character varying(100) NOT NULL,
    status character varying(10) NOT NULL,
    CONSTRAINT setores_status_check CHECK (((status)::text = ANY ((ARRAY['ativo'::character varying, 'inativo'::character varying])::text[])))
);


ALTER TABLE public.setores OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 49184)
-- Name: setores_id_setor_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.setores_id_setor_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.setores_id_setor_seq OWNER TO postgres;

--
-- TOC entry 4978 (class 0 OID 0)
-- Dependencies: 220
-- Name: setores_id_setor_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.setores_id_setor_seq OWNED BY public.setores.id_setor;


--
-- TOC entry 225 (class 1259 OID 49253)
-- Name: usuarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuarios (
    id_usuarios integer NOT NULL,
    usuario character varying(100) NOT NULL,
    senha character varying(255) NOT NULL,
    data_criacao timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.usuarios OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 49252)
-- Name: usuarios_id_usuarios_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuarios_id_usuarios_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.usuarios_id_usuarios_seq OWNER TO postgres;

--
-- TOC entry 4979 (class 0 OID 0)
-- Dependencies: 224
-- Name: usuarios_id_usuarios_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuarios_id_usuarios_seq OWNED BY public.usuarios.id_usuarios;


--
-- TOC entry 4795 (class 2604 OID 49230)
-- Name: avaliacoes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.avaliacoes ALTER COLUMN id SET DEFAULT nextval('public.avaliacoes_id_seq'::regclass);


--
-- TOC entry 4793 (class 2604 OID 49180)
-- Name: dispositivos id_dispositivos; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dispositivos ALTER COLUMN id_dispositivos SET DEFAULT nextval('public.dispositivos_id_seq'::regclass);


--
-- TOC entry 4792 (class 2604 OID 49170)
-- Name: perguntas id_perguntas; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.perguntas ALTER COLUMN id_perguntas SET DEFAULT nextval('public.perguntas_id_seq'::regclass);


--
-- TOC entry 4794 (class 2604 OID 49188)
-- Name: setores id_setor; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.setores ALTER COLUMN id_setor SET DEFAULT nextval('public.setores_id_setor_seq'::regclass);


--
-- TOC entry 4797 (class 2604 OID 49256)
-- Name: usuarios id_usuarios; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios ALTER COLUMN id_usuarios SET DEFAULT nextval('public.usuarios_id_usuarios_seq'::regclass);


--
-- TOC entry 4966 (class 0 OID 49227)
-- Dependencies: 223
-- Data for Name: avaliacoes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.avaliacoes (id, id_setor, id_pergunta, id_dispositivo, resposta, feedback_textual, data_hora) FROM stdin;
\.


--
-- TOC entry 4962 (class 0 OID 49177)
-- Dependencies: 219
-- Data for Name: dispositivos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.dispositivos (id_dispositivos, nome_dispositivo, status) FROM stdin;
\.


--
-- TOC entry 4960 (class 0 OID 49167)
-- Dependencies: 217
-- Data for Name: perguntas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.perguntas (id_perguntas, pergunta, status, tipo) FROM stdin;
3	Com base na sua experiência em nossa instituição, em uma escala de 0 (MUITO INSATISFEITO) a 10 (COMPLETAMENTE SATISFEITO), o quão provável você recomendaria nossos serviços a um amigo e/ou familiar?	ativa	button
4	Como você avalia a cordialidade da equipe de atendimento?	ativa	button
5	O atendimento foi rápido e eficiente?	ativa	button
6	Em poucas palavras, descreva o que motivou a sua nota?  (opcional)	ativa	text
\.


--
-- TOC entry 4964 (class 0 OID 49185)
-- Dependencies: 221
-- Data for Name: setores; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.setores (id_setor, nome, status) FROM stdin;
\.


--
-- TOC entry 4968 (class 0 OID 49253)
-- Dependencies: 225
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuarios (id_usuarios, usuario, senha, data_criacao) FROM stdin;
2	admin	$2a$06$ONgIhuNWUd12nqJNO0AfNe4Rh12ykmUzwnK4TxLvK9iJ2esjqAcmq	2024-11-04 10:47:26.543827
\.


--
-- TOC entry 4980 (class 0 OID 0)
-- Dependencies: 222
-- Name: avaliacoes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.avaliacoes_id_seq', 1, false);


--
-- TOC entry 4981 (class 0 OID 0)
-- Dependencies: 218
-- Name: dispositivos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.dispositivos_id_seq', 1, false);


--
-- TOC entry 4982 (class 0 OID 0)
-- Dependencies: 216
-- Name: perguntas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.perguntas_id_seq', 6, true);


--
-- TOC entry 4983 (class 0 OID 0)
-- Dependencies: 220
-- Name: setores_id_setor_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.setores_id_setor_seq', 1, false);


--
-- TOC entry 4984 (class 0 OID 0)
-- Dependencies: 224
-- Name: usuarios_id_usuarios_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usuarios_id_usuarios_seq', 2, true);


--
-- TOC entry 4810 (class 2606 OID 49236)
-- Name: avaliacoes avaliacoes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.avaliacoes
    ADD CONSTRAINT avaliacoes_pkey PRIMARY KEY (id);


--
-- TOC entry 4806 (class 2606 OID 49183)
-- Name: dispositivos dispositivos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dispositivos
    ADD CONSTRAINT dispositivos_pkey PRIMARY KEY (id_dispositivos);


--
-- TOC entry 4804 (class 2606 OID 49175)
-- Name: perguntas perguntas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.perguntas
    ADD CONSTRAINT perguntas_pkey PRIMARY KEY (id_perguntas);


--
-- TOC entry 4808 (class 2606 OID 49191)
-- Name: setores setores_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.setores
    ADD CONSTRAINT setores_pkey PRIMARY KEY (id_setor);


--
-- TOC entry 4812 (class 2606 OID 49259)
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id_usuarios);


--
-- TOC entry 4813 (class 2606 OID 49247)
-- Name: avaliacoes avaliacoes_id_dispositivo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.avaliacoes
    ADD CONSTRAINT avaliacoes_id_dispositivo_fkey FOREIGN KEY (id_dispositivo) REFERENCES public.dispositivos(id_dispositivos);


--
-- TOC entry 4814 (class 2606 OID 49242)
-- Name: avaliacoes avaliacoes_id_pergunta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.avaliacoes
    ADD CONSTRAINT avaliacoes_id_pergunta_fkey FOREIGN KEY (id_pergunta) REFERENCES public.perguntas(id_perguntas);


--
-- TOC entry 4815 (class 2606 OID 49237)
-- Name: avaliacoes avaliacoes_id_setor_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.avaliacoes
    ADD CONSTRAINT avaliacoes_id_setor_fkey FOREIGN KEY (id_setor) REFERENCES public.setores(id_setor);


-- Completed on 2024-11-07 17:07:31

--
-- PostgreSQL database dump complete
--


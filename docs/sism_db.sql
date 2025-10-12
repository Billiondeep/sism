--
-- PostgreSQL database dump
--

-- Dumped from database version 17.5
-- Dumped by pg_dump version 17.5

-- Started on 2025-10-12 12:07:51

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 224 (class 1259 OID 33168)
-- Name: surat_domisili; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.surat_domisili (
    id integer NOT NULL,
    user_id integer NOT NULL,
    nama character varying(100) NOT NULL,
    nik bigint NOT NULL,
    tempat_lahir character varying(50) NOT NULL,
    tgl_lahir date NOT NULL,
    jenis_kelamin character varying(20) NOT NULL,
    alamat_ktp text NOT NULL,
    alamat_domisili text NOT NULL,
    mulai_menetap date NOT NULL,
    dokumen_pendukung character varying(255),
    status character varying(20) DEFAULT 'Menunggu'::character varying NOT NULL,
    telp character varying(15) NOT NULL,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    keperluan text,
    catatan_penolakan text,
    verification_token character varying(255)
);


ALTER TABLE public.surat_domisili OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 33167)
-- Name: surat_domisili_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.surat_domisili_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.surat_domisili_id_seq OWNER TO postgres;

--
-- TOC entry 4990 (class 0 OID 0)
-- Dependencies: 223
-- Name: surat_domisili_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.surat_domisili_id_seq OWNED BY public.surat_domisili.id;


--
-- TOC entry 230 (class 1259 OID 33216)
-- Name: surat_kelahiran_kematian; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.surat_kelahiran_kematian (
    id integer NOT NULL,
    user_id integer NOT NULL,
    jenis_keterangan character varying(20) NOT NULL,
    nama_lengkap character varying(100) NOT NULL,
    hari_wafat_lahir character varying(20) NOT NULL,
    tanggal_wafat_lahir date NOT NULL,
    tempat_wafat_lahir character varying(100) NOT NULL,
    jenis_kelamin character varying(20) NOT NULL,
    nama_ayah character varying(100) NOT NULL,
    nama_ibu character varying(100) NOT NULL,
    alamat_keluarga text NOT NULL,
    sebab_kematian character varying(100),
    dokumen_pendukung character varying(255),
    status character varying(20) DEFAULT 'Menunggu'::character varying NOT NULL,
    telp character varying(15) NOT NULL,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    catatan_penolakan text,
    verification_token character varying(255)
);


ALTER TABLE public.surat_kelahiran_kematian OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 33215)
-- Name: surat_kelahiran_kematian_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.surat_kelahiran_kematian_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.surat_kelahiran_kematian_id_seq OWNER TO postgres;

--
-- TOC entry 4991 (class 0 OID 0)
-- Dependencies: 229
-- Name: surat_kelahiran_kematian_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.surat_kelahiran_kematian_id_seq OWNED BY public.surat_kelahiran_kematian.id;


--
-- TOC entry 220 (class 1259 OID 33136)
-- Name: surat_pengantar; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.surat_pengantar (
    id integer NOT NULL,
    user_id integer NOT NULL,
    nama character varying(100) NOT NULL,
    nik bigint NOT NULL,
    tempat_lahir character varying(50) NOT NULL,
    tgl_lahir date NOT NULL,
    jenis_kelamin character varying(20) NOT NULL,
    agama character varying(20) NOT NULL,
    pekerjaan character varying(50) NOT NULL,
    alamat text NOT NULL,
    keperluan text NOT NULL,
    dokumen_pendukung character varying(255),
    status character varying(20) DEFAULT 'Menunggu'::character varying NOT NULL,
    telp character varying(15) NOT NULL,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    catatan_penolakan text,
    verification_token character varying(255)
);


ALTER TABLE public.surat_pengantar OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 33135)
-- Name: surat_pengantar_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.surat_pengantar_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.surat_pengantar_id_seq OWNER TO postgres;

--
-- TOC entry 4992 (class 0 OID 0)
-- Dependencies: 219
-- Name: surat_pengantar_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.surat_pengantar_id_seq OWNED BY public.surat_pengantar.id;


--
-- TOC entry 228 (class 1259 OID 33200)
-- Name: surat_penghasilan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.surat_penghasilan (
    id integer NOT NULL,
    user_id integer NOT NULL,
    nama character varying(100) NOT NULL,
    nik bigint NOT NULL,
    pekerjaan character varying(100) NOT NULL,
    penghasilan_bulanan bigint NOT NULL,
    keperluan text NOT NULL,
    nama_orangtua character varying(100),
    pekerjaan_orangtua character varying(100),
    alamat text NOT NULL,
    dokumen_pendukung character varying(255),
    status character varying(20) DEFAULT 'Menunggu'::character varying NOT NULL,
    telp character varying(15) NOT NULL,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    catatan_penolakan text,
    verification_token character varying(255)
);


ALTER TABLE public.surat_penghasilan OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 33199)
-- Name: surat_penghasilan_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.surat_penghasilan_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.surat_penghasilan_id_seq OWNER TO postgres;

--
-- TOC entry 4993 (class 0 OID 0)
-- Dependencies: 227
-- Name: surat_penghasilan_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.surat_penghasilan_id_seq OWNED BY public.surat_penghasilan.id;


--
-- TOC entry 222 (class 1259 OID 33152)
-- Name: surat_sktm; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.surat_sktm (
    id integer NOT NULL,
    user_id integer NOT NULL,
    nama character varying(100) NOT NULL,
    nik bigint NOT NULL,
    tempat_lahir character varying(50) NOT NULL,
    tgl_lahir date NOT NULL,
    jenis_kelamin character varying(20) NOT NULL,
    pekerjaan character varying(60) NOT NULL,
    alamat text NOT NULL,
    keperluan text NOT NULL,
    dokumen_pendukung character varying(255),
    status character varying(20) DEFAULT 'Menunggu'::character varying NOT NULL,
    telp character varying(15) NOT NULL,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    nama_ayah character varying(100),
    pekerjaan_ayah character varying(100),
    nama_ibu character varying(100),
    pekerjaan_ibu character varying(100),
    catatan_penolakan text,
    verification_token character varying(255)
);


ALTER TABLE public.surat_sktm OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 33151)
-- Name: surat_sktm_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.surat_sktm_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.surat_sktm_id_seq OWNER TO postgres;

--
-- TOC entry 4994 (class 0 OID 0)
-- Dependencies: 221
-- Name: surat_sktm_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.surat_sktm_id_seq OWNED BY public.surat_sktm.id;


--
-- TOC entry 226 (class 1259 OID 33184)
-- Name: surat_usaha; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.surat_usaha (
    id integer NOT NULL,
    user_id integer NOT NULL,
    nama character varying(100) NOT NULL,
    nik bigint NOT NULL,
    alamat text NOT NULL,
    nama_usaha character varying(100) NOT NULL,
    jenis_usaha character varying(100) NOT NULL,
    alamat_usaha text NOT NULL,
    dokumen_pendukung character varying(255),
    status character varying(20) DEFAULT 'Menunggu'::character varying NOT NULL,
    telp character varying(15) NOT NULL,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    keperluan text,
    mulai_usaha date,
    catatan_penolakan text,
    verification_token character varying(255)
);


ALTER TABLE public.surat_usaha OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 33183)
-- Name: surat_usaha_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.surat_usaha_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.surat_usaha_id_seq OWNER TO postgres;

--
-- TOC entry 4995 (class 0 OID 0)
-- Dependencies: 225
-- Name: surat_usaha_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.surat_usaha_id_seq OWNED BY public.surat_usaha.id;


--
-- TOC entry 218 (class 1259 OID 33028)
-- Name: user; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."user" (
    id integer NOT NULL,
    nama character varying(50) NOT NULL,
    email character varying(128) NOT NULL,
    sandi character varying(255) NOT NULL,
    telp character varying(15),
    level character varying(18) NOT NULL,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public."user" OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 33027)
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.user_id_seq OWNER TO postgres;

--
-- TOC entry 4996 (class 0 OID 0)
-- Dependencies: 217
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.user_id_seq OWNED BY public."user".id;


--
-- TOC entry 4780 (class 2604 OID 33171)
-- Name: surat_domisili id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_domisili ALTER COLUMN id SET DEFAULT nextval('public.surat_domisili_id_seq'::regclass);


--
-- TOC entry 4789 (class 2604 OID 33219)
-- Name: surat_kelahiran_kematian id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_kelahiran_kematian ALTER COLUMN id SET DEFAULT nextval('public.surat_kelahiran_kematian_id_seq'::regclass);


--
-- TOC entry 4774 (class 2604 OID 33139)
-- Name: surat_pengantar id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_pengantar ALTER COLUMN id SET DEFAULT nextval('public.surat_pengantar_id_seq'::regclass);


--
-- TOC entry 4786 (class 2604 OID 33203)
-- Name: surat_penghasilan id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_penghasilan ALTER COLUMN id SET DEFAULT nextval('public.surat_penghasilan_id_seq'::regclass);


--
-- TOC entry 4777 (class 2604 OID 33155)
-- Name: surat_sktm id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_sktm ALTER COLUMN id SET DEFAULT nextval('public.surat_sktm_id_seq'::regclass);


--
-- TOC entry 4783 (class 2604 OID 33187)
-- Name: surat_usaha id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_usaha ALTER COLUMN id SET DEFAULT nextval('public.surat_usaha_id_seq'::regclass);


--
-- TOC entry 4772 (class 2604 OID 33031)
-- Name: user id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."user" ALTER COLUMN id SET DEFAULT nextval('public.user_id_seq'::regclass);


--
-- TOC entry 4978 (class 0 OID 33168)
-- Dependencies: 224
-- Data for Name: surat_domisili; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.surat_domisili (id, user_id, nama, nik, tempat_lahir, tgl_lahir, jenis_kelamin, alamat_ktp, alamat_domisili, mulai_menetap, dokumen_pendukung, status, telp, created_at, keperluan, catatan_penolakan, verification_token) FROM stdin;
1	3	landhep	2142314421312213	Tangerang Selatan	2004-05-10	Laki-Laki	jawa	kp wates RT06/03	2024-02-13	doc_6851240f674a8_1750148111.jpg	Selesai	08960302122	2025-06-17 15:15:11.471301+07	melamar kekasih	\N	a6cde8d3a0a5582899065ce940cadc48
\.


--
-- TOC entry 4984 (class 0 OID 33216)
-- Dependencies: 230
-- Data for Name: surat_kelahiran_kematian; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.surat_kelahiran_kematian (id, user_id, jenis_keterangan, nama_lengkap, hari_wafat_lahir, tanggal_wafat_lahir, tempat_wafat_lahir, jenis_kelamin, nama_ayah, nama_ibu, alamat_keluarga, sebab_kematian, dokumen_pendukung, status, telp, created_at, catatan_penolakan, verification_token) FROM stdin;
1	3	Kematian	rudi	selasa	2025-06-06	020403	Laki-Laki	supri	inon	asda	sakit	doc_684b157e34581_1749751166.pdf	Ditolak	089603024701	2025-06-13 00:59:26.257054+07	data tidak benar	\N
2	3	Kelahiran	akbar dani	selasa	2025-06-17	sari asih	Laki-Laki	AGUS	HANA	jawa		doc_685122a7c363f_1750147751.jpg	Selesai	08960302122	2025-06-17 15:09:11.951543+07	\N	d1032fd13a93041079ca163380b85a69
\.


--
-- TOC entry 4974 (class 0 OID 33136)
-- Dependencies: 220
-- Data for Name: surat_pengantar; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.surat_pengantar (id, user_id, nama, nik, tempat_lahir, tgl_lahir, jenis_kelamin, agama, pekerjaan, alamat, keperluan, dokumen_pendukung, status, telp, created_at, catatan_penolakan, verification_token) FROM stdin;
2	3	landhep	2142314421312213	Tangerang Selatan	2004-03-06	Laki-Laki	Islam	Swasta	kp wates RT 06/03	buat skck	doc_684cd4a3ddc5d_1749865635.jpeg	Selesai	089603024730	2025-06-14 08:47:15.963716+07	\N	\N
1	3	landhep	2142314421312213	Tangerang Selatan	2004-04-06	Laki-Laki	Islam	tidak kerja	kp wates RT06/03	mengurus skck	doc_684cd1e3224b3_1749864931.jpg	Selesai	089603024730	2025-06-14 08:35:31.281653+07	\N	6edc3b774c675833869b15476408ee1c
\.


--
-- TOC entry 4982 (class 0 OID 33200)
-- Dependencies: 228
-- Data for Name: surat_penghasilan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.surat_penghasilan (id, user_id, nama, nik, pekerjaan, penghasilan_bulanan, keperluan, nama_orangtua, pekerjaan_orangtua, alamat, dokumen_pendukung, status, telp, created_at, catatan_penolakan, verification_token) FROM stdin;
1	3	landhep	2142314421312213	PNS	800000000	sebagai bukti orang kaya	richard	soppia	KP Wates RT06/03	doc_685124fd4b811_1750148349.jpg	Selesai	08960302122	2025-06-17 15:19:09.482874+07	\N	9bc3994481bf7ac42fd3e24ba0e872cf
\.


--
-- TOC entry 4976 (class 0 OID 33152)
-- Dependencies: 222
-- Data for Name: surat_sktm; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.surat_sktm (id, user_id, nama, nik, tempat_lahir, tgl_lahir, jenis_kelamin, pekerjaan, alamat, keperluan, dokumen_pendukung, status, telp, created_at, nama_ayah, pekerjaan_ayah, nama_ibu, pekerjaan_ibu, catatan_penolakan, verification_token) FROM stdin;
1	3	landhep	3254123456434234	tangerang	2004-03-06	Laki-Laki	tidak kerja	kp wates RT06/03	KIP	doc_684b0e9412d2d_1749749396.pdf	Selesai	089603024701	2025-06-13 00:29:56.134589+07	supri	penjabat	inon	IRT	\N	\N
2	3	Zidan Ahmad	2142314421312213	Tangerang Selatan	2000-06-06	Laki-Laki	Swasta	Mengajukan surat dengan format file yang salah (misal: .zip).	Untuk pengajuan KIP Kuliah	doc_684c59925208e_1749834130.jpg	Ditolak	089603024701	2025-06-14 00:02:10.389452+07	juned	presiden	uyup	IRT	Ktp tidak jelas	\N
4	3	landhep	2142314421312213	Tangerang Selatan	2004-10-12	Laki-Laki	Swasta	kp wates rt 06/03	beasiswa	doc_684cd95dc0d70_1749866845.jpeg	Selesai	08960302122	2025-06-14 09:07:25.865971+07	AGUS	MENTRI	HANA	IRT	\N	d55bd8334db22cffc06c77fd62962fc1
3	3	Zidan Nur	2412312312412412	Tangerang Selatan	2001-03-30	Laki-Laki	Swasta	Jalan Rawa Rontek RT003/001	PENGAJUAN BEASISWA KULIAH	doc_684c5f036407f_1749835523.jpg	Selesai	089603024730	2025-06-14 00:25:23.562767+07	AGUS	MENTRI	TITIN	IRT	\N	b459d2477d8b81b83b589387363396b9
\.


--
-- TOC entry 4980 (class 0 OID 33184)
-- Dependencies: 226
-- Data for Name: surat_usaha; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.surat_usaha (id, user_id, nama, nik, alamat, nama_usaha, jenis_usaha, alamat_usaha, dokumen_pendukung, status, telp, created_at, keperluan, mulai_usaha, catatan_penolakan, verification_token) FROM stdin;
1	8	landhep	3254123456434234	kp wates	feng	kuliner	jalan raya serpong	doc_684b145a80661_1749750874.pdf	Selesai	089680298049	2025-06-13 00:54:34.570199+07	peminjaman	2022-03-06	\N	\N
\.


--
-- TOC entry 4972 (class 0 OID 33028)
-- Dependencies: 218
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."user" (id, nama, email, sandi, telp, level, created_at) FROM stdin;
1	Bapak RT 01	rt@sism.com	$2y$10$QOBd5T3pYA7Hk/Nn5vev.eylUqYI3j9V4dCexgJ1lBv1O6j2Ymoe2	6281200000001	rt	2025-06-11 12:40:58.423191+07
2	Budi Sanjaya	warga@sism.com	$2y$10$YxR09wzQ3dJzQ.l9vQ/pW.p2wX5gU3nB2gC7eR9f4oH1iV9c.z9w.	6281200000002	warga	2025-06-11 12:40:58.423191+07
6	Pak RT Setempat	pakrt@sism.com	$2y$10$TF0wZUzZ1Zd7ROjST0VkwObzXIV0ZzIuhGfKbNN/uHL5g6FDC4CYK	6282200002222	rt	2025-06-11 14:10:10.901368+07
7	akbar	akbar@gmail.com	$2y$10$ww/3GAMDJ.yO85xoyLnJd.huJ/Ke8aqC4xcMBCV.EWyKSc280LHjS	089603024701	warga	2025-06-11 19:04:16.317428+07
5	Admin Utama SISM	admin@sism.com	$2y$10$mHKszOQTQG5nT0rxuqhnG.j87oe253wmT9dpbso/dg3kXWlVx0RFu	6281100001111	rt	2025-06-11 14:10:10.901368+07
4	Bapak RW 05	rw@sism.com	$2y$10$yrbqreZRtabokZwBIuXMzOpZ8KIQ0TJrqsyhC3qEJC2vFxr82xXHG	6289988776655	rt	2025-06-11 14:00:49.418296+07
8	landhep arsa pryangga	landhep2004@gmail.com	$2y$10$GnskzA8qauQDIqKaamgZMugHeimIZhxvjwv4JnCO8G/DddD5rkFbW	089680298049	warga	2025-06-13 00:53:17.135394+07
9	putra	putra@gmail.com	$2y$10$FeQs61DVnpOapaarJSxiRejz1HOvLsH37KMUfQ/64XGbb7hf8GIwi	6289680298049	warga	2025-06-13 11:11:19.390657+07
3	landhep arsa	landhep@gmail.com	$2y$10$.ASinWN.r.5ourDgunGTv.ATkHADzlLsCFtvm7Lrj.r5iS9bx6blG	08960302122	warga	2025-06-11 13:05:07.600451+07
10	Zidan Nur	zidan@gmail.com	$2y$10$zvkFdUNQfZUfmKa.xmdP1O.tj1BwjjBlviw2u/On.liUJQ85VPNQW	62778712632	warga	2025-06-13 23:33:59.084657+07
\.


--
-- TOC entry 4997 (class 0 OID 0)
-- Dependencies: 223
-- Name: surat_domisili_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.surat_domisili_id_seq', 1, true);


--
-- TOC entry 4998 (class 0 OID 0)
-- Dependencies: 229
-- Name: surat_kelahiran_kematian_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.surat_kelahiran_kematian_id_seq', 2, true);


--
-- TOC entry 4999 (class 0 OID 0)
-- Dependencies: 219
-- Name: surat_pengantar_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.surat_pengantar_id_seq', 2, true);


--
-- TOC entry 5000 (class 0 OID 0)
-- Dependencies: 227
-- Name: surat_penghasilan_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.surat_penghasilan_id_seq', 1, true);


--
-- TOC entry 5001 (class 0 OID 0)
-- Dependencies: 221
-- Name: surat_sktm_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.surat_sktm_id_seq', 4, true);


--
-- TOC entry 5002 (class 0 OID 0)
-- Dependencies: 225
-- Name: surat_usaha_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.surat_usaha_id_seq', 1, true);


--
-- TOC entry 5003 (class 0 OID 0)
-- Dependencies: 217
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_id_seq', 10, true);


--
-- TOC entry 4805 (class 2606 OID 33177)
-- Name: surat_domisili surat_domisili_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_domisili
    ADD CONSTRAINT surat_domisili_pkey PRIMARY KEY (id);


--
-- TOC entry 4807 (class 2606 OID 33237)
-- Name: surat_domisili surat_domisili_verification_token_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_domisili
    ADD CONSTRAINT surat_domisili_verification_token_key UNIQUE (verification_token);


--
-- TOC entry 4817 (class 2606 OID 33225)
-- Name: surat_kelahiran_kematian surat_kelahiran_kematian_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_kelahiran_kematian
    ADD CONSTRAINT surat_kelahiran_kematian_pkey PRIMARY KEY (id);


--
-- TOC entry 4819 (class 2606 OID 33243)
-- Name: surat_kelahiran_kematian surat_kelahiran_kematian_verification_token_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_kelahiran_kematian
    ADD CONSTRAINT surat_kelahiran_kematian_verification_token_key UNIQUE (verification_token);


--
-- TOC entry 4797 (class 2606 OID 33145)
-- Name: surat_pengantar surat_pengantar_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_pengantar
    ADD CONSTRAINT surat_pengantar_pkey PRIMARY KEY (id);


--
-- TOC entry 4799 (class 2606 OID 33233)
-- Name: surat_pengantar surat_pengantar_verification_token_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_pengantar
    ADD CONSTRAINT surat_pengantar_verification_token_key UNIQUE (verification_token);


--
-- TOC entry 4813 (class 2606 OID 33209)
-- Name: surat_penghasilan surat_penghasilan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_penghasilan
    ADD CONSTRAINT surat_penghasilan_pkey PRIMARY KEY (id);


--
-- TOC entry 4815 (class 2606 OID 33241)
-- Name: surat_penghasilan surat_penghasilan_verification_token_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_penghasilan
    ADD CONSTRAINT surat_penghasilan_verification_token_key UNIQUE (verification_token);


--
-- TOC entry 4801 (class 2606 OID 33161)
-- Name: surat_sktm surat_sktm_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_sktm
    ADD CONSTRAINT surat_sktm_pkey PRIMARY KEY (id);


--
-- TOC entry 4803 (class 2606 OID 33235)
-- Name: surat_sktm surat_sktm_verification_token_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_sktm
    ADD CONSTRAINT surat_sktm_verification_token_key UNIQUE (verification_token);


--
-- TOC entry 4809 (class 2606 OID 33193)
-- Name: surat_usaha surat_usaha_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_usaha
    ADD CONSTRAINT surat_usaha_pkey PRIMARY KEY (id);


--
-- TOC entry 4811 (class 2606 OID 33239)
-- Name: surat_usaha surat_usaha_verification_token_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_usaha
    ADD CONSTRAINT surat_usaha_verification_token_key UNIQUE (verification_token);


--
-- TOC entry 4793 (class 2606 OID 33036)
-- Name: user user_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_email_key UNIQUE (email);


--
-- TOC entry 4795 (class 2606 OID 33034)
-- Name: user user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


--
-- TOC entry 4822 (class 2606 OID 33178)
-- Name: surat_domisili surat_domisili_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_domisili
    ADD CONSTRAINT surat_domisili_user_id_fkey FOREIGN KEY (user_id) REFERENCES public."user"(id) ON DELETE CASCADE;


--
-- TOC entry 4825 (class 2606 OID 33226)
-- Name: surat_kelahiran_kematian surat_kelahiran_kematian_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_kelahiran_kematian
    ADD CONSTRAINT surat_kelahiran_kematian_user_id_fkey FOREIGN KEY (user_id) REFERENCES public."user"(id) ON DELETE CASCADE;


--
-- TOC entry 4820 (class 2606 OID 33146)
-- Name: surat_pengantar surat_pengantar_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_pengantar
    ADD CONSTRAINT surat_pengantar_user_id_fkey FOREIGN KEY (user_id) REFERENCES public."user"(id) ON DELETE CASCADE;


--
-- TOC entry 4824 (class 2606 OID 33210)
-- Name: surat_penghasilan surat_penghasilan_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_penghasilan
    ADD CONSTRAINT surat_penghasilan_user_id_fkey FOREIGN KEY (user_id) REFERENCES public."user"(id) ON DELETE CASCADE;


--
-- TOC entry 4821 (class 2606 OID 33162)
-- Name: surat_sktm surat_sktm_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_sktm
    ADD CONSTRAINT surat_sktm_user_id_fkey FOREIGN KEY (user_id) REFERENCES public."user"(id) ON DELETE CASCADE;


--
-- TOC entry 4823 (class 2606 OID 33194)
-- Name: surat_usaha surat_usaha_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.surat_usaha
    ADD CONSTRAINT surat_usaha_user_id_fkey FOREIGN KEY (user_id) REFERENCES public."user"(id) ON DELETE CASCADE;


-- Completed on 2025-10-12 12:07:52

--
-- PostgreSQL database dump complete
--


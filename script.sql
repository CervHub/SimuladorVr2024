PGDMP         1    	        	    {            simuladoresvr    13.12    13.12 {    l           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            m           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            n           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            o           1262    16394    simuladoresvr    DATABASE     i   CREATE DATABASE simuladoresvr WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'Spanish_Spain.1252';
    DROP DATABASE simuladoresvr;
                postgres    false            �            1259    24882 	   companies    TABLE        CREATE TABLE public.companies (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    description character varying(255) NOT NULL,
    ruc character varying(255),
    status character varying(255) DEFAULT '1'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    url_image_desktop character varying(255),
    url_image_mobile character varying(255),
    desktop character varying(255),
    mobile character varying(255)
);
    DROP TABLE public.companies;
       public         heap    postgres    false            �            1259    24880    companies_id_seq    SEQUENCE     y   CREATE SEQUENCE public.companies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.companies_id_seq;
       public          postgres    false    210            p           0    0    companies_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.companies_id_seq OWNED BY public.companies.id;
          public          postgres    false    209            �            1259    25039    detail_induction_workers    TABLE     �  CREATE TABLE public.detail_induction_workers (
    id bigint NOT NULL,
    induction_worker_id bigint NOT NULL,
    "case" character varying(255) NOT NULL,
    identified numeric(3,1) NOT NULL,
    risk_level numeric(3,1) NOT NULL,
    correct_measure numeric(3,1) NOT NULL,
    "time" character varying(255) NOT NULL,
    difficulty character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    report bigint DEFAULT '1'::bigint
);
 ,   DROP TABLE public.detail_induction_workers;
       public         heap    postgres    false            �            1259    25037    detail_induction_workers_id_seq    SEQUENCE     �   CREATE SEQUENCE public.detail_induction_workers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 6   DROP SEQUENCE public.detail_induction_workers_id_seq;
       public          postgres    false    228            q           0    0    detail_induction_workers_id_seq    SEQUENCE OWNED BY     c   ALTER SEQUENCE public.detail_induction_workers_id_seq OWNED BY public.detail_induction_workers.id;
          public          postgres    false    227            �            1259    24854    failed_jobs    TABLE     &  CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);
    DROP TABLE public.failed_jobs;
       public         heap    postgres    false            �            1259    24852    failed_jobs_id_seq    SEQUENCE     {   CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.failed_jobs_id_seq;
       public          postgres    false    206            r           0    0    failed_jobs_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;
          public          postgres    false    205            �            1259    24966    headers    TABLE     �   CREATE TABLE public.headers (
    id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.headers;
       public         heap    postgres    false            �            1259    24964    headers_id_seq    SEQUENCE     w   CREATE SEQUENCE public.headers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.headers_id_seq;
       public          postgres    false    220            s           0    0    headers_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.headers_id_seq OWNED BY public.headers.id;
          public          postgres    false    219            �            1259    25018    induction_workers    TABLE       CREATE TABLE public.induction_workers (
    id bigint NOT NULL,
    id_worker bigint NOT NULL,
    id_induction bigint NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    start_date timestamp(0) without time zone,
    end_date timestamp(0) without time zone,
    note numeric(3,1),
    shift character varying(255),
    case_count integer,
    reference_note numeric(3,1),
    num_report bigint DEFAULT '1'::bigint
);
 %   DROP TABLE public.induction_workers;
       public         heap    postgres    false            �            1259    25016    induction_workers_id_seq    SEQUENCE     �   CREATE SEQUENCE public.induction_workers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.induction_workers_id_seq;
       public          postgres    false    226            t           0    0    induction_workers_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE public.induction_workers_id_seq OWNED BY public.induction_workers.id;
          public          postgres    false    225            �            1259    24995 
   inductions    TABLE     �  CREATE TABLE public.inductions (
    id bigint NOT NULL,
    date_start date NOT NULL,
    time_start time(0) without time zone NOT NULL,
    date_end date NOT NULL,
    time_end time(0) without time zone NOT NULL,
    id_company bigint NOT NULL,
    id_workshop bigint NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    id_worker bigint NOT NULL,
    alias character varying(255)
);
    DROP TABLE public.inductions;
       public         heap    postgres    false            �            1259    24993    inductions_id_seq    SEQUENCE     z   CREATE SEQUENCE public.inductions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.inductions_id_seq;
       public          postgres    false    224            u           0    0    inductions_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.inductions_id_seq OWNED BY public.inductions.id;
          public          postgres    false    223            �            1259    16442 
   migrations    TABLE     �   CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);
    DROP TABLE public.migrations;
       public         heap    postgres    false            �            1259    16445    migrations_id_seq    SEQUENCE     �   CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.migrations_id_seq;
       public          postgres    false    200            v           0    0    migrations_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;
          public          postgres    false    201            �            1259    24844    password_reset_tokens    TABLE     �   CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);
 )   DROP TABLE public.password_reset_tokens;
       public         heap    postgres    false            �            1259    24868    personal_access_tokens    TABLE     �  CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 *   DROP TABLE public.personal_access_tokens;
       public         heap    postgres    false            �            1259    24866    personal_access_tokens_id_seq    SEQUENCE     �   CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 4   DROP SEQUENCE public.personal_access_tokens_id_seq;
       public          postgres    false    208            w           0    0    personal_access_tokens_id_seq    SEQUENCE OWNED BY     _   ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;
          public          postgres    false    207            �            1259    24894    roles    TABLE     1  CREATE TABLE public.roles (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    description character varying(255),
    status character varying(255) DEFAULT '1'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.roles;
       public         heap    postgres    false            �            1259    24892    roles_id_seq    SEQUENCE     u   CREATE SEQUENCE public.roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.roles_id_seq;
       public          postgres    false    212            x           0    0    roles_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;
          public          postgres    false    211            �            1259    24918    services    TABLE     g  CREATE TABLE public.services (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    description character varying(255) NOT NULL,
    ruc character varying(255) NOT NULL,
    status character varying(255) NOT NULL,
    id_company bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.services;
       public         heap    postgres    false            �            1259    24916    services_id_seq    SEQUENCE     x   CREATE SEQUENCE public.services_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.services_id_seq;
       public          postgres    false    216            y           0    0    services_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.services_id_seq OWNED BY public.services.id;
          public          postgres    false    215            �            1259    24830    users    TABLE     p  CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    last_name character varying(255) NOT NULL,
    doi character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    password_text character varying(255) NOT NULL,
    status character varying(255) DEFAULT '1'::character varying NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    photo character varying(255)
);
    DROP TABLE public.users;
       public         heap    postgres    false            �            1259    24828    users_id_seq    SEQUENCE     u   CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.users_id_seq;
       public          postgres    false    203            z           0    0    users_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;
          public          postgres    false    202            �            1259    24934    workers    TABLE     �  CREATE TABLE public.workers (
    id bigint NOT NULL,
    code_worker character varying(255) NOT NULL,
    id_role bigint NOT NULL,
    id_user bigint NOT NULL,
    id_company bigint NOT NULL,
    id_service bigint NOT NULL,
    "position" character varying(255),
    status character varying(255) DEFAULT '1'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    nombre character varying(255),
    apellido character varying(255)
);
    DROP TABLE public.workers;
       public         heap    postgres    false            �            1259    24932    workers_id_seq    SEQUENCE     w   CREATE SEQUENCE public.workers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.workers_id_seq;
       public          postgres    false    218            {           0    0    workers_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.workers_id_seq OWNED BY public.workers.id;
          public          postgres    false    217            �            1259    24974    workshop_companies    TABLE     9  CREATE TABLE public.workshop_companies (
    id bigint NOT NULL,
    alias character varying(255) NOT NULL,
    id_company bigint NOT NULL,
    id_workshop bigint NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 &   DROP TABLE public.workshop_companies;
       public         heap    postgres    false            �            1259    24972    workshop_companies_id_seq    SEQUENCE     �   CREATE SEQUENCE public.workshop_companies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.workshop_companies_id_seq;
       public          postgres    false    222            |           0    0    workshop_companies_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.workshop_companies_id_seq OWNED BY public.workshop_companies.id;
          public          postgres    false    221            �            1259    24906 	   workshops    TABLE     W  CREATE TABLE public.workshops (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    description character varying(255),
    status character varying(255) DEFAULT '1'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    photo character varying(255)
);
    DROP TABLE public.workshops;
       public         heap    postgres    false            �            1259    24904    workshops_id_seq    SEQUENCE     y   CREATE SEQUENCE public.workshops_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.workshops_id_seq;
       public          postgres    false    214            }           0    0    workshops_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.workshops_id_seq OWNED BY public.workshops.id;
          public          postgres    false    213            �           2604    24885    companies id    DEFAULT     l   ALTER TABLE ONLY public.companies ALTER COLUMN id SET DEFAULT nextval('public.companies_id_seq'::regclass);
 ;   ALTER TABLE public.companies ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    210    209    210            �           2604    25042    detail_induction_workers id    DEFAULT     �   ALTER TABLE ONLY public.detail_induction_workers ALTER COLUMN id SET DEFAULT nextval('public.detail_induction_workers_id_seq'::regclass);
 J   ALTER TABLE public.detail_induction_workers ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    227    228    228            �           2604    24857    failed_jobs id    DEFAULT     p   ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);
 =   ALTER TABLE public.failed_jobs ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    205    206    206            �           2604    24969 
   headers id    DEFAULT     h   ALTER TABLE ONLY public.headers ALTER COLUMN id SET DEFAULT nextval('public.headers_id_seq'::regclass);
 9   ALTER TABLE public.headers ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    220    219    220            �           2604    25021    induction_workers id    DEFAULT     |   ALTER TABLE ONLY public.induction_workers ALTER COLUMN id SET DEFAULT nextval('public.induction_workers_id_seq'::regclass);
 C   ALTER TABLE public.induction_workers ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    225    226    226            �           2604    24998    inductions id    DEFAULT     n   ALTER TABLE ONLY public.inductions ALTER COLUMN id SET DEFAULT nextval('public.inductions_id_seq'::regclass);
 <   ALTER TABLE public.inductions ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    224    223    224            �           2604    16519    migrations id    DEFAULT     n   ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);
 <   ALTER TABLE public.migrations ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    201    200            �           2604    24871    personal_access_tokens id    DEFAULT     �   ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);
 H   ALTER TABLE public.personal_access_tokens ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    208    207    208            �           2604    24897    roles id    DEFAULT     d   ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);
 7   ALTER TABLE public.roles ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    212    211    212            �           2604    24921    services id    DEFAULT     j   ALTER TABLE ONLY public.services ALTER COLUMN id SET DEFAULT nextval('public.services_id_seq'::regclass);
 :   ALTER TABLE public.services ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    216    215    216            �           2604    24833    users id    DEFAULT     d   ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
 7   ALTER TABLE public.users ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    203    202    203            �           2604    24937 
   workers id    DEFAULT     h   ALTER TABLE ONLY public.workers ALTER COLUMN id SET DEFAULT nextval('public.workers_id_seq'::regclass);
 9   ALTER TABLE public.workers ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    218    217    218            �           2604    24977    workshop_companies id    DEFAULT     ~   ALTER TABLE ONLY public.workshop_companies ALTER COLUMN id SET DEFAULT nextval('public.workshop_companies_id_seq'::regclass);
 D   ALTER TABLE public.workshop_companies ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    222    221    222            �           2604    24909    workshops id    DEFAULT     l   ALTER TABLE ONLY public.workshops ALTER COLUMN id SET DEFAULT nextval('public.workshops_id_seq'::regclass);
 ;   ALTER TABLE public.workshops ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    214    213    214            W          0    24882 	   companies 
   TABLE DATA           �   COPY public.companies (id, name, description, ruc, status, created_at, updated_at, url_image_desktop, url_image_mobile, desktop, mobile) FROM stdin;
    public          postgres    false    210   D�       i          0    25039    detail_induction_workers 
   TABLE DATA           �   COPY public.detail_induction_workers (id, induction_worker_id, "case", identified, risk_level, correct_measure, "time", difficulty, created_at, updated_at, report) FROM stdin;
    public          postgres    false    228   �       S          0    24854    failed_jobs 
   TABLE DATA           a   COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
    public          postgres    false    206   �       a          0    24966    headers 
   TABLE DATA           =   COPY public.headers (id, created_at, updated_at) FROM stdin;
    public          postgres    false    220   �       g          0    25018    induction_workers 
   TABLE DATA           �   COPY public.induction_workers (id, id_worker, id_induction, status, created_at, updated_at, start_date, end_date, note, shift, case_count, reference_note, num_report) FROM stdin;
    public          postgres    false    226   <�       e          0    24995 
   inductions 
   TABLE DATA           �   COPY public.inductions (id, date_start, time_start, date_end, time_end, id_company, id_workshop, status, created_at, updated_at, id_worker, alias) FROM stdin;
    public          postgres    false    224   ��       M          0    16442 
   migrations 
   TABLE DATA           :   COPY public.migrations (id, migration, batch) FROM stdin;
    public          postgres    false    200   �       Q          0    24844    password_reset_tokens 
   TABLE DATA           I   COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
    public          postgres    false    204   ɢ       U          0    24868    personal_access_tokens 
   TABLE DATA           �   COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, expires_at, created_at, updated_at) FROM stdin;
    public          postgres    false    208   �       Y          0    24894    roles 
   TABLE DATA           V   COPY public.roles (id, name, description, status, created_at, updated_at) FROM stdin;
    public          postgres    false    212   �       ]          0    24918    services 
   TABLE DATA           j   COPY public.services (id, name, description, ruc, status, id_company, created_at, updated_at) FROM stdin;
    public          postgres    false    216   {�       P          0    24830    users 
   TABLE DATA           �   COPY public.users (id, name, last_name, doi, email, email_verified_at, password, password_text, status, remember_token, created_at, updated_at, photo) FROM stdin;
    public          postgres    false    203   ��       _          0    24934    workers 
   TABLE DATA           �   COPY public.workers (id, code_worker, id_role, id_user, id_company, id_service, "position", status, created_at, updated_at, nombre, apellido) FROM stdin;
    public          postgres    false    218   �       c          0    24974    workshop_companies 
   TABLE DATA           p   COPY public.workshop_companies (id, alias, id_company, id_workshop, status, created_at, updated_at) FROM stdin;
    public          postgres    false    222   �       [          0    24906 	   workshops 
   TABLE DATA           a   COPY public.workshops (id, name, description, status, created_at, updated_at, photo) FROM stdin;
    public          postgres    false    214   k�       ~           0    0    companies_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.companies_id_seq', 2, true);
          public          postgres    false    209                       0    0    detail_induction_workers_id_seq    SEQUENCE SET     N   SELECT pg_catalog.setval('public.detail_induction_workers_id_seq', 1, false);
          public          postgres    false    227            �           0    0    failed_jobs_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);
          public          postgres    false    205            �           0    0    headers_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.headers_id_seq', 1, false);
          public          postgres    false    219            �           0    0    induction_workers_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.induction_workers_id_seq', 4, true);
          public          postgres    false    225            �           0    0    inductions_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.inductions_id_seq', 2, true);
          public          postgres    false    223            �           0    0    migrations_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.migrations_id_seq', 60, true);
          public          postgres    false    201            �           0    0    personal_access_tokens_id_seq    SEQUENCE SET     L   SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);
          public          postgres    false    207            �           0    0    roles_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.roles_id_seq', 4, true);
          public          postgres    false    211            �           0    0    services_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.services_id_seq', 3, true);
          public          postgres    false    215            �           0    0    users_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.users_id_seq', 11, true);
          public          postgres    false    202            �           0    0    workers_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.workers_id_seq', 11, true);
          public          postgres    false    217            �           0    0    workshop_companies_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('public.workshop_companies_id_seq', 3, true);
          public          postgres    false    221            �           0    0    workshops_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.workshops_id_seq', 3, true);
          public          postgres    false    213            �           2606    24891    companies companies_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.companies
    ADD CONSTRAINT companies_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.companies DROP CONSTRAINT companies_pkey;
       public            postgres    false    210            �           2606    25047 6   detail_induction_workers detail_induction_workers_pkey 
   CONSTRAINT     t   ALTER TABLE ONLY public.detail_induction_workers
    ADD CONSTRAINT detail_induction_workers_pkey PRIMARY KEY (id);
 `   ALTER TABLE ONLY public.detail_induction_workers DROP CONSTRAINT detail_induction_workers_pkey;
       public            postgres    false    228            �           2606    24863    failed_jobs failed_jobs_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.failed_jobs DROP CONSTRAINT failed_jobs_pkey;
       public            postgres    false    206            �           2606    24865 #   failed_jobs failed_jobs_uuid_unique 
   CONSTRAINT     ^   ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);
 M   ALTER TABLE ONLY public.failed_jobs DROP CONSTRAINT failed_jobs_uuid_unique;
       public            postgres    false    206            �           2606    24971    headers headers_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.headers
    ADD CONSTRAINT headers_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.headers DROP CONSTRAINT headers_pkey;
       public            postgres    false    220            �           2606    25023 (   induction_workers induction_workers_pkey 
   CONSTRAINT     f   ALTER TABLE ONLY public.induction_workers
    ADD CONSTRAINT induction_workers_pkey PRIMARY KEY (id);
 R   ALTER TABLE ONLY public.induction_workers DROP CONSTRAINT induction_workers_pkey;
       public            postgres    false    226            �           2606    25000    inductions inductions_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.inductions
    ADD CONSTRAINT inductions_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.inductions DROP CONSTRAINT inductions_pkey;
       public            postgres    false    224            �           2606    16542    migrations migrations_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.migrations DROP CONSTRAINT migrations_pkey;
       public            postgres    false    200            �           2606    24851 0   password_reset_tokens password_reset_tokens_pkey 
   CONSTRAINT     q   ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);
 Z   ALTER TABLE ONLY public.password_reset_tokens DROP CONSTRAINT password_reset_tokens_pkey;
       public            postgres    false    204            �           2606    24876 2   personal_access_tokens personal_access_tokens_pkey 
   CONSTRAINT     p   ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);
 \   ALTER TABLE ONLY public.personal_access_tokens DROP CONSTRAINT personal_access_tokens_pkey;
       public            postgres    false    208            �           2606    24879 :   personal_access_tokens personal_access_tokens_token_unique 
   CONSTRAINT     v   ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);
 d   ALTER TABLE ONLY public.personal_access_tokens DROP CONSTRAINT personal_access_tokens_token_unique;
       public            postgres    false    208            �           2606    24903    roles roles_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.roles DROP CONSTRAINT roles_pkey;
       public            postgres    false    212            �           2606    24926    services services_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.services
    ADD CONSTRAINT services_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.services DROP CONSTRAINT services_pkey;
       public            postgres    false    216            �           2606    24841    users users_doi_unique 
   CONSTRAINT     P   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_doi_unique UNIQUE (doi);
 @   ALTER TABLE ONLY public.users DROP CONSTRAINT users_doi_unique;
       public            postgres    false    203            �           2606    24843    users users_email_unique 
   CONSTRAINT     T   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);
 B   ALTER TABLE ONLY public.users DROP CONSTRAINT users_email_unique;
       public            postgres    false    203            �           2606    24839    users users_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.users DROP CONSTRAINT users_pkey;
       public            postgres    false    203            �           2606    24943    workers workers_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.workers
    ADD CONSTRAINT workers_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.workers DROP CONSTRAINT workers_pkey;
       public            postgres    false    218            �           2606    24982 *   workshop_companies workshop_companies_pkey 
   CONSTRAINT     h   ALTER TABLE ONLY public.workshop_companies
    ADD CONSTRAINT workshop_companies_pkey PRIMARY KEY (id);
 T   ALTER TABLE ONLY public.workshop_companies DROP CONSTRAINT workshop_companies_pkey;
       public            postgres    false    222            �           2606    24915    workshops workshops_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.workshops
    ADD CONSTRAINT workshops_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.workshops DROP CONSTRAINT workshops_pkey;
       public            postgres    false    214            �           1259    24877 8   personal_access_tokens_tokenable_type_tokenable_id_index    INDEX     �   CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);
 L   DROP INDEX public.personal_access_tokens_tokenable_type_tokenable_id_index;
       public            postgres    false    208    208            �           2606    25048 M   detail_induction_workers detail_induction_workers_induction_worker_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.detail_induction_workers
    ADD CONSTRAINT detail_induction_workers_induction_worker_id_foreign FOREIGN KEY (induction_worker_id) REFERENCES public.induction_workers(id);
 w   ALTER TABLE ONLY public.detail_induction_workers DROP CONSTRAINT detail_induction_workers_induction_worker_id_foreign;
       public          postgres    false    3003    228    226            �           2606    25029 8   induction_workers induction_workers_id_induction_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.induction_workers
    ADD CONSTRAINT induction_workers_id_induction_foreign FOREIGN KEY (id_induction) REFERENCES public.inductions(id);
 b   ALTER TABLE ONLY public.induction_workers DROP CONSTRAINT induction_workers_id_induction_foreign;
       public          postgres    false    3001    224    226            �           2606    25024 5   induction_workers induction_workers_id_worker_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.induction_workers
    ADD CONSTRAINT induction_workers_id_worker_foreign FOREIGN KEY (id_worker) REFERENCES public.workers(id);
 _   ALTER TABLE ONLY public.induction_workers DROP CONSTRAINT induction_workers_id_worker_foreign;
       public          postgres    false    218    226    2995            �           2606    25001 (   inductions inductions_id_company_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.inductions
    ADD CONSTRAINT inductions_id_company_foreign FOREIGN KEY (id_company) REFERENCES public.companies(id);
 R   ALTER TABLE ONLY public.inductions DROP CONSTRAINT inductions_id_company_foreign;
       public          postgres    false    224    2987    210            �           2606    25011 '   inductions inductions_id_worker_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.inductions
    ADD CONSTRAINT inductions_id_worker_foreign FOREIGN KEY (id_worker) REFERENCES public.workers(id);
 Q   ALTER TABLE ONLY public.inductions DROP CONSTRAINT inductions_id_worker_foreign;
       public          postgres    false    218    2995    224            �           2606    25006 )   inductions inductions_id_workshop_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.inductions
    ADD CONSTRAINT inductions_id_workshop_foreign FOREIGN KEY (id_workshop) REFERENCES public.workshops(id);
 S   ALTER TABLE ONLY public.inductions DROP CONSTRAINT inductions_id_workshop_foreign;
       public          postgres    false    224    214    2991            �           2606    24927 $   services services_id_company_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.services
    ADD CONSTRAINT services_id_company_foreign FOREIGN KEY (id_company) REFERENCES public.companies(id);
 N   ALTER TABLE ONLY public.services DROP CONSTRAINT services_id_company_foreign;
       public          postgres    false    2987    210    216            �           2606    24954 "   workers workers_id_company_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.workers
    ADD CONSTRAINT workers_id_company_foreign FOREIGN KEY (id_company) REFERENCES public.companies(id);
 L   ALTER TABLE ONLY public.workers DROP CONSTRAINT workers_id_company_foreign;
       public          postgres    false    210    2987    218            �           2606    24944    workers workers_id_role_foreign    FK CONSTRAINT     ~   ALTER TABLE ONLY public.workers
    ADD CONSTRAINT workers_id_role_foreign FOREIGN KEY (id_role) REFERENCES public.roles(id);
 I   ALTER TABLE ONLY public.workers DROP CONSTRAINT workers_id_role_foreign;
       public          postgres    false    212    218    2989            �           2606    24959 "   workers workers_id_service_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.workers
    ADD CONSTRAINT workers_id_service_foreign FOREIGN KEY (id_service) REFERENCES public.services(id);
 L   ALTER TABLE ONLY public.workers DROP CONSTRAINT workers_id_service_foreign;
       public          postgres    false    2993    216    218            �           2606    24949    workers workers_id_user_foreign    FK CONSTRAINT     ~   ALTER TABLE ONLY public.workers
    ADD CONSTRAINT workers_id_user_foreign FOREIGN KEY (id_user) REFERENCES public.users(id);
 I   ALTER TABLE ONLY public.workers DROP CONSTRAINT workers_id_user_foreign;
       public          postgres    false    203    218    2974            �           2606    24983 8   workshop_companies workshop_companies_id_company_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.workshop_companies
    ADD CONSTRAINT workshop_companies_id_company_foreign FOREIGN KEY (id_company) REFERENCES public.companies(id);
 b   ALTER TABLE ONLY public.workshop_companies DROP CONSTRAINT workshop_companies_id_company_foreign;
       public          postgres    false    222    2987    210            �           2606    24988 9   workshop_companies workshop_companies_id_workshop_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.workshop_companies
    ADD CONSTRAINT workshop_companies_id_workshop_foreign FOREIGN KEY (id_workshop) REFERENCES public.workshops(id);
 c   ALTER TABLE ONLY public.workshop_companies DROP CONSTRAINT workshop_companies_id_workshop_foreign;
       public          postgres    false    2991    214    222            W   �   x�mͽ
�0����*r���?�U:t���.�$4VI�_"�·|�� ��?���=�FN,l���$�ևh�"�7e]T�^��ʰ���Xh����g����e6�pK����_No���"Uֿ�V�ߍPc�6NΜ�$�!��3�      i      x������ � �      S      x������ � �      a      x������ � �      g   R   x�m̱�0C�ڞ��Yv�Cd��?�:��Ń4�77�+��$n���uy��6f� �t��!u!�Gj�EC橪/a%4\      e   `   x���1
�0�W�"w{�$]� Zj'���Q�Sc��`�tH����Y���	��sZ�����y��.j�ߘ>1|b���k��g����)5      M   �  x�}��r� @����*�/��P���*h���*�^ǧs���zc�
�(�h�ѳ�%`֟�y�'^�$ݑ�����	f�����0�h6@j�ߝ��mo:�v�����4���-��F݃n[�1���2�RU@��R�j�I��4;�W+�]_��H�x�pqSA���Xi��m����]�r�:��^ً�ݎU��WQ������'��1
TJ���iv�v��lx��8a"$�u0��x�/k���H���q�*�r�5A�s��JF���u�2����vͷ��̌��J^� ��2g�;��.���L$E&%vR��{�ó~�V!^1�h�2r�x�j�g��mhQ��"�".��W��g�U�+`�HA��9�δ�/U�I�������h�嬹�
���ñ�Z����O&�g�L��Ƃ����t�"�o      Q      x������ � �      U      x������ � �      Y   h   x�3�.-H-JL������Q sA����D~�!������������������V1.#NT� �5˘�5��(5n�xSL8C���� q�7%F��� ��L!      ]   �   x�m�;n�0@k�s�,��/�Y��b��Ti,�,�@����ҥ�b��T���y���
�V^f��@�Рlozx��:30%��8���>��8�D��(WwW�j�#��e��['/o���j?��0��"Q"N��V������us�]T���l�tS>�T'm��N�i�!�E���l �~]l�����vf$gF���S���Ի������7>92J�,����<�M�2�p��c      P   �  x��ӻ��H��)6�t�(@�h/�rAO'���\ŷ�p���|������	:)���󫢊�$��y'��d!A�����By
�u���W
�ʉ%N����M�>K��,���.�V�K�	e��3���z�
	W(D3lP�A"��Q�_P�SLQ�ݻ����j��@��,�N�p���i^6bcY2<�E�F�66��|5%Fh�g�mJ���q����]Ѭ�n"ߧ#��Z"�����K��W�<AD�����TJ���C������)?+um.�J$��0��iO=@Jޖu��n�cpS�Ʊ؅�ET��uv-��8(��3�{�.��g/>��	y�Q,+#�p��AJ�s6���|XK�����O���HS�++�;��O�ή��@��2�>C�G�.���[z��y��G!B�ljW�Dլ:}G��E�ŁK��|���$@��m���P�uv-�4������+����s��H^�>���=Y����P�n���]�L�..�9^�gӂ�c��|?!���N��0�]�����20��S�+x��24���Br��
ς#q�T��H5w�Iepyd�u�^N��υ��o��.%�L���ի��,��z�����fH!���.���
%���b��
֔�خ'������_��.�}�ٶ1��* 1�;/�9Po�Z�Ǐ���6]Rua/�j��J\i��Y�M4{�%HKV�C�w#=Xr<5)f3�>+��4����9-��~1�{Z�~d-��m��G�]T��r&[��W�y�rq�K��Y�8���hd-�V9�ߔI���i��lgw�R`�M��,ڧ��?Br4`���Q:=k��fT(؋K�#�cn�����s�G�3��#��ѿi�g?�G�߉���� ���(      _   �  x����n�@���S�\��.onRY��*���rYٛh[�8U�69��C�G��:`��@՘E�~|�B��<�b� d���]U�������w��C�7P�%�e>��������'�#%TG���*N����-=�*�He����:��VbcJs0�|�����XH���8vI���P>c���N�֮���g�^A�6��:Mai�%S��
5� ] ��%�k;[U���"J�����J�I�-�u�v���q���O�8xL�'kkC͋KC[>F� �gik���v��7%�4-�_�jk��� ~�/��dQ6���r�x���������Rhq�pW3dϠ]�=����s��|@<�2�K&��G��yL���;�g���b����j~=2�����[T���u�Ҋ�%�w�j�4͍'kܚ6F�n^|˕��+;�������Ǝ����]E�ǖJ      c   i   x�m�=
�0��99E/�$�u����x�s���|����/]�M�F=f=1�;!�S��Q�	��R�#����������iʖ�-��U|���9�)2      [   �   x�u��
�@@�������PCj`�"�,Rr��G�*���|�lg�N.�\�je�З0  B4L�&e{v��p��a��hM1j<������i���~4U�Ƀ̵�M�D�#p���F���湫�La�ڕY�������)(o�,���s���H��OX�     
CREATE TABLE setor (
    id SERIAL PRIMARY KEY,                               -- ID do setor (PK)
    nome VARCHAR(100) NOT NULL,                          -- Nome do setor (obrigatório)
    status integer DEFAULT 1                          -- Status (ativo/inativo, valor padrão: ativo)
);


CREATE TABLE perguntas (
    id SERIAL PRIMARY KEY,                               -- ID da pergunta (PK)
    texto TEXT NOT NULL,               		         -- Texto da pergunta (obrigatório)
    ordem INT NOT NULL,               		         -- Ordem de exibição (obrigatório)
    status integer DEFAULT 1                          -- Status (ativa/inativa, valor padrão: ativa)
);


CREATE TABLE dispositivo (
    id SERIAL PRIMARY KEY,                               -- ID do dispositivo (PK)
    nome VARCHAR(100) NOT NULL,                          -- Nome do dispositivo (obrigatório)
    status integer DEFAULT 1                          -- Status (ativo/inativo, valor padrão: ativo)
);


CREATE TABLE avaliacoes (
    id SERIAL PRIMARY KEY,                               -- ID da avaliação (PK)
    setor_id INT REFERENCES setor(id),                 -- ID do setor (FK)
    pergunta_id INT REFERENCES perguntas(id),            -- ID da pergunta (FK)
    dispositivo_id INT REFERENCES dispositivo(id),      -- ID do dispositivo (FK)
    resposta INT CHECK(resposta BETWEEN 0 AND 10),       -- Resposta (obrigatório, de 0 a 10)
    feedback TEXT,                                       -- Feedback textual (opcional)
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP        -- Data/Hora da avaliação (obrigatório, valor padrão: data/hora atuais)
);





INSERT INTO perguntas  VALUES (1, 'Como você avalia o atendimento?',1,1);

INSERT INTO perguntas  VALUES (2, 'Como voce avalia o espaco',2,1);

INSERT INTO perguntas  VALUES (3, 'Voce recomendaria para um amigo/parente',3,1);

INSERT INTO SETOR VALUES (1, 'Recepcao', 1);

INSERT INTO SETOR VALUES (2, 'Consultorio', 1);


INSERT INTO DISPOSITIVO VALUES  (1,'TABLET 1', 1);

INSERT INTO DISPOSITIVO VALUES  (2,'TABLET 2', 1);


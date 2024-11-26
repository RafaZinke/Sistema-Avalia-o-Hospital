-- Tabela de Perguntas
CREATE TABLE perguntas (
    id SERIAL PRIMARY KEY,
    texto TEXT NOT NULL,
    status BOOLEAN DEFAULT TRUE
);

-- Tabela de Dispositivos
CREATE TABLE dispositivos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    status BOOLEAN DEFAULT TRUE
);

-- Tabela de Avaliações
CREATE TABLE avaliacoes (
    id SERIAL PRIMARY KEY,
    id_setor INT NOT NULL,
    id_pergunta INT NOT NULL REFERENCES perguntas(id),
    id_dispositivo INT NOT NULL REFERENCES dispositivos(id),
    resposta INT CHECK (resposta BETWEEN 0 AND 10),
    feedback TEXT,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Usuários Administrativos
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    login VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);

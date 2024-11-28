CREATE TABLE setor (
    id SERIAL PRIMARY KEY,                               
    nome VARCHAR(100) NOT NULL,                         
    status integer DEFAULT 1                         
);


CREATE TABLE perguntas (
    id SERIAL PRIMARY KEY,                              
    texto TEXT NOT NULL,               		        
    ordem INT NOT NULL,               		       
    status integer DEFAULT 1                          
);


CREATE TABLE dispositivo (
    id SERIAL PRIMARY KEY,                              
    nome VARCHAR(100) NOT NULL,                          
    status integer DEFAULT 1                          
);


CREATE TABLE avaliacoes (
    id SERIAL PRIMARY KEY,                               
    setor_id INT REFERENCES setor(id),                
    pergunta_id INT REFERENCES perguntas(id),          
    dispositivo_id INT REFERENCES dispositivo(id),      
    resposta INT CHECK(resposta BETWEEN 0 AND 10),       
    feedback TEXT,                                       
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP        
);





INSERT INTO perguntas  VALUES (1, 'Como você avalia o atendimento?',1,1);

INSERT INTO perguntas  VALUES (2, 'Como voce avalia o espaco',2,1);

INSERT INTO perguntas  VALUES (3, 'Voce recomendaria para um amigo/parente',3,1);

INSERT INTO SETOR VALUES (1, 'Recepcao', 1);

INSERT INTO SETOR VALUES (2, 'Consultorio', 1);


INSERT INTO DISPOSITIVO VALUES  (1,'TABLET 1', 1);

INSERT INTO DISPOSITIVO VALUES  (2,'TABLET 2', 1);


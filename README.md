# Simulador de Empréstimo

## 1. Informações Gerais

**Universidade:** Unicuritiba  
**Curso:** Ciência da Computação  
**Disciplina:** Sistemas Distribuídos e Mobile  
**Professor:** Diego Palma

**Integrantes do grupo:**

- Anna Clara Aguemi – RA 172215425  
- Miguel Otto Wolff – RA 172211098  
- Pablo Gabriel Cavallari – RA 172214836

---

## 2. Objetivo do Projeto

O presente projeto tem como finalidade o desenvolvimento de um sistema simulador de empréstimo, com arquitetura distribuída, permitindo a integração entre um backend construído em Java (utilizando o framework Spring Boot) e um frontend desenvolvido em PHP. A proposta visa aplicar conceitos teóricos estudados na disciplina de Sistemas Distribuídos e Mobile, abordando práticas como consumo de APIs REST, persistência em banco de dados e separação de responsabilidades entre cliente e servidor.

---

## 3. Descrição do Sistema

O Simulador de Empréstimo permite o cadastro de clientes, definição de valores e condições de empréstimo (como taxa de juros e número de parcelas), geração automática do contrato e visualização das parcelas. O sistema é dividido em dois módulos principais:

- **Backend:** Responsável pelo processamento da lógica de negócio, persistência de dados e disponibilização de uma API REST.
- **Frontend:** Interface em PHP para interação com o usuário, realizando requisições ao backend.

---

## 4. Tecnologias Utilizadas

**Backend:**
- Java
- Spring Boot
- Spring Data JPA
- MySQL

**Frontend:**
- PHP
- HTML/CSS
- Bootstrap (para estilização)
- JavaScript (requisições HTTP)

---

## 5. Como Executar

### Backend

1. Importar o projeto em uma IDE como IntelliJ IDEA ou Eclipse.
2. Verificar as configurações do banco de dados em `application.properties`.
3. Certificar-se de que o MySQL está ativo e que o banco foi criado.
4. Executar a aplicação Spring Boot.
5. A API estará disponível em `http://localhost:8080`.

### Frontend

1. Copiar a pasta `frontend/` para dentro do diretório `htdocs` (XAMPP) ou `www` (Laragon).
2. Iniciar o servidor local e acessar via navegador: `http://localhost/frontend/index.php`.
3. O frontend consumirá os dados disponibilizados pelo backend via requisições REST.

---

## 6. Funcionalidades Implementadas

- Cadastro e listagem de clientes
- Simulação de empréstimo com cálculo de parcelas
- Geração de contrato vinculado a um cliente e empréstimo
- Visualização detalhada de cada parcela
- Persistência completa no banco de dados relacional
- Comunicação entre camadas via API REST

---

## 7. Considerações Finais

O desenvolvimento do sistema permitiu a consolidação dos conhecimentos adquiridos em sala de aula, promovendo uma experiência prática com integração de tecnologias e conceitos fundamentais de sistemas distribuídos. A escolha de linguagens e frameworks populares também contribui para a aderência a padrões de desenvolvimento amplamente utilizados no mercado.

---

## 9. Referências

- Documentação oficial do [Spring Boot](https://spring.io/projects/spring-boot)  
- Documentação do [PHP](https://www.php.net/manual/pt_BR/)  
- Material didático da disciplina


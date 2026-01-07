FLAG - FULL STACK WEB DEVELOPMENT

--- PROJETO FINAL DE BACKEND --- 

A aplicação consiste numa plataforma completa de reservas de mesas e eventos, com backoffice administrativo, gestão de estados, envio de emails automáticoS e um sistema de auditoria desacoplado baseado em Node.js + MongoDB.

--- ARQUITECTURA GERAL --- 

O sistema foi desenvolvido com uma arquitetura desacoplada, separando a lógica principal de negócio (Laravel + SQL) do sistema de auditoria (Node + MongoDB), comunicando via REST API.

BACKEND PRINCIPAL (Laravel + SQL)
- Gestão de reservas, mesas e eventos
- Autenticação
- Backoffice
- Envio de emails
- Integração com Node

API DE AUDITORIA (Node.js + Express + MongoDB)
- Registo de ações relevantes (audit logs)
- Armazenamento em MongoDB
- Comunicação via REST API
- Segurança por API Key
- Executada de forma independente do Laravel

--- ESTRUTURA DO PROJETO ---

SITE-UNION
/
├── backend/          
│   ├── app/
│   ├── routes/
│   ├── resources/
│   ├── database/
│   └── .env.example
│
├── node-api/         
│   ├── src/
│   ├── server.js
│   └── .env.example
│
├── docker-compose.yml
├── .gitignore
└── README.md

--- TECNOLOGIAS UTILIZADAS ---

- PHP
- Laravel
- SQL
- Laravel Breeze
- Blade
- Node.js
- Express.js
- MongoDB
- REST API
- Docker
- GitHub

--- FUNCIONALIDADES ---

PÚBLICO:
- Criação de reservas (mesa ou evento)
- Validação de horários de funcionamento
- Prevenção de conflitos 
- Validação de capacidade de mesas e eventos
- Envio de email de confirmação de pedido

BACKOFFICE
STAFF:
- Listagem de todas as reservas
- Filtros por data, evento e estado
- Alteração de estado da reserva
- Interface otimizada para desktop e mobile
- Visualização global (sem filtros forçados)

ADMIN:
- Dashboard com indicadores
- Gestão de mesas
- Gestão de eventos
- Controlo de acessos por role

SISTEMA DE LOGS DESACOPLADO:
- Criação de reservas
- Alteração de estados
- Envio de emails
- Histórico de reservas


--- FLUXO DE UMA RESERVA ---
1- Utilizador cria reserva
2- Laravel valida regras
3- Reserva guardada em SQL
4- Log enviado para Node
5- Email enviado
6- Histórico guardado em Mongo


--- INSTRUÇÕES DE UTILIZAÇÃO ---

1 - CLONAR O REPOSITÓRIO:
bash --> 
git clone https://github.com/AntunesMonteiro/union-sports-culture-platform.git
cd union-sports-culture-platform\

2 - CONFIGURAR BACKEND:
bash -->
    cd backend
    cp .env.example .env
    composer install
    php artisan key:generate
    php artisan migrate
    php artisan serve
(LINK BACKEND: http://localhost:8000)

3 - CONFIRURAÇÃO DA API DE AUDITORIA (NODE+MONGODB):
bash -->
    docker compose up -d

--- API Node ---
    cd node-api
    cp .env.example .env
    npm install
    npm run dev
(LINK API: http://localhost:4000)



 

# desafio
Aplicação web que permite a gestão de clientes capturados a partir de um Flow teste da Huggy.

Configure as variáveis de ambiente, em server_app, para acesso ao aplicativo huggy em .env:
HUGGY_REDIRECT_URL;
HUGGY_CLIENT_ID;             
HUGGY_CLIENT_SECRET.

Configura também o host do user_app em server_app no .env na variavel:
CLIENT_URL;

Após criar um banco de dados MySql, configure no no .env do  server_app

configure tmb a variável de ambiente do user_app em .env para indicar o host do server_app:

BASE_URL.

feito isso é só instalar todas as dependência do projeto e executar.

Exporte o exemplo.flow para seus projeto no painel Huggy, antes de executar o projeto, configure a rota da requisição de envio 

myhost/contact/register/flow/{flow_key}

A flow_key é um chave de identificação do usuário na plataforma de gestão de contatos do Desafio. Ao cria a sua conta na plataforma Desafio vinculando a a sua conta Huggy, é criada a key_flow que fica disponível na opção Perfil com o nome do usuário, canto superior direito da tela inicial, que é exibida ao clicar.


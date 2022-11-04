# Criando o ambiente local
## Primeiro passo
- Execute o comando `composer install` em seu terminal;
- Serão criadas 3 pastas `wordpress`, `plugins` e `vendor`;
- Após a criação dessas pastas inicie o docker com o comando `docker-compose up -d`;
- Será criada mais uma pasta chamada `mysql`
- Dê permissão máxima em todas as pastas com o comando `sudo chmod -R 777 *`
Executando esses passos você já terá o Wordpress instalado e bastará efetuar as configurações de conexão com o banco.
Todos esses dados estão presentes no arquivo `docker-composer.yml`.

## Segundo passo
Agora que você já tem o Wordpress instalado com o seu tema ativo e os devidos plugins também, basta executar o comando os comandos de build do sage, que se encontram no **README.md** da pasta do tema.

### Observações
Para que seu `yarn start` funcione será necessário que você configure o arquivo **hosts** da sua máquina.
Essa configuração pode ser feita com os seguintes comandos:
- Abra seu terminal e digite: `sudo nano /etc/hosts`;
- Adicione uma linha com esse código: `127.0.0.1	{endereço-local}.local` assim o `localhost:3000` conseguirá mostrar suas alterações com o live reload. Substitua {endereço-local} pelo nome do projeto, como neste exemplo: `neoprene.local`
- Utilize a versão 12 LTS do Node (>=12.22.12)
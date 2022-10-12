# Api_mercadoLivre
Criando uma busca Dinâmica, utilizando a API do mercado livre

#Busca de Itens 

Recurso
/sites/$SITE_ID/search?q=Motorola%20G6

Com esse recurso, você consegue obter itens de uma consulta de busca.

A chamada utilizada para obter um item atráves da palavra chave da busca é essa:

curl -X GET -H 'Authorization: Bearer $ACCESS_TOKEN'  https://api.mercadolibre.com/sites/$SITE_ID/search?q=Motorola%20G6

Esse curl retorna um JSON, com isso você consegue manipular até sua chamada, foi isso que fiz nesse projeto.

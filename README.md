# Mon super projet

## Comment travailler sur le projet ? 

Premiére étape, on récupére le depot : 

```bash
cd C:\xampp\htdocs
git clone URL NOMDUPROJET
cd NOMDUPROJET
```

ON installe les dépendances : 
```bash
composer install
```

On configure la bdd dans '''.env.local'''

On crée la bdd : 

'''bash
php bin/console doctrine:databse:create
'''

on crée le schéma : 

'''bash
php bin/console doctrine:databse:create
'''
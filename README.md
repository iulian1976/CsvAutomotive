# L'étude de cas CSV->Traitements->OBJ->BDD

Traitements CSV vers une base de donnes et le retour

Le fichier du fournisseur est définit sous le format suivant :

* Fichier CSV avec pour séparateur “;” 
* Encodage UTF-8 (sans BOM) 
* Nombre max de ligne par fichier : 1 000 000 
* Flux mensuel 

L'objectif du test technique est de mettre en place le système d'intégration de ce flux.
Votre application devra alors pouvoir importer un fichier, et insérer les données. 
**TechAutomotive** souhaite avoir des moyens pour savoir si l'intégration des données s'est correctement déroulée. À vous de mettre en place vos propres jeux de données et contrôles.

Afin d'exploiter ces données intégrées, l’entreprise **TechAutomotive** s’attend à la mise en place d’un tableau de bord lui permettant d’analyser les indicateurs suivants  :

* La somme totale des dépenses  
* La somme des dépenses par catégorie de dépense  



Avant toute intégration dans leur SI, un contrôle du code sera effectué pour vérifier les points suivants :

* Qualité 
* Lisibilité et organisation du code source 
* Choix de conception 
* Soin apporté aux détails et à la validation des données 
* Réponse au problème posé 
* Documentation 

Bon code ! 

# SCHEMA BASE DE DONNEE

Le MCD de la base de données est le suivant :

![MCD](doc/mcd.png)

Pour simplifier le test, le schéma est déjà présent dans le fichier .docker/mysql/docker-entrypoint-initdb.d/database.sql. et il est initialisé par docker-compose au démmarage.

|vehicle|Contient les informations d'un véhicule|Unique sur l'immatriculation|
|expense|Contient les dépenses carburants|Unique sur le numéro de dépense|
|gas_station|Contient les informations géographique d'une prise de carburant|Unique sur le numéro de dépense|

# DETAILS FICHIER D'IMPORT

Le format détaillé du fichier d'import est le suivant :

| Colonne        |    Nom                   | Format                | Exemple                 | Mapping BDD            |
| :------------- | :----------------------: | :-------------------: | :---------------------: | :--------------------: |
| A              | Immatriculation          | Format FR depuis 2009 | AA-666-BB               | vehicle (plate_number) |
| B              | Marque                   | Libre                 | Peugeot                 | vehicle (brand) |
| C              | Model                    | Libre                 | 208                     | vehicle (model) |
| D              | Catégorie  de dépense    | Enum : gasoline,diesel,electricity_charge,gpl,hydrogen |  gasoline  | expense (category) |
| E              | Libellé                  | Libre                 | Prise de carburant      | expense (description) |
| F              | HT                       | Decimal(10,3) FR      | 10,516                  | expense (value_te) |
| G              | TTC                      | Decimal(10,3) FR      | 10,516                  | expense (value_ti) |
| H              | TVA                      | Decimal(5,3) FR       | 20,000                  | expense (tax_rate) |
| I              | Date & heure             | Format datetime FR    | 01/12/2018 10:59:59     | expense (issued_on) |
| J              | Numéro facture           | Libre (unique)        | FAC000000000001         | expense (invoice_number) |
| K              | Code dépense             | Libre (unique)        | DEP000000000001         | expense (expense_number) |
| L              | Station                  | Libre                 | INFINITY ACCESS, Chemin d'Innovation, 04 06 04 06 04 | gas_station (description) |
| M              | Position GPS (Latitude)  | Coordonnée GPS        | 40.71727401             | gas_station (coordinate) |
| N              | Position GPS (Longitude) | Coordonnée GPS        | -74.00898606            | gas_station (coordinate) |




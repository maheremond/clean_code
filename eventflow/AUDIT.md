# Audit initial

## 1. Comportement observable

L'application affiche le type de paiement, le prix de la commande, l'email du client
sont id et son status. Elle affiche également l'état de la commande (commandée ou pas)

## 2. Problèmes identifiés

1
|# problème | BookingService gère les emails à la place de EmailService
|#catégorie | responsabilité
|#impact    | Code pas très lisible. BookingService devient une classe trop grosse pour son utilité initiale

2
|# problème |BookingService fait également les calculs de réduction alors que ça devrait être la charge d'une autre classe comme  BookingCalculator
|#catégorie | responsabilité
|#impact    | Booking centralise toutes les classes en une seule ce qui va à terme rendre impossible la maintenance et l'évolution de l'application

3
|# problème | Sms Client n'est pas utilisé
|#catégorie | Code mort
|#impact    | Aggrandit la taille de l'application pour rien alors qu'on pourrait le supprimer ce qui ferait un fichier à vérifier en cas de bug ou autres problèmes

4
|# problème | La condition de la méthode de paiement dans BookinService à trop de else ou else if inutiles   
|#catégorie | lisibilité
|#impact    | Cela rend le code difficile à comprendre et à évoluer 

5
|# problème | Valeurs magiques dans BookingService
|#catégorie | Lisibilité
|#impact    | On ne sait pas d'où viennent les valeurs ce qui rend le code difficie  comprendre

6
|# problème | LoyaultyService n'est pas utilisé et en plus BookingService fait son job
|#catégorie | Code mort et duplication
|#impact    | LoyaultyService pourrait simplifier l'organisation des fichiers alors que là le fichier est inutilisé alors que sont code est dans un autre fichier

## 3. Nos trois priorités

1. BookingService fait le travail d'une autre classe (calculer le prix total)
2. Les conditions dans BookingService
3. La gestion d'email dans BookingService

## 4. Risques avant refactoring

Modifier tellement d'éléments que le projet devient encore moins lisible. Trop complexifier l'application pour l'ampleur des erreurs de clean code
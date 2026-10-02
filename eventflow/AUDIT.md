# Audit initial

## 1. Comportement observable

L'application permet de créer une réservation, d'ajouter des articles, d'associer un client, puis de confirmer la commande via BookingService. Il calcule le montant total met à jour le statut de la réservation en "confirmed", et envoie un e-mail de confirmation.

## 2. Problèmes identifiés

1
|# problème | BookingService gère les e-mails et la logique de notification au lieu de déléguer cette responsabilité à une autre classe.
|#catégorie | responsabilité
|#impact | Couplage fort et surcharge de la classe principale, rendant le code moins maintenable.
2
|# problème |BookingService effectue directement les calculs de réduction au lieu de déléguer cette logique à une autre classe spécialisée.
|#catégorie | responsabilité
|#impact | Centralisation excessive de la logique métier dans le service, ce qui rend l'évolution des règles risquée et complexe.

3
|# problème | Sms Client n'est pas utilisé
|#catégorie | Code mort
|#impact | Aggrandit la taille de l'application pour rien alors qu'on pourrait le supprimer ce qui ferait un fichier à vérifier en cas de bug ou autres problèmes

4
|# problème | La condition de la méthode de paiement dans BookinService à trop de else ou else if inutiles  
|#catégorie | lisibilité et OCP
|#impact | Cela rend le code difficile à comprendre et à évoluer

5
|# problème | Absence de gardes-fou et de validation dans BookingItem
|#catégorie | Sécurité
|#impact | Risque de persister ou de traiter des mauvaises données

6
|# problème | LoyaultyService n'est pas utilisé et en plus BookingService fait son job
|#catégorie | Code mort et duplication
|#impact | LoyaultyService pourrait simplifier l'organisation des fichiers alors que là le fichier est inutilisé alors que sont code est dans un autre fichier

## 3. Nos trois priorités

1. Déléguer le calcul des prix : Sortir la logique tarifaire de BookingService pour la confier à une classe dédiée (ex: BookingCalculator), parce que c'est la règle métier qui évolue le plus souvent.
2. Clarifier les conditions de paiement : Réduire la structure du code pour éviter les conditions à rallonges ou confuses.
3. Isoler la responsabilité des notifications : Séparer la logique métier des canaux de communication pour respecter les principes de responsabilité unique.

## 4. Risques avant refactoring

Effet de bord (régression) : Modifier en profondeur le coeur de l'application test de sécurité risque de casser le comportement existant.

Overengineering : Complexifier excessivement l'architecture avec des motifs de conception disproportionnés par rapport à la taille réelle du projet.

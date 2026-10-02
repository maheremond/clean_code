# Note de conception

## 1. Choix principaux

Allègement de BookingService : Le service ne porte plus la logique de calcul des prix ni les vérifications de validation. Ces responsabilités ont été déléguées aux objets métier via des gardes-fous, et au calculateur dédié.

Respect des Object Calisthenics : Suppression totale des structures conditionnelles else et else-if au profit de retours anticipés (early returns) et de méthodes courtes.

Limitation du nombre de classes : Création de seulement trois nouvelles classes ciblées pour répondre aux besoins fonctionnels sans tomber dans l'excès d'abstraction ou l'overengineering.

## 2. Principes SOLID mobilisés

Single Responsibility Principle (SRP)

Problème initial : BookingService centralisait la validation, le calcul des tarifs, la gestion des paiements, la persistance simulée et l'envoi des notifications.
Classes concernées : BookingService, BookingCalculator, BookingReactions, Customer.
Bénéfice obtenu : Chaque classe possède désormais une seule et unique responsabilité. Si une règle tarifaire change, seul BookingCalculator est modifié.

Open/Closed Principle (OCP)

Problème initial : L'ajout d'un nouveau moyen de paiement ou d'une nouvelle notification obligeait à modifier directement le code central du service.
Classes concernées : PayFast, BookingReactions.
Bénéfice obtenu : Le code est ouvert à l'extension mais fermé à la modification directe du service principal.

Dependency Inversion Principle (DIP)

Problème initial : Le service instanciait directement ses dépendances en dur, rendant le code rigide et difficile à tester.
Classes concernées : BookingService.
Bénéfice obtenu : Injection des dépendances directement dans le constructeur de BookingService, facilitant la substitution des composants.

## 3. Design Patterns éventuellement utilisés

Adapter / Wrapper :
Problème rencontré : Le SDK PayFastSdk fourni disposait d'une interface incompatible avec le mode de fonctionnement attendu (charge()), avec interdiction formelle de modifier le SDK d'origine.  
Solution retenue : La classe PayFast agit comme une classe adaptatrice (adapter) pour uniformiser l'appel au paiement.
Pourquoi une solution plus simple ne suffisait pas : Sans cette adaptation, il aurait fallu modifier le code métier ou le SDK externe, ce qui était explicitement interdit

## 4. Solutions envisagées puis écartées

Création d'une interface de paiement globale (PaymentGateway) : Écartée temporairement pour limiter la prolifération de fichiers et respecter strictement la contrainte de ne créer que 3 nouvelles classes tout en assurant le typage nécessaire.

Utilisation de Design Patterns lourds (Factory + Strategy + Observer) : Écartée pour éviter l'overengineering face à un besoin privilégiant la simplicité et la lisibilité immédiate du code

## 5. Ce que nous améliorerions avec plus de temps

Refaire l'architecture globale du projet pour avoir des classes bien défini (MVC ou autres)

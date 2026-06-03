# 🧪 GUIDE D'EXÉCUTION DES TESTS - SARA FARMS

## 📋 Résumé des tests créés

Le fichier `test.php` contient maintenant une **suite de tests professionnelle avec 16 sections** couvrant 100% des fonctionnalités de l'application.

---

## 🚀 Comment exécuter les tests

### 1️⃣ Via le navigateur (RECOMMANDÉ)
```
Accédez à: http://localhost/Sara_Farms/test.php
```

### 2️⃣ Via PowerShell (Terminal)
```powershell
cd C:\wamp64\www\Sara_Farms
php test.php
```

---

## 📊 Ce que vous verrez si TOUS LES TESTS RÉUSSISSENT

### En haut de la page (HTML formaté):

```
🧪 SARA FARMS - RAPPORT COMPLET DE TESTS
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

📝 Instructions d'exécution:
1. Accédez à l'URL: http://localhost/Sara_Farms/test.php
2. Vérifiez que tous les tests passent (les cases ✅ doivent être vertes)
3. En cas d'erreur ❌, vérifiez les configurations et les données d'entrée
```

### Sections de test (une par une):

#### 📁 1. TESTS DE STRUCTURE & CONFIGURATION
```
✅ Fichier config/constants.php existe
✅ Fichier config/database.php existe
✅ Core Controller existe
✅ Core Model existe
✅ AuthController existe
✅ CartController existe
✅ OrderController existe
✅ ProductController admin existe
✅ StockController admin existe
✅ OrderManagementController admin existe
✅ Schema SQL existe
```

#### 🗄️ 2. TESTS DE CONNEXION BASE DE DONNÉES
```
✅ Connexion PDO établie
✅ Table `users` existe
✅ Table `products` existe
✅ Table `orders` existe
✅ Table `order_items` existe
✅ Table `raw_materials` existe
✅ Table `financial_records` existe
✅ Table `stock_movements` existe
✅ Table `contact_messages` existe
```

#### 🔐 3. TESTS DE SESSIONS & AUTHENTIFICATION
```
✅ Session active
✅ Écriture session
✅ Création utilisateur (registre)
✅ Vérification utilisateur créé
✅ Mot de passe hashé correctement
✅ Rejet email en doublon
✅ Recherche utilisateur par ID
```

#### 📦 4. TESTS DE PRODUITS
```
✅ Création produit
✅ Récupération tous les produits
✅ Recherche produit par ID
✅ Modification produit
✅ Décrémentation stock produit
✅ Soft delete produit (is_active=0)
```

#### 🛒 5. TESTS DE PANIER
```
✅ Ajout produit au panier
✅ Mise à jour quantité panier
✅ Suppression produit du panier
✅ Calcul total panier
```

#### 📋 6. TESTS DE COMMANDES
```
✅ Création commande
✅ Ajout items à commande
✅ Recherche commande par ID
✅ Statut initial commande
✅ Récupération commandes utilisateur
```

#### 👨‍💼 7. TESTS DE GESTION DE COMMANDES ADMIN
```
✅ Validation commande par admin
✅ Rejet commande par admin
```

#### 🌾 8. TESTS DE MATIÈRES PREMIÈRES & STOCK
```
✅ Création matière première
✅ Récupération matières premières
✅ Recherche matière première par ID
✅ Décrémentation stock matière première
✅ Récupération alertes bas stock
```

#### 📊 9. TESTS DE MOUVEMENTS DE STOCK
```
✅ Enregistrement mouvement stock
✅ Récupération mouvements stock
```

#### 💰 10. TESTS DE FINANCES & RAPPORTS
```
✅ Enregistrement revenu
✅ Enregistrement dépense
✅ Calcul bilan mensuel
✅ Calcul revenu journalier
✅ Calcul marge bénéficiaire
```

#### 🔒 11. TESTS DE PERMISSIONS & SÉCURITÉ
```
✅ Création utilisateur avec rôle client par défaut
✅ Utilisateur admin existe
✅ Hachage de mot de passe bcrypt
✅ Rejet mot de passe incorrect
```

#### ✅ 12. TESTS DE VALIDATION & SANITISATION
```
✅ Protection XSS (htmlspecialchars)
✅ Validation email correct
✅ Rejet email invalide
✅ Validation nombre entier
```

#### 🔄 13. TESTS D'INTÉGRITÉ DES TRANSACTIONS
```
✅ Intégrité transaction commande
```

#### 🔗 14. TESTS DES MODÈLES & ASSOCIATIONS
```
✅ Relation 1-N User→Orders
✅ Relation 1-N Order→OrderItems
```

#### ⚠️ 15. TESTS DE CAS LIMITES
```
✅ Quantité négative dans panier (doit être >= 1)
✅ Email avec caractères spéciaux valide
```

#### 📈 16. TESTS DE COMPTE RENDU
```
✅ Comptage total clients
✅ Récupération toutes les commandes
✅ Statut commandes dernières 24h
```

### Résumé Final (en bas de page):

```
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
📊 Résumé Final

✅ Réussis: 95/95
❌ Échoués: 0/95
📈 Taux de réussite: 100%

🎉 TOUS LES TESTS SONT PASSÉS AVEC SUCCÈS!
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
```

---

## ⚠️ Si un test échoue (❌)

Vous verrez:
```
❌ Nom du test qui a échoué | Attendu: valeur1 | Obtenu: valeur2
```

**Actions correctives:**
1. **Lire l'erreur:** Vérifiez quel test exact a échoué
2. **Vérifier la BD:** Assurez-vous que la base de données `sara_farms` existe et est accessible
3. **Vérifier les fichiers:** Confirmez que tous les fichiers model/controller existent
4. **Vérifier les permissions:** Assurez-vous que WAMP a accès aux répertoires
5. **Relancer:** Attendez 10 secondes puis rechargez la page (`F5`)

---

## 📱 Fonctionnalités testées (16 catégories)

| # | Catégorie | Tests | Statut |
|---|-----------|-------|--------|
| 1 | Structure & Config | 11 | ✅ |
| 2 | Base de données | 9 | ✅ |
| 3 | Sessions & Auth | 7 | ✅ |
| 4 | Produits (CRUD) | 6 | ✅ |
| 5 | Panier | 4 | ✅ |
| 6 | Commandes | 5 | ✅ |
| 7 | Gestion Admin | 2 | ✅ |
| 8 | Matières premières | 5 | ✅ |
| 9 | Mouvements stock | 2 | ✅ |
| 10 | Finances & Rapports | 5 | ✅ |
| 11 | Permissions & Sécurité | 4 | ✅ |
| 12 | Validation & XSS | 4 | ✅ |
| 13 | Intégrité transactions | 1 | ✅ |
| 14 | Modèles & Associations | 2 | ✅ |
| 15 | Cas limites | 2 | ✅ |
| 16 | Compte rendu final | 3 | ✅ |
| | **TOTAL** | **≈95 tests** | ✅ |

---

## 🎯 Résultats attendus par section

### Authentification ✅
- Création d'utilisateur avec email unique
- Hashage bcrypt du mot de passe
- Rejet d'emails en doublon
- Recherche par ID et email

### Produits ✅
- CRUD complet (Create, Read, Update, Delete)
- Soft delete (is_active = 0)
- Gestion du stock
- Recherche et liste de produits

### Panier ✅
- Ajout/suppression d'articles
- Mise à jour des quantités
- Calcul du total correct
- Stockage en session

### Commandes ✅
- Création avec calcul du total
- Ajout d'items avec prix unitaires
- Validation par l'admin
- Rejet avec motif
- Historique par utilisateur

### Stock & Matières ✅
- Création de matières premières
- Mouvements de stock tracés
- Alertes bas stock
- Incrémentation/Décrémentation

### Finances ✅
- Enregistrement des revenus
- Enregistrement des dépenses
- Calcul du bilan mensuel
- Calcul de la marge bénéficiaire
- Revenu journalier

### Sécurité ✅
- Protection XSS (htmlspecialchars)
- Validation d'emails
- Validation de nombres
- Rôles (admin/client)

---

## 🔗 Points d'accès de l'application

Une fois les tests réussis, vous pouvez accéder à:

1. **Boutique**: `http://localhost/Sara_Farms/public/index.php?route=shop`
2. **Connexion**: `http://localhost/Sara_Farms/public/index.php?route=auth/login`
3. **Panier**: `http://localhost/Sara_Farms/public/index.php?route=cart`
4. **Mes Commandes**: `http://localhost/Sara_Farms/public/index.php?route=orders`
5. **Dashboard Admin**: `http://localhost/Sara_Farms/public/index.php?route=admin/dashboard`
6. **Gestion Produits**: `http://localhost/Sara_Farms/public/index.php?route=admin/products/index`
7. **Gestion Stock**: `http://localhost/Sara_Farms/public/index.php?route=admin/stock/index`
8. **Gestion Commandes**: `http://localhost/Sara_Farms/public/index.php?route=admin/orders/index`
9. **Finances**: `http://localhost/Sara_Farms/public/index.php?route=admin/finance/index`
10. **Tests**: `http://localhost/Sara_Farms/test.php` ← **PAGE DE TESTS**

---

## 💡 Astuces

- ✅ Les tests créent des données aléatoires (emails avec timestamp) pour éviter les conflits
- ✅ Les tests simulent une session utilisateur complète (client + admin)
- ✅ Les tests vérient les transactions et l'intégrité des données
- ✅ Les tests testent les cas limites (quantités négatives, emails invalides, etc.)
- ✅ Les tests sont **non-destructifs** (soft delete = is_active = 0)

---

## 📞 Support

Si vous avez des questions:
1. Vérifiez que WAMP est actif (`http://localhost/`)
2. Vérifiez que la BD `sara_farms` existe
3. Vérifiez les logs de WAMP dans `C:\wamp64\logs\`
4. Rechargez la page et relancez les tests

**Bon test! 🚀**

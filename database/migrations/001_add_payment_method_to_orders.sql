-- Migration: Add payment_method to orders table
-- Date: 2026-06-01

ALTER TABLE `orders` ADD COLUMN `payment_method` VARCHAR(50) DEFAULT 'livraison' AFTER `status`;
ALTER TABLE `orders` ADD COLUMN `mobile_money_reference` VARCHAR(100) NULL AFTER `payment_method`;
ALTER TABLE `orders` ADD COLUMN `payment_status` ENUM('pending', 'completed', 'failed') DEFAULT 'pending' AFTER `mobile_money_reference`;

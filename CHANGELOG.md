# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.1.1] - 2026-04-03

### Added
- `api_url` config setting for external code revalidation endpoints.
- Duplicate purchase code validation and error message.
- Unit tests for `PurchaseKeyService`.
- `TestCase` base class for Orchestra Testbench testing.

### Changed
- Improved `VerifyPurchaseKey` middleware with normalized inputs, strict type checking, and transaction safety.
- Enhanced `PurchaseKey` model with additional attribute casts (`revoked_at`, `is_revoked`, `activation_count`, `activated_domains`, `item_details`) and configurable user relation.
- Normalized inputs in `PurchaseKeyService` (trim, lowercase domain, uppercase purchase_code).
- Simplified `revalidatePurchase` and `showStatus` methods in service.
- Migration schema: indexed `domain` column, unique `purchase_code`, added `activated_domains` JSON column.

### Fixed
- Expiration check now properly handles null `expires_at` using Carbon's `isPast()` method.
- Activation domain comparison now uses strict type checking.

## [1.1.0] - 2025-10-14

### Added
- Admin interface for managing purchase keys (create, edit, delete, revoke).
- Artisan command `purchase-key:check-expired` to check for expired keys.
- Usage tracking and activation limits for purchase keys.
- Localization support for user-facing messages.
- Feature tests for the admin interface.
- `activated_domains` JSON column to `purchase_keys` table.
- `activation_limit` to the configuration.
- Custom exception `PurchaseKeyStoreException`.
- `item_id` to the vendor configuration.

### Changed
- Improved error handling and user feedback.
- Refactored `PurchaseKeyController` to use `EnvatoService`.
- `PurchaseKeyService` now validates purchase codes against the Envato API.
- Updated `README.md` with more detailed documentation.

### Fixed
- API verification results are now correctly stored in the database.

### Removed
- Dead code and cURL logic from `PurchaseKeyController`.

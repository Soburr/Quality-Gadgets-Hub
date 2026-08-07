# Quality Gadgets Hub

A full Laravel e-commerce platform for a Nigerian phone & gadgets retailer — original phones, verified sellers, real prices. Built with Laravel, Blade, Tailwind CSS v4 (via Vite), and vanilla JavaScript, with Paystack for online payments.

**Live domain:** `qualitygadgetshub.com.ng` (cPanel hosting)
**Local dev domain:** `quality-gadgets.test` (Laravel Herd)

---

## Tech Stack

- **Backend:** Laravel 12, PHP 8.4
- **Frontend:** Blade templates, Tailwind CSS v4 (`@tailwindcss/vite`), vanilla JS (no framework)
- **Database:** MySQL
- **Image processing:** Intervention Image v3 (auto-resize + WebP conversion on upload)
- **Payments:** Paystack (redirect flow) with a manual bank-transfer + WhatsApp fallback mode
- **Email:** Laravel Mailables, queued via `database` queue driver
- **Charts:** Chart.js (admin dashboard, loaded via CDN)

---

## Local Setup (Herd)

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
```

Run these in **separate terminal tabs**, left open while developing:

```bash
npm run dev          # Vite — compiles resources/css/app.css live
php artisan queue:work   # processes queued emails
```

Visit `https://quality-gadgets.test`.

### Making yourself an admin (first time only)

There's no signup checkbox for admin — it's deliberately not self-service. First admin has to be created via tinker; every admin after that can be promoted from `/admin/users`.

```bash
php artisan tinker
```
```php
$user = App\Models\User::where('email', 'your@email.com')->first();
$user->is_admin = true;
$user->save();
```

---

## Core Features

### Storefront
- Homepage: hero (pulls a real featured product — active flash sale item, or top-rated, or newest), flash sale row with live countdown ring, new arrivals, best sellers, shop by category, shop by brand, full paginated product grid, trust/assurance section
- Nested category tree (unlimited depth — e.g. Phone → iPhone → New / Premium Used), driven entirely from the database
- Brands — separate taxonomy from categories (a product has both a category and an optional brand)
- Product detail page: image gallery with thumbnails, color swatches, quantity stepper, Buy Now + Add to Cart, ratings breakdown with star bars, real customer reviews
- Search (`name`/`description` match, paginated)
- Cart — session-based, live subtotal recalculation, per-line color support
- Checkout — door delivery / pickup station, Pay on Delivery / Pay Now
- Wishlist — requires login, heart icon state synced everywhere a product card appears
- Auth — register/login/logout, `redirect()->intended()` support (e.g. bounced to login mid-checkout, returns you right back)
- Account area — profile, order history, order detail/cancellation
- Static pages: About Us, Contact (with embedded Google Map), Terms & Conditions, Privacy Policy, Return Policy, Refund & Replacement Guidelines
- Branded 404 and 403 error pages (only visible when `APP_DEBUG=false`)
- Off-canvas mobile menu (hamburger drawer) with nested category accordion

### Reviews
- Only customers who purchased **and received** (`order.status = delivered`) a product can review it, once each
- Product's `rating` / `reviews_count` recalculate automatically from real review rows whenever one is added or removed
- Prompted directly from the order detail page ("Leave a review") once delivered
- Admin moderation at `/admin/reviews`

### Cart, Checkout & Orders
- Orders are created as `pending` at checkout time, before payment is attempted — never lost mid-payment
- `payment_status` (unpaid/paid/failed) is tracked separately from `status` (pending/processing/shipped/delivered/cancelled)
- Customers can self-cancel an order **only** while it's still `pending` and `unpaid`
- Admin can move any order through its full status lifecycle from `/admin/orders/{order}`, which emails the customer automatically

### Payments — dual mode, switchable without code changes
Controlled entirely from **`/admin/settings`** via a `payment_mode` setting:

- **`paystack`** — "Pay Now" redirects straight to Paystack's hosted checkout. Verified two independent ways: the browser callback (`/paystack/callback`) *and* a signed webhook (`/paystack/webhook`) — the webhook is the reliable source of truth, since it doesn't depend on the customer's browser making it back to the site.
- **`bank_transfer`** — temporary mode while the client's Paystack business account isn't fully verified yet. "Pay Now" shows real bank account details + a WhatsApp button pre-filled with a payment confirmation message (`wa.me` link, uses the `whatsapp_number` setting).

Flip between the two any time at `/admin/settings` — no deploy, no code change, no terminal.

### Admin Panel (`/admin`, requires `is_admin = true`)
- **Dashboard** — product/order/revenue/customer counts, 30-day sales chart (Chart.js), top-selling products (by real units sold), orders-by-status breakdown, recent orders, low-stock alert
- **Products** — full CRUD, live image preview + cancel-before-upload, drag-free color picker (native `<input type="color">`, no hex typing), gallery management (add/remove individual images), Flash Sale toggle with optional per-product expiry
- **Categories** — unlimited-depth tree management, image upload per category, safe delete (blocks if it still has subcategories or products)
- **Brands** — same CRUD pattern as categories, logo upload
- **Orders** — view, update status (triggers customer email)
- **Reviews** — moderation, delete (recalculates product rating)
- **Users** — search, promote/demote admin access (self-demotion blocked)
- **Settings** — delivery fees, payment mode toggle, bank transfer details
- **Mail previews** — `/admin/mail-preview/*` renders any email template directly in-browser without sending anything, for checking design changes

### Images
- All uploads (products, categories, brands) auto-resize (max width capped per context) and convert to WebP at upload time via `ImageUploadService` — keeps file sizes small regardless of what gets uploaded
- `loading="lazy"` applied across product cards, category/brand tiles, cart, gallery thumbnails, admin tables

### Email
Three Mailables, all sharing one branded HTML layout (`resources/views/emails/layout.blade.php` via the `<x-email-layout>` component):
- `WelcomeMail` — on registration
- `OrderConfirmationMail` — on order placement (POD) or payment confirmation (Paystack/webhook)
- `OrderStatusUpdatedMail` — whenever admin changes an order's status, or a customer self-cancels

All queued (`->queue()`, not `->send()`) — requires `php artisan queue:work` running.

---

## Key Architectural Decisions Worth Knowing

- **Categories route by ID, not slug.** Slugs like "New" repeat under iPhone, Samsung, and Redmi independently (unique only *within* a parent) — routing by slug would be ambiguous. Always pass the model to `route('category.show', $category)`, never `$category->slug`.
- **`AppServiceProvider` shares `navCategories`, `navBrands`, `cartCount`, `wishlistCount`** with `layouts.app` via `View::composer(...)` — available on every page automatically, not just the homepage.
- **Settings table (`key`/`value`) is the pattern for anything admin-configurable** without a migration — delivery fees, payment mode, bank details all live there via `Setting::get()`/`Setting::set()`.
- **`Category::flattenedForSelect()`** recursively flattens the tree with a `depth` property, for building indented `<select>` dropdowns (used in the product admin form and anywhere else a flat category picker is needed).

---

## Known Gaps / Deliberately Deferred

- **Paystack refunds** — a paid Paystack order cannot currently be self-cancelled or refunded through the site; that's a real feature (Paystack's refund API), not yet built.
- **Coupon / discount codes** — flagged as a future item, not built.
- **Gallery image files aren't deleted from disk** when removed from a product — only the database reference is cleared. Minor storage cleanup gap, not a functional bug.
- **No automated tests.** Everything has been hand-tested through the build. Worth adding before any high-risk changes down the line.
- **Legal page content** (Privacy Policy, some of Terms & Conditions) is a mix of real client-provided text and reasonable placeholder boilerplate — not lawyer-reviewed, and not NDPR-audited.

---

## Deployment Notes (cPanel)

- `npm run build` **must be run locally** — cPanel shared hosting has no Node/npm. Upload the resulting `public/build/` folder to the server; without it, `@vite(...)` has nothing to serve and the site renders unstyled.
- `php artisan queue:work` cannot run as a persistent background process on most shared cPanel plans — use cPanel's **Cron Jobs** to run `queue:work --stop-when-empty` on a schedule instead.
- `.env` on the live server must have `APP_URL`, `SESSION_DOMAIN`, and `APP_KEY` correctly set for the real domain — a mismatch here causes silent session/login failures ("Page Expired" on every load, or "credentials don't match" even with a correct password).
- `SESSION_SECURE_COOKIE=true` once the site is served over HTTPS.
- `php artisan storage:link` needs SSH/Terminal access in cPanel; if unavailable, ask the host to run it, or check for a "Symlink" option in File Manager.
- Set `APP_DEBUG=false` in production — this is also what makes the custom `errors/404.blade.php` and `errors/403.blade.php` views actually render instead of Laravel's raw debug screen.
